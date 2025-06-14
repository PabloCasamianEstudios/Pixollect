<template>
    <metaHead>
        <title>{{ $t("{user}'s Games", { user: user.name }) }}</title>
        <meta
            head-key="description"
            name="description"
            content="Home page of the application"
        />
    </metaHead>
    <FlashMessage />
    <UserLayout :user="user">
        <div class="userGamesContainer">
            <h1 class="sectionTitle">
                {{ $t("{user}'s Collection", { user: user.name }) }}
            </h1>

            <div class="gamesHeader">
                <input
                    v-model="search"
                    type="text"
                    class="searchInput"
                    :placeholder="$t('Search in collection...')"
                    @input="handleSearch"
                />

                <select v-model="filters.state" class="filterSelect">
                    <option value="">{{ $t('All States') }}</option>
                    <option value="whishlist">{{ $t('Wishlist') }}</option>
                    <option value="playing">{{ $t('Playing') }}</option>
                    <option value="completed">{{ $t('Completed') }}</option>
                    <option value="dropped">{{ $t('Dropped') }}</option>
                    <option value="planned">{{ $t('Planned') }}</option>
                    <option value="backlog">{{ $t('Backlog') }}</option>
                </select>

                <select v-model="filters.genre" class="filterSelect">
                    <option value="">{{ $t('All Genres') }}</option>
                    <option
                        v-for="genre in uniqueGenres"
                        :key="genre"
                        :value="genre"
                    >
                        {{ genre }}
                    </option>
                </select>

                <select v-model="filters.platform" class="filterSelect">
                    <option value="">{{ $t('All Platforms') }}</option>
                    <option
                        v-for="platform in uniquePlatforms"
                        :key="platform"
                        :value="platform"
                    >
                        {{ platform }}
                    </option>
                </select>

                <select v-model="filters.theme" class="filterSelect">
                    <option value="">{{ $t('All Themes') }}</option>
                    <option
                        v-for="theme in uniqueThemes"
                        :key="theme"
                        :value="theme"
                    >
                        {{ theme }}
                    </option>
                </select>

                <select v-model="filters.saga" class="filterSelect">
                    <option value="">{{ $t('All Sagas') }}</option>
                    <option
                        v-for="saga in uniqueSagas"
                        :key="saga"
                        :value="saga"
                    >
                        {{ saga }}
                    </option>
                </select>
            </div>

            <div v-if="filteredGames.length" class="gamesGrid">
                <div
                    v-for="game in filteredGames"
                    :key="game.id"
                    class="gameCard"
                    :class="{ mastered: game.pivot.mastered }"
                    @click="goToGame(game.id)"
                >
                    <div class="gameImageWrapper">
                        <img
                            :src="game.image_url"
                            :alt="game.title"
                            class="gameImage"
                        />
                        <div
                            v-if="currentUser?.id === user.id"
                            class="gameOverlay"
                        >
                            <div class="gameActions">
                                <button
                                    class="actionBtn"
                                    @click.stop="openUpdateModal(game)"
                                    title="Edit"
                                >
                                    ✏️
                                </button>
                                <!-- <button
                                    class="actionBtn"
                                    @click.stop="incrementAchievement(game)"
                                    title="Achievement"
                                >
                                    ⬆️
                                </button> -->
                                <button
                                    class="actionBtn"
                                    @click.stop="removeGame(game.id)"
                                    title="Remove"
                                >
                                    ❌
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="gameInfo">
                        <h2 class="gameTitle">{{ game.title }}</h2>
                        <div class="gameStats">
                            <span class="gameProgress">
                                <template v-if="game.pivot.mastered">⭐</template>
                                <template v-else-if="game.achievements > 0">
                                    {{
                                        (
                                            (game.pivot.achievements_unlocked * 100) /
                                            game.achievements
                                        ).toFixed(2)
                                    }}%
                                </template>
                            </span>

                            <span class="gameState">{{
                                formatState(game.pivot.state)
                            }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="empty-message">
                <h1>{{ $t('EMPTY') }}</h1>
                <p>{{ $t('No games here') }}</p>
            </div>
            <UserUpdateGameModal
                v-if="showModal && selectedGame && selectedUserGame"
                :game="selectedGame"
                :userGame="selectedUserGame"
                @close="closeModal"
            />
        </div>
    </UserLayout>
</template>

<script>
import AppLayout from '@/Layouts/Layout.vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head as metaHead, router, usePage } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { useI18n } from 'vue-i18n';

import UserUpdateGameModal from '../../Components/UserUpdateGameModal.vue';
import FlashMessage from '../../Components/FlashMessage.vue';

export default {
    layout: AppLayout,
    components: {
        UserLayout,
        metaHead,
        UserUpdateGameModal,
        FlashMessage,
    },
    setup() {
        const { t } = useI18n();
        return {
            t,
            $t: t,
        };
    },
    props: {
        user: {
            type: Object,
            required: true,
        },
        games: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            showModal: false,
            selectedGame: null,
            selectedUserGame: null,
            search: '',
            filters: {
                state: '',
                genre: '',
                platform: '',
                theme: '',
                saga: '',
            },
        };
    },
    computed: {
        currentUser() {
            return usePage().props.auth.user;
        },
        uniqueGenres() {
            const genres = new Set();
            this.games.forEach((game) => {
                game.genres?.forEach((genre) => genres.add(genre.name));
            });
            return Array.from(genres).sort();
        },
        uniquePlatforms() {
            const platforms = new Set();
            this.games.forEach((game) => {
                game.platforms?.forEach((platform) =>
                    platforms.add(platform.name),
                );
            });
            return Array.from(platforms).sort();
        },
        uniqueThemes() {
            const themes = new Set();
            this.games.forEach((game) => {
                game.themes?.forEach((theme) => themes.add(theme.name));
            });
            return Array.from(themes).sort();
        },
        uniqueSagas() {
            const sagas = new Set();
            this.games.forEach((game) => {
                if (game.saga?.name) {
                    sagas.add(game.saga.name);
                }
            });
            return Array.from(sagas).sort();
        },
        filteredGames() {
            return this.games.filter((game) => {
                const matchesSearch =
                    !this.search ||
                    game.title
                        .toLowerCase()
                        .includes(this.search.toLowerCase());
                const matchesState =
                    !this.filters.state ||
                    game.pivot.state === this.filters.state;
                const matchesGenre =
                    !this.filters.genre ||
                    game.genres?.some((g) => g.name === this.filters.genre);
                const matchesPlatform =
                    !this.filters.platform ||
                    game.platforms?.some(
                        (p) => p.name === this.filters.platform,
                    );
                const matchesTheme =
                    !this.filters.theme ||
                    game.themes?.some((t) => t.name === this.filters.theme);
                const matchesSaga =
                    !this.filters.saga || game.saga?.name === this.filters.saga;

                return (
                    matchesSearch &&
                    matchesState &&
                    matchesGenre &&
                    matchesPlatform &&
                    matchesTheme &&
                    matchesSaga
                );
            });
        },
    },
    methods: {
        goToGame(gameId) {
            router.visit(`/games/${gameId}`);
        },
        openUpdateModal(game) {
            this.selectedGame = game;
            this.selectedUserGame = {
                state: game.pivot.state,
                user_score: game.pivot.user_score,
                hours_played: game.pivot.hours_played,
                achievements_unlocked: game.pivot.achievements_unlocked,
                mastered: game.pivot.mastered,
                start_date: game.pivot.start_date,
                end_date: game.pivot.end_date,
            };
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
            this.selectedGame = null;
            this.selectedUserGame = null;
        },
        formatState(state) {
            const states = {
                whishlist: 'Whishlist',
                playing: 'Playing',
                completed: 'Completed',
                dropped: 'Dropped',
                planned: 'Planned',
                backlog: 'Backlog',
            };
            return states[state] || state;
        },
        async removeGame(gameId) {
            const result = await Swal.fire({
                title: this.t('Remove game?'),
                text: this.t(
                    'Are you sure you want to remove this game from your collection?',
                ),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.t('YES'),
                cancelButtonText: this.t('NO'),
                confirmButtonColor: '#ff1540',
                cancelButtonColor: '#ff1540',
                background: '#262626',
                color: '#fff',
                iconColor: '#ff1540',
            });

            if (result.isConfirmed) {
                router.delete(`/games/${gameId}/remove`, {
                    preserveScroll: true,
                });
            }
        },
        async incrementAchievement(game) {
            const result = await Swal.fire({
                title: this.t('Increment achievement?'),
                text: this.t(
                    'Do you want to add one achievement to this game?',
                ),
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: this.t('YES'),
                cancelButtonText: this.t('NO'),
                confirmButtonColor: '#ff1540',
                cancelButtonColor: '#ff1540',
                background: '#262626',
                color: '#fff',
                iconColor: '#ff1540',
            });

            if (!result.isConfirmed) return;

            try {
                const response = await fetch(
                    `/api/games/${game.id}/increment-achievement`,
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                        },
                        body: JSON.stringify({}),
                    },
                );

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const data = await response.json();

                const updatedGame = this.games.find((g) => g.id === game.id);
                if (updatedGame) {
                    updatedGame.pivot.achievements_unlocked =
                        data.achievements_unlocked;
                    updatedGame.pivot.state = data.state;
                    updatedGame.pivot.mastered = data.mastered;
                }
            } catch (error) {
                console.error('Error incrementing achievement:', error);
                Swal.fire({
                    title: 'Error',
                    text: this.t('Failed to increment achievement'),
                    icon: 'error',
                    confirmButtonColor: '#ff1540',
                    background: '#262626',
                    color: '#fff',
                });
            }
        },
    },
};
</script>

