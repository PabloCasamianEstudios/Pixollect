<template>
    <metaHead>
        <title>{{ user.name }}</title>
        <meta
            head-key="description"
            name="description"
            content="Home page of the application"
        />
    </metaHead>
    <div class="profile-container">
        <h1 v-if="currentUser?.id === user?.id">Your profile</h1>
        <h1 v-else>{{ user.name }}'s Profile</h1>
        <p>Juegos en colección: {{ gamesCount }}</p>
    </div>
</template>

<script>
import { Head as metaHead, usePage } from '@inertiajs/vue3';
export default {
    components: {
        metaHead,
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

<style scoped>
.profile-container {
    padding: 2rem;
    color: white;
}
</style>
