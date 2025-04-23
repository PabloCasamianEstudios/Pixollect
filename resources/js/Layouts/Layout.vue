<template>
    <NavLayout />

    <main>
        <slot></slot>
    </main>
</template>

<script>
import NavLayout from '@/Layouts/Nav.vue';

export default {
    components: {
        NavLayout,
    },
};
</script>
<style scoped></style>
