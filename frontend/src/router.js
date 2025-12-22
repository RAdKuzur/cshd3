import { createRouter, createWebHistory } from 'vue-router'
import { useAuthContextStore } from '@/services/AuthContext.js'

// страницы
import HomePage from "@/pages/HomePage.vue"
import LoginPage from "@/pages/LoginPage.vue"
import ProfilePage from "@/pages/ProfilePage.vue"
import StuffPage from "@/pages/StuffPage.vue"
import SettingPage from "@/pages/SettingPage.vue"
import DocPage from "@/pages/DocPage.vue"
import MapPage from "@/pages/map/MapPage.vue"
import ErrorPage from "@/pages/ErrorPage.vue"
import TaskPage from "@/pages/TaskPage.vue"
import AdminPage from "@/pages/admin/AdminPage.vue"
import ReportPage from "@/pages/report/ReportPage.vue"
import MainThingPage from "@/pages/thing/MainThingPage.vue"
import ElectronicsPage from "@/pages/thing/electronics/ElectronicsPage.vue"
import ElectronicsCreatePage from "@/pages/thing/electronics/ElectronicsCreatePage.vue"
import ElectronicsViewPage from "@/pages/thing/electronics/ElectronicsViewPage.vue"
import ElectronicsEditPage from "@/pages/thing/electronics/ElectronicsEditPage.vue"
import GeneralMapPage from "@/pages/map/GeneralMapPage.vue"
import AdminPositionPage from "@/pages/admin/position/AdminPositionPage.vue"
import AdminAuditoriumPage from "@/pages/admin/auditorium/AdminAuditoriumPage.vue"
import AdminUserPage from "@/pages/admin/user/AdminUserPage.vue"
import AdminUserCreatePage from "@/pages/admin/user/AdminUserCreatePage.vue"
import AdminUserEditPage from "@/pages/admin/user/AdminUserEditPage.vue"
import AdminUserViewPage from "@/pages/admin/user/AdminUserViewPage.vue"
import ReportAuditoriumPage from "@/pages/report/ReportAuditoriumPage.vue"
import ReportThingPage from "@/pages/report/ReportThingPage.vue"
import TransferActPage from "@/pages/thing/transfer-act/TransferActPage.vue"
import TransferActCreatePage from "@/pages/thing/transfer-act/TransferActCreatePage.vue"
import TransferActViewPage from "@/pages/thing/transfer-act/TransferActViewPage.vue"
import TransferActEditPage from "@/pages/thing/transfer-act/TransferActEditPage.vue"


const BACKEND_URL = '';

const routes = [
    { path: '/', redirect: '/home' },
    { path: '/:pathMatch(.*)*', component: ErrorPage },
    { path: '/home', component: HomePage },
    { path: '/login', component: LoginPage },
    { path: '/logout' }, // special route for logout

    { path: '/profile/:username', component: ProfilePage, meta: { auth: true } },
    { path: '/stuff', component: StuffPage },
    { path: '/map', component: MapPage, meta: { auth: true } },
    { path: '/map/general', component:  GeneralMapPage, meta: { auth: true }},
    { path: '/reports', component: ReportPage, meta: { auth: true }},
    { path: '/reports/auditoriums', component: ReportAuditoriumPage, meta: { auth: true }},
    { path: '/reports/things', component: ReportThingPage, meta: { auth: true }},

    { path: '/admin', component: AdminPage, meta: { auth: true } },
    { path: '/admin/positions', component: AdminPositionPage, meta: { auth: true } },
    { path: '/admin/auditoriums', component: AdminAuditoriumPage, meta: { auth: true } },
    { path: '/admin/users', component: AdminUserPage, meta: { auth: true } },
    { path: '/admin/users/create', component: AdminUserCreatePage, meta: { auth: true } },
    { path: '/admin/users/edit/:id', component: AdminUserEditPage, meta: { auth: true } },
    { path: '/admin/users/view/:id', component: AdminUserViewPage, meta: { auth: true } },

    { path: '/things', component: MainThingPage, meta: { auth: true } },
    { path: '/things/electronics', component: ElectronicsPage, meta: { auth: true } },
    { path: '/things/electronics/create', component: ElectronicsCreatePage, meta: { auth: true } },
    { path: '/things/electronics/view/:id', component: ElectronicsViewPage, meta: { auth: true } },
    { path: '/things/electronics/edit/:id', component: ElectronicsEditPage, meta: { auth: true } },

    { path: '/things/transfer-acts', component: TransferActPage, meta: { auth: true } },
    { path: '/things/transfer-acts/create', component: TransferActCreatePage, meta: { auth: true } },
    { path: '/things/transfer-acts/view/:id', component: TransferActViewPage, meta: { auth: true } },
    { path: '/things/transfer-acts/edit/:id', component: TransferActEditPage, meta: { auth: true } },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

// Pinia store
let authStore
router.beforeEach(async (to, from, next) => {
    if (!authStore) authStore = useAuthContextStore()

    // Logout route
    if (to.path === '/logout') {
        try {
            await authStore.logout()
        } catch (e) {
            console.error('Ошибка при выходе:', e)
        } finally {
            return next('/login')
        }
    }

    // Если маршрут не защищён
    if (!to.meta.auth) return next()

    // Проверяем авторизацию через refresh
    if (!authStore.initialized) {
        try {
            await authStore.refresh()
        } catch (e) {
            console.error('Ошибка refresh:', e)
        }
    }

    if (authStore.user) {
        return next()
    } else {
        return next('/login')
    }
})

export { BACKEND_URL };
export default router
