<template>
    <div>
        <metaHead>
            <title>{{ user.name }}</title>
            <meta
                head-key="description"
                name="description"
                content="Home page of the application"
            />
        </metaHead>
        <FlashMessage />

        <UserLayout :user="user">
            <div class="profile-container">
                <div v-if="loading" class="loading-container">
                    <p>Loading user data...</p>
                </div>
                <div v-else-if="error" class="error-container">
                    <p>Error loading user data: {{ error }}</p>
                </div>

                <div v-else-if="counters?.totals?.games > 0">
                    <div class="stats-overview">
                        <div class="stat-item">
                            <span class="stat-label">Total Games:</span>
                            <span class="stat-value">{{
                                counters?.totals?.games
                                    ?.toString()
                                    .padStart(3, '0') || '000'
                            }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Total Hours:</span>
                            <span class="stat-value">{{
                                counters?.totals?.hours
                                    ? Math.round(counters.totals.hours)
                                          .toString()
                                          .padStart(3, '0')
                                    : '000'
                            }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Total Achievements:</span>
                            <span class="stat-value">{{
                                counters?.totals?.achievements
                                    ?.toString()
                                    .padStart(3, '0') || '000'
                            }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Total Spent:</span>
                            <span class="stat-value">
                                ${{
                                    counters?.financial?.total_spent != null
                                        ? Math.round(
                                              counters.financial.total_spent,
                                          )
                                              .toString()
                                              .padStart(3, '0')
                                        : '000'
                                }}
                            </span>
                        </div>
                    </div>

                    <div class="charts-section">
                        <div class="chart-wrapper">
                            <div class="chart-container">
                                <div class="chart-header">
                                    <h3>Games by Genre</h3>
                                </div>
                                <div class="chart-canvas-container">
                                    <canvas
                                        ref="genreChart"
                                        class="chart-canvas"
                                    ></canvas>
                                </div>
                            </div>
                        </div>

                         <div class="chart-wrapper">
                            <div class="chart-container">
                                <div class="chart-header">
                                    <h3>Games by State</h3>
                                </div>
                                <div class="chart-canvas-container">
                                    <canvas
                                        ref="stateChart"
                                        class="chart-canvas"
                                    ></canvas>
                                </div>
                            </div>
                        </div>

                         <div class="chart-wrapper">
                        <div class="chart-container">
                            <div class="chart-header">
                                <h3>Games Mastered</h3>
                            </div>
                            <div class="chart-canvas-container">
                                <canvas
                                    ref="masteredChart"
                                    class="chart-canvas"
                                ></canvas>
                            </div>
                        </div>
                    </div>

                          <div class="chart-wrapper">
                            <div class="chart-container">
                                <div class="chart-header">
                                    <h3>Library by Saga</h3>
                                </div>
                                <div class="chart-canvas-container">
                                    <canvas
                                        ref="sagaRadarChart"
                                        class="chart-canvas"
                                    ></canvas>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <div v-else class="empty-message">
                    <h1>NO GAMES</h1>
                    <p>No games to calc user stats</p>
                </div>
            </div>
        </UserLayout>
    </div>
</template>

<script>
import { Head as metaHead } from '@inertiajs/vue3';
import { Chart, registerables } from 'chart.js';
import FlashMessage from '@/Components/FlashMessage.vue';
import UserLayout from '@/Layouts/UserLayout.vue';

Chart.register(...registerables);

export default {
    components: {
        metaHead,
        UserLayout,
        FlashMessage,
    },
    props: {
        user: Object,
        errors: Object,
        auth: Object,
        flash: Object,
        gamesCount: Number,
        userGames: Array,
    },
    data() {
        return {
            loading: false,
            error: null,
            counters: {},
            stats: {
                gamesByGenre: [],
                gamesByState: [],
                gamesBySaga: [],
                gamesMastered: { mastered_count: 0, not_mastered_count: 0 },
            },
            genreChart: null,
            stateChart: null,
            sagaRadarChart: null,
            chartColors: [
                '#ff1540',
                '#ff2e54',
                '#ff4768',
                '#ff607c',
                '#ff7990',
                '#ff92a4',
                '#ffabb8',
                '#ffc4cc',
                '#ffdde0',
                '#fff6f7',
            ],
        };
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        async fetchData() {
            this.loading = true;
            try {
                await Promise.all([
                    this.fetchUserCounts(this.user.id),
                    this.fetchUserStats(this.user.id),
                ]);

                this.$nextTick(() => {
                    this.initAllCharts();
                });
            } catch (error) {
                console.error('Error fetching data:', error);
                this.error = error.message;
            } finally {
                this.loading = false;
            }
        },
        async fetchUserCounts(userId) {
            try {
                const response = await fetch(`/user/${userId}/counts`);
                const data = await response.json();

                this.counters = {
                    totals: {
                        games: data.total_games,
                        hours: data.total_hours,
                        achievements: data.total_achievements,
                    },
                    financial: {
                        total_spent: data.total_spent,
                    },
                };

                return data;
            } catch (error) {
                console.error('Error fetching user stats:', error);
                return null;
            }
        },
        async fetchUserStats(userId) {
            const response = await fetch(`/user/${userId}/stats`);
            if (!response.ok) throw new Error('Failed to fetch stats');
            const data = await response.json();

            this.stats = {
                gamesByGenre: data.gamesByGenre || [],
                gamesByState: data.gamesByState || [],
                gamesBySaga: data.gamesBySaga || [],
                gamesMastered: data.gamesMastered || { mastered_count: 0, not_mastered_count: 0 }


            };
        },
        initStateChart() {
            this.$nextTick(() => {
                if (!this.$refs.stateChart || !this.stats.gamesByState?.length) return;

                const ctx = this.$refs.stateChart.getContext('2d');
                if (this.stateChart) this.stateChart.destroy();

                this.stateChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: this.stats.gamesByState.map((item) => item.title),
                        datasets: [{
                            data: this.stats.gamesByState.map((item) => item.count),
                            backgroundColor: this.chartColors,
                            borderColor: 'white',
                            borderWidth: 1,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    color: '#ffffff',
                                    font: { size: 12 },
                                },
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                            },
                        },
                    },
                });
            });
        },
        initGenreChart() {
            this.$nextTick(() => {
                if (!this.$refs.genreChart || !this.stats.gamesByGenre?.length) return;

                const ctx = this.$refs.genreChart.getContext('2d');
                if (this.genreChart) this.genreChart.destroy();

                this.genreChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: this.stats.gamesByGenre.map((item) => item.title),
                        datasets: [{
                            label: 'Games by Genre',
                            data: this.stats.gamesByGenre.map((item) => item.userGames),
                            backgroundColor: this.chartColors,
                            borderColor: 'white',
                            borderWidth: 1,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    color: '#ffffff',
                                },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)',
                                },
                            },
                            x: {
                                ticks: {
                                    color: '#ffffff',
                                },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)',
                                },
                            },
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                            },
                        },
                    },
                });
            });
        },
        initSagaRadarChart() {
            this.$nextTick(() => {
                if (!this.$refs.sagaRadarChart || !this.stats.gamesBySaga?.length) {
                    console.log('No data or canvas for radar chart');
                    return;
                }

                const sortedData = [...this.stats.gamesBySaga]
                    .sort((a, b) => b.count - a.count)
                    .slice(0, 8);

                const ctx = this.$refs.sagaRadarChart.getContext('2d');
                if (this.sagaRadarChart) this.sagaRadarChart.destroy();

                this.sagaRadarChart = new Chart(ctx, {
                    type: 'radar',
                    data: {
                        labels: sortedData.map(item => item.title),
                        datasets: [
                            {
                                label: 'Number of Games',
                                data: sortedData.map(item => item.count),
                                backgroundColor: 'rgba(255, 21, 64, 0.2)',
                                borderColor: '#ff1540',
                                borderWidth: 2,
                                pointBackgroundColor: '#ff1540',
                                pointBorderColor: '#fff',
                                pointHoverRadius: 5
                            },
                            {
                                label: 'Hours Played',
                                data: sortedData.map(item => Math.round(item.hours/10)),
                                backgroundColor: 'rgba(100, 149, 237, 0.2)',
                                borderColor: 'white',
                                borderWidth: 2,
                                pointBackgroundColor: '#ccc',
                                pointBorderColor: '#fff',
                                pointHoverRadius: 5
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            r: {
                                angleLines: { color: 'rgba(255, 255, 255, 0.1)' },
                                grid: { color: 'rgba(255, 255, 255, 0.1)' },
                                pointLabels: {
                                    color: '#ffffff',
                                    font: { size: 11 }
                                },
                                ticks: {
                                    display: false,
                                    backdropColor: 'transparent'
                                },
                                suggestedMin: 0
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    color: '#ffffff',
                                    font: { size: 12 }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.9)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label.includes('Hours')) {
                                            return `${label}: ${context.raw * 10} hrs`;
                                        }
                                        return `${label}: ${context.raw}`;
                                    }
                                }
                            }
                        }
                    }
                });
            });
        },
        initMasteredChart() {
            this.$nextTick(() => {
                if (!this.$refs.masteredChart || !this.stats.gamesMastered) return;

                const ctx = this.$refs.masteredChart.getContext('2d');
                if (this.masteredChart) this.masteredChart.destroy();

                this.masteredChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Mastered', 'Not Mastered'],
                        datasets: [{
                            data: [
                                this.stats.gamesMastered.mastered_count,
                                this.stats.gamesMastered.not_mastered_count
                            ],
                            backgroundColor: ['#ff1540', '#ffc4cc'],
                            borderColor: 'white',
                            borderWidth: 1,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    color: '#ffffff',
                                    font: { size: 12 },
                                },
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            },
                        },
                    },
                });
            });
        },
        initAllCharts() {
            this.initGenreChart();
            this.initStateChart();
            this.initSagaRadarChart();
            this.initMasteredChart();
        },
    },
    beforeUnmount() {
        if (this.genreChart) this.genreChart.destroy();
        if (this.stateChart) this.stateChart.destroy();
        if (this.sagaRadarChart) this.sagaRadarChart.destroy();
        if (this.masteredChart) this.masteredChart.destroy();
    },
};
</script>

