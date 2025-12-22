import './assets/main.css'
import "@/plugins/axios";
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import   router  from './router'
import App from './App.vue'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import {Tabs, Tab} from 'vue3-tabs-component';

createApp(App)
    .use(router)
    .use(ElementPlus)
    .use(createPinia())
    .component('tabs', Tabs)
    .component('tab', Tab)
    .mount('#app')