<template>
    <metaHead>
        <title>{{ $t('Games') }}</title>
        <meta
            head-key="description"
            name="description"
            content="Games page of the application"
        />
    </metaHead>

    <section class="gamesPage">
        <FlashMessage />
        <div class="gamesHeader">
            <input
                v-model="search"
                type="text"
                class="searchInput"
                :placeholder="$t('Search...')"
                @input="handleSearch"
            />

            <div class="filters">
                <select v-model="filters.genre">
                    <option value="">{{ $t('All Genres') }}</option>
                    <option
                        v-for="genre in genres"
                        :key="genre.id"
                        :value="genre.name"
                    >
                        {{ genre.name }}
                    </option>
                </select>
                <select v-model="filters.platform">
                    <option value="">{{ $t('All Platforms') }}</option>
                    <option
                        v-for="platform in platforms"
                        :key="platform.id"
                        :value="platform.name"
                    >
                        {{ platform.name }}
                    </option>
                </select>
                <select v-model="filters.theme">
                    <option value="">{{ $t('All Themes') }}</option>
                    <option
                        v-for="theme in themes"
                        :key="theme.id"
                        :value="theme.name"
                    >
                        {{ theme.name }}
                    </option>
                </select>
                <select v-model="filters.saga">
                    <option value="">{{ $t('All Sagas') }}</option>
                    <option
                        v-for="saga in sagas"
                        :key="saga.id"
                        :value="saga.name"
                    >
                        {{ saga.name }}
                    </option>
                </select>
            </div>
        </div>

        <div class="gameGrid">
            <div
                v-for="game in filteredGames"
                :key="game.id"
                @click="viewGame(game.id)"
                class="gameCard"
            >
                <img :src="game.image_url" :alt="game.title" />
                <div class="overlay">
                    <h2>{{ game.title }}</h2>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import FlashMessage from '@/Components/FlashMessage.vue';
import { Head as metaHead, usePage, router } from '@inertiajs/vue3';

export default {
    name: 'Games',
    components: {
        metaHead,
        FlashMessage,
    },
    data() {
        const page = usePage();
        return {
            games: page.props.games || [],
            genres: page.props.genres || [],
            platforms: page.props.platforms || [],
            themes: page.props.themes || [],
            sagas: page.props.sagas || [],
            search: '',
            filters: {
                genre: '',
                platform: '',
                theme: '',
                saga: '',
            },
        };
    },
    computed: {
        filteredGames() {
            return this.games.filter((game) => {
                const matchTitle = game.title
                    .toLowerCase()
                    .includes(this.search.toLowerCase());
                const matchGenre =
                    !this.filters.genre ||
                    game.genres?.some((gam) => gam.name === this.filters.genre);
                const matchPlatform =
                    !this.filters.platform ||
                    game.platforms?.some(
                        (plat) => plat.name === this.filters.platform,
                    );
                const matchTheme =
                    !this.filters.theme ||
                    game.themes?.some(
                        (them) => them.name === this.filters.theme,
                    );
                    const matchSaga = !this.filters.saga || game.saga?.name === this.filters.saga;

                return (
                    matchTitle &&
                    matchGenre &&
                    matchPlatform &&
                    matchTheme &&
                    matchSaga
                );
            });
        },
    },
    methods: {
        viewGame(id) {
            router.visit(`/games/${id}`);
        },
    },
};
</script>

<style scoped lang="scss">
@use '../../css/variables.scss' as *;

.gamesPage {
    background-color: #121212;
    color: white;
    font-family: 'Orbitron', sans-serif;
    padding: 2rem;
    min-height: 78.7vh;

    .gamesHeader {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 2rem;
        gap: 10px;
        justify-content: center;

        .searchInput {
            background-color: #1c1c1c;
            border: 1px solid #333;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-size: 1rem;
            flex: 1;
            width: 60%;
        }

        .filters {
            justify-content: center;
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            flex-grow: 1;

            select {
                background-color: #1c1c1c;
                color: white;
                border: 1px solid #333;
                padding: 0.5rem;
                border-radius: 5px;
                font-size: 0.9rem;
            }
        }
    }

    .gameGrid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 24px;
        max-width: 1100px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .gameCard {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        transition: transform 0.3s;
        cursor: pointer;

        &:hover {
            transform: scale(1.02);
        }

        img {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 12px;
        }

        .overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100%;
        background: rgba(0, 0, 0, 0.75);
        opacity: 0;
        transition: opacity 0.4s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;

        h2 {
            color: white;
            font-size: 1.1rem;
            padding: 1rem;
        }
    }

    &:hover .overlay {
        opacity: 1;
    }
    }
}
</style>
