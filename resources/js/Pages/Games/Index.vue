<template>
    <Head>
        <title>CRUD Games</title>
        <meta
            head-key="description"
            name="description"
            content="Index Game Admin Management page of the application"
        />
    </Head>
    <h1>
        TABLA PARA QUE LOS ADMIN VEAN LOS JUEGUITOS DE LA BD Y PUEDAN
        GESTIONARLOS
    </h1>
</template>

<script>
import { Head } from '@inertiajs/vue3';
export default {
    props: {
        games: Array,
        successMessage: String, // Recibimos el mensaje de éxito
    },
};
</script>
