<template>
    <metaHead>
        <title>Home</title>
        <meta
            head-key="description"
            name="description"
            content="Home page of the application"
        />
    </metaHead>

    <h1>ROLE: {{ currentUser?.role || 'NO  ROLE' }}</h1>

    <div v-if="currentUser?.role === 'admin'">you r n admin</div>
    <div v-else-if="currentUser?.role === 'user'">you r n user</div>
    <div v-else-if="currentUser?.role === 'mute'">you r muted</div>
    <div v-else>you r random</div>
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
};
</script>
