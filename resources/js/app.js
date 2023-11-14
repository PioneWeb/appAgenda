import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { createI18n } from 'vue-i18n'
import moment from "moment/moment";
import "moment/locale/it";

import elit from 'element-plus/dist/locale/it'
import elen from 'element-plus/dist/locale/en'
import it from "./Lang/it.json";
import en from "./Lang/en.json";

import SessionStorage from "./SessionStorage.js"

const element_locales = [elit,elen]
const locales = {'it':it, 'en': en};
const locale = Object.keys(locales).find(item => {return navigator.language.includes(item)}) ?  window.navigator.language.slice(0,2) : 'it';
const i18n = createI18n({
    locale: locale,
    messages: locales
})

import 'element-plus/theme-chalk/dark/css-vars.css'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(i18n)
            .mixin({
                data: () => {
                    return {
                        locales: element_locales,
                        SessionStorage: SessionStorage,
                    }
                },
                methods: {
                    moment: moment,
                }
            })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
