<template>
    <transition name="fade">
        <div
            v-if="visible && message"
            :class="['flashMessage', isError ? 'flashError' : 'flashSuccess']"
        >
            <p class="flashText">{{ message }}</p>
        </div>
    </transition>
</template>

<script>
import { usePage } from '@inertiajs/vue3';

export default {
    name: 'FlashMessage',
    data() {
        return {
            visible: !!usePage().props.flash?.message,
        };
    },
    computed: {
        message() {
            return usePage().props.flash?.message || null;
        },
        isError() {
            const msg = this.message?.toLowerCase() || '';
            return (
                msg.includes('error') ||
                msg.includes('fail') ||
                msg.includes('unauthorized')
            );
        },
    },
    watch: {
        message(newVal) {
            this.visible = !!newVal;
            if (this.visible) {
                setTimeout(() => {
                    this.visible = false;
                }, 5000);
            }
        },
    },
    mounted() {
        if (this.visible) {
            setTimeout(() => {
                this.visible = false;
            }, 5000);
        }
    },
};
</script>

<style scoped lang="scss">
@use '../../css/variables.scss' as *;

.flashMessage {
    position: fixed;
    top: 3rem;
    left: 50%;
    transform: translateX(-50%);
    z-index: 9999;

    padding: 1rem 1.5rem;
    border-radius: 8px;
    max-width: 600px;
    text-align: center;
    font-family: 'Orbitron', sans-serif;
    font-size: 1rem;
    font-weight: bold;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
    border: 1px solid #444;
}

.flashSuccess {
    background-color: #1e3322;
    color: #a6f3c1;
    border-color: #3cc97e;
}

.flashError {
    background-color: #331e1e;
    color: #f3a6a6;
    border-color: #c93c3c;
}

.flashText {
    margin: 0;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.4s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