<style lang="scss" scoped>
@use '../../../css/variables.scss' as *;

.userGamesContainer {
    background-color: #121212;
    padding: 2rem;
    min-height: 100vh;
    font-family: 'Orbitron', sans-serif;
    color: white;
    max-width: 1400px;
    margin: 0 auto;
}

.sectionTitle {
    font-size: 2rem;
    color: $main-color;
    text-align: center;
    margin-bottom: 2rem;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.gamesGrid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 1.5rem;
    padding: 0 1rem;
}

.gameCard {
    position: relative;
    background-color: #1e1e1e;
    border-radius: 6px;
    overflow: hidden;
    transition: all 0.3s ease;
    cursor: pointer;

    &.mastered {
        border: 2px solid $main-color;
        box-shadow: 0 0 10px rgba($main-color, 0.5);
    }

    &:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);

        .gameOverlay {
            transform: translateY(0);
        }
    }
}

.gameImageWrapper {
    position: relative;
    width: 100%;
    height: 0;
    padding-bottom: 150%;
    overflow: hidden;
}

.gameImage {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;

    .gameCard:hover & {
        transform: scale(1.05);
    }
}

.gameOverlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
    padding: 1rem;
    transform: translateY(100%);
    transition: transform 0.3s ease;
    display: flex;
    justify-content: center;
}

