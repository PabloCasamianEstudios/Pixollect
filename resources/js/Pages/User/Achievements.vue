<template>
    <metaHead>
        <title>{{ $t('{user}\'s Achievements', { user: user.name }) }}</title>
    </metaHead>
        <FlashMessage />

    <UserLayout :user="user">
        <div class="achievements-container">
            <h1 class="achievements-title">{{ $t('{user}\'s Achievements', { user: user.name }) }}</h1>

            <div class="achievements-grid">
                <div v-for="achievement in achievements" :key="achievement.id"
                     class="achievement-card"
                     :class="{ 'locked': !achievement.unlocked }">
                    <img src="/images/achievement.png" :alt="achievement.title" class="achievement-icon"/>
                    <div class="achievement-content">
                        <h3>{{ achievement.title }}</h3>
                        <p>{{ achievement.description }}</p>
                        <div class="progress" v-if="achievement.progress">
                            {{ $t('Progress') }}: {{ achievement.progress.current }}/{{ achievement.progress.total }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>

<script>
import { Head as metaHead } from '@inertiajs/vue3';
import UserLayout from '@/Layouts/UserLayout.vue';
import FlashMessage from '@/Components/FlashMessage.vue';

export default {
    components: { metaHead, UserLayout, FlashMessage },
    props: {
        user: Object,
        stats: {
            type: Object,
            required: true,
            default: () => ({
                total_games: 0,
                total_hours: 0,
                total_achievements: 0,
                rated_games: 0,
                completed_games: 0,
                mastered_games: 0,
                unique_genres: 0,
            })
        },
    }, computed: {
        //EN UN FUTURO ESTO MEJOR SEPARARLO EN SU PROPIA TABLA
        achievements() {
            return [
                {
                    id: 1,
                    title: 'Novice Collector',
                    description: 'Own 1 game in your collection',
                    unlocked: this.stats.total_games >= 1,
                    progress: { current: Math.min(this.stats.total_games, 1), total: 1 }
                },
                {
                    id: 2,
                    title: 'Growing Collection',
                    description: 'Own 10 games in your collection',
                    unlocked: this.stats.total_games >= 10,
                    progress: { current: Math.min(this.stats.total_games, 10), total: 10 }
                },
                {
                    id: 3,
                    title: 'Serious Collector',
                    description: 'Own 50 games in your collection',
                    unlocked: this.stats.total_games >= 50,
                    progress: { current: Math.min(this.stats.total_games, 50), total: 50 }
                },
                {
                    id: 4,
                    title: 'Hardcore Collector',
                    description: 'Own 100 games in your collection',
                    unlocked: this.stats.total_games >= 100,
                    progress: { current: Math.min(this.stats.total_games, 100), total: 100 }
                },

                {
                    id: 5,
                    title: 'Casual Player',
                    description: 'Play for 1 hour total',
                    unlocked: this.stats.total_hours >= 1,
                    progress: { current: Math.min(Math.floor(this.stats.total_hours), 1), total: 1 }
                },
                {
                    id: 6,
                    title: 'Dedicated Player',
                    description: 'Play for 10 hours total',
                    unlocked: this.stats.total_hours >= 10,
                    progress: { current: Math.min(Math.floor(this.stats.total_hours), 10), total: 10 }
                },
                {
                    id: 7,
                    title: 'Hardcore Player',
                    description: 'Play for 100 hours total',
                    unlocked: this.stats.total_hours >= 100,
                    progress: { current: Math.min(Math.floor(this.stats.total_hours), 100), total: 100 }
                },

                {
                    id: 8,
                    title: 'First Achievement',
                    description: 'Unlock your first achievement',
                    unlocked: this.stats.total_achievements >= 1,
                    progress: { current: Math.min(this.stats.total_achievements, 1), total: 1 }
                },
                {
                    id: 9,
                    title: 'Achievement Hunter',
                    description: 'Unlock 100 achievements',
                    unlocked: this.stats.total_achievements >= 100,
                    progress: { current: Math.min(this.stats.total_achievements, 100), total: 100 }
                },

                {
                    id: 10,
                    title: 'Critic',
                    description: 'Rate 1 game',
                    unlocked: this.stats.rated_games >= 1,
                    progress: { current: Math.min(this.stats.rated_games, 1), total: 1 }
                },
                {
                    id: 11,
                    title: 'Professional Critic',
                    description: 'Rate 10 games',
                    unlocked: this.stats.rated_games >= 10,
                    progress: { current: Math.min(this.stats.rated_games, 10), total: 10 }
                },

                {
                    id: 12,
                    title: 'First Completion',
                    description: 'Complete 1 game',
                    unlocked: this.stats.completed_games >= 1,
                    progress: { current: Math.min(this.stats.completed_games, 1), total: 1 }
                },
                {
                    id: 13,
                    title: 'Completionist',
                    description: 'Complete 10 games',
                    unlocked: this.stats.completed_games >= 10,
                    progress: { current: Math.min(this.stats.completed_games, 10), total: 10 }
                },

                {
                    id: 14,
                    title: 'First Mastery',
                    description: 'Master 1 game',
                    unlocked: this.stats.mastered_games >= 1,
                    progress: { current: Math.min(this.stats.mastered_games, 1), total: 1 }
                },

                {
                    id: 15,
                    title: 'Genre Explorer',
                    description: 'Play games from 5 different genres',
                    unlocked: this.stats.unique_genres >= 5,
                    progress: { current: Math.min(this.stats.unique_genres, 5), total: 5 }
                },
                {
                    id: 16,
                    title: 'Genre Master',
                    description: 'Play games from 10 different genres',
                    unlocked: this.stats.unique_genres >= 10,
                    progress: { current: Math.min(this.stats.unique_genres, 10), total: 10 }
                }
            ];
        }
    }
};
</script>
<style lang='scss' scoped>
@use '../../../css/variables.scss' as *;

.achievements-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
    color: white;
}

.achievements-title {
    font-size: 2rem;
    text-align: center;
    margin-bottom: 2rem;
    color: $main-color;
    text-transform: uppercase;
}

.achievements-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
}

.achievement-card {
    display: flex;
    background: #1e1e1e;
    border-radius: 8px;
    padding: 1rem;
    transition: transform 0.3s ease;
}

.achievement-card:hover {
    transform: translateY(-5px);
}

.achievement-card.locked {
    opacity: 0.6;
    filter: grayscale(100%);
}

.achievement-icon {
    width: 64px;
    height: 64px;
    margin-right: 1rem;
    object-fit: contain;
}

.achievement-content {
    flex: 1;
}

.achievement-content h3 {
    margin: 0 0 0.5rem 0;
    color: $main-color;
}

.achievement-content p {
    margin: 0 0 0.5rem 0;
    color: #aaa;
    font-size: 0.9rem;
}

.progress {
    font-size: 0.8rem;
    color: $main-color;
}

@media (max-width: 768px) {
    .achievements-grid {
        grid-template-columns: 1fr;
    }
}

</style>
