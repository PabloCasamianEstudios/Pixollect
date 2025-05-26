<template>
    <div>
        <metaHead>
            <title>{{ $t('About') }}
</title>
            <meta
                head-key="description"
                name="description"
                content="About page of Pixollect"
            />
        </metaHead>

        <div class="about-container">
        <div class="border">


            <h1 class="about-title">{{ $t('What is Pixollect?') }}
</h1>
            <p class="about-paragraph">
                {{ $t( 'Pixollect is a web application built to help gamers keep track of their video game collections. It centralizes all your games, no matter the platform or format, and provides tools for organizing, analyzing, and discovering new titles.') }}
            </p>

            <h2 class="about-subtitle">{{ $t('Project Objective') }}</h2>
            <p class="about-paragraph">
                {{ $t( 'The goal is to offer users a practical and user-friendly platform to manage their gaming libraries, track their progress, compare games, and receive personalized recommendations.') }}
            </p>

            <h2 class="about-subtitle">{{ $t('Target Audience') }}</h2>
            <p class="about-paragraph">
                {{ $t('Pixollect is designed for any gamer, whether casual or hardcore, who values collection tracking, stats, and game discovery based on personal preferences.') }}
            </p>

            <h2 class="about-subtitle">{{ $t('Technologies Used') }}</h2>
            <ul class="about-list">
                <li>{{ $t('Laravel (Backend)') }}</li>
                <li>{{ $t('Inertia.js + Vue 3 (Frontend)') }}</li>
                <li>{{ $t('MySQL (Database)') }}</li>
                <li>{{ $t('Chart.js (Statistics)') }}</li>
            </ul>
        </div>
         </div>

    </div>
</template>
<script>
import { Head as metaHead } from '@inertiajs/vue3';

export default {
    components: {
        metaHead,
    },
};
</script>
<style scoped lang="scss">
@use '../../css/variables.scss' as *;

.about-container {
    background-color: #1e1e1e;
    padding: 2rem;
    border-radius: 8px;
    text-align: left;
    font-size: 1.1rem;
    color: #aaa;
    margin-top: 2rem;
    max-width: 900px;
    margin-left: auto;
    margin-right: auto;
}

.border {
        border: 1px dashed $main-color;
        padding: 1.5rem 2rem;
        border-radius: 8px;
}

.about-title {
    font-size: 2rem;
    color: $main-color;
    margin-bottom: 1.5rem;
    text-align: center;
}

.about-subtitle {
    font-size: 1.3rem;
    margin-top: 2rem;
    margin-bottom: 0.5rem;
    color: lighten($main-color, 10%);
}

.about-paragraph {
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 1rem;
    color: lighten(#ccc, 10%);
}

.about-list {
    list-style: disc;
    padding-left: 1.5rem;
    color: #ccc;

    li {
        margin-bottom: 0.5rem;
    }
}
</style>
