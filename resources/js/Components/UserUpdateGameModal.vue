<template>
    <div class="modal-backdrop" @click.self="$emit('close')">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h2 class="modal-title">
                        {{ game.title }}
                        <span class="release-year">{{
                            new Date(game.release_date).getFullYear()
                        }}</span>
                    </h2>
                </div>
                <button class="close-btn" @click="confirmDelete">✕</button>
            </div>

            <form @submit.prevent="submit" class="modal-body">
                <div class="side-panel">
                    <img
                        :src="game.image_url"
                        alt="Game Cover"
                        class="game-cover"
                    />
                    <!--  Esta mrda no pilla el valor por defecto que debería, ni el mastered tampoco. -->
                    <select v-model="form.status" :selected="userGame?.state">
                        <option value="Completed">Completed</option>
                        <option value="Playing">Playing</option>
                        <option value="Backlog">Backlog</option>
                        <option value="Wishlist">Wishlist</option>
                        <option value="Dropped">Dropped</option>
                        <option value="Planned">Planned</option>
                    </select>
                </div>

                <div class="main-panel">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" v-model="form.start_date" />
                            <span v-if="errors.start_date" class="formError">{{
                                errors.start_date
                            }}</span>
                        </div>
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" v-model="form.end_date" />
                            <span v-if="errors.end_date" class="formError">{{
                                errors.end_date
                            }}</span>
                        </div>
                        <div class="form-group">
                            <label>Hours Played</label>
                            <input
                                type="number"
                                v-model="form.hours_played"
                                min="0"
                            />
                            <span
                                v-if="errors.hours_played"
                                class="formError"
                                >{{ errors.hours_played }}</span
                            >
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>user_score</label>
                            <input
                                type="number"
                                v-model="form.user_score"
                                min="0"
                                max="10"
                            />
                            <span v-if="errors.user_score" class="formError">{{
                                errors.user_score
                            }}</span>
                        </div>

                        <div class="form-group checkbox-group">
                            <label
                                ><input
                                    type="checkbox"
                                    v-model="form.mastered"
                                />
                                Mastered</label
                            >
                        </div>
                    </div>

                    <div class="form-group" v-if="game.achievements > 0">
                        <label>Achievements Unlocked</label>
                        <input
                            type="number"
                            v-model="form.achievements_unlocked"
                            min="0"
                        />
                        <small>of {{ game.achievements }} achievements</small>
                        <span
                            v-if="errors.achievements_unlocked"
                            class="formError"
                            >{{ errors.achievements_unlocked }}</span
                        >
                    </div>
                    <div v-else style="padding:43px;"></div>


                    <div class="modal-actions">
                        <button
                            type="button"
                            class="cancel-btn"
                            @click="$emit('close')"
                        >
                            Cancel
                        </button>
                        <button type="submit" class="submit-btn">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        game: Object,
        userGame: Object,
    },
    emits: ['close'],
    data() {
        return {
            form: {
                game_id: this.game.id,
                status: this.userGame.state,
                user_score: this.userGame.user_score,
                hours_played: this.userGame.hours_played,
                achievements_unlocked: this.userGame.achievements_unlocked,
                mastered: this.userGame.mastered,
                start_date: this.userGame.start_date,
                end_date: this.userGame.end_date,
            },
            errors: {
                user_score: '',
                achievements_unlocked: '',
                hours_played: '',
                start_date: '',
                end_date: '',
            },
        };
    },
    methods: {
        confirmDelete() {
            if (
                confirm(
                    'Are you sure you want to remove this game from your collection?',
                )
            ) {
                this.$inertia.delete(`/games/${this.game.id}/remove`);
                this.$emit('close');
            }
        },
        validate() {
            let valid = true;

            if (this.form.user_score < 0 || this.form.user_score > 10) {
                this.errors.user_score = 'user_score must be between 0 and 10';
                valid = false;
            } else {
                this.errors.user_score = '';
            }

            if (
                this.form.achievements_unlocked < 0 ||
                this.form.achievements_unlocked > this.game.achievements
            ) {
                this.errors.achievements_unlocked = `Must be between 0 and ${this.game.achievements}`;
                valid = false;
            } else {
                this.errors.achievements_unlocked = '';
            }

            if (this.form.hours_played !== null && this.form.hours_played < 0) {
                this.errors.hours_played = 'Hours cannot be negative';
                valid = false;
            } else {
                this.errors.hours_played = '';
            }

            if (
                this.form.start_date &&
                this.form.start_date < this.game.release_date
            ) {
                this.errors.start_date =
                    'Start date cannot be before release date';
                valid = false;
            } else {
                this.errors.start_date = '';
            }

            if (
                this.form.start_date &&
                this.form.end_date &&
                this.form.end_date < this.form.start_date
            ) {
                this.errors.end_date = 'End date cannot be before start date';
                valid = false;
            } else {
                this.errors.end_date = '';
            }

            return valid;
        },
        submit() {
            if (
                this.form.achievements_unlocked == this.game.achievements &&
                this.game.achievements !== 0
            ) {
                this.form.mastered = true;
            }

            if (!this.validate()) return;

            const payload = { ...this.form };
            this.$inertia.put(`/games/${this.form.game_id}/update`, payload, {
                onSuccess: () => {
                    this.$emit('close');
                },
            });
        },
    },
};
</script>

<style scoped lang="scss">
@use '../../css/variables.scss' as *;

.modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background-color: #1c1c1c;
    color: white;
    padding: 2rem;
    border-radius: 12px;
    width: 800px;
    font-family: 'Orbitron', sans-serif;
    display: flex;
    flex-direction: column;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;

    .modal-title {
        font-size: 1.5rem;
        color: $main-color;
    }

    .release-year {
        font-size: 0.9rem;
        color: #aaa;
        display: block;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #fff;
        cursor: pointer;
    }
}

.modal-body {
    display: flex;
    gap: 2rem;
}

.side-panel {
    flex: 0 0 25%;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;

    .game-cover {
        width: 100%;
        border-radius: 10px;
    }

    select {
        padding: 0.5rem;
        background: #2c2c2c;
        color: white;
        border: 1px solid $main-color;
        border-radius: 8px;
        width: 100%;
    }
}

.main-panel {
    flex: 1;

    .form-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;

        .form-group {
            flex: 1;
        }
    }

    .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 1rem;

        label {
            margin-bottom: 0.4rem;
            font-weight: 600;
        }

        input,
        textarea {
            padding: 0.5rem;
            border-radius: 8px;
            border: 1px solid $main-color;
            background-color: #2c2c2c;
            color: white;
        }

        textarea {
            resize: vertical;
        }

        small {
            font-size: 0.8rem;
            color: #aaa;
        }
    }

    .checkbox-group {
        margin-top: 2rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .formError {
        color: #e53935;
        font-size: 0.85rem;
        margin-top: 0.3rem;
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    .cancel-btn,
    .submit-btn {
        padding: 0.6rem 1.2rem;
        border: none;
        border-radius: 8px;
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
}
</style>
