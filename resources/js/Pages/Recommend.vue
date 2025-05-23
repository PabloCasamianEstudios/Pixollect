<template>
    <metaHead>
        <title>Recomendator</title>
        <meta
            head-key="description"
            name="description"
            content="Personalized game recommendations"
        />
    </metaHead>

    <div v-if="currentUser() !== null" class="recommendation-container">
        <div
            v-if="games.length > 0 && currentGameIndex < games.length"
            class="decision-section"
        >
            <h1 class="title">Discover New Games</h1>
            <p class="subtitle">Based on your gaming preferences</p>

            <div class="game-card-wrapper">
                <button @click="rejectGame" class="decision-btn">
                    <span class="icon">✕</span>
                </button>

                <div
                    class="main-game-card"
                    :class="{ 'disliked': isDisliked(games[currentGameIndex].game.id) }"
                    @click="viewGame(games[currentGameIndex].game.id)"
                >
                    <img
                        :src="games[currentGameIndex].game.image_url"
                        :alt="games[currentGameIndex].game.title"
                        class="game-image"
                    />
                    <div class="game-info">
                        <h3>{{ games[currentGameIndex].game.title }}</h3>
                        <div class="game-meta">
                            <span v-if="games[currentGameIndex].game.release_date">
                                {{ new Date(games[currentGameIndex].game.release_date).getFullYear() }}
                            </span>
                            <span>{{ games[currentGameIndex].game.genres.map((g) => g.name).join(', ') }}</span>
                        </div>
                    </div>
                </div>

                <button @click="acceptGame" class="decision-btn">
                    <span class="icon">✓</span>
                </button>
            </div>

            <div class="progress-indicator">
                {{ currentGameIndex + 1 }} / {{ games.length }}
            </div>
        </div>

        <div class="selected-games-section">
            <h2 v-if="selectedGames.length > 0">Your Selected Games</h2>
            <div class="selected-games-grid">
                <div
                    v-for="(game, index) in selectedGames"
                    :key="index"
                    class="selected-game-card"
                    @click="viewGame(game.game.id)"
                >
                    <img
                        :src="game.game.image_url"
                        :alt="game.game.title"
                        class="selected-game-image"
                    />
                    <div class="selected-game-overlay">
                        <span>{{ game.game.title }}</span>
                    </div>
                </div>
            </div>

            <div
                v-if="currentGameIndex >= games.length && games.length > 0"
                class="recommendation-complete"
            >
                <h3>You've reviewed all recommendations!</h3>
                <p>Come back tomorrow for new suggestions.</p>
                <div v-if="dislikedGames.length > 0" class="disliked-games-list">
                    <h4>Games you disliked:</h4>
                    <div class="disliked-games-grid">
                        <div
                            v-for="(game, index) in dislikedGames"
                            :key="'disliked-'+index"
                            class="disliked-game-card"
                            @click="viewGame(game.id)"
                        >
                            <img
                                :src="game.image_url"
                                :alt="game.title"
                                class="disliked-game-image"
                            />
                            <div class="disliked-game-overlay">
                                <span>{{ game.title }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div v-else class="recommendation-container">
        <div class="empty-message">
            <h1>SORRY!!!</h1>
            <p>You must be logged in to get personalized game recommendations</p>
        </div>
    </div>
</template>

<script>
import { usePage, Head as metaHead } from '@inertiajs/vue3';

export default {
    components: {
        metaHead
    },
    data() {
        return {
            games: [],
            currentGameIndex: 0,
            selectedGames: [],
            dislikedGames: [],
            isLoading: true,
            error: null,
        };
    },
    computed: {
        userId() {
            return usePage().props.auth.user?.id;
        },
    },
    mounted() {
        if (!this.userId) {
            this.error = 'Debes iniciar sesión para ver recomendaciones';
            return;
        }

        this.fetchRecommendations();

        const lastRecommendationDate = localStorage.getItem('lastRecommendationDate');
        const today = new Date().toISOString().split('T')[0];

        if (lastRecommendationDate !== today) {
            localStorage.setItem('lastRecommendationDate', today);
            this.resetRecommendations();
        } else {
            const savedState = localStorage.getItem('recommendationState');
            if (savedState) {
                const state = JSON.parse(savedState);
                this.currentGameIndex = state.currentIndex;
                this.selectedGames = state.selectedGames;
                this.dislikedGames = state.dislikedGames || [];
            }
        }
    },
    methods: {
        currentUser() {
            return usePage().props.auth.user;
        },
        async fetchRecommendations() {
            try {
                this.isLoading = true;
                this.error = null;

                if (!this.userId) {
                    throw new Error('Usuario no autenticado');
                }

                const response = await fetch(`/api/recommend/${this.userId}`);

                if (!response.ok) {
                    throw new Error(`Error HTTP! estado: ${response.status}`);
                }

                const data = await response.json();
                this.games = data;
            } catch (err) {
                console.error('Error al obtener recomendaciones:', err);
                this.error = 'Error al cargar recomendaciones. Inténtalo de nuevo.';
            } finally {
                this.isLoading = false;
            }
        },
        saveState() {
            const state = {
                currentIndex: this.currentGameIndex,
                selectedGames: this.selectedGames,
                dislikedGames: this.dislikedGames
            };
            localStorage.setItem('recommendationState', JSON.stringify(state));
        },
        resetRecommendations() {
            this.currentGameIndex = 0;
            this.selectedGames = [];
            this.dislikedGames = [];
            this.saveState();
            this.fetchRecommendations();
        },
        acceptGame() {
            this.selectedGames.push(this.games[this.currentGameIndex]);
            this.nextGame();
        },
        rejectGame() {
            this.dislikedGames.push(this.games[this.currentGameIndex].game);
            this.nextGame();
        },
        nextGame() {
            this.currentGameIndex++;
            this.saveState();

            if (this.currentGameIndex >= this.games.length) {
                this.saveState();
            }
        },
        viewGame(gameId) {
            this.$inertia.visit(`/games/${gameId}`);
        },
        isDisliked(gameId) {
            return this.dislikedGames.some(g => g.id === gameId);
        }
    },
};
</script>

<style lang="scss" scoped>
@use '../../css/variables.scss' as *;

.recommendation-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 2rem;
    color: white;
    border-radius: 12px;
    background-color: #1c1c1c;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    font-family: 'Orbitron', sans-serif;
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
    }

    p {
        margin: 0;
        color: lighten($main-color, 15%);
        font-size: 1.2rem;
    }
}

