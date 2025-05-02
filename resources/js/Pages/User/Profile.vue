<template>
    <metaHead>
        <title>{{ user.name }}</title>
        <meta
            head-key="description"
            name="description"
            content="Home page of the application"
        />
    </metaHead>
    <UserLayout :user="user">
        <div class="profile-info">
            <p class="profile-stats">
                Games in Collection:
                {{ gamesCount.toString().padStart(3, '0') }}
            </p>
        </div>
    </UserLayout>
</template>

<script>
import AppLayout from '@/Layouts/Layout.vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head as metaHead, usePage } from '@inertiajs/vue3';
export default {
    layout: AppLayout,
    components: {
        metaHead,
        UserLayout,
    },
    computed: {
        currentUser() {
            return usePage().props.auth.user;
        },
    },
    props: {
        user: Object,
        gamesCount: Number,
    },
};
</script>

<style lang="scss" scoped>
@use '../../../css/variables.scss' as *;
.profile-container {
    color: white;
    padding: 2rem;
    min-height: 81vh;
    background-color: #1a1a1a;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
    font-family: 'Orbitron', sans-serif;
    max-width: 900px;
    margin: 2rem auto;
}

.profile-header {
    display: flex;
    align-items: center;
    gap: 2rem;
    padding: 2rem;
}

.profile-avatar {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ffffff;
}

.profile-info {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.profile-name {
    font-size: 2rem;
    font-weight: bold;
    color: white;
    margin: 0;
}

.profile-stats {
    font-size: 1.2rem;
    color: #a1a1a1;
    margin-top: 0.5rem;
}
</style>
