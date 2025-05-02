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
                </div>
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
        </div>

        <UserGameModal v-if="showModal" :game="game" @close="closeModal" />
    </div>
</template>

<script setup>
import { Head, router, usePage } from '@inertiajs/vue3';
import { defineProps, ref, computed } from 'vue';
import UserGameModal from '@/Components/UserGameModal.vue';

const props = defineProps({
    game: Object,
    platforms: Array,
    genres: Array,
    themes: Array,
    gameTags: Array,
    gameModes: Array,
    sagas: Array,
    userGames: Array,
});
const showModal = ref(false);

// methods

function openModal() {
    showModal.value = true;
}
function closeModal() {
    showModal.value = false;
}

async function removeFromCollection(gameId) {
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
}

function formatDate(date) {
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(date).toLocaleDateString('en-US', options);
}

function redirectToGameList() {
    router.visit('/gameList');
}
const isGameInCollection = computed(() =>
    props.userGames.some((userGame) => userGame.id === props.game.id),
);
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
        font-size: 2rem;
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
</style>
