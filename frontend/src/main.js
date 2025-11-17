import './assets/main.css'

import { createApp } from 'vue'
import   router  from './router'
import App from './app.vue'
import {Tabs, Tab} from 'vue3-tabs-component';

createApp(App)
    .use(router)
    .component('tabs', Tabs)
    .component('tab', Tab)
    .mount('#app')