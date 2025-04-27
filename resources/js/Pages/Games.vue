<template>
    <metaHead>
        <title>Games</title>
        <meta
            head-key="description"
            name="description"
            content="Games page of the application"
        />
    </metaHead>

    <section class="gamesPage">
        <div class="gamesHeader">
            <input
                v-model="search"
                type="text"
                class="searchInput"
                placeholder="Search games..."
            />

            <div class="filters">
                <select v-model="filters.genre">
                    <option value="">All Genres</option>
                    <option
                        v-for="genre in genres"
                        :key="genre.id"
                        :value="genre.name"
                    >
                        {{ genre.name }}
                    </option>
                </select>
                <select v-model="filters.platform">
                    <option value="">All Platforms</option>
                    <option
                        v-for="platform in platforms"
                        :key="platform.id"
                        :value="platform.name"
                    >
                        {{ platform.name }}
                    </option>
                </select>
                <select v-model="filters.theme">
                    <option value="">All Themes</option>
                    <option
                        v-for="theme in themes"
                        :key="theme.id"
                        :value="theme.name"
                    >
                        {{ theme.name }}
                    </option>
                </select>
            </div>
        </div>

        <div class="gameGrid">
            <div v-for="game in filteredGames" :key="game.id" class="gameCard">
                <img :src="game.image_url" alt="Game cover" />
                <div class="overlay">
                    <h2>{{ game.title }}</h2>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { Head as metaHead, usePage } from '@inertiajs/vue3';

export default {
    name: 'Games',
    components: {
        metaHead,
    },
    data() {
        const page = usePage();
        return {
            games: page.props.games || [],
            genres: page.props.genres || [],
            platforms: page.props.platforms || [],
            themes: page.props.themes || [],
            search: '',
            filters: {
                genre: '',
                platform: '',
                theme: '',
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
                return matchTitle && matchGenre && matchPlatform && matchTheme;
            });
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

    .gamesHeader {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 2rem;

        .searchInput {
            background-color: #1c1c1c;
            border: 1px solid #333;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-size: 1rem;
            flex: 1;
            min-width: 250px;
        }

        .filters {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;

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
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 2rem;
    }

    .gameCard {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        transition: transform 0.3s;

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
                font-size: 1.2rem;
                padding: 1rem;
            }
        }

        &:hover .overlay {
            opacity: 1;
        }
    }
}
</style>
