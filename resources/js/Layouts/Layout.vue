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
<style scoped>
body {
    min-height: 100vh;
}
main{
    min-height: 100vh;

}
</style>
