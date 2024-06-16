import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'

import bootstrap from 'bootstrap/dist/js/bootstrap.bundle.js'
import 'bootstrap/dist/css/bootstrap.css'
import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        { path: '/', name: 'login', component: () => import('./components/LoginForm.vue') },
        { path: '/signup', name: 'signup', component: () => import('./components/SignupForm.vue') }
    ]
})
export default router
createApp(App).use(bootstrap).use(router).mount('#app')
