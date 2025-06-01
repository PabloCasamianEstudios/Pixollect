<template>
    <MetaHead>
        <title>{{ $t('Admin Panel') }}</title>
        <meta
            head-key="description"
            name="description"
            content="Admin Panel of Pixollect"
        />
    </MetaHead>

    <section class="adminPanel">
        <h1 class="adminTitle">{{ $t('Admin Panel') }}</h1>

        <h2 class="sectionTitle">{{ $t('Manage Tables') }}</h2>
        <div class="adminButtons">
            <button
                v-for="item in adminSections"
                :key="item.name"
                @click="navigate(item.route)"
                class="adminButton"
            >
                {{ item.label }}
            </button>
        </div>
    </section>
</template>

<script>
import { Head as MetaHead } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

export default {
    name: 'AdminPanel',
    components: {
        MetaHead,
    },
    data() {
        return {
            adminSections: [
                { name: 'games', label: 'Games', route: '/games' },
                { name: 'sagas', label: 'Sagas', route: '/sagas' },
                { name: 'users', label: 'Users', route: '/users' },
                // { name: 'themes', label: 'Themes', route: '/themes' },
                //     { name: 'genres', label: 'Genres', route: '/genres' },
                //     { name: 'platforms', label: 'Platforms', route: '/platforms' },
            ],
        };
    },
    methods: {
        navigate(route) {
            router.visit(route);
        },
    },
};
</script>

<style scoped lang="scss">
@use '../../css/variables.scss' as *;

.adminPanel {
    background-color: #121212;
    color: white;
    font-family: 'Orbitron', sans-serif;
    min-height: 100vh;
    padding: 2rem;

    .adminTitle {
        text-align: center;
        font-size: 2.5rem;
        margin-bottom: 2rem;
    }

    .sectionTitle {
        text-align: center;
        font-size: 1.5rem;
        margin-bottom: 2rem;
        font-weight: 400;
    }
    .adminButtons {
        display: flex;
        flex-direction: row;
        gap: 2rem;
        justify-content: center;
        align-items: center;
    }

    .adminButton {
        background-color: #1c1c1c;
        color: white;
        border: 1px solid #333;
        border-radius: 12px;
        padding: 1.5rem;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.3s;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);

        &:hover {
            background-color: #333;
            transform: scale(1.05);
        }
    }
}

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
}
</style>
