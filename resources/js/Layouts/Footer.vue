<template>
    <footer class="footer">
        <div class="footer-top">
            <LinkTo href="/about" class="footer-link">{{ $t('About') }}</LinkTo>
            <LinkTo href="/contact" class="footer-link">{{ $t('Contact Us') }}</LinkTo>
            <LinkTo href="/terms" class="footer-link">{{ $t('Terms') }}</LinkTo>
            <LinkTo href="/privacy" class="footer-link">{{ $t('Privacy') }}</LinkTo>
            <a  href="/manualUsuario.pdf" download="manualUsuario.pdf" class="footer-link">{{ $t('User Help') }}</a>
        </div>
        <div class="footer-bottom">
            <p>{{ $t('Pixollect') }} - {{ currentYear }}</p>
        </div>
    </footer>
</template>

<script>
import { Link as LinkTo } from '@inertiajs/vue3';

export default {
    name: 'FooterComponent',
    components: {
        LinkTo,
    },
    data() {
        return {
            currentYear: new Date().getFullYear(),
        };
    },
};
</script>

<style lang="scss" scoped>
@use '../../css/variables.scss' as *;

.footer {
    background-color: #1c1c1c;
    color: white;
    padding: 2rem;
    text-align: center;
    font-family: 'Orbitron', sans-serif;
    display: flex;
    flex-direction: column;
    gap: 1rem;

    .footer-top {
        display: flex;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;

        .footer-link {
            color: white;
            text-decoration: none;
            font-size: 1rem;
            transition: color 0.3s;

            &:hover {
                color: $main-color;
            }
        }
    }

    .footer-bottom {
        font-size: 0.9rem;
        color: #aaa;
    }
}
</style>
