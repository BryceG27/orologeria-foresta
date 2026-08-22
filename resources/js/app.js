import './bootstrap';
import '../css/app.css';
import { createPinia } from "pinia";

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import BaseBlock from "@/Components/BaseBlock.vue";
import BaseBackground from "@/Components/BaseBackground.vue";
import BasePageHeading from "@/Components/BasePageHeading.vue";

import PrimeVue from 'primevue/config';
import Aura from '@primeuix/themes/aura';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const el = document.getElementById('app');
const initialPage = el?.dataset?.page ? JSON.parse(el.dataset.page) : undefined;

createInertiaApp({
    page: initialPage,
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue', { eager: true })
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(createPinia())
            .use(PrimeVue, {
                theme: {
                    preset: Aura,
                    options: {
                        prefix: 'p',
                        darkModeSelector: '.my-app-dark',
                        cssLayer: false
                    }
                }
            })
            .component("BaseBlock", BaseBlock)
            .component("BaseBackground", BaseBackground)
            .component("BasePageHeading", BasePageHeading)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

import * as bootstrap from "bootstrap";
window.bootstrap = bootstrap;
