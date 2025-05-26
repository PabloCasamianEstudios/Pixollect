<template>
    <GuestLayout>
        <Head title="Forgot Password" />

        <div class="loginContainer">
            <div class="loginBox">
                <h2 class="loginTitle">{{ $t('Forgot Password') }}</h2>

                <div class="infoText">
                    {{ $t('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>

                <div
                    v-if="status"
                    class="statusMessage"
                >
                    {{ status }}
                </div>

                <form @submit.prevent="submit">
                    <div class="inputGroup">
                        <InputLabel for="email" :value="$t('Email')" />
                        <TextInput
                            id="email"
                            type="email"
                            v-model="form.email"
                            required
                            autofocus
                            autocomplete="username"
                            class="inputField"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="actions">
                        <PrimaryButton
                            class="loginBtn"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            {{ $t('Email Password Reset Link') }}
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<style lang="scss" scoped>
@use '../../../css/variables.scss' as *;

.loginContainer {
    background-color: #121212;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: calc(100vh - 67px);
    height: 100%;
    font-family: 'Orbitron', sans-serif;
}

.loginBox {
    background-color: #1e1e1e;
    border-radius: 8px;
    padding: 2rem;
    width: 100%;
    max-width: 400px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
    text-align: center;
    color: white;
    border: 1px solid #333;
}

.loginTitle {
    font-size: 2rem;
    color: $main-color;
    margin-bottom: 1.5rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
}

.infoText {
    color: #bbb;
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
    text-align: left;
    line-height: 1.5;
}

.statusMessage {
    color: #4ade80;
    font-size: 0.9rem;
    margin-bottom: 1rem;
    padding: 0.5rem;
    background-color: rgba(74, 222, 128, 0.1);
    border-radius: 4px;
}

.inputGroup {
    margin-bottom: 1.5rem;
}

.inputField {
    background-color: #2e2e2e;
    border: none;
    border-radius: 4px;
    padding: 0.8rem;
    width: 100%;
    color: white;
    font-size: 1rem;
    margin-top: 0.5rem;
    transition: background 0.3s ease-in-out;
}

.inputField:focus {
    background-color: #3a3a3a;
    outline: none;
    box-shadow: 0 0 6px $main-color;
}

.actions {
    display: flex;
    justify-content: center;
    margin-top: 1.5rem;
}

.loginBtn {
    background-color: $main-color;
    border: none;
    padding: 0.8rem 1.5rem;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
    width: 100%;

    &:hover {
        background-color: #e40068;
    }

    &.opacity-25 {
        opacity: 0.25;
    }
}

@media (max-width: 480px) {
    .loginBox {
        padding: 1.5rem;
        width: 90%;
    }
}
</style>
