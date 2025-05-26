<template>
    <MetaHead>
        <title>CRUD  Users</title>
        <meta
            head-key="description"
            name="description"
            content="Index User Admin Management page of the application"
        />
    </MetaHead>
    <div class="usersPage">
        <h1 class="usersPage__title">{{ $t('Manage Users') }}</h1>

        <FlashMessage />

        <div class="usersPage__tableWrapper">
            <table class="usersPage__table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Games</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td>{{ user.id }}</td>
                        <td>
                            <img
                                :src="user.avatar_url || '/default-avatar.png'"
                                alt="User avatar"
                                class="userImg"
                            />
                        </td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.role }}</td>
                        <td>{{ user.games_count }}</td>
                        <td class="actionBtns">
                        <button @click="viewUser(user.name)" title="View">👁️</button>
                            <button @click="editUser(user.name)" title="Edit">
                                ✏️
                            </button>
                            <button
                                @click="deleteUser(user.name)"
                                title="Delete"
                            >
                                ❌
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import FlashMessage from '@/Components/FlashMessage.vue';
import { Head as MetaHead, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { useI18n } from 'vue-i18n';

export default {
    components: {
        MetaHead,
        FlashMessage,
    },
    props: {
        users: Array,
        successMessage: String,
    },
    setup() {
        const { t } = useI18n();
        return {
                t,
                $t: t
            };

    },
    methods: {
        editUser(name) {
            this.$inertia.visit(`/users/${name}/edit`);
        },
        async deleteUser(name) {
            const result = await Swal.fire({
                title: this.t('Delete user?'),
                text: this.t('Are you sure you want to delete this user?'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.t('YES'),
                cancelButtonText: this.t('NO'),
                confirmButtonColor: '#ff1540',
                cancelButtonColor: '#ff1540',
                background: '#262626',
                color: '#fff',
                iconColor: '#ff1540'
            });

            if (result.isConfirmed) {
                router.delete(`/users/${name}`);
            }
        },
        viewUser(name) {
            this.$inertia.visit(`/user/${name}`);
        },
    },
};
</script>

<style lang="scss" scoped>
@use '../../../css/variables.scss' as *;

.usersPage {
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

        .userImg {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .actionBtns {
            display: flex;
            gap: 0.5rem;
            height: 5rem;

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
}
</style>
