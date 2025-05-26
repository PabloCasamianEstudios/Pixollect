<template>
    <metaHead>
        <title>$t('Settings')</title>
    </metaHead>

    <FlashMessage />

<UserLayout :user="user">
        <div class="settings-container">
            <h1>Account Settings</h1>

            <form @submit.prevent="submit">
                <div class="form-group">
                    <label>Username</label>
                    <input v-model="form.name" type="text" />
                    <p v-if="form.errors.name" class="error">{{ form.errors.name }}</p>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input v-model="form.email" type="email" />
                    <p v-if="form.errors.email" class="error">{{ form.errors.email }}</p>
                </div>

                <div class="form-group">
                    <label>Current Password<span>*</span></label>
                    <input v-model="form.current_password" type="password" />
                    <p v-if="form.errors.current_password" class="error">
                        {{ form.errors.current_password }}
                    </p>
                </div>

                <div class="form-group">
                    <label>New Password</label>
                    <input v-model="form.password" type="password" />
                </div>

                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input v-model="form.password_confirmation" type="password" />
                    <p v-if="form.errors.password" class="error">{{ form.errors.password }}</p>
                </div>

                <button :disabled="form.processing">Update</button>

                <p v-if="successMessage" class="success">{{ successMessage }}</p>
            </form>
        </div>
    </UserLayout>
</template>

<script>
import { Head as metaHead } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { useForm, usePage } from '@inertiajs/vue3';

export default {
    components: {
        UserLayout,
        FlashMessage,
        metaHead
    },
    props: {
        user: Object,
    },
    data() {
        return {
            form: useForm({
                name: this.user.name,
                email: this.user.email,
                current_password: '',
                password: '',
                password_confirmation: '',
            }),
        };
    },
    computed: {
        successMessage() {
            return usePage().props.flash.success;
        },
    },
    methods: {
        submit() {
            this.form.patch(`/user/${this.user.name}/settings`);
        },
    },
};
</script>

<style lang="scss" scoped>
@use '../../../css/variables.scss' as *;

span {
    color: $main-color;
}

.settings-container {
    max-width: 600px;
    margin: 0 auto;
    background: #1e1e1e;
    padding: 2rem;
    border-radius: 8px;
    color: white;
}

.form-group {
    margin-bottom: 1.5rem;
}

label {
    display: block;
    margin-bottom: 0.5rem;
    color: #aaa;
}

input {
    width: 100%;
    padding: 0.5rem;
    background: #2a2a2a;
    border: 1px solid #444;
    border-radius: 4px;
    color: white;
}

button {
    background: $main-color;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    border: none;
    font-weight: bold;
    cursor: pointer;
    margin-top: 1rem;
}

.error {
    color: red;
    font-size: 0.9rem;
}

.success {
    color: limegreen;
    margin-top: 1rem;
}
</style>
