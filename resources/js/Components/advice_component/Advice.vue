<template>
    <div class="beta-advise">
        <strong>{{ $t('BETA NOTICE') }}</strong>
        <p>
            {{ $t('Pixollect is in beta.') }}
            {{ $t('Found a bug or want a game added?') }}
            <a @click="$inertia.visit('/contact')" class="advise-link">{{
                $t('Contact us')
            }}</a
            >.
            {{ $t('Include game info and a cover URL from') }}
            <a
                href="https://www.steamgriddb.com/"
                target="_blank"
                rel="noopener"
                class="external-link"
                >SteamGridDB</a
            >.
        </p>
    </div>
</template>

<script>
export default {
    name: 'Advise',
};
</script>

<style scoped lang="scss">
@use '../../../css/variables.scss' as *;

.beta-advise {
    background-color: $main-color;
    color: white;
    border-left: 6px solid darken($main-color, 20%);
    border-radius: 6px;
    padding: 0.75rem 1rem;
    font-size: 0.85rem;
    margin-top: 1.5rem;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
    font-family: 'Orbitron', sans-serif;
    opacity: 0;
    transform: translateY(10px);
    animation: fadeSlideIn 0.6s ease-out forwards;
    @keyframes fadeSlideIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    transition: box-shadow 0.4s ease;

    &:hover {
        box-shadow: 0 0 12px rgba(255, 255, 255, 0.15);
    }
    strong {
        display: block;
        margin-bottom: 0.4rem;
        font-size: 0.95rem;
        color: white;
    }

    p {
        margin: 0;
        line-height: 1.4;
    }

    .advise-link,
    .external-link {
        color: rgb(131, 210, 255);
        font-weight: 600;
        text-decoration: underline;
        cursor: pointer;

        &:hover {
            text-decoration: none;
        }
    }
}
</style>
