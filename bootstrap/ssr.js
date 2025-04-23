import { createInertiaApp } from '@inertiajs/inertia-vue3';
import * as pkg from '@inertiajs/server';  // Change to import the entire module
import { renderToString } from '@vue/server-renderer';
import { createSSRApp, h } from 'vue';

// Access the createServer from the imported module
const { createServer } = pkg;

createServer((page) =>
    createInertiaApp({
        page,
        render: renderToString,
        resolve: (name) => import(`./Pages/${name}.vue`),
        setup({ App, props, plugin }) {
            const app = createSSRApp({ render: () => h(App, props) });
            app.use(plugin);
            return app;
        },
    }),
);
