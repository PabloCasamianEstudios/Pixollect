<template>
    <NavLayout />

    <main>
        <slot></slot>
    </main>

    <FooterLayout />
</template>

<script>
import NavLayout from '@/Layouts/Nav.vue';
import FooterLayout from '@/Layouts/Footer.vue';

export default {
    components: {
        NavLayout,
        FooterLayout,
    },
};
</script>
<style scoped></style>
