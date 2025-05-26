<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);
</script>

<template>
    <GuestLayout>
        <Head :title="$t('Email Verification')" />

        <div class="verificationContainer">
            <div class="verificationBox">
                <h2 class="verificationTitle">{{ $t('Email Verification') }}</h2>

                <div class="verificationMessage">
                    {{ $t('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </div>

                <div class="verificationSuccess" v-if="verificationLinkSent">
                    {{ $t('A new verification link has been sent to the email address you provided during registration.') }}
                </div>

                <form @submit.prevent="submit" class="verificationForm">
                    <div class="verificationActions">
                        <PrimaryButton
                            class="verificationButton"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            {{ $t('Resend Verification Email') }}
                        </PrimaryButton>

                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="logoutLink"
                        >
                            {{ $t('Log Out') }}
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

<style lang="scss" scoped>
@use '../../../css/variables.scss' as *;

.verificationContainer {
    background-color: #121212;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: calc(100vh - 67px);
    height: 100%;
    font-family: 'Orbitron', sans-serif;
}

.verificationBox {
    background-color: #1e1e1e;
    border-radius: 8px;
    padding: 2rem;
    width: 100%;
    max-width: 500px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
    text-align: center;
    color: white;
    border: 1px solid #333;
}

.verificationTitle {
    font-size: 2rem;
    color: $main-color;
    margin-bottom: 1.5rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
}

.verificationMessage {
    color: #bbb;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    text-align: left;
}

.verificationSuccess {
    color: #4ade80;
    font-size: 0.95rem;
    margin-bottom: 1.5rem;
    padding: 0.8rem;
    background-color: rgba(74, 222, 128, 0.1);
    border-radius: 4px;
    border-left: 3px solid #4ade80;
    text-align: left;
}

.verificationForm {
    margin-top: 2rem;
}

.verificationActions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1.5rem;
}

.verificationButton {
    background-color: $main-color;
    border: none;
    padding: 0.8rem 1.5rem;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
    width: 60%;

    &:hover {
        background-color: #e40068;
    }

    &.opacity-25 {
        opacity: 0.25;
    }
}

.logoutLink {
    color: white;
    font-size: 0.9rem;
    text-decoration: underline;
    transition: color 0.3s ease-in-out;

    &:hover {
        color: $main-color;
    }
}

@media (max-width: 480px) {
    .verificationBox {
        padding: 1.5rem;
        width: 90%;
    }

    .verificationActions {
        flex-direction: column;
        gap: 1rem;
    }

    .verificationButton {
        width: 100%;
    }

    .logoutLink {
        width: 100%;
        text-align: center;
    }
}
</style>
