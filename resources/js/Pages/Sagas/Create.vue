<template>
    <metaHead>
        <title>Create Saga</title>
        <meta
            head-key="description"
            name="description"
            content="Create Saga page of the application"
        />
    </metaHead>

    <div class="formContainer">
        <h1 class="formTitle">Create Saga</h1>

        <form @submit.prevent="submit" class="formFields">
            <input v-model="form.name" type="text" placeholder="Name" />
            <div v-if="errors.name" class="formError">{{ errors.name }}</div>

            <textarea v-model="form.description" placeholder="Description" />

            <button type="submit" class="submitBtn">Create Saga</button>
        </form>
    </div>
</template>

<script setup>
import { Head as metaHead, useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';

const form = useForm({
    name: '',
    description: '',
});

const errors = reactive({
    name: '',
});

function validate() {
    let valid = true;
    errors.name = form.name.trim() ? '' : 'Name is required.';
    return valid = !errors.name;
}

function submit() {
    if (!validate()) return;
    form.post('/sagas');
}
</script>

<style scoped lang="scss">
@use '../../../css/variables.scss' as *;

.formError {
    color: #e53935;
    font-size: 0.85rem;
    margin-top: -0.5rem;
    margin-bottom: 0.5rem;
}

.formContainer {
    max-width: 600px;
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
    textarea {
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

    textarea {
        min-height: 100px;
        resize: vertical;
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
        background-color: #ff3a5eff;
    }
}
</style>
