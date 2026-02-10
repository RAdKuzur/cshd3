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
import ErrorPage from "@/pages/error/ErrorPage.vue"
import TaskPage from "@/pages/TaskPage.vue"
import AdminPage from "@/pages/admin/AdminPage.vue"
import ReportPage from "@/pages/report/ReportPage.vue"
import MainThingPage from "@/pages/thing/MainThingPage.vue"
import ElectronicsPage from "@/pages/thing/things/ElectronicsPage.vue"
import ThingCreatePage from "@/pages/thing/things/ThingCreatePage.vue"
import ThingViewPage from "@/pages/thing/things/ThingViewPage.vue"
import ThingEditPage from "@/pages/thing/things/ThingEditPage.vue"
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
import ForbiddenErrorPage from "@/pages/error/ForbiddenErrorPage.vue";
import AuthErrorPage from "@/pages/error/AuthErrorPage.vue";
import FilePage from "@/pages/files/FilePage.vue";
import FurniturePage from "@/pages/thing/things/FurniturePage.vue";
import ReportArmPage from "@/pages/report/ReportArmPage.vue";
import AdminBranchPage from "@/pages/admin/branch/AdminBranchPage.vue";
import ReportGeneralPage from "@/pages/report/ReportGeneralPage.vue";
import LicenceErrorPage from "@/pages/error/LicenceErrorPage.vue";
import TechWorkErrorPage from "@/pages/error/TechWorkErrorPage.vue";
import NetworkThingPage from "@/pages/thing/network-things/NetworkThingPage.vue";
import NetworkThingCreatePage from "@/pages/thing/network-things/NetworkThingCreatePage.vue";
import NetworkThingViewPage from "@/pages/thing/network-things/NetworkThingViewPage.vue";
import NetworkThingEditPage from "@/pages/thing/network-things/NetworkThingEditPage.vue";
import SearchPage from "@/pages/search/SearchPage.vue";
import ReportFormPage from "@/pages/report/ReportFormPage.vue";
import IternalErrorPage from "@/pages/error/IternalErrorPage.vue";
import AdminLicencePage from "@/pages/admin/licence/AdminLicencePage.vue";
import AdminTechWorkPage from "@/pages/admin/tech-work/AdminTechWorkPage.vue";
import DevicePage from "@/pages/thing/devices/DevicePage.vue";
import DeviceCreatePage from "@/pages/thing/devices/DeviceCreatePage.vue";
import DeviceViewPage from "@/pages/thing/devices/DeviceViewPage.vue";
import DeviceEditPage from "@/pages/thing/devices/DeviceEditPage.vue";
import ResourcePage from "@/pages/thing/resources/ResourcePage.vue";
import ResourceCreatePage from "@/pages/thing/resources/ResourceCreatePage.vue";
import ResourceViewPage from "@/pages/thing/resources/ResourceViewPage.vue";
import ResourceEditPage from "@/pages/thing/resources/ResourceEditPage.vue";
import AdminCompanyPage from "@/pages/admin/company/AdminCompanyPage.vue";
import AdminModelPage from "@/pages/admin/model/AdminModelPage.vue";


const BACKEND_URL = '';