.title {
    font-size: 2rem;
    color: $main-color;
    text-align: center;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.subtitle {
    text-align: center;
    color: #aaa;
    margin-bottom: 2rem;
    font-size: 1rem;
}

.decision-section {
    margin-bottom: 3rem;
    transition: all 0.3s ease;
    padding: 1rem;
    background: #1e1e1e;
    border-radius: 8px;
    border: 1px solid #333;
}

.game-card-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 2rem;
    margin: 2rem 0;
}

.main-game-card {
    width: 300px;
    height: 400px;
    position: relative;
    cursor: pointer;
    transition: transform 0.3s ease;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    border: 1px solid #333;

    &:hover {
        transform: scale(1.03);
    }

    &.disliked {
        filter: grayscale(100%);
        opacity: 0.7;
    }
}

.game-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.game-info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1.5rem;
    background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));

    h3 {
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
        color: white;
        font-weight: 500;
    }
}

.game-meta {
    display: flex;
    justify-content: space-between;
    font-size: 0.9rem;
    color: #ccc;
}

.decision-btn {
    width: 70px;
    height: 70px;
    border: none;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-weight: bold;
    transform: rotate(45deg);
    background-color: $main-color;
    color: white;

    &:hover {
        transform: rotate(45deg) scale(1.1);
    }

    .icon {
        font-size: 2rem;
        transform: rotate(-45deg);
    }
}

.progress-indicator {
    text-align: center;
    color: #aaa;
    font-size: 0.9rem;
    margin-top: 1rem;
    padding: 0.5rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 4px;
}

.selected-games-section {
    margin-top: 3rem;
    padding: 1rem;
    background: #1e1e1e;
    border-radius: 8px;
    border: 1px solid #333;

    h2 {
        text-align: center;
        margin-bottom: 2rem;
        color: $main-color;
        text-transform: uppercase;
        font-size: 1.5rem;
    }
}

.selected-games-grid, .disliked-games-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 1.5rem;
    padding: 1rem;
}

.selected-game-card, .disliked-game-card {
    position: relative;
    height: 200px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.3s ease;
    border: 1px solid #444;

    &:hover {
        transform: scale(1.05);
    }
}

.disliked-game-card {
    filter: grayscale(100%);
    opacity: 0.7;

    &:hover {
        filter: grayscale(70%);
        opacity: 0.9;
    }
}

.selected-game-image, .disliked-game-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.selected-game-overlay, .disliked-game-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 0.8rem;
    background: rgba(0, 0, 0, 0.7);
    text-align: center;
    font-size: 0.9rem;
    color: white;
}

.recommendation-complete {
    text-align: center;
    margin-top: 2rem;
    padding: 2rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    border: 1px dashed $main-color;

    h3 {
        color: $main-color;
        margin-bottom: 0.5rem;
        font-size: 1.3rem;
    }

    p {
        color: #aaa;
    }
}

.disliked-games-list {
    margin-top: 2rem;

    h4 {
        color: #f44336;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }
}

@media (max-width: 768px) {
    .game-card-wrapper {
        flex-direction: column;
        gap: 1rem;
    }

    .decision-btn {
        width: 60px;
        height: 60px;
    }

    .main-game-card {
        width: 100%;
        height: 70vh;
    }

    .selected-games-grid, .disliked-games-grid {
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    }
}
</style>
