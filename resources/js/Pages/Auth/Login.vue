<template>
    <Head title="Log in" />

    <GuestLayout>
        <div class="loginContainer">
            <div class="loginBox">
                <h2 class="loginTitle">Log in</h2>

                <form @submit.prevent="submit">
                    <div class="inputGroup">
                        <InputLabel for="email" value="Email" />
                        <TextInput
                            id="email"
                            type="email"
                            v-model="form.email"
                            autofocus
                            autocomplete="username"
                            class="inputField"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="inputGroup">
                        <InputLabel for="password" value="Password" />
                        <TextInput
                            id="password"
                            type="password"
                            v-model="form.password"
                            autocomplete="current-password"
                            class="inputField"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.password"
                        />
                    </div>

                    <div class="rememberMe">
                        <Checkbox
                            name="remember"
                            v-model:checked="form.remember"
                        />
                        <span class="rememberText">Remember me</span>
                    </div>

                    <div class="actions">
                        <Link
                            v-if="canResetPassword"
                            href="/forgot-password"
                            class="forgotPasswordLink"
                        >
                            Forgot your password?
                        </Link>

                        <PrimaryButton
                            class="loginBtn"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Log in
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post('login', {
        onFinish: () => form.reset('password'),
    });
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

.rememberMe {
    display: flex;
    align-items: center;
    margin-top: 1rem;
}

.rememberText {
    margin-left: 0.5rem;
    color: #bbb;
    font-size: 0.9rem;
}

.actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1.5rem;
}

.forgotPasswordLink {
    color: white;
    font-size: 0.9rem;
    text-decoration: underline;
    transition: color 0.3s ease-in-out;

    &:hover {
        color: $main-color;
    }
}

.loginBtn {
    background-color: $main-color;
    border: none;
    padding: 0.8rem 1.5rem;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
    width: 48%;

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
