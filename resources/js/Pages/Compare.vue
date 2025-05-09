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
        <div class="comparison-table">
            <table>
                <thead>
                    <tr>
                        <th class="attribute-header">TITLE</th>
                        <th class="attribute-header">COVER</th>
                        <th class="attribute-header">PRICE</th>
                        <th class="attribute-header">DEVELOPER</th>
                        <th class="attribute-header">RELEASE DATE</th>
                        <th class="attribute-header">GENRES</th>
                        <th class="attribute-header">PLATFORMS</th>
                        <th class="attribute-header">GAME MODES</th>
                        <th class="attribute-header">THEMES</th>
                        <th class="attribute-header">SAGA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="game in selectedGames" :key="game.id" class="game-row">
                        <td class="game-value title">{{ game.title }}</td>
                        <td class="game-value cover">
                            <img :src="game.image_url" class="game-cover" />
                        </td>
                        <td class="game-value price">
                            {{ formatPrice(game.price) }}
                        </td>
                        <td class="game-value developer">
                            {{ game.developer || 'N/A' }}
                        </td>
                        <td class="game-value release-date">
                            {{ formatDate(game.release_date) }}
                        </td>
                        <td class="game-value genres">
                            {{ game.genres?.map(g => g.name).join(', ') || 'N/A' }}
                        </td>
                        <td class="game-value platforms">
                            {{ game.platforms?.map(p => p.name).join(', ') || 'N/A' }}
                        </td>
                        <td class="game-value game-modes">
                            {{ game.game_modes?.map(m => m.name).join(', ') || 'N/A' }}
                        </td>
                        <td class="game-value themes">
                            {{ game.themes?.map(t => t.name).join(', ') || 'N/A' }}
                        </td>
                        <td class="game-value saga">
                            {{ game.saga?.name || 'N/A' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

        <div v-else class="empty-message">
            <p>No games added yet. Start by searching and adding your favorite titles!</p>
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

const formatPrice = (price) => {
    if (price === 0 || price === '0') return 'GRATIS';
    if (!price) return 'N/A';
    return `$${price}`;
};
const formatDate = (dateString) => {
    if (!dateString) return 'N/A';

    try {
        const date = new Date(dateString);
        return date.toLocaleDateString('es-ES', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    } catch (e) {
        return 'N/A';
    }
};
const formatRelation = (relation) => {
    if (!relation || !relation.length) return 'N/A';
    return relation.map(item => item.name).join(', ');
};
</script>

<style scoped lang="scss">
@use '../../css/variables.scss' as *;

.comparator-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 2rem;
    color: white;
    border-radius: 12px;

    background-color: #1c1c1c;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
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
    overflow-x: auto;
}

.comparison-table {
    width: 100%;
    overflow-x: auto;
    table {
        width: 100%;
        border-collapse: collapse;
    }
}

.attribute-header {
    padding: 1rem;
    background: rgba($main-color, 0.2);
    color: $main-color;
    text-transform: uppercase;
    font-weight: bold;
    text-align: left;
    border-bottom: 2px solid $main-color;
}

.game-row {
    &:nth-child(even) {
        background: rgba(255, 255, 255, 0.03);
    }

    &:hover {
        background: rgba($main-color, 0.1);
    }
}

.game-value {
    padding: 0.8rem 1rem;
    border-bottom: 1px solid #333;

    white-space: nowrap;
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;

    &.title {
        font-weight: 500;
    }

    &.price {
        font-weight: bold;
        color: $main-color;
    }

    &.achievements {
        text-align: center;
    }

       &.genres, &.platforms, &.game-modes, &.themes {
        white-space: normal;
        max-width: 150px;
    }
}

.game-cover {
    width: 60px;
    height: auto;
    border-radius: 4px;
    border: 1px solid #444;
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

    p {
        margin: 0;
        color: lighten($main-color, 15%);
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .comparison-section {
        font-size: 0.9rem;
    }

    .attribute-header, .game-value {
        padding: 0.6rem 0.5rem;
    }

    .game-cover {
        width: 40px;
    }
}
</style>
