<template>
    <div class="userGamesContainer">
        <h1 class="sectionTitle">{{ user.name }}'s Collection</h1>

        <div v-if="games.length" class="gamesGrid">
            <div v-for="game in games" :key="game.id" class="gameCard">
                <img
                    :src="game.image_url"
                    :alt="game.title"
                    class="gameImage"
                />
                <div class="gameInfo">
                    <h2 class="gameTitle">{{ game.title }}</h2>
                    <p class="gameProgress">
                        Progress: {{ game.pivot.progress }}%
                    </p>
                    <p class="gameState">Status: {{ game.pivot.state }}</p>
                </div>
            </div>
        </div>

        <div v-else class="noGamesMessage">
            <p>This user hasn’t added any games yet.</p>
        </div>
    </div>
</template>

<script setup>
defineProps({
    user: Object,
    games: Array,
});
</script>

<style lang="scss" scoped>
@use '../../../css/variables.scss' as *;

.userGamesContainer {
    background-color: #121212;
    padding: 2rem;
    min-height: 100vh;
    font-family: 'Orbitron', sans-serif;
    color: white;
}

.sectionTitle {
    font-size: 2rem;
    color: $main-color;
    text-align: center;
    margin-bottom: 2rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
}

.gamesGrid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 1.5rem;
}

.gameCard {
    background-color: #1e1e1e;
    border: 1px solid #333;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s ease-in-out;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);

    &:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5);
    }
}

.gameImage {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.gameInfo {
    padding: 1rem;
}

.gameTitle {
    font-size: 1.2rem;
    margin-bottom: 0.5rem;
    color: $main-color;
}

.gameProgress,
.gameState {
    font-size: 0.9rem;
    color: #ccc;
}

.noGamesMessage {
    text-align: center;
    margin-top: 3rem;
    font-size: 1.1rem;
    color: #aaa;
}
</style>