<style lang="scss" scoped>
@use '../../../css/variables.scss' as *;

.stats-overview {
    display: flex;
    justify-content: space-between;
    background: rgba(255, 255, 255, 0.05);
    padding: 1.5rem;
    border-radius: 8px;
    margin-bottom: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex: 1;
}

.stat-label {
    font-size: 0.9rem;
    color: #aaa;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.stat-value {
    font-size: 1.8rem;
    font-weight: bold;
    color: $main-color;
}

.charts-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.chart-container {
    background: rgba(255, 255, 255, 0.05);
    padding: 1.5rem;
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    height: 500px;
}

.chart-header {
    margin-bottom: 1.5rem;
    h3 {
        color: $main-color;
        margin-bottom: 0.5rem;
        font-size: 1.2rem;
    }
}

.chart-canvas-container {
    position: relative;
    height: 400px;
    width: 100%;
}

.chart-canvas {
    width: 100% !important;
    height: 100% !important;
}

.loading-container,
.error-container {
    padding: 2rem;
    text-align: center;
    color: #aaa;
    font-size: 1.2rem;
}

.error-container {
    color: #ff6384;
}

@media (max-width: 768px) {
    .stats-overview {
        flex-direction: column;
        gap: 1.5rem;
    }
    .charts-section {
        grid-template-columns: 1fr;
    }
}

.empty-message {
    background-color: #1e1e1e;
    border: 1px dashed $main-color;
    padding: 2rem;
    border-radius: 8px;
    text-align: center;
    font-size: 1.1rem;
    color: #aaa;
    font-family: 'Orbitron', sans-serif;
    margin-top: 2rem;

    p {
        margin: 0;
        color: lighten($main-color, 15%);
    }
}
</style>
