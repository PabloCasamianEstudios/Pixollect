<template>
    <metaHead>
        <title>CRUD Games</title>
        <meta
            head-key="description"
            name="description"
            content="Index Game Admin Management page of the application"
        />
    </metaHead>
    <div class="gamesPage">
        <h1 class="gamesPage__title">Manage Games</h1>

        <FlashMessage />

        <div class="gamesPage__tableWrapper">
            <table class="gamesPage__table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Release</th>
                        <th>Developer</th>
                        <th>Publisher</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="game in games" :key="game.id">
                        <td>{{ game.id }}</td>
                        <td>
                            <img
                                :src="game.image_url"
                                alt="Imagen del juego"
                                class="gameImg"
                            />
                        </td>
                        <td>{{ game.title }}</td>
                        <td class="descriptionCell">{{ game.description }}</td>
                        <td>{{ game.release_date }}</td>
                        <td>{{ game.developer }}</td>
                        <td>{{ game.publisher }}</td>
                        <td>${{ game.price }}</td>
                        <td class="actionBtns">
                            <button @click="viewGame(game.id)" title="Ver">
                                👁️
                            </button>
                            <button @click="editGame(game.id)" title="Editar">
                                ✏️
                            </button>
                            <button
                                @click="deleteGame(game.id)"
                                title="Eliminar"
                            >
                                ❌
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <button class="createButton" @click="createGame">+</button>
    </div>
</template>

<script>
// eslint-disable-next-line no-unused-vars
import FlashMessage from '@/Components/FlashMessage.vue';
import { Head as metaHead, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

export default {
    components: {
        metaHead,
        FlashMessage
    },
    props: {
        games: Array,
        successMessage: String,
    },
    methods: {
        viewGame(id) {
            router.visit(`/games/${id}`);
        },
        editGame(id) {
            router.visit(`/games/${id}/edit`);
        },
        async deleteGame(id) {
            const result = await Swal.fire({
                title: 'DELETE GAME?',
                text: 'Are you sure you want to delete this game?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'DELETE',
                cancelButtonText: 'CANCEL',
                confirmButtonColor: '#ff1540',
                cancelButtonColor: '#ff1540',
                background: '#262626',
                color: '#fff',
                iconColor: '#ff1540',
                buttonsStyling: true,
                reverseButtons: true
            });

            if (result.isConfirmed) {
                router.delete(`/games/${id}`);
            }
        },
        createGame() {
            router.visit('/games/create');
        },
    },
};
</script>

<style lang="scss" scoped>
@use '../../../css/variables.scss' as *;

.gamesPage {
    background-color: #121212;
    color: white;
    padding: 2rem;
    font-family: 'Orbitron', sans-serif;
    min-height: 78.7vh;
    &__title {
        font-size: 2rem;
        color: $main-color;
        margin-bottom: 1.5rem;
    }

    &__tableWrapper {
        overflow-x: auto;
    }

    &__table {
        width: 100%;
        border-collapse: collapse;

        th,
        td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #2e2e2e;
            min-height: 107px;
            max-height: 107px;
        }

        th {
            background-color: #1c1c1c;
            color: $main-color;
        }

        .gameImg {
            width: 50px;
            height: auto;
            border-radius: 6px;
        }

        .descriptionCell {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .actionBtns {
            display: flex;
            gap: 0.5rem;

            button {
                background: none;
                border: none;
                font-size: 1.2rem;
                cursor: pointer;
                transition: transform 0.2s ease;

                &:hover {
                    transform: scale(1.2);
                }
            }
        }
    }
    .createButton {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        background-color: $main-color;
        color: #fff;
        border: none;
        border-radius: 10px;
        width: 60px;
        height: 60px;
        font-size: 2rem;
        cursor: pointer;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.4);
        transition: all 0.3s ease;

        &:hover {
            transform: scale(1.1);
        }
    }
}
</style>
