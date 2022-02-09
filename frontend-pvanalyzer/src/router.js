import { createRouter, createWebHistory } from 'vue-router';

import LoginPage from './pages/auth/LoginPage.vue';
import RegisterPage from './pages/auth/RegisterPage.vue';
import Dashboard from './pages/dashboard/Dashboard.vue';
import PVInstallation from './pages/pv-installation/PVInstallation.vue'
import ProfilePage from './pages/auth/ProfilePage.vue';


const router = createRouter({
    history: createWebHistory(),
    routes: [ 
        { path: '/', redirect: '/dashboard' },
        { path: '/dashboard', component: Dashboard},
        { path: '/login', component: LoginPage},
        { path: '/register', component: RegisterPage},
        { path: '/pv-installation', component: PVInstallation},     //info o instalacji
        { path: '/readings', component: null},                      //odczyty
        { path: '/profile', component: ProfilePage},
    ]
});

export default router;