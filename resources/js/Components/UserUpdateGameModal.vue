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
                    <select v-model="form.status" :selected="userGame?.state">
                        <option value="Completed">{{ $t('Completed') }}</option>
                        <option value="Playing">{{ $t('Playing') }}</option>
                        <option value="Backlog">{{ $t('Backlog') }}</option>
                        <option value="Wishlist">{{ $t('Wishlist') }}</option>
                        <option value="Dropped">{{ $t('Dropped') }}</option>
                        <option value="Planned">{{ $t('Planned') }}</option>
                    </select>
                </div>

                <div class="main-panel">
                    <div class="form-row">
                        <div class="form-group">
                            <label>{{ $t('Start Date') }}</label>
                            <input type="date" v-model="form.start_date" />
                            <span v-if="errors.start_date" class="formError">{{
                                errors.start_date
                            }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ $t('End Date') }}</label>
                            <input type="date" v-model="form.end_date" />
                            <span v-if="errors.end_date" class="formError">{{
                                errors.end_date
                            }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ $t('Hours Played') }}</label>
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
                            <label>{{ $t('User Score') }}</label>
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
                                {{ $t('Mastered') }}</label
                            >
                        </div>
                    </div>

                    <div class="form-group" v-if="game.achievements > 0">
                        <label>{{ $t('Achievements Unlocked') }}</label>
                        <input
                            type="number"
                            v-model="form.achievements_unlocked"
                            min="0"
                        />
                        <small>{{ $t('of') }} {{ game.achievements }}
                            {{ $t('achievements') }}</small>
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
                            {{ $t('Cancel') }}
                        </button>
                        <button type="submit" class="submit-btn">{{ $t('Update') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
import { useI18n } from 'vue-i18n';


export default {
    props: {
        game: Object,
        userGame: Object,
    },
    emits: ['close'],
    setup() {
        const { t } = useI18n();
        return {
                t,
                $t: t
            };

    },
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
        async confirmDelete() {
            const result = await Swal.fire({
                title: this.t('Confirm removal'),
                text: this.t('Are you sure you want to remove this game from your collection?'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.t('YES'),
                cancelButtonText: this.t('NO'),
                confirmButtonColor: '#ff1540',
                cancelButtonColor: '#ff1540',
                background: '#262626',
                color: '#fff',
                iconColor: '#ff1540'
            });

            if (result.isConfirmed) {
                this.$inertia.delete(`/games/${this.game.id}/remove`);
                this.$emit('close');
            }
        },
        validate() {
            let valid = true;

            if (this.form.user_score < 0 || this.form.user_score > 10) {
                this.errors.user_score = this.t('Score must be between 0 and 10');
                valid = false;
            } else {
                this.errors.user_score = '';
            }

            if (
                this.form.achievements_unlocked < 0 ||
                this.form.achievements_unlocked > this.game.achievements
            ) {
                this.errors.achievements_unlocked = this.t('Must be between 0 and')+ ' ' + this.game.achievements;
                valid = false;
            } else {
                this.errors.achievements_unlocked = '';
            }

            if (this.form.hours_played !== null && this.form.hours_played < 0) {
                this.errors.hours_played = this.t('Hours cannot be negative');
                valid = false;
            } else {
                this.errors.hours_played = '';
            }

            if (
                this.form.start_date &&
                this.form.start_date < this.game.release_date
            ) {
                this.errors.start_date =
                    this.t('Start date cannot be before release date');
                valid = false;
            } else {
                this.errors.start_date = '';
            }

            if (
                this.form.start_date &&
                this.form.end_date &&
                this.form.end_date < this.form.start_date
            ) {
                this.errors.end_date = this.errors.end_date = this.t('End date cannot be before start date');
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
    background: rgba(0, 0, 0, 0.85);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    backdrop-filter: blur(4px);
}

.modal-content {
    background-color: #1e1e1e;
    color: white;
    padding: 2rem;
    border-radius: 12px;
    width: 850px;
    max-width: 90vw;
    max-height: 90vh;
    overflow-y: auto;
    font-family: 'Orbitron', sans-serif;
    display: flex;
    flex-direction: column;
    border: 1px solid $main-color;
    box-shadow: 0 0 20px rgba($main-color, 0.3);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #333;

    .modal-title {
        font-size: 1.8rem;
        color: white;
        font-weight: bold;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .release-year {
        font-size: 1rem;
        color: $main-color;
        font-weight: normal;
        opacity: 0.8;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #aaa;
        cursor: pointer;
        transition: color 0.2s;
        padding: 0.5rem;
        margin: -0.5rem;

        &:hover {
            color: $main-color;
        }
    }
}

.modal-body {
    display: flex;
    gap: 2rem;

    @media (max-width: 768px) {
        flex-direction: column;
    }
}

.side-panel {
    flex: 0 0 220px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1.5rem;

    .game-cover {
        width: 100%;
        border-radius: 10px;
        border: 1px solid #333;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s, box-shadow 0.3s;

        &:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.4);
        }
    }

    select {
        padding: 0.7rem;
        background: #2c2c2c;
        color: white;
        border: 1px solid $main-color;
        border-radius: 8px;
        width: 100%;
        font-family: 'Orbitron', sans-serif;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;

        &:hover {
            border-color: lighten($main-color, 10%);
        }

        &:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba($main-color, 0.3);
        }
    }
}

.main-panel {
    flex: 1;

    .form-row {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 1.5rem;

        @media (max-width: 600px) {
            flex-direction: column;
            gap: 1rem;
        }

        .form-group {
            flex: 1;
        }
    }

    .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 1.5rem;
        position: relative;

        label {
            margin-bottom: 0.6rem;
            font-weight: 600;
            color: #ddd;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input,
        textarea {
            padding: 0.7rem 1rem;
            border-radius: 8px;
            border: 1px solid #444;
            background-color: #2c2c2c;
            color: white;
            font-family: 'Orbitron', sans-serif;
            transition: all 0.2s;

            &:focus {
                outline: none;
                border-color: $main-color;
                box-shadow: 0 0 0 2px rgba($main-color, 0.2);
            }

            &[type="number"] {
                appearance: textfield;
            }
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        small {
            font-size: 0.8rem;
            color: #aaa;
            margin-top: 0.3rem;
        }
    }

    .checkbox-group {
        margin-top: 2.5rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;

        label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            font-weight: normal;
            text-transform: none;
            color: white;
        }

        input[type="checkbox"] {
            appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid $main-color;
            border-radius: 4px;
            background-color: #2c2c2c;
            cursor: pointer;
            position: relative;
            transition: all 0.2s;

            &:checked {
                background-color: $main-color;

                &::after {
                    content: "✓";
                    position: absolute;
                    color: black;
                    font-size: 0.9rem;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                }
            }
        }
    }

    .formError {
        color: #ff4d4d;
        font-size: 0.85rem;
        margin-top: 0.4rem;
        position: absolute;
        bottom: -1.2rem;
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1.2rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #333;
    }

    .cancel-btn,
    .submit-btn {
        padding: 0.8rem 1.8rem;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        font-family: 'Orbitron', sans-serif;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
        transition: all 0.2s;
    }

    .cancel-btn {
        background-color: #333;
        color: #ddd;

        &:hover {
            background-color: #444;
            color: white;
        }
    }

    .submit-btn {
        background-color: $main-color;
        color: black;

        &:hover {
            background-color: lighten($main-color, 10%);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba($main-color, 0.3);
        }

        &:active {
            transform: translateY(0);
        }
    }
}
</style>
