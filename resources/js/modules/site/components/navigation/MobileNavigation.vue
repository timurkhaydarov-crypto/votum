<template>
    <!-- ============================================ -->
    <!-- OVERLAY -->
    <!-- ============================================ -->

    <Transition
        enter-active-class="transition-opacity duration-300"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition-opacity duration-200"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div
            v-if="open"
            class="fixed inset-0 z-[60] bg-black/20 backdrop-blur-[1px]"
            @click="close"
        ></div>
    </Transition>

    <!-- ============================================ -->
    <!-- DRAWER -->
    <!-- ============================================ -->

    <Transition
        enter-active-class="transform transition duration-300 ease-out"
        enter-from-class="translate-x-full"
        enter-to-class="translate-x-0"
        leave-active-class="transform transition duration-250 ease-in"
        leave-from-class="translate-x-0"
        leave-to-class="translate-x-full"
    >
        <aside
            v-if="open"
            class="fixed right-0 top-0 z-[70] flex h-screen w-[85%] max-w-[380px] flex-col border-l border-[#f1f0ee] bg-[#fdfcfb] shadow-[0_18px_50px_rgba(20,20,20,0.08)]"
        >
            <!-- ======================================== -->
            <!-- HEADER -->
            <!-- ======================================== -->

            <div
                class="flex h-[60px] shrink-0 items-center justify-between border-b border-[#f1f0ee] bg-[#fdfcfb] px-5"
            >
                <Logo :mobile="true" />

                <ChangeLanguage />
            </div>

            <!-- ======================================== -->
            <!-- NAVIGATION -->
            <!-- ======================================== -->

            <div class="flex-1 overflow-y-auto px-4 py-5">
                <div class="space-y-1">
                    <!-- HOME -->

                    <RouterLink
                        to="/"
                        @click="close"
                        class="group flex items-center gap-2.5 rounded-lg px-2.5 py-2.5 text-[13.5px] font-medium tracking-[-0.01em] text-[#252525] transition-colors duration-200 hover:bg-transparent"
                    >
                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-md bg-[#efefef] text-gray-600 transition-all duration-200 group-hover:bg-[#252525] group-hover:text-white"
                        >
                            <i class="bi bi-house-door text-lg"></i>
                        </span>

                        <span>
                            {{ t('menu.home') }}
                        </span>
                    </RouterLink>

                    <!-- PRODUCTS -->

                    <DropdownMenu
                        :open="productsOpen"
                        :title="t('menu.products')"
                        :icon="Icon.PRODUCTS"
                        :categories="productCategories"
                        all-link="/products"
                        :all-label="t('megaMenu.allProducts')"
                        @toggle="toggleProducts"
                        @close="close"
                    />

                    <!-- SERVICES -->

                    <DropdownMenu
                        :open="servicesOpen"
                        :title="t('menu.services')"
                        :icon="Icon.SERVICES"
                        :categories="serviceCategories"
                        all-link="/services"
                        :all-label="t('megaMenu.allServices')"
                        @toggle="toggleServices"
                        @close="close"
                    />

                    <!-- OTHER MENU ITEMS -->

                    <RouterLink
                        v-for="item in mainMenu"
                        :key="item.title"
                        :to="item.href"
                        @click="close"
                        class="group flex items-center gap-2.5 rounded-lg px-2.5 py-2.5 text-[13.5px] font-medium tracking-[-0.01em] text-[#252525] transition-colors duration-200 hover:bg-transparent"
                    >
                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-md bg-[#efefef] text-gray-600 transition-all duration-200 group-hover:bg-[#252525] group-hover:text-white"
                        >
                            <i
                                :class="[
                                    'bi',
                                    item.icon,
                                    'text-xl',
                                ]"
                            ></i>
                        </span>

                        <span>
                            {{ t(item.title) }}
                        </span>
                    </RouterLink>
                </div>
            </div>

            <!-- ======================================== -->
            <!-- CONTACTS -->
            <!-- ======================================== -->

            <div
                class="shrink-0 border-t border-[#e8e6e3] bg-[#fdfcfb] px-5 py-4 text-center"
            >
                <!-- WORKING HOURS -->

                <div
                    v-if="contacts.operatingHours?.length"
                >
                    <div
                        v-for="department in contacts.operatingHours"
                        :key="department.id ?? department.name"
                        class="mb-2 last:mb-0"
                    >
                        <div
                            v-for="contact in department.contacts"
                            :key="contact.id"
                            class="flex items-center justify-center gap-2 text-[12px] text-gray-500"
                        >
                            <i
                                class="bi bi-clock text-[14px] text-gray-400"
                                aria-hidden="true"
                            ></i>

                            <span>
                                {{ t(`weekdays.${contact.from}`) }}
                                –
                                {{ t(`weekdays.${contact.to}`) }}

                                <span class="ml-1 text-[#252525]">
                                    {{ contact.time }}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- SOCIAL MEDIA -->
<!-- 
                <div v-if="contacts.socialMedia?.length">
                    <div
                        class="flex items-center justify-center gap-2"
                    >
                        <a
                            v-for="social in contacts.socialMedia"
                            :key="
                                social.id ??
                                social.platform ??
                                social.url
                            "
                            :href="social.url"
                            target="_blank"
                            rel="noopener noreferrer"
                            :aria-label="
                                social.name ??
                                social.platform
                            "
                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#efefef] text-gray-500 transition-all duration-200 hover:bg-[#252525] hover:text-white"
                        >
                            <i
                                :class="[
                                    'bi',
                                    `bi-${social.platform}`,
                                    'text-[15px] leading-none',
                                ]"
                                aria-hidden="true"
                            ></i>
                        </a>
                    </div>
                </div> -->
            </div>

            <!-- ======================================== -->
            <!-- FOOTER -->
            <!-- ======================================== -->

            <footer
                class="shrink-0 border-t border-slate-200 bg-white"
            >
                <div
                    class="mx-auto w-full max-w-7xl px-4 py-5 text-center text-xs text-slate-400 sm:px-6 lg:px-8"
                >
                    © {{ new Date().getFullYear() }}
                    {{ t('logo.title') }}.
                    {{ t('common.copyright') }}
                </div>
            </footer>
        </aside>
    </Transition>
