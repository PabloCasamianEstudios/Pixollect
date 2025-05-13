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

     <div class="container">
      <div class="message">
      <h1>ESSENTIALS QUE FALTAN</h1>
            <p>1 | CUSTOM RECOMENDATOR - <span>YA PENSADO Y VERSIÓN SIMPLE</span></p>
            <p>2 | USER AND SAGAS CRUD  - <span class="meh">REPETIR COMO CON GAMES *ez*</span></p>
            <p>3 | USER STATS - <span class="meh">chart.js</span></p>
            <p>4 | MENSAJES USER FRIENDLY - <span>POR AHORA COMPLETO</span></p>
            <p>5 | LANGUAGES - <span class="meh">FÁCIL PERO LARGO</span></p>
            <p>6 | USER GAME SECTION BUTTONS  - <span class="meh">falta uno, por decidir</span></p>
            <p>7 | USER SECTION ACHIEVEMENTS   - <span class="meh"> FALTA DECIDIR SI MODIFICAR USER.PHP</span></p>
            <p>8 | UNIFICAR ESTILOS Y VARIABLES</p>
            <p>9 | PÁGINAS BLA BLA BLA (HOME, ABOUT, TERMS, PRIVACY, CONTACT)</p>
            <p>10 | REFACTORIZAR Y MEJORAR CÓDIGO</p>
            <p>11 | MORE RESPONSIVE</p>
            <p>12 | EXPORTAR CSV</p>
            <p>13 | Contact con PHPMAILER</p>


        </div>
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
};
</script>
<style scoped lang="scss">
@use '../../css/variables.scss' as *;

.container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 2rem;
    color: white;
    border-radius: 12px;

    background-color: #1c1c1c;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
}

.message {
    background-color: #1e1e1e;
    border: 1px dashed $main-color;
    padding: 2rem;
    border-radius: 8px;
    text-align: center;
    font-size: 1.1rem;
    color: #aaa;
    font-family: 'Orbitron', sans-serif;

    p {
        margin: 10px;
        color: lighten($main-color, 15%);
        span {
            color: green;


        }
        .meh {
                color: yellow;
            }

    }
}</style>