.gameActions {
    display: flex;
    gap: 0.5rem;
}

.actionBtn {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid white;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;

    &:hover {
        background: $main-color;
        color: black;
        transform: scale(1.1);
    }
}

.gameInfo {
    padding: 1rem;
}

.gameTitle {
    font-size: 1rem;
    margin: 0;
    color: white;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.gameStats {
    display: flex;
    justify-content: space-between;
    margin-top: 0.5rem;
    font-size: 0.8rem;
    color: #aaa;
}

.gameProgress {
    color: $main-color;
    font-weight: bold;
}

.gameState {
    text-transform: uppercase;
    font-size: 0.7rem;
    letter-spacing: 1px;
}

.noGamesMessage {
    text-align: center;
    margin-top: 3rem;
    font-size: 1.1rem;
    color: #aaa;
    padding: 2rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

.gamesHeader {
    display: flex;
    flex-direction: row;
    margin-bottom: 2rem;
    padding: 0 1rem;
    gap: 10px;

    .searchInput {
        background-color: #1c1c1c;
        border: 1px solid #333;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        font-size: 1rem;
        width: 100%;
    }

    .filters-container {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .filterSelect {
        background-color: #1c1c1c;
        border: 1px solid #333;
        color: white;
        padding: 0.5rem;
        border-radius: 5px;
        font-size: 0.9rem;
        flex: 1;
        min-width: 110px;

        &:focus {
            outline: none;
            border-color: $main-color;
        }
    }
}
.empty-message {
    background-color: #1e1e1e;
    border: 1px dashed $main-color;
    padding: 2rem;
    border-radius: 8px;
    text-align: center;
    font-size: 1.1rem;
    color: #aaa;
    font-family: 'Orbitron', sans-serif;
    margin-top: 2rem;

    h1 {
        color: $main-color;
        font-size: 2rem;
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    p {
        margin: 0;
        color: lighten($main-color, 15%);
        font-size: 1.2rem;
    }
}

@media (max-width: 768px) {
    .gamesGrid {
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    }

    .gamesHeader {
        padding: 0 0.5rem;
        flex-direction: column;
        .filters-container {
            flex-direction: column;

            .filterSelect {
                width: 100%;
            }
        }
    }
}
</style>
