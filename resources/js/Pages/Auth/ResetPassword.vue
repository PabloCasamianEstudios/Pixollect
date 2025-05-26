<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head :title="$t('Reset Password')" />

        <div class="passwordResetContainer">
            <div class="passwordResetBox">
                <h2 class="passwordResetTitle">{{ $t('Reset Password') }}</h2>

                <form @submit.prevent="submit" class="passwordResetForm">
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

                    <div class="inputGroup">
                        <InputLabel for="password" :value="$t('Password')" />
                        <TextInput
                            id="password"
                            type="password"
                            v-model="form.password"
                            required
                            autocomplete="new-password"
                            class="inputField"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="inputGroup">
                        <InputLabel for="password_confirmation" :value="$t('Confirm Password')" />
                        <TextInput
                            id="password_confirmation"
                            type="password"
                            v-model="form.password_confirmation"
                            required
                            autocomplete="new-password"
                            class="inputField"
                        />
                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>

                    <div class="actions">
                        <PrimaryButton
                            class="resetButton"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            {{ $t('Reset Password') }}
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

<style lang="scss" scoped>
@use '../../../css/variables.scss' as *;

.passwordResetContainer {
    background-color: #121212;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: calc(100vh - 67px);
    height: 100%;
    font-family: 'Orbitron', sans-serif;
}

.passwordResetBox {
    background-color: #1e1e1e;
    border-radius: 8px;
    padding: 2rem;
    width: 100%;
    max-width: 450px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
    color: white;
    border: 1px solid #333;
}

.passwordResetTitle {
    font-size: 2rem;
    color: $main-color;
    margin-bottom: 1.5rem;
    text-align: center;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
}

.passwordResetForm {
    margin-top: 1.5rem;
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

    &:focus {
        background-color: #3a3a3a;
        outline: none;
        box-shadow: 0 0 6px $main-color;
    }
}

.actions {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

.resetButton {
    background-color: $main-color;
    border: none;
    padding: 0.8rem 2rem;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    width: 100%;
    max-width: 300px;

    &:hover {
        background-color: #e40068;
        transform: translateY(-2px);
    }

    &:active {
        transform: translateY(0);
    }
}

@media (max-width: 480px) {
    .passwordResetBox {
        padding: 1.5rem;
        width: 90%;
    }

    .resetButton {
        padding: 0.8rem 1.5rem;
    }
}
</style>
