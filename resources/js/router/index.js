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
import ContactsPage from '../modules/site/pages/ContactsPage.vue';
import AboutPage from '../modules/site/pages/AboutPage.vue';
import CartPage from '../modules/site/pages/CartPage.vue';

import SpecialistsPage from '../modules/site/pages/services/training/Specialists.vue'
import SeminarsPage from '../modules/site/pages/services/training/Seminars.vue'
import QualificationPage from '../modules/site/pages/services/training/Qualification.vue'

import CalibrationPage from '../modules/site/pages/services/metrology/Calibration.vue'
import MetrologyExpertisePage from '../modules/site/pages/services/metrology/Expertise.vue'
import VerificationPage from '../modules/site/pages/services/metrology/Verification.vue'

import EquipmentPage from '../modules/site/pages/services/diagnostics/Equipment.vue'
import DiagnosticExpertisePage from '../modules/site/pages/services/diagnostics/Expertise.vue'
import TechnicalPage from '../modules/site/pages/services/diagnostics/Technical.vue'
import DocumentationPage from '../modules/manager/pages/DocumentationPage.vue'



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
        {
            path: '/manager/documentation',
            name: 'manager-documentation',
            component:DocumentationPage,
            meta: {
                requiresAuth: true,
                roles: ['admin', 'manager'],
            },
        },
        {
            path: '/cart',
            name: 'cart',
            component: CartPage,
        },
        {
            path: '/contacts',
            name: 'contacts',
            component: ContactsPage,
        },
        {
            path: '/about',
            name: 'about',
            component: AboutPage,
        },
        {
            path: '/services/training/specialists',
            component: SpecialistsPage,
        },
        {
            path: '/services/training/qualification',
            component: QualificationPage,
        },
        {
            path: '/services/training/seminars',
            component: SeminarsPage,
        },
        {
            path: '/services/metrology/verification',
            component: VerificationPage,
        },
        {
            path: '/services/metrology/calibration',
            component: CalibrationPage,
        },
        {
            path: '/services/metrology/expertise',
            component: MetrologyExpertisePage,
        },
        {
            path: '/services/diagnostics/technical',
            component: TechnicalPage,
        },
        {
            path: '/services/diagnostics/equipment',
            component: EquipmentPage,
        },
        {
            path: '/services/diagnostics/expertise',
            component: DiagnosticExpertisePage,
        },
    ],

    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        }

        return {
            top: 0,
            left: 0,
            behavior: 'smooth',
        };
    },
});

export default router;
