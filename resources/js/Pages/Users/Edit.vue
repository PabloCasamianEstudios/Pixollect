<template>
    <Head>
        <title>Edit User</title>
        <meta name="description" content="Edit User page of the application" />
    </Head>

    <div class="formContainer">
        <h1 class="formTitle">Editar Usuario</h1>

        <form @submit.prevent="submit" class="formFields">
            <input v-model="form.name" type="text" placeholder="Name" />
            <div v-if="errors.name" class="formError">{{ errors.name }}</div>

            <input v-model="form.email" type="email" placeholder="Email" />
            <div v-if="errors.email" class="formError">{{ errors.email }}</div>

            <input v-model="form.password" type="password" placeholder="Password (leave blank to keep current)" />
            <div v-if="errors.password" class="formError">{{ errors.password }}</div>

            <input v-model="form.avatar_url" type="text" placeholder="Avatar URL" />
            <div v-if="errors.avatar_url" class="formError">{{ errors.avatar_url }}</div>

            <select v-model="form.role">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <div v-if="errors.role" class="formError">{{ errors.role }}</div>

            <button type="submit" class="submitBtn">Actualizar Usuario</button>
        </form>
    </div>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';

const props = defineProps({
    user: Object,
});

const user = props.user;

const form = useForm({
    name: user.name || '',
    email: user.email || '',
    password: '',
    avatar_url: (user.avatar_url === '/images/defaultIcon.png') ? '' : (user.avatar_url || ''),
    role: user.role || 'user',
});

const errors = reactive({
    name: '',
    email: '',
    password: '',
    avatar_url: '',
    role: '',
});

function validateUrl(url) {
    const regex = /^(https?|ftp):\/\/[^\s/$.?#].[^\s]*$/i;
    return regex.test(url);
}

function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function validate() {
    let valid = true;

    errors.name = form.name.trim() ? '' : 'Name is required.';
    errors.email = form.email.trim()
        ? validateEmail(form.email)
            ? ''
            : 'Email must be a valid address.'
        : 'Email is required.';
    errors.password = form.password && form.password.length < 6
        ? 'Password must be at least 6 characters.'
        : '';
    errors.avatar_url = form.avatar_url.trim()
        ? validateUrl(form.avatar_url)
            ? ''
            : 'Avatar URL must be valid.'
        : '';
    errors.role = ['user', 'admin'].includes(form.role) ? '' : 'Invalid role selected.';

    for (let key in errors) {
        if (errors[key]) valid = false;
    }

    return valid;
}

function submit() {
    if (!validate()) return;

    if (!form.avatar_url) {
        form.avatar_url = null;
    }

    form.put(`/users/${user.name}`);
}
</script>

<style lang="scss" scoped>
@use '../../../css/variables.scss' as *;

.formError {
    color: #e53935;
    font-size: 0.85rem;
    margin-top: -0.5rem;
    margin-bottom: 0.5rem;
}

.formContainer {
    max-width: 800px;
    margin: 2rem auto;
    padding: 2rem;
    background-color: #1c1c1c;
    color: white;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    font-family: 'Orbitron', sans-serif;
}

.formTitle {
    font-size: 1.8rem;
    color: $main-color;
    text-align: center;
    margin-bottom: 1.5rem;
}

.formFields {
    display: flex;
    flex-direction: column;
    gap: 1rem;

    input,
    textarea,
    select {
        padding: 0.6rem 1rem;
        border-radius: 8px;
        border: 1px solid #444;
        background-color: #121212;
        color: white;
        font-size: 1rem;

        &:focus {
            outline: none;
            border-color: $main-color;
        }
    }
}

.submitBtn {
    background-color: $main-color;
    color: black;
    padding: 0.8rem;
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s;

    &:hover {
        background-color: #ff5b79;
    }
}
</style>
