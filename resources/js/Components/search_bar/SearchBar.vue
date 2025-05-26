<template>
    <input
        v-model="searchQuery"
        type="text"
        class="searchInput"
        :placeholder="placeholder"
        @input="handleSearch"
    />
</template>

<script>
export default {
    props: {
        placeholder: {
            type: String,
            default: 'Search games...',
        },
    },
    data() {
        return {
            searchQuery: '',
        };
    },
    methods: {
        handleSearch() {
            this.$emit('search', this.searchQuery);
        },
    },
};
</script>

<style scoped>
.searchInput {
    background-color: #1c1c1c;
    border: 1px solid #333;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 5px;
    font-size: 1rem;
    flex: 1;
    min-width: 250px;
}
</style>
