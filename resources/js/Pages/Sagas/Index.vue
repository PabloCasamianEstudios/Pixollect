<template>
    <metaHead>
        <title>Manage Sagas</title>
        <meta
            head-key="description"
            name="description"
            content=" Saga Management page of the application"
        />
    </metaHead>

      <FlashMessage />
    <div class="sagasPage">
        <h1 class="sagasPage__title">Manage Sagas</h1>



        <div class="sagasPage__tableWrapper">
            <table class="sagasPage__table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Games Count</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="saga in sagas" :key="saga.id">
                        <td>{{ saga.id }}</td>
                        <td>{{ saga.name }}</td>
                        <td class="descriptionCell">{{ saga.description }}</td>
                        <td>{{ saga.games_count }}</td>
                        <td class="actionBtns">
                            <button @click="editSaga(saga.id)" title="Edit">✏️</button>
                            <button @click="deleteSaga(saga.id)" title="Delete">❌</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <button class="createButton" @click="createSaga">+</button>
    </div>
</template>

<script>
import FlashMessage from '@/Components/FlashMessage.vue';
import { Head as metaHead, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';


export default {
    components: {
        metaHead,
        FlashMessage,
    },
    props: {
        sagas: Array,
        successMessage: String,
    },
    methods: {
        createSaga() {
            router.visit('/sagas/create');
        },
        editSaga(id) {
            router.visit(`/sagas/${id}/edit`);
        },
        async deleteSaga(id) {
            const result = await Swal.fire({
                title: 'Delete Saga',
                text: 'Are you sure you want to delete this saga?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'DELETE',
                cancelButtonText: 'CANCEL',
                confirmButtonColor: '#ff1540',
                cancelButtonColor: '#ff1540',
                background: '#262626',
                color: '#fff',
                iconColor: '#ff1540'
            });

            if (result.isConfirmed) {
                router.delete(`/sagas/${id}`);
            }
        },
    },
};
</script>

<style lang="scss" scoped>
@use '../../../css/variables.scss' as *;

.sagasPage {
    background-color: #121212;
    color: white;
    padding: 2rem;
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
        }

        th {
            background-color: #1c1c1c;
            color: $main-color;
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
