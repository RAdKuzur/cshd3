import { createRouter, createWebHistory } from 'vue-router'
import AuthService from "@/services/AuthService";

// импорт страниц
import HomePage from "@/pages/HomePage.vue";
import LoginPage from "@/pages/LoginPage.vue";
import ProfilePage from "@/pages/ProfilePage.vue";
import StuffPage from "@/pages/StuffPage.vue";
import SettingPage from "@/pages/SettingPage.vue";
import DocPage from "@/pages/DocPage.vue";
import MapPage from "@/pages/MapPage.vue";
import ErrorPage from "@/pages/ErrorPage.vue";
import TaskPage from "@/pages/TaskPage.vue";
import AdminPage from "@/pages/AdminPage.vue";
import ReportPage from "@/pages/ReportPage.vue";
import MainThingPage from "@/pages/thing/MainThingPage.vue";
import ElectronicsPage from "@/pages/thing/electronics/ElectronicsPage.vue";
import ElectronicsCreatePage from "@/pages/thing/electronics/ElectronicsCreatePage.vue";
import ElectronicsViewPage from "@/pages/thing/electronics/ElectronicsViewPage.vue";

const routes = [
    { path: '/', redirect: '/home' },
    { path: '/home', component: HomePage },
    { path: '/login', component: LoginPage },
    { path: '/logout' }, // маршрут для выхода
    { path: '/profile/:username', component: ProfilePage, meta: { auth: true } },
    { path: '/stuff', component: StuffPage },
    { path: '/settings', component: SettingPage, meta: { auth: true } },
    { path: '/things', component: MainThingPage, meta: { auth: true } },
    { path: '/docs', component: DocPage, meta: { auth: true } },
    { path: '/map', component: MapPage, meta: { auth: true } },
    { path: '/tasks', component: TaskPage, meta: { auth: true } },
    { path: '/admin', component: AdminPage, meta: { auth: true } },
    { path: '/reports', component: ReportPage, meta: { auth: true } },
    { path: '/:pathMatch(.*)*', component: ErrorPage },



    { path: '/things', component: MainThingPage, meta: { auth: true } },
    { path: '/things/electronics', component: ElectronicsPage, meta: { auth: true } },
    { path: '/things/electronics/create', component: ElectronicsCreatePage, meta: { auth: true } },
    { path: '/things/electronics/view', component: ElectronicsViewPage, meta: { auth: true } },
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
        // сервер вернул 401 → редирект на login
        next('/login');
    }
});

export default router;