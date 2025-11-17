import { createRouter, createWebHistory } from 'vue-router'

import HomePage from "@/pages/HomePage.vue";
import ErrorPage from "@/pages/ErrorPage.vue";
import ProfilePage from "@/pages/ProfilePage.vue";
import LoginPage from "@/pages/LoginPage.vue";
import StuffPage from "@/pages/StuffPage.vue";

const routes = [
    { path: '/' , redirect: '/home'},
    { path: '/home', component: HomePage },
    { path: '/error', component: ErrorPage },
    { path: '/profile', component: ProfilePage  },
    { path: '/stuff', component: StuffPage },
    { path: '/logout', component: LoginPage },
    { path: '/login', component: LoginPage},
    { path: '/:pathMatch(.*)*', component: ErrorPage }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router