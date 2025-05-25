import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
// import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import Layout from './Layouts/Layout.vue';

const appName = import.meta.env.VITE_APP_NAME || 'Pixollect';

let locale = localStorage.getItem('locale');
if (!locale) {
    localStorage.setItem('locale', 'en');
    locale = localStorage.getItem('locale');
}
window.locale = locale;

import { createI18n } from 'vue-i18n/dist/vue-i18n.cjs';
import messages from './messages';

const i18n = createI18n ({
    locale: locale,
    fallbackLocale: 'en',
    globalInjection: true,
    messages,
});

window.$i18n = i18n;

createInertiaApp({
    title: (title) => `${title} | ${appName}`,
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        page.default.layout = page.default.layout || Layout;
        return page;
    },
    // resolve: (name) =>
    //     resolvePageComponent(
    //         `./Pages/${name}.vue`,
    //         import.meta.glob('./Pages/**/*.vue'),
    //     ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(i18n)
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#ff1540',
    },
});
