<template>
    <Head>
        <title></title>
        <meta
            head-key="description"
            name="description"
            :content="'User place'"
        />
    </Head>

    <UserLayout :user="user"></UserLayout>
</template>
<script>
import { Head, router } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import AppLayout from '@/Layouts/Layout.vue'
import UserLayout from '@/Layouts/UserLayout.vue';

export default {
    layout: AppLayout,
    components: {
        UserLayout,
    }
}

</script>
