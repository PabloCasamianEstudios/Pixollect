<template>
    <metaHead>
        <title>{{ user.name }} Achievements</title>
    </metaHead>
        <FlashMessage />

    <UserLayout :user="user">
        <h1>{{ user.name }}'s Achievements</h1>
        <p>WAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA.</p>
    </UserLayout>
</template>

<script>
import { Head as metaHead } from '@inertiajs/vue3';
import UserLayout from '@/Layouts/UserLayout.vue';
import FlashMessage from '@/Components/FlashMessage.vue';

export default {
    components: { metaHead, UserLayout, FlashMessage },
    props: {
        user: Object,
    },
};
</script>
