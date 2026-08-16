import { createRouter, createWebHistory } from 'vue-router';

import AuthLayout from '../layouts/AuthLayout.vue';
import LoginPage from '../modules/auth/pages/LoginPage.vue';
import RegisterPage from '../modules/auth/pages/RegisterPage.vue';
import ForgotPasswordPage from '../modules/auth/pages/ForgotPasswordPage.vue';
import ResetPasswordPage from '../modules/auth/pages/ResetPasswordPage.vue';
import SiteIndexPage from '../modules/site/pages/index.vue';
import ProductsShellLayout from '../modules/site/layouts/ProductsShellLayout.vue';
import ProductsAllPage from '../modules/site/pages/products/ProductsAllPage.vue';
import ProductsByCategoryPage from '../modules/site/pages/products/ProductsByCategoryPage.vue';
import ProductsByGroupPage from '../modules/site/pages/products/ProductsByGroupPage.vue';
import ProductDetailPage from '../modules/site/pages/products/ProductDetailPage.vue';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'site.index',
            component: SiteIndexPage,
        },
        {
            path: '/products',
            component: ProductsShellLayout,
            children: [
                {
                    path: '',
                    name: 'products.all',
                    component: ProductsAllPage,
                },
                {
                    path: 'item/:productId',
                    name: 'products.detail',
                    component: ProductDetailPage,
                    props: true,
                },
                {
                    path: ':categorySlug/:groupSlug',
                    name: 'products.group',
                    component: ProductsByGroupPage,
                    props: true,
                },
                {
                    path: ':categorySlug',
                    name: 'products.category',
                    component: ProductsByCategoryPage,
                    props: true,
                },
            ],
        },
        {
            path: '/auth',
            component: AuthLayout,
            children: [
                {
                    path: 'login',
                    name: 'auth.login',
                    component: LoginPage,
                },
                {
                    path: 'register',
                    name: 'auth.register',
                    component: RegisterPage,
                },
                {
                    path: 'forgot-password',
                    name: 'auth.forgot-password',
                    component: ForgotPasswordPage,
                },
                {
                    path: 'reset-password/:token?',
                    name: 'auth.reset-password',
                    component: ResetPasswordPage,
                    props: true,
                },
            ],
        },
    ],
});

export default router;
