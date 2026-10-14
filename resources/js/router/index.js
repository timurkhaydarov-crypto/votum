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
import ServicesAllPage from '../modules/site/pages/services/ServicesAllPage.vue';
import IndividualProjectsPage from '../modules/site/pages/services/IndividualProjectsPage.vue';

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
            path: '/services',
            name: 'services.all',
            component: ServicesAllPage,
        },
        {
            path: '/services/individual-projects',
            name: 'services.individual-projects',
            component: IndividualProjectsPage,
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

let pendingCatalogTarget = null;
let lastHistoryPosition = router.options.history.state.position;

const isCatalogRoute = (route) => route.matched.some(
    (record) => record.path === '/products' || record.path.startsWith('/products/'),
);

const hasCatalogHistory = () => {
    return typeof window !== 'undefined' &&
        window.history.state?.__productCatalogTrail === true;
};

const markCatalogHistory = () => {
    if (typeof window === 'undefined') {
        return;
    }

    window.history.replaceState(
        {
            ...window.history.state,
            __productCatalogTrail: true,
        },
        '',
        window.location.href,
    );
};

router.beforeEach((to, from) => {
    const historyPosition = router.options.history.state.position;
    const isHistoryTraversal = historyPosition !== lastHistoryPosition;

    if (isHistoryTraversal) {
        lastHistoryPosition = historyPosition;
        pendingCatalogTarget = null;
        return true;
    }

    if (pendingCatalogTarget) {
        return true;
    }

    if (to.name === 'products.category') {
        if (from.name === 'products.all' || (from.matched.length > 0 && isCatalogRoute(from))) {
            return true;
        }

        if (from.matched.length === 0 && hasCatalogHistory()) {
            return true;
        }

        pendingCatalogTarget = to.fullPath;

        return {
            name: 'products.all',
            replace: from.matched.length === 0,
        };
    }

    if (to.name === 'products.group') {
        const isParentCategory =
            from.name === 'products.category' &&
            from.params.categorySlug === to.params.categorySlug;

        if (isParentCategory) {
            return true;
        }

        if (from.matched.length === 0 && hasCatalogHistory()) {
            return true;
        }

        pendingCatalogTarget = to.fullPath;

        if (from.matched.length === 0 || !isCatalogRoute(from)) {
            return {
                name: 'products.all',
                replace: from.matched.length === 0,
            };
        }

        return {
            name: 'products.category',
            params: {
                categorySlug: to.params.categorySlug,
            },
        };
    }

    return true;
});

router.afterEach((to, _from, failure) => {
    if (router.currentRoute.value.fullPath !== to.fullPath) {
        return;
    }

    lastHistoryPosition = router.options.history.state.position;

    if (failure) {
        pendingCatalogTarget = null;
        return;
    }

    if (isCatalogRoute(to)) {
        markCatalogHistory();
    }

    if (!pendingCatalogTarget) {
        return;
    }

    const target = router.resolve(pendingCatalogTarget);

    if (to.fullPath === target.fullPath) {
        pendingCatalogTarget = null;
        return;
    }

    if (to.name === 'products.all') {
        if (target.name === 'products.group') {
            void router.push({
                name: 'products.category',
                params: {
                    categorySlug: target.params.categorySlug,
                },
            });
            return;
        }

        void router.push(target.fullPath);
        return;
    }

    if (to.name === 'products.category' && target.name === 'products.group') {
        void router.push(target.fullPath);
        return;
    }

    pendingCatalogTarget = null;
});

export default router;
