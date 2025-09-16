import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue'
import { createInertiaApp, Head } from '@inertiajs/vue3'
import { ZiggyVue } from "../../vendor/tightenco/ziggy"
import FrontendLayout from "@/layouts/FrontendLayout.vue";
import BackendLayout from "@/layouts/BackendLayout.vue";
import AdminLayout from "@/layouts/AdminLayout.vue";

createInertiaApp({
    resolve: async(name) => {
        const pages = import.meta.glob('./pages/**/*.vue', { eager: true })
        const page = await pages[`./pages/${name}.vue`];

        if (name.startsWith('backend/')) {
            page.default.layout = page.default.layout || BackendLayout;

        } else if (name.startsWith('admin/')) {
            page.default.layout = page.default.layout || AdminLayout;

        } else {
            page.default.layout = page.default.layout || FrontendLayout;
        }

        return page;
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        app.use(plugin)
            .use(ZiggyVue)
            .component("Head", Head)
            .mount(el)
    },
    progress: {
      color: '#4ECAC2',
      includeCSS: true,
      showSpinner: false,
    },
    title: (title) => `ClueForge ${title ? '| ':''} ${title}`,
})
