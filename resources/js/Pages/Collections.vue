<template>
    <metaHead>
        <title>Collections</title>
        <meta
            head-key="description"
            name="description"
            content="Compare page of the application"
        />
    </metaHead>

    <div class="collections-page">
        <div class="search-bar">
            <input
                v-model="search"
                type="text"
                placeholder="Search users..."
                class="search-input"
            />
        </div>

        <div class="cards-grid">
            <div
                v-for="user in filteredUsers"
                :key="user.id"
                class="user-card"
                @click="goToProfile(user.name)"
            >
                <div class="avatar-container">
                    <img :src="user.avatar_url" alt="Avatar" class="avatar" />
                </div>
                <div class="card-content">
                    <div class="username">{{ user.name }}</div>
                    <div class="game-count">{{ user.games.length }} juegos</div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { Head as metaHead } from '@inertiajs/vue3';

export default {
    components: {
        metaHead,
    },
    props: {
        users: [],
    },
    data() {
        return {
            search: '',
        };
    },
    computed: {
        filteredUsers() {
            const query = this.search.toLowerCase();

            const usersWithGames = this.users.filter(
                (user) => user.games && user.games.length > 0,
            );
            return usersWithGames.filter((user) =>
                user.name.toLowerCase().includes(query),
            );
        },
    },
    methods: {
        goToProfile(name) {
            this.$inertia.visit(`/user/${name}`);
        },
    },
};
</script>

<style scoped>
.collections-page {
    max-width: 1100px;
    margin: 0 auto;
    padding: 40px 20px;
}

.search-bar {
    margin-bottom: 30px;
    text-align: center;
}

.search-input {
    width: 100%;
    max-width: 400px;
    padding: 10px 14px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 16px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.06);
}

.cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 24px;
}

.user-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.user-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
}

.avatar-container {
    display: flex;
    justify-content: center;
    margin-bottom: 16px;
}

.avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
}

.card-content .username {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-bottom: 6px;
}

.card-content .game-count {
    font-size: 14px;
    color: #666;
}
</style>
