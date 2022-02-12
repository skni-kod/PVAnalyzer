import { createRouter, createWebHistory } from 'vue-router';

import LoginPage from './pages/auth/LoginPage.vue';
import RegisterPage from './pages/auth/RegisterPage.vue';
import Dashboard from './pages/dashboard/Dashboard.vue';
import PVInstallation from './pages/pv-installation/PVInstallation.vue'
import ProfilePage from './pages/auth/ProfilePage.vue';
import store from './store/index.js';

const router = createRouter({
    history: createWebHistory(),
    routes: [ 
        { path: '/', redirect: '/dashboard' },
        { path: '/dashboard', component: Dashboard, meta: { requiresAuth: true }},
        { path: '/login', component: LoginPage},
        { path: '/register', component: RegisterPage},
        { path: '/pv-installation', component: PVInstallation, meta: { requiresAuth: true }},     //info o instalacji
        { path: '/readings', component: null,  meta: { requiresAuth: true }},                      //odczyty
        // { path: '/profile', component: ProfilePage,},
        { path: '/profile', component: ProfilePage, meta: { requiresAuth: true }},
    ]
});

router.beforeEach((to, _, next) => {
  if (to.meta.requiresAuth && !store.getters.isAuthenticated) {
    next('/login');
  }else {
    next();
  }
})

export default router;