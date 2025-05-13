<template>
    <Head>
        <title>{{ game.title }} - Game Details</title>
        <meta
            head-key="description"
            name="description"
            :content="'Details for ' + game.title"
        />
    </Head>

    <div class="gameDetailContainer">
        <FlashMessage />

        <div class="gameDetailLeft">
            <img :src="game.image_url" alt="Game Cover" class="gameCover" />
            <div class="gameInfo">
                <div class="downTags">
                    <strong>Platforms:</strong>
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
                <div class="downTags">
                    <strong>Genres:</strong>
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
                <div class="downTags">
                    <strong>Themes:</strong>
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
                <!-- pablo del futuro decide si ponerlas o no

                 <div class="downTags">
                    <strong>Tags:</strong>
                    <div class="pill-container">
                        <span
                            v-for="tag in game.game_tags"
                            :key="tag.id"
                            class="pill"
                            @click="redirectToGameList"
                        >
                            {{ tag.name }}
                        </span>
                    </div>
                </div> -->
            </div>
        </div>

        <div class="gameDetailRight">
            <h1 class="gameTitle">{{ game.title }}</h1>
            <p class="gameRelease">
                Released on {{ formatDate(game.release_date) }} by
                {{ game.developer }} and published by {{ game.publisher }}
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

        <UserGameModal v-if="showModal" :game="game" :userGames="userGames" @close="closeModal" />
    </div>
</template>

<script>
import { Head, router, usePage } from '@inertiajs/vue3';
import UserGameModal from '@/Components/UserGameModal.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
export default {
    components: {
        Head,
        UserGameModal,
        FlashMessage
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
        };
    },
    mounted() {
        this.fetchSameSagaGames();
    },
    computed: {
        isGameInCollection() {
            return this.userGames.some(
                (userGame) => userGame.id === this.game.id,
            );
        },
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
        openModal() {
            if(this.currentUser() !== null) {
                 this.showModal = true;
            } else {
                console.log('you need to be registered'); // PABLO DEL FUTURO HAZ UN AVISO PARA EL USUARIO DE Q ESTO NO FUSCA PQ NO ESTÁ LOGGED
            }
        },
        closeModal() {
            this.showModal = false;
        },
        goToGame(gameId) {
            router.visit(`/games/${gameId}`);
        },
        async removeFromCollection(gameId) {
            if (
                confirm(
                    'Are you sure you want to remove this game from your collection?',
                )
            ) {
                try {
                    await router.delete(`/games/${gameId}/remove`);
                } catch (error) {
                    console.error('Error removing game:', error);
                }
            }
        },
        formatDate(date) {
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
    max-width: 900px;
    margin: 2rem auto;
    padding: 2rem;
    background-color: #1c1c1c;
    color: white;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    font-family: 'Orbitron', sans-serif;
    display: flex;
    justify-content: space-between;
    gap: 2rem;
}

.gameDetailLeft {
    width: 30%;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.gameCover {
    width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}

.gameInfo {
    margin-top: 1rem;
    text-align: center;
    .downTags {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    p {
        font-size: 1rem;
        margin: 0.5rem 0;
    }

    strong {
        color: $main-color;
    }
}

.pill-container {
    margin-top: 0.5rem;
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    justify-content: center;
    margin: 10px 10px 10px 10px;
}

.pill {
    background-color: #2c2c2c;
    padding: 0.4rem 0.8rem;
    border-radius: 10px;
    border: 1px solid $main-color;
    font-size: 0.9rem;
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

.gameDetailRight {
    width: 65%;

    .gameTitle {
        font-size: 4rem;
        font-weight: bold;
        color: white;
        margin-bottom: 1rem;
    }

    .gameRelease {
        font-size: 1.2rem;
        color: #a1a1a1;
        margin-top: 0.5rem;
    }

    .gameDescription {
        font-size: 1rem;
        color: white;
        margin-top: 1rem;
        line-height: 1.6;
    }

    .addBtn {
        background-color: $main-color;
        color: black;
        padding: 0.7rem 1.4rem;
        border-radius: 6px;
        font-weight: bold;
        font-size: 1rem;
        margin-top: 2rem;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;

        &:hover {
            background-color: lighten($main-color, 10%);
        }
    }
}

.same-saga-section {
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid lighten(#1c1c1c, 10%);

    h3 {
        color: $main-color;
        margin-bottom: 1.5rem;
        font-size: 1.5rem;
    }

    .saga-game-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1.5rem;
    }

    .saga-game-card {
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: #2a2a2a;
        border-radius: 10px;
        padding: 0.8rem;
        text-align: center;

        &:hover {
            transform: translateY(-5px);

            .saga-title {
                color: $main-color;
            }
        }

        .saga-cover {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin-bottom: 0.8rem;
            border: 2px solid transparent;
        }

        .saga-title {
            font-size: 0.95rem;
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
</style>
