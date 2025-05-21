<template>
    <metaHead>
        <title>Home</title>
        <meta
            head-key="description"
            name="description"
            content="Home page of the application"
        />
    </metaHead>

    <div class="home-container">
        <div v-if="!currentUser" class="inner-bordered-box">
            <img src="images/icon.png" alt="Pixollect" class="logo" />
            <h1 class="home-title">Welcome to Pixollect</h1>
            <p class="home-paragraph">
                Track, compare, and explore your video game collection with
                ease.
            </p>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Track Your Collection</h3>
                    <p>Keep record of all your games in one place</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔍</div>
                    <h3>Discover New Games</h3>
                    <p>Find recommendations based on your taste</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🏆</div>
                    <h3>Achievement Tracking</h3>
                    <p>Monitor your gaming progress and trophies</p>
                </div>
            </div>

            <div class="button-group">
                <button @click="$inertia.visit('/login')" class="home-button">
                    Login
                </button>
                <button
                    @click="$inertia.visit('/register')"
                    class="home-button"
                >
                    Register
                </button>
            </div>
        </div>

        <div v-else class="logged-in-content">
            <div class="logged-box">
                <img src="images/icon.png" alt="Pixollect" class="logo" />
                <h1>Pixollect</h1>
                <p class="stats-text">
                    TOTAL USERS: {{ stats.users }} | TOTAL GAMES:
                    {{ stats.games }}
                </p>

                <div class="slider-wrapper" v-if="latestGames.length">
                    <div class="slider-track">
                        <div
                            v-for="(game, index) in repeatedGames"
                            :key="game.id + '-' + index"
                            class="gameCard"
                            @click="$inertia.visit(`/games/${game.id}`)"
                        >
                            <img :src="game.image_url" :alt="game.title" />
                            <div class="overlay">
                                <h2>{{ game.title }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head as metaHead, usePage } from '@inertiajs/vue3';

export default {
    components: {
        metaHead,
    },
    data() {
        return {
            latestGames: [],
            stats: {
                users: 0,
                games: 0,
            },
        };
    },
    computed: {
        currentUser() {
            return usePage().props.auth?.user || null;
        },
        repeatedGames() {
            return [
                ...this.latestGames,
                ...this.latestGames,
                ...this.latestGames,
            ];
        },
        sliderStyle() {
            return {
                animation: 'scrollLeft 30s linear infinite',
            };
        },
    },
    mounted() {
        if (this.currentUser) {
            this.fetchLatestGames();
            this.fetchStats();
        }
    },
    methods: {
        async fetchLatestGames() {
            const res = await fetch('/api/games/games/latest');
            const data = await res.json();
            this.latestGames = data.data || [];
        },
        async fetchStats() {
            const res = await fetch('/api/globalStats');

            const data = await res.json();
            this.stats.users = data.total_users;
            this.stats.games = data.total_games;
        },
    },
};
</script>
<style scoped lang="scss">
@use '../../css/variables.scss' as *;

.home-container {
    max-width: 1000px;
    margin: 2rem auto;
    padding: 2rem;
    color: #ccc;
    font-family: 'Orbitron', sans-serif;
}

.inner-bordered-box {
    border: 1px dashed $main-color;
    padding: 2rem;
    border-radius: 8px;
    background-color: #1e1e1e;
    text-align: center;
}

.home-title {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: $main-color;
}

.home-paragraph {
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

.button-group {
    display: flex;
    justify-content: center;
    gap: 1.5rem;

    margin-top: 2rem;
}

.home-button {
    background-color: #1e1e1e;
    color: white;
    font-weight: bold;
    padding: 0.8rem 2rem;
    border: 1px dashed $main-color;
    border-radius: 6px;
    cursor: pointer;
    text-transform: uppercase;
    transition: all 0.4s ease;

    &:hover {
        background-color: $main-color;
        color: black;
    }
}

.logged-in-content {
    text-align: center;
}

.logo {
    max-width: 150px;
    margin-bottom: 1.5rem;
}

.stats-text {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    color: lighten($main-color, 10%);
}

.slider-wrapper {
    overflow: hidden;
    position: relative;
    height: 260px;
    border: 1px solid #333;
    border-radius: 8px;
    background-color: #1e1e1e;
    padding: 1rem 0;
}

.slider-track {
    display: flex;
    gap: 2.5rem;
    padding: 0 1rem;
    width: max-content;
    animation: scroll-left 60s linear infinite;
    align-items: center;
}

@keyframes scroll-left {
    0% {
        transform: translateX(0%);
    }
    100% {
        transform: translateX(-50%);
    }
}

.gameCard {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
    width: 150px;
    height: 225px;
    flex-shrink: 0;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    transition: transform 0.3s;
    cursor: pointer;

    &:hover {
        transform: scale(1.05);
    }

    img {
        width: 100%;
        height: 100%;
        object-fit: cover;
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
            font-size: 1rem;
            padding: 0.5rem;
        }
    }

    &:hover .overlay {
        opacity: 1;
    }


}

.logged-in-content {
        text-align: center;

        .logged-box {
            border: 1px dashed $main-color;
            background-color: #1e1e1e;
            padding: 2rem;
            border-radius: 10px;
            max-width: 1000px;
            margin: 0 auto;

            h1 {
                color: $main-color;
                font-size: 2rem;
                margin-bottom: 1rem;
            }

            .stats-text {
                font-size: 1.1rem;
                margin-bottom: 2rem;
                color: lighten($main-color, 15%);
            }

            .slider-wrapper {
                border: 1px solid #333;
                border-radius: 8px;
                background-color: #1c1c1c;
                padding: 1rem 0;
                overflow: hidden;
                position: relative;
                height: 260px;
            }
        }

        .logo {
            max-width: 150px;
            margin-bottom: 1rem;
        }
    }
</style>
