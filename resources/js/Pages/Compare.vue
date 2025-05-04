<template>
    <Head>
        <title>Game Comparator</title>
        <meta
            head-key="description"
            name="description"
            content="Compare your favorite games"
        />
    </Head>

    <div class="comparator-container">
        <div class="search-section">
            <div class="search-box">
                <input
                    type="text"
                    v-model="searchTerm"
                    @input="searchGames"
                    placeholder="Search game..."
                    class="search-input"
                />
                <button
                    @click="addSelectedGame"
                    :disabled="!selectedGame"
                    class="action-button"
                >
                    ADD
                </button>
            </div>

            <div v-if="searchResults.length" class="search-results">
                <div
                    v-for="game in searchResults"
                    :key="game.id"
                    @click="selectGame(game)"
                    class="game-result"
                >
                    <img :src="game.image_url" class="game-thumbnail" />
                    <span class="game-title">{{ game.title }}</span>
                </div>
            </div>
        </div>

        <div v-if="selectedGames.length" class="comparison-section">
            <div class="comparison-grid">
                <div class="attribute-header">
                    <div class="attribute-name">TITLE</div>
                    <div
                        v-for="game in selectedGames"
                        :key="'title-' + game.id"
                        class="game-value"
                    >
                        {{ game.title }}
                    </div>
                </div>

                <div class="attribute-row">
                    <div class="attribute-name">COVER</div>
                    <div
                        v-for="game in selectedGames"
                        :key="'cover-' + game.id"
                        class="game-value"
                    >
                        <img :src="game.image_url" class="game-cover" />
                    </div>
                </div>

                <div class="attribute-row">
                    <div class="attribute-name">PRICE</div>
                    <div
                        v-for="game in selectedGames"
                        :key="'price-' + game.id"
                        class="game-value"
                    >
                        {{ game.price ? `$${game.price}` : 'N/A' }}
                    </div>
                </div>

                <div class="attribute-row">
                    <div class="attribute-name">ACHIEVEMENTS</div>
                    <div
                        v-for="game in selectedGames"
                        :key="'achievements-' + game.id"
                        class="game-value"
                    >
                        {{ game.achievements_count ?? 'N/A' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const searchTerm = ref('');
const searchResults = ref([]);
const selectedGame = ref(null);
const selectedGames = ref([]);
let searchTimeout = null;

const searchGames = async () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(async () => {
        if (!searchTerm.value.trim()) {
            searchResults.value = [];
            return;
        }

        try {
            const response = await fetch(
                `/api/games/search?query=${encodeURIComponent(searchTerm.value)}`,
            );
            const data = await response.json();
            searchResults.value = data.games || [];
        } catch (error) {
            console.error('Error searching games:', error);
        }
    }, 300);
};

const selectGame = (game) => {
    selectedGame.value = game;
    searchTerm.value = game.title;
    searchResults.value = [];
};

const addSelectedGame = () => {
    if (
        selectedGame.value &&
        !selectedGames.value.find((g) => g.id === selectedGame.value.id)
    ) {
        selectedGames.value.push(selectedGame.value);
    }
    selectedGame.value = null;
    searchTerm.value = '';
};
</script>

<style scoped lang="scss">
@use '../../css/variables.scss' as *;

.comparator-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 1rem;
    font-family: 'Orbitron', sans-serif;
    color: white;
}

.search-section {
    margin-bottom: 2rem;
}

.search-box {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.search-input {
    flex-grow: 1;
    padding: 0.8rem 1rem;
    background: #1e1e1e;
    border: 1px solid #333;
    border-radius: 6px;
    color: white;
    font-family: 'Orbitron', sans-serif;
    font-size: 1rem;

    &:focus {
        outline: none;
        border-color: $main-color;
        box-shadow: 0 0 0 2px rgba($main-color, 0.3);
    }
}

.action-button {
    padding: 0 1.5rem;
    background-color: $main-color;
    border: none;
    border-radius: 6px;
    color: black;
    font-weight: bold;
    font-family: 'Orbitron', sans-serif;
    text-transform: uppercase;
    cursor: pointer;
    transition: background-color 0.3s;

    &:hover:not(:disabled) {
        background-color: lighten($main-color, 10%);
    }

    &:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
}

.search-results {
    background: #1e1e1e;
    border: 1px solid #333;
    border-radius: 6px;
    max-height: 300px;
    overflow-y: auto;
}

.game-result {
    display: flex;
    align-items: center;
    padding: 0.8rem 1rem;
    cursor: pointer;
    transition: background-color 0.2s;

    &:hover {
        background-color: rgba($main-color, 0.1);
    }
}

.game-thumbnail {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 4px;
    margin-right: 1rem;
}

.game-title {
    font-size: 0.9rem;
}

.comparison-section {
    background: #1e1e1e;
    border-radius: 8px;
    padding: 1rem;
    border: 1px solid #333;
}

.comparison-grid {
    display: grid;
    grid-template-columns: 150px repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.attribute-header, .attribute-row {
    display: contents;
}

.attribute-name {
    font-weight: bold;
    color: $main-color;
    text-transform: uppercase;
    padding: 1rem;
    display: flex;
    align-items: center;
    background: rgba(0, 0, 0, 0.2);
    border-radius: 4px;
}

.game-value {
    padding: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.03);
    border-radius: 4px;
    border: 1px solid #333;
}

.game-cover {
    width: 100px;
    height: auto;
    border-radius: 6px;
    border: 1px solid #444;
}
</style>
