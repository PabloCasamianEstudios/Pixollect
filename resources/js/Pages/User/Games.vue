<template>
    <metaHead>
        <title>{{ user.name }} Games</title>
        <meta
            head-key="description"
            name="description"
            content="Home page of the application"
        />
    </metaHead>
    <FlashMessage />
    <UserLayout :user="user">
        <div class="userGamesContainer">
            <h1 class="sectionTitle">{{ user.name }}'s Collection</h1>

            <div v-if="games.length" class="gamesGrid">
                <div
                    v-for="game in games"
                    :key="game.id"
                    class="gameCard"
                    @click="goToGame(game.id)"
                >
                    <div class="gameImageWrapper">
                        <img
                            :src="game.image_url"
                            :alt="game.title"
                            class="gameImage"
                        />
                        <div v-if="currentUser?.id === user.id" class="gameOverlay">
                            <div class="gameActions">
                                <button
                                    class="actionBtn"
                                    @click.stop="openUpdateModal(game)"
                                >
                                    O
                                </button>
                                <button class="actionBtn">X</button>
                                <button class="actionBtn">X</button>
                            </div>
                        </div>
                    </div>
                    <div class="gameInfo">
                        <h2 class="gameTitle">{{ game.title }}</h2>
                        <div class="gameStats">
                            <span
                                v-if="game.achievements > 0"
                                class="gameProgress"
                                >{{ ((game.pivot.achievements_unlocked*100)/game.achievements).toFixed(2) }}%</span>
                                <span
                                v-else
                                class="gameProgress"
                                ></span>
                            <span class="gameState">{{
                                formatState(game.pivot.state)
                            }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="noGamesMessage">
                <p>This user hasn't added any games yet.</p>
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
        };
    },
    computed: {
        currentUser() {
            return usePage().props.auth.user;
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

@media (max-width: 768px) {
    .gamesGrid {
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    }
}
</style>
