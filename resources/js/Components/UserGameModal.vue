<template>
    <div class="modal-backdrop" @click.self="$emit('close')">
        <div class="modal-content">
            <h2 class="modal-title">
                Add "{{ game.title }}" to your Collection
            </h2>

            <form @submit.prevent="submit">
                <div class="form-group">
                    <label>Status</label>
                    <select v-model="form.status">
                        <option value="Completed">Completed</option>
                        <option value="Playing">Playing</option>
                        <option value="Backlog">Backlog</option>
                        <option value="Wishlist">Wishlist</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Rating</label>
                    <input type="number" v-model="form.rating" />

                    <span v-if="errors.rating" class="formError">
                        {{ errors.rating }}
                    </span>
                </div>

                <div class="modal-actions">
                    <button
                        type="button"
                        class="cancel-btn"
                        @click="$emit('close')"
                    >
                        Cancel
                    </button>
                    <button type="submit" class="submit-btn">Save</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { reactive } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

export default {
    props: {
        game: Object,
        userGames: Array,
    },
    emits: ['close'],
    data() {
        return {
            form: reactive({
                game_id: this.game.id,
                status: 'Playing',
                rating: null,
            }),
            errors: reactive({
                rating: '',
            }),
        };
    },
    computed: {
        currentUser() {
            return usePage().props.auth.user;
        },
    },
    methods: {
        isGameInCollection(gameId) {
            return this.userGames.find((game) => game.id === gameId);
        },
        validate() {
            let isValid = true;
            //validar rating valido
            if (
                this.form.rating !== null &&
                (this.form.rating < 0 || this.form.rating > 10)
            ) {
                this.errors.rating = 'Rating must be a number between 0 and 10';
                isValid = false;
            } else {
                this.errors.rating = '';
            }
            return isValid;
        },
        submit() {
            if (this.validate()) {
                if (this.isGameInCollection(this.form.game_id)) {
                    this.$emit('close');
                } else {
                    router.post(`/games/${this.form.game_id}/add`, this.form, {});
                    this.$emit('close');
                }
            } else {
                console.log('rating inválido');
            }
        },
    },
};
</script>
<style scoped lang="scss">
@use '../../css/variables.scss' as *;

.formError {
    color: #e53935;
    font-size: 0.85rem;
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
}

.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 100;
}

.modal-content {
    background: #1c1c1c;
    color: white;
    padding: 2rem;
    border-radius: 12px;
    width: 400px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.7);
    font-family: 'Orbitron', sans-serif;
}

.modal-title {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    color: $main-color;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 1rem;

    label {
        margin-bottom: 0.5rem;
        color: white;
    }

    input,
    select {
        padding: 0.5rem;
        border-radius: 8px;
        border: 1px solid $main-color;
        background-color: #2c2c2c;
        color: white;
    }
}

.modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 1.5rem;
}

.cancel-btn,
.submit-btn {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    border: none;
    font-weight: bold;
    cursor: pointer;
}

.cancel-btn {
    background-color: #555;
    color: white;
}

.submit-btn {
    background-color: $main-color;
    color: black;

    &:hover {
        background-color: lighten($main-color, 10%);
    }
}
</style>
