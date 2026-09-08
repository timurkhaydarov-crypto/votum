<template>
    <Alert v-if="isVisible" :type="type" :message="message" />
    <TopPagePanel class="hidden sm:block" />
    <MainMenu class="bg-white sm:fixed sm:inset-x-0 sm:top-[40px] sm:z-[60]" />
        <router-view />
    <footer class="border-t border-slate-200 bg-white">
        <div
            class="mx-auto w-full max-w-7xl px-4 py-5 text-center text-xs text-slate-400 sm:px-6 lg:px-8"
        >
            © {{ new Date().getFullYear() }} {{ t('logo.title') }}.
            {{ t('common.copyright') }}
        </div>
    </footer>
</template>

<script setup>
import { onMounted, watch } from 'vue';
import { useI18n } from 'vue-i18n';

import Alert from './modules/site/components/UI/Alert.vue';
import TopPagePanel from './modules/site/components/TopPagePanel/index.vue';
import MainMenu from './modules/site/components/navigation/MainHeader.vue';

import { useGlobalAlert } from './modules/site/composables/useGlobalAlert';
import { useCart } from './modules/site/composables/useCart';

const { isVisible, type, message } = useGlobalAlert();

const { fetchCart, initialized } = useCart();

const { t, locale } = useI18n();

/**
 * Update browser document title.
 */
const updateDocumentTitle = () => {
    document.title = t('logo.title') || 'TECHNOVOTUM';
};

/**
 * Initialize cart from backend.
 *
 * Cart is stored on the server, so after a page reload
 * we restore the current cart state via GET /api/cart.
 */
const initializeCart = async () => {
    if (initialized.value) {
        return;
    }

    try {
        await fetchCart();
    } catch (error) {
        console.error('Failed to initialize cart:', error);
    }
};

onMounted(() => {
    updateDocumentTitle();
    initializeCart();
});

watch(locale, updateDocumentTitle, {
    immediate: true,
});
</script>
