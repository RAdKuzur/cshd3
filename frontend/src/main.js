import './assets/main.css'
import '@/plugins/axios'
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import { Tabs, Tab } from 'vue3-tabs-component'
import { useAuthContextStore } from '@/services/AuthContext'

async function bootstrap() {
    const app = createApp(App)

    // 1. Pinia до router
    const pinia = createPinia()
    app.use(pinia)

    // 2. Инициализация auth (refresh один раз)
    const authStore = useAuthContextStore()
    try {
        await authStore.init()
    } catch (e) {
        // игнорируем — authStore.init сам установит initialized
        console.warn('auth init failed', e)
    }

    // 3. Подключаем router _после_ init
    const { default: router } = await import('./router')
    app.use(router)

    // 4. UI плагины
    app.use(ElementPlus)
    app.component('tabs', Tabs)
    app.component('tab', Tab)

    // 5. Монтируем
    app.mount('#app')
}

bootstrap()
