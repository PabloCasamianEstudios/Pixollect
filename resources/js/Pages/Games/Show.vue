<template>
    <metaHead>
        <title>{{ game.title }} - Game Details</title>
        <meta
            head-key="description"
            name="description"
            :content="'Details for ' + game.title"
        />
    </metaHead>

    <div class="gameDetailContainer">
        <FlashMessage />

        <div class="gameDetailLeft">
            <img :src="game.image_url" alt="Game Cover" class="gameCover" />
            <div class="gameStats">
                <div class="statItem">
                    <span class="statValue">{{ this.players || 0 }}</span>
                    <span class="statLabel">Players</span>
                </div>
                <div class="statItem">
                    <span class="statValue">{{ this.avg ? this.avg.toFixed(1) : 'N/A' }}</span>
                    <span class="statLabel">Avg. Rating</span>
                </div>
                <div class="statItem">
                    <span class="statValue">#{{ this.rank }}</span>
                    <span class="statLabel">Game Rank</span>
                </div>
                <!-- esto hay que pulirlo
                <div class="recentPlayers" v-if="recentPlayers.length > 0">
                    <h4>Recent Players</h4>
                    <div class="playerList">
                        <div v-for="player in recentPlayers" :key="player.id" class="playerItem">
                            <span class="playerName">{{ player.name }}</span>
                            <span class="playerHours">{{ player.hours_played }}h</span>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>

        <div class="gameDetailCenter">
            <h1 class="gameTitle">{{ game.title }}</h1>
            <p class="gameRelease">
                Released on {{ formatDate(game.release_date) }} by
                {{ game.developer || 'Unknown' }} and published by {{ game.publisher || 'Unknown' }}
            </p>
            <p class="gameDescription">{{ game.description }}</p>

            <button
                v-if="!isGameInCollection"
                class="addBtn"
                @click="openModal"
            >
                Add to your Collection
            </button>
            <button
                v-else
                class="addBtn"
                @click="removeFromCollection(game.id)"
            >
                Remove from Collection
            </button>

            <div v-if="game.saga && sameSagaGames.length" class="same-saga-section">
                <h3>More from the "{{ game.saga.name }}" saga</h3>
                <div class="saga-game-list">
                    <div
                        v-for="sagaGame in sameSagaGames"
                        :key="sagaGame.id"
                        class="saga-game-card"
                        @click="goToGame(sagaGame.id)"
                    >
                        <img :src="sagaGame.image_url" alt="Game Cover" class="saga-cover" />
                        <p class="saga-title">{{ sagaGame.title }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="gameDetailRight">
            <div class="tagsSection">
                <h3>Game Details</h3>
                <div class="tagsGroup">
                    <h4>Platforms</h4>
                    <div class="pill-container">
                        <span
                            v-for="platform in game.platforms"
                            :key="platform.id"
                            class="pill"
                            @click="redirectToGameList"
                        >
                            {{ platform.name }}
                        </span>
                    </div>
                </div>
                <div class="tagsGroup">
                    <h4>Genres</h4>
                    <div class="pill-container">
                        <span
                            v-for="genre in game.genres"
                            :key="genre.id"
                            class="pill"
                            @click="redirectToGameList"
                        >
                            {{ genre.name }}
                        </span>
                    </div>
                </div>
                <div class="tagsGroup">
                    <h4>Themes</h4>
                    <div class="pill-container">
                        <span
                            v-for="theme in game.themes"
                            :key="theme.id"
                            class="pill"
                            @click="redirectToGameList"
                        >
                            {{ theme.name }}
                        </span>
                    </div>
                </div>
                <div class="tagsGroup" v-if="game.game_modes && game.game_modes.length">
                    <h4>Game Modes</h4>
                    <div class="pill-container">
                        <span
                            v-for="mode in game.game_modes"
                            :key="mode.id"
                            class="pill"
                            @click="redirectToGameList"
                        >
                            {{ mode.name }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <UserGameModal v-if="showModal" :game="game" :userGames="userGames" @close="closeModal" />
    </div>
</template>

<script>
import { Head as metaHead, router, usePage } from '@inertiajs/vue3';
import UserGameModal from '@/Components/UserGameModal.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import Swal from 'sweetalert2';
export default {
    components: {
        UserGameModal,
        FlashMessage,
        metaHead
    },
    props: {
        game: Object,
        platforms: Array,
        genres: Array,
        themes: Array,
        gameTags: Array,
        gameModes: Array,
        sagas: Array,
        userGames: Array,
    },
    data() {
        return {
            showModal: false,
            sameSagaGames: [],
            gameRank: 'N/A',
            allGamesStats: [],
            players: 0,
            avg: null,
            rank: null,
        };
    },
    computed: {
        isGameInCollection() {
            return this.userGames.some(
                (userGame) => userGame.id === this.game.id,
            );
        },
        recentPlayers() {
            return this.game.recent_players || [];
        }
    },
    async mounted() {
        await this.fetchSameSagaGames();
        await this.fetchGameStats();
    },
    methods: {
        currentUser() {
            return usePage().props.auth.user;
        },
        async fetchSameSagaGames() {
            const response = await fetch(
                `${window.location.protocol}//${window.location.host}/api/games/${this.game.id}/same-saga`
            );
            this.sameSagaGames = (await response.json()).games;
        },
        async fetchGameStats() {
            try {
                const response = await fetch(`/api/games/${this.game.id}/stats`);
                const stats = await response.json();
                console.log(stats);

                this.rank = stats.rank || 'N/A';
                this.players = stats.total_players;
                this.avg = stats.average_score;

            } catch (error) {
                console.error('Error fetching game stats:', error);
            }
        },
        openModal() {
            if(this.currentUser() !== null) {
                 this.showModal = true;
            } else {
                console.log('you need to be registered');
            }
        },
        closeModal() {
            this.showModal = false;
        },
        goToGame(gameId) {
            router.visit(`/games/${gameId}`);
        },
        async removeFromCollection(gameId) {
    const result = await Swal.fire({
        title: 'Are you sure?',
        text: 'Are you sure you want to remove this game from your collection?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'YES',
        cancelButtonText: 'NO',
        confirmButtonColor: '#ff1540',
        cancelButtonColor: '#ff1540',
        background: '#262626',
        color: '#fff',
        iconColor: '#ff1540'
    });

    if (result.isConfirmed) {
        try {
            await router.delete(`/games/${gameId}/remove`);
        } catch (error) {
            console.error('Error removing game:', error);
        }
    }
},
        formatDate(date) {
            if (!date) return 'N/A';
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return new Date(date).toLocaleDateString('en-US', options);
        },
        redirectToGameList() {
            router.visit('/gameList');
        },
    },
};
</script>

<style scoped lang="scss">
@use '../../../css/variables.scss' as *;

.gameDetailContainer {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 2rem;
    background-color: #1c1c1c;
    color: white;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    font-family: 'Orbitron', sans-serif;
    display: grid;
    grid-template-columns: 250px 1fr 250px;
    gap: 2rem;
}

.gameDetailLeft {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.gameCover {
    width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    border: 1px solid #333;
}

.gameStats {
    background: #1e1e1e;
    border-radius: 8px;
    padding: 1.5rem;
    border: 1px solid #333;

    .statItem {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #333;

        &:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
    }

    .statValue {
        font-size: 1.8rem;
        font-weight: bold;
        color: $main-color;
        margin-bottom: 0.3rem;
    }

    .statLabel {
        font-size: 0.9rem;
        color: #aaa;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
}

.recentPlayers {
    margin-top: 2rem;

    h4 {
        color: $main-color;
        font-size: 1rem;
        margin-bottom: 1rem;
        text-align: center;
        text-transform: uppercase;
    }

    .playerList {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }

    .playerItem {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.9rem;

        .playerName {
            color: #ddd;
        }

        .playerHours {
            color: $main-color;
            font-weight: bold;
        }
    }
}

.gameDetailCenter {
    .gameTitle {
        font-size: 2.5rem;
        font-weight: bold;
        color: white;
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .gameRelease {
        font-size: 1rem;
        color: #a1a1a1;
        margin-bottom: 1.5rem;
    }

    .gameDescription {
        font-size: 1rem;
        color: white;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .addBtn {
        background-color: $main-color;
        color: black;
        padding: 0.7rem 1.4rem;
        border-radius: 6px;
        font-weight: bold;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
        border: none;
        text-transform: uppercase;
        letter-spacing: 1px;

        &:hover {
            background-color: lighten($main-color, 10%);
        }
    }
}

.gameDetailRight {
    .tagsSection {
        background: #1e1e1e;
        border-radius: 8px;
        padding: 1.5rem;
        border: 1px solid #333;

        h3 {
            color: $main-color;
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
        }

        .tagsGroup {
            margin-bottom: 1.5rem;

            &:last-child {
                margin-bottom: 0;
            }

            h4 {
                color: #ddd;
                font-size: 0.9rem;
                margin-bottom: 0.8rem;
                text-transform: uppercase;
                letter-spacing: 1px;
            }
        }
    }
}

.pill-container {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.pill {
    background-color: #2c2c2c;
    padding: 0.4rem 0.8rem;
    border-radius: 10px;
    border: 1px solid $main-color;
    font-size: 0.8rem;
    color: white;
    cursor: pointer;
    transition:
        background-color 0.3s,
        color 0.3s;

    &:hover {
        background-color: $main-color;
        color: black;
    }
}

.same-saga-section {
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid #333;

    h3 {
        color: $main-color;
        margin-bottom: 1.5rem;
        font-size: 1.3rem;
        text-transform: uppercase;
    }

    .saga-game-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 1rem;
    }

    .saga-game-card {
        cursor: pointer;
        transition: transform 0.3s ease;
        background: #1e1e1e;
        border-radius: 8px;
        padding: 0.8rem;
        text-align: center;
        border: 1px solid #333;

        &:hover {
            transform: translateY(-5px);
            border-color: $main-color;

            .saga-title {
                color: $main-color;
            }
        }

        .saga-cover {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 0.8rem;
        }

        .saga-title {
            font-size: 0.85rem;
            color: #ddd;
            transition: color 0.3s ease;
            font-weight: 500;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    }
}

@media (max-width: 900px) {
    .gameDetailContainer {
        grid-template-columns: 1fr;
    }

    .gameDetailLeft {
        align-items: center;
    }

    .gameCover {
        max-width: 250px;
    }

    .gameStats {
        width: 100%;
        max-width: 400px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;

        .statItem {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
            border-right: 1px solid #333;
            padding-right: 1rem;

            &:last-child {
                border-right: none;
            }
        }

        .recentPlayers {
            grid-column: span 3;
            margin-top: 1rem;
        }
    }
}
</style>