const routes = [
    { path: '/', redirect: '/home' },
    { path: '/:pathMatch(.*)*', component: ErrorPage },
    { path: '/not-found', component: ErrorPage },
    { path: '/not-auth', component:  AuthErrorPage  },
    { path: '/forbidden', component: ForbiddenErrorPage  },
    { path: '/licence-error', component: LicenceErrorPage },
    { path: '/tech-work', component: TechWorkErrorPage },
    { path: '/iternal-error', component: IternalErrorPage },
    { path: '/home', component: HomePage },
    { path: '/login', component: LoginPage },
    { path: '/logout' }, // special route for logout

    { path: '/profile/:username', component: ProfilePage, meta: { auth: true } },
    { path: '/stuff', component: StuffPage, meta: { auth: true } },
    { path: '/map', component: MapPage, meta: { auth: true } },
    { path: '/map/general', component:  GeneralMapPage, meta: { auth: true }},
    { path: '/reports', component: ReportPage, meta: { auth: true }},
    { path: '/reports/auditoriums', component: ReportAuditoriumPage, meta: { auth: true }},
    { path: '/reports/things', component: ReportThingPage, meta: { auth: true }},
    { path: '/reports/arms', component: ReportArmPage, meta: { auth: true }},
    { path: '/reports/general', component: ReportGeneralPage, meta: { auth: true }},
    { path: '/reports/forms', component: ReportFormPage, meta: { auth: true }},

    { path: '/admin', component: AdminPage, meta: { auth: true } },
    { path: '/admin/positions', component: AdminPositionPage, meta: { auth: true } },
    { path: '/admin/auditoriums', component: AdminAuditoriumPage, meta: { auth: true } },
    { path: '/admin/branches', component: AdminBranchPage, meta: { auth: true } },
    { path: '/admin/licences', component: AdminLicencePage, meta: { auth: true } },
    { path: '/admin/models', component: AdminModelPage, meta: { auth: true } },
    { path: '/admin/companies', component: AdminCompanyPage, meta: { auth: true } },
    { path: '/admin/tech-works', component: AdminTechWorkPage, meta: { auth: true } },
    { path: '/admin/users', component: AdminUserPage, meta: { auth: true } },
    { path: '/admin/users/create', component: AdminUserCreatePage, meta: { auth: true } },
    { path: '/admin/users/edit/:id', component: AdminUserEditPage, meta: { auth: true } },
    { path: '/admin/users/view/:id', component: AdminUserViewPage, meta: { auth: true } },

    { path: '/things', component: MainThingPage, meta: { auth: true } },
    { path: '/things/electronics', component: ElectronicsPage, meta: { auth: true } },
    { path: '/things/furniture', component: FurniturePage, meta: { auth: true } },
    { path: '/things/create', component: ThingCreatePage, meta: { auth: true } },
    { path: '/things/view/:id', component: ThingViewPage, meta: { auth: true } },
    { path: '/things/edit/:id', component: ThingEditPage, meta: { auth: true } },

    { path: '/things/transfer-acts', component: TransferActPage, meta: { auth: true } },
    { path: '/things/transfer-acts/create', component: TransferActCreatePage, meta: { auth: true } },
    { path: '/things/transfer-acts/view/:id', component: TransferActViewPage, meta: { auth: true } },
    { path: '/things/transfer-acts/edit/:id', component: TransferActEditPage, meta: { auth: true } },

    { path: '/things/network', component: NetworkThingPage, meta: { auth: true } },
    { path: '/things/network/create', component: NetworkThingCreatePage, meta: { auth: true } },
    { path: '/things/network/view/:id', component: NetworkThingViewPage, meta: { auth: true } },
    { path: '/things/network/edit/:id', component: NetworkThingEditPage, meta: { auth: true } },

    { path: '/things/devices', component: DevicePage, meta: { auth: true } },
    { path: '/things/devices/create', component: DeviceCreatePage, meta: { auth: true } },
    { path: '/things/devices/view/:id', component: DeviceViewPage, meta: { auth: true } },
    { path: '/things/devices/edit/:id', component: DeviceEditPage, meta: { auth: true } },

    { path: '/things/resources', component: ResourcePage, meta: { auth: true } },
    { path: '/things/resources/create', component: ResourceCreatePage, meta: { auth: true } },
    { path: '/things/resources/view/:id', component: ResourceViewPage, meta: { auth: true } },
    { path: '/things/resources/edit/:id', component: ResourceEditPage, meta: { auth: true } },

    { path: '/search', component: SearchPage, meta: { auth: true }},
    { path: '/admin/files', component: FilePage , meta: { auth: true } }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    const auth = useAuthContextStore();

    if (to.path === '/logout') {
        auth.logout();
        return next('/login');
    }

    if (to.path === '/login') {
        return next();
    }

    if (!to.meta.auth) {
        return next();
    }

    if (!auth.user) {
        return next('/login');
    }

    next();
});






export { BACKEND_URL };
export default router
