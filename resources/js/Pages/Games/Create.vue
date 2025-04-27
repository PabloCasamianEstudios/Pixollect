<template>
    <metaHead>
        <title>Create Game</title>
        <meta
            head-key="description"
            name="description"
            content="Create Game page of the application"
        />
    </metaHead>

    <div class="formContainer">
        <h1 class="formTitle">Crear Juego</h1>

        <form @submit.prevent="submit" class="formFields">
            <input v-model="form.title" type="text" placeholder="Title" />
            <div v-if="errors.title" class="formError">{{ errors.title }}</div>
            <textarea v-model="form.description" placeholder="Description" />
            <div v-if="errors.description" class="formError">
                {{ errors.description }}
            </div>
            <input v-model="form.release_date" type="date" />
            <div v-if="errors.release_date" class="formError">
                {{ errors.release_date }}
            </div>

            <input
                v-model="form.developer"
                type="text"
                placeholder="Developer"
            />
            <input
                v-model="form.publisher"
                type="text"
                placeholder="Publisher"
            />
            <input
                v-model="form.price"
                type="number"
                step="0.01"
                placeholder="Price"
            />
            <div>
                <label>Amount of achievements</label>
                <input
                    id="achievement_id"
                    v-model="form.achievement_id"
                    type="number"
                    placeholder="Amount"
                />
            </div>
            <input
                v-model="form.achievements"
                type="text"
                placeholder="Achievements Amount"
            />
            <div v-if="errors.achievements" class="formError">
                {{ errors.achievements }}
            </div>

            <input
                v-model="form.image_url"
                type="text"
                placeholder="URL image"
            />
            <div v-if="errors.image_url" class="formError">
                {{ errors.image_url }}
            </div>
            <select v-model="form.saga_id">
                <option :value="null">Saga</option>
                <option v-for="saga in sagas" :key="saga.id" :value="saga.id">
                    {{ saga.name }}
                </option>
            </select>

            <div class="checkboxGroup">
                <label>Genres</label>
                <div
                    v-for="genre in genres"
                    :key="genre.id"
                    class="checkboxItem"
                >
                    <input
                        type="checkbox"
                        :id="'genre-' + genre.id"
                        :value="genre.id"
                        v-model="form.genre_ids"
                    />
                    <label :for="'genre-' + genre.id">{{ genre.name }}</label>
                </div>
                <div v-if="errors.genre_ids" class="formError">
                    {{ errors.genre_ids }}
                </div>
            </div>

            <div class="checkboxGroup">
                <label>Platforms</label>
                <div
                    v-for="platform in platforms"
                    :key="platform.id"
                    class="checkboxItem"
                >
                    <input
                        type="checkbox"
                        :id="'platform-' + platform.id"
                        :value="platform.id"
                        v-model="form.platform_ids"
                    />
                    <label :for="'platform-' + platform.id">{{
                        platform.name
                    }}</label>
                </div>
                <div v-if="errors.platform_ids" class="formError">
                    {{ errors.platform_ids }}
                </div>
            </div>

            <div class="checkboxGroup">
                <label>Themes</label>
                <div
                    v-for="theme in themes"
                    :key="theme.id"
                    class="checkboxItem"
                >
                    <input
                        type="checkbox"
                        :id="'theme-' + theme.id"
                        :value="theme.id"
                        v-model="form.theme_ids"
                    />
                    <label :for="'theme-' + theme.id">{{ theme.name }}</label>
                </div>
                <div v-if="errors.theme_ids" class="formError">
                    {{ errors.theme_ids }}
                </div>
            </div>

            <div class="checkboxGroup">
                <label>Game Modes</label>
                <div
                    v-for="mode in gameModes"
                    :key="mode.id"
                    class="checkboxItem"
                >
                    <input
                        type="checkbox"
                        :id="'mode-' + mode.id"
                        :value="mode.id"
                        v-model="form.game_mode_ids"
                    />
                    <label :for="'mode-' + mode.id">{{ mode.name }}</label>
                </div>
                <div v-if="errors.game_modes_ids" class="formError">
                    {{ errors.game_modes_ids }}
                </div>
            </div>

            <div class="checkboxGroup">
                <label>Tags</label>
                <div v-for="tag in gameTags" :key="tag.id" class="checkboxItem">
                    <input
                        type="checkbox"
                        :id="'tag-' + tag.id"
                        :value="tag.id"
                        v-model="form.game_tag_ids"
                    />
                    <label :for="'tag-' + tag.id">{{ tag.name }}</label>
                </div>
                <div v-if="errors.game_tag_ids" class="formError">
                    {{ errors.game_tag_ids }}
                </div>
            </div>

            <button type="submit" class="submitBtn">Create Game</button>
        </form>
    </div>
