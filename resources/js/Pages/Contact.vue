<template>

     <MetaHead>
        <title>{{ $t('Contact') }} </title>
        <meta
            head-key="description"
            name="description"
            content="Contact of Pixollect"
        />
    </MetaHead>
    <FlashMessage />
    <div class="formContainer">
    <div class="inner-bordered-box ">


        <h1>{{ $t('Contact') }}</h1>
        <form @submit.prevent="submit">
            <input v-model="form.name" type="text" :placeholder="$t('Name')" />
            <input v-model="form.email" type="email" :placeholder="$t('Email')" />
            <textarea v-model="form.message" :placeholder="$t('Message')"></textarea>

            <div v-if="form.errors" class="errors">
                <div v-for="(error, field) in form.errors" :key="field">
                    {{ error }}
                </div>
            </div>

            <button type="submit">{{ $t('Send') }}
</button>
        </form>
    </div>
      </div>
</template>

<script>
import FlashMessage from '@/Components/FlashMessage.vue';
import { useForm, Head as MetaHead } from '@inertiajs/vue3';

export default {
    name: 'Contact',
    components: {
        FlashMessage,
        MetaHead,
    },
    props: {
        errors: Object,
        auth: Object,
        flash: Object
    },
    setup() {
        const form = useForm({
            name: '',
            email: '',
            message: '',
        });

        function submit() {
            form.post('/contact/send', {
                preserveScroll: true,
                onSuccess: () => {
                    form.reset();
                }
            });
        }

        return { form, submit };
    },
};
</script>

<style lang="scss" scoped>
@use '../../css/variables.scss' as *;

.formContainer {
    max-width: 500px;
    margin: 2rem auto;
    padding: 2rem;
    background: #1c1c1c;
    border-radius: 10px;
    color: white;
}

input, textarea {
    width: 100%;
    margin-bottom: 1rem;
    padding: 0.5rem;
    background: #121212;
    border: 1px solid #444;
    border-radius: 8px;
    color: white;
}

button {
    background-color: $main-color;
    color: white;
    border: none;
    padding: 0.8rem 1.2rem;
    border-radius: 8px;
    cursor: pointer;
}

.inner-bordered-box {
    border: 1px dashed $main-color;
    padding: 2rem;
    border-radius: 8px;
    background-color: #1e1e1e;
    text-align: center;
}
</style>
