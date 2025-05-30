<template>
    <metaHead>
        <title>{{ $t('Collections') }}</title>
        <meta
            head-key="description"
            name="description"
            content="Compare page of the application"
        />
    </metaHead>

<FlashMessage />

    <div class="collections-page">
        <div class="search-bar">
            <input
                v-model="search"
                type="text"
                :placeholder="$t('Search users...')"
                class="search-input"
            />
        </div>

        <div class="cards-grid">
            <div
                v-for="user in filteredUsers"
                :key="user.id"
                @click="goToProfile(user.name)"
            >
                <div class="user-card" v-if="isAdmin || user.role !== 'mute'">
                    <div class="avatar-container">
                        <img
                            :src="user.avatar_url"
                            :alt="$t('Avatar')"
                            class="avatar"
                        />
                    </div>
                    <div class="card-content">
                        <div class="username">{{ user.name }}</div>
                        <div class="game-count">
                            {{ user.games.length }} {{ $t('games') }}
                        </div>

                        <div v-if="isAdmin" class="role-select" @click.stop>
                            <select
                                v-model="user.role"
                                @change="updateUserRole(user)"
                            >
                                <option value="user">{{ $t('User') }}</option>
                                <option value="admin">{{ $t('Admin') }}</option>
                                <option value="mute">{{ $t('Mute') }}</option>
                                <option
                                    value="deleteuser"
                                    class="delete-option"
                                >
                                    {{ $t('Delete User') }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import FlashMessage from '@/Components/FlashMessage.vue';
import { Head as metaHead, usePage } from '@inertiajs/vue3';

export default {
    components: {
        metaHead,
        FlashMessage
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

            return this.users
                .filter((user) => user.games && user.games.length > 0)
                .filter((user) => {
                    const match = user.name.toLowerCase().includes(query);
                    const visible = this.isAdmin || user.role !== 'mute';
                    return match && visible;
                });
        },
        currentUserRole() {
            return usePage().props.auth?.user?.role ?? null;
        },
        isAdmin() {
            return this.currentUserRole === 'admin';
        },
    },
    methods: {
        goToProfile(name) {
            this.$inertia.visit(`/user/${name}`);
        },
        updateUserRole(user) {
            this.$inertia.post(`/user/${user.id}/update-role`, {
                role: user.role,
            });
        },
    },
};
</script>

<style scoped>
.collections-page {
    max-width: 1100px;
    margin: 0 auto;
    padding: 40px 20px;
    color: white;
}

.search-bar {
    margin-bottom: 2rem;
    text-align: center;
}

.search-input {
    background-color: #1c1c1c;
    border: 1px solid #333;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 5px;
    font-size: 1rem;
    width: 100%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.06);
}

.cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 24px;
}

.user-card {
    position: relative;
    background: #1c1c1c;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    transition: transform 0.3s;

    &:hover {
        transform: scale(1.02);
    }
}

.user-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
}

.avatar-container {
    display: flex;
    justify-content: center;
    margin-bottom: 16px;
    padding-top: 1rem;
}

.avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #333;
}

.card-content {
    padding: 1rem;
    text-align: center;

    .username {
        font-size: 1.1rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
        color: white;
    }

    .game-count {
        font-size: 0.9rem;
        color: #aaa;
    }

    .overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.75);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;

        .username {
            color: white;
            font-size: 1.2rem;
            padding: 1rem;
        }
    }

    &:hover .overlay {
        opacity: 1;
    }
}

.role-select {
    margin-top: 0.5rem;
    text-align: center;
}

.role-select select {
    padding: 0.25rem;
    border-radius: 6px;
    background-color: #2c2c2c;
    color: white;
    border: 1px solid #444;
}

.delete-option {
    background-color: #b00020;
    color: white;
}
</style>