</template>

<script setup>
import { Head as metaHead, useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';

defineProps({
    genres: Array,
    platforms: Array,
    themes: Array,
    gameModes: Array,
    gameTags: Array,
    sagas: Array,
});

const form = useForm({
    title: '',
    description: '',
    release_date: '',
    developer: '',
    publisher: '',
    price: '',
    image_url: '',
    genre_ids: [],
    platform_ids: [],
    theme_ids: [],
    game_mode_ids: [],
    game_tag_ids: [],
    saga_id: null,
});

const errors = reactive({
    title: '',
    release_date: '',
    image_url: '',
    genre_ids: '',
    theme_ids: '',
    game_modes_ids: '',
    platform_ids: '',
    game_tag_ids: '',
    description: '',
    achievements: '',
});

const isValidDate = (dateStr) => {
    const date = new Date(dateStr);
    const hoy = new Date();

    if (date > hoy) {
        return false;
    }
    return true;
};

function validate() {
    let valid = true;
    errors.title = form.title.trim() ? '' : 'Title is required.';
    if (isNaN(form.achievements)) {
        errors.achievements = 'Achievements must be numeric.';
    }

    errors.description = form.description.trim()
        ? ''
        : 'Description is required.';
    errors.release_date = form.release_date
        ? isValidDate(form.release_date)
            ? ''
            : 'Release date must be a valid date.'
        : 'Release date is required.';
    errors.image_url = form.image_url.trim()
        ? ''
        : 'URL image of the game is required.';
    errors.genre_ids = form.genre_ids.length
        ? ''
        : 'You have to select at least one game genre.';
    errors.game_mode_ids = form.game_mode_ids.length
        ? ''
        : 'You have to select at least one game mode.';
    errors.platform_ids = form.platform_ids.length
        ? ''
        : 'You have to select at least one gaming platform.';
    errors.theme_ids = form.theme_ids.length
        ? ''
        : 'You have to select at least one game theme.';
    errors.game_tag_ids = form.game_tag_ids.length
        ? ''
        : 'You have to select at least one game tag.';

    for (let key in errors) {
        if (errors[key]) valid = false;
    }

    return valid;
}
function submit() {
    if (!validate()) return;
    form.post('/games');
}
</script>

<style scoped lang="scss">
@use '../../../css/variables.scss' as *;

.formError {
    color: #e53935;
    font-size: 0.85rem;
    margin-top: -0.5rem;
    margin-bottom: 0.5rem;
}

.formContainer {
    max-width: 800px;
    margin: 2rem auto;
    padding: 2rem;
    background-color: #1c1c1c;
    color: white;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    font-family: 'Orbitron', sans-serif;
}

.formTitle {
    font-size: 1.8rem;
    color: $main-color;
    text-align: center;
    margin-bottom: 1.5rem;
}

.formFields {
    display: flex;
    flex-direction: column;
    gap: 1rem;

    input,
    textarea,
    select {
        padding: 0.6rem 1rem;
        border-radius: 8px;
        border: 1px solid #444;
        background-color: #121212;
        color: white;
        font-size: 1rem;

        &:focus {
            outline: none;
            border-color: $main-color;
        }
    }

    textarea {
        min-height: 100px;
        resize: vertical;
    }
}

.checkboxGroup {
    margin-top: 1rem;

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 0.5rem;
    }

    .checkboxItem {
        display: flex;
        align-items: center;
        margin-bottom: 0.3rem;

        input[type='checkbox'] {
            margin-right: 0.5rem;
        }
    }
}

.submitBtn {
    background-color: $main-color;
    color: black;
    padding: 0.8rem;
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s;

    &:hover {
        background-color: #FF3A5EFF;
    }
}
</style>
