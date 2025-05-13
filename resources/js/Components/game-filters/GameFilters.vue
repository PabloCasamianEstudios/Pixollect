<template>
    <div class="filters">
        <select v-model="filters.genre" @change="applyFilters">
            <option value="">All Genres</option>
            <option v-for="genre in genres" :key="genre.id" :value="genre.name">
                {{ genre.name }}
            </option>
        </select>

        <select v-model="filters.platform" @change="applyFilters">
            <option value="">All Platforms</option>
            <option
                v-for="platform in platforms"
                :key="platform.id"
                :value="platform.name"
            >
                {{ platform.name }}
            </option>
        </select>

        <select v-model="filters.theme" @change="applyFilters">
            <option value="">All Themes</option>
            <option v-for="theme in themes" :key="theme.id" :value="theme.name">
                {{ theme.name }}
            </option>
        </select>

        <select v-model="filters.saga" @change="applyFilters">
            <option value="">All Sagas</option>
            <option v-for="saga in sagas" :key="saga.id" :value="saga.name">
                {{ saga.name }}
            </option>
        </select>
    </div>
</template>

<script>
import { usePage } from '@inertiajs/vue3';
export default {
    props: {
        genres: {
            type: Array,
            required: true,
        },
        platforms: {
            type: Array,
            required: true,
        },
        themes: {
            type: Array,
            required: true,
        },
        sagas: {
            type: Array,
            required: true,
        },
    },
    data() {
        const page = usePage();
        return {
            filters: {
                genres: page.props.genres || [],
                platforms: page.props.platforms || [],
                themes: page.props.themes || [],
                sagas: page.props.sagas || [],
            },
        };
    },
    methods: {
        applyFilters() {
            this.$emit('filter', this.filters);
        },
    },
};
</script>

<style scoped>
.filters {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

select {
    background-color: #1c1c1c;
    color: white;
    border: 1px solid #333;
    padding: 0.5rem;
    border-radius: 5px;
    font-size: 0.9rem;
}
</style>