</template>

<script setup>
import {
    onMounted,
    onUnmounted,
    ref,
    watch,
} from 'vue';

import { useI18n } from 'vue-i18n';

import DropdownMenu from './dropdown-menu/DropdownMenu.vue';
import Logo from '../shared/Logo.vue';
import ChangeLanguage from '../UI/ChangeLanguage.vue';

import { Icon } from '@/modules/site/constants/icons.js';

import {
    mainMenu,
    serviceCategories,
    fetchProductCategories,
} from './navigation.data.js';

import { useContacts } from '../../composables/useContacts.js';

defineProps({
    open: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['close']);

const { t, locale } = useI18n();

const {
    contacts,
    loadContacts,
} = useContacts();

const productsOpen = ref(false);
const servicesOpen = ref(false);
const productCategories = ref([]);

/**
 * Tailwind `lg` breakpoint.
 *
 * Desktop navigation starts at 1024px.
 */
const DESKTOP_BREAKPOINT = 1024;

/**
 * Load product categories.
 */
const loadProductCategories = async () => {
    try {
        productCategories.value =
            await fetchProductCategories(
                locale.value
            );
    } catch (error) {
        console.error(
            'Failed to load product menu:',
            error
        );

        productCategories.value = [];
    }
};

/**
 * Get localized department name.
 */
const getDepartmentName = (name) => {
    if (!name) {
        return '';
    }

    if (typeof name === 'string') {
        return name;
    }

    if (typeof name === 'object') {
        const current = locale.value;

        return (
            name[current] ??
            name.ru ??
            name.en ??
            Object.values(name)[0] ??
            ''
        );
    }

    return '';
};

/**
 * Close mobile menu.
 */
const close = () => {
    productsOpen.value = false;
    servicesOpen.value = false;

    emit('close');
};

/**
 * Handle browser window resize.
 *
 * When the viewport reaches the desktop breakpoint,
 * the mobile menu is automatically closed.
 */
const handleResize = () => {
    if (window.innerWidth >= DESKTOP_BREAKPOINT) {
        close();
    }
};

/**
 * Toggle products.
 */
const toggleProducts = () => {
    productsOpen.value = !productsOpen.value;

    if (productsOpen.value) {
        servicesOpen.value = false;
    }
};

/**
 * Toggle services.
 */
const toggleServices = () => {
    servicesOpen.value = !servicesOpen.value;

    if (servicesOpen.value) {
        productsOpen.value = false;
    }
};

/**
 * Initial loading.
 */
onMounted(async () => {
    window.addEventListener(
        'resize',
        handleResize
    );

    await Promise.all([
        loadProductCategories(),
        loadContacts(),
    ]);
});

/**
 * Cleanup.
 */
onUnmounted(() => {
    window.removeEventListener(
        'resize',
        handleResize
    );
});

/**
 * Reload data after language change.
 */
watch(locale, async () => {
    await Promise.all([
        loadProductCategories(),
        loadContacts(),
    ]);
});
</script>