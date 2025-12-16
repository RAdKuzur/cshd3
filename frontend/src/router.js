import { createRouter, createWebHistory } from 'vue-router'
import AuthService from "@/services/AuthService";

// импорт страниц
import HomePage from "@/pages/HomePage.vue";
import LoginPage from "@/pages/LoginPage.vue";
import ProfilePage from "@/pages/ProfilePage.vue";
import StuffPage from "@/pages/StuffPage.vue";
import SettingPage from "@/pages/SettingPage.vue";
import DocPage from "@/pages/DocPage.vue";
import MapPage from "@/pages/map/MapPage.vue";
import ErrorPage from "@/pages/ErrorPage.vue";
import TaskPage from "@/pages/TaskPage.vue";
import AdminPage from "@/pages/admin/AdminPage.vue";
import ReportPage from "@/pages/report/ReportPage.vue";
import MainThingPage from "@/pages/thing/MainThingPage.vue";
import ElectronicsPage from "@/pages/thing/electronics/ElectronicsPage.vue";
import ElectronicsCreatePage from "@/pages/thing/electronics/ElectronicsCreatePage.vue";
import ElectronicsViewPage from "@/pages/thing/electronics/ElectronicsViewPage.vue";
import ElectronicsEditPage from "@/pages/thing/electronics/ElectronicsEditPage.vue";
import GeneralMapPage from "@/pages/map/GeneralMapPage.vue";
import AdminPositionPage from "@/pages/admin/position/AdminPositionPage.vue";
import AdminAuditoriumPage from "@/pages/admin/auditorium/AdminAuditoriumPage.vue";
import AdminUserPage from "@/pages/admin/user/AdminUserPage.vue";
import AdminUserCreatePage from "@/pages/admin/user/AdminUserCreatePage.vue";
import AdminUserEditPage from "@/pages/admin/user/AdminUserEditPage.vue";
import AdminUserViewPage from "@/pages/admin/user/AdminUserViewPage.vue";
import ReportAuditoriumPage from "@/pages/report/ReportAuditoriumPage.vue";
import ReportThingPage from "@/pages/report/ReportThingPage.vue";
import TransferActPage from "@/pages/thing/transfer-act/TransferActPage.vue";
import TransferActCreatePage from "@/pages/thing/transfer-act/TransferActCreatePage.vue";
import TransferActViewPage from "@/pages/thing/transfer-act/TransferActViewPage.vue";
import TransferActEditPage from "@/pages/thing/transfer-act/TransferActEditPage.vue";

const BACKEND_URL = '';

const routes = [
    { path: '/', redirect: '/home' },
    { path: '/:pathMatch(.*)*', component: ErrorPage },
    { path: '/home', component: HomePage },
    { path: '/login', component: LoginPage },
    { path: '/logout' }, // маршрут для выхода
    { path: '/profile/:username', component: ProfilePage, meta: { auth: true } },
    { path: '/stuff', component: StuffPage },
    // { path: '/settings', component: SettingPage, meta: { auth: true } },
    // { path: '/docs', component: DocPage, meta: { auth: true } },
    { path: '/map', component: MapPage, meta: { auth: true } },
    { path: '/map/general', component:  GeneralMapPage, meta: { auth: true }},
    // { path: '/tasks', component: TaskPage, meta: { auth: true } },

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
];

const router = createRouter({
    history: createWebHistory(),
    routes
});


// это Auth v1.0 пока она выключена, пусть всё обрабатывает middleware бэкенда

router.beforeEach(async (to, from, next) => {
    // Обработка выхода
    if (to.path === '/logout') {
        try {
            // Вызываем метод выхода (если он есть в AuthService)
            if (AuthService.logout) {
                await AuthService.logout();
            }
        } catch (e) {
            console.error('Ошибка при выходе:', e);
        } finally {
            // Всегда перенаправляем на страницу входа
            return next('/login');
        }
    }

    // если маршрут не защищён → пропускаем
    if (!to.meta.auth) return next();

    try {
        // await AuthService.check(); // проверяем токен через сервер
        next();
    } catch (e) {
        localStorage.removeItem('username');
        localStorage.removeItem('fio');
        next('/login');
    }
});
export { BACKEND_URL };
export default router;