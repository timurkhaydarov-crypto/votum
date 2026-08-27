<template>

    <nav
        class="absolute left-1/2 hidden
           -translate-x-1/2
           items-center gap-1
           lg:flex"
    >

        <!-- Главная -->

        <RouterLink
            to="/"
            class="group flex items-center gap-2
             rounded-xl px-3 py-2
             text-sm font-medium
             text-[#252525]
             transition hover:bg-gray-100"
        >
            <i
                class="bi bi-house-door text-[17px]
               text-gray-500
               group-hover:text-[#252525]
               nav-item-icon"
            ></i>

            <span>{{ t('menu.home') }}</span>
        </RouterLink>


        <!-- ========================================== -->
        <!-- ПРОДУКЦИЯ -->
        <!-- ========================================== -->

        <div
            class="relative"
            @mouseenter="openProducts"
            @mouseleave="closeProducts"
            @contextmenu.prevent
        >

            <button
                type="button"
                class="group flex items-center gap-2
               rounded-xl px-3 py-2
               text-sm font-medium
               text-[#252525]
               transition hover:bg-gray-100"
            >

                <i
                    class="bi bi-box-seam text-[17px]
                 text-gray-500 nav-item-icon"
                ></i>

                <span>{{ t('menu.products') }}</span>

                <i
                    class="bi bi-chevron-down
                 text-[10px] text-gray-400
                 transition-transform"
                    :class="{
                        'rotate-180': productsOpen
                    }"
                ></i>

            </button>


            <MegaMenu
                :open="productsOpen"
                :variant="'content'"
                :title="t('menu.products')"
                :icon="'bi-box-seam'"
                :categories="productCategories"
                :all-link="'/products'"
                :all-label="t('megaMenu.allProducts')"
                :footer="{
                    title: t('megaMenu.needHelpTitle'),
                    description: t('megaMenu.needHelpDescription'),
                    button: t('megaMenu.contactUs'),
                    link: '/contacts'
                }"
                @close="productsOpen = false"
            />

        </div>


        <!-- ========================================== -->
        <!-- УСЛУГИ -->
        <!-- ========================================== -->

        <div
            class="relative"
            @mouseenter="openServices"
            @mouseleave="closeServices"
            @contextmenu.prevent
        >

            <button
                type="button"
                class="group flex items-center gap-2
               rounded-xl px-3 py-2
               text-sm font-medium
               text-[#252525]
               transition hover:bg-gray-100"
            >

                <i
                    class="bi bi-tools text-[17px]
                 text-gray-500 nav-item-icon"
                ></i>

                <span>{{ t('menu.services') }}</span>

                <i
                    class="bi bi-chevron-down
                 text-[10px] text-gray-400
                 transition-transform"
                    :class="{
                        'rotate-180': servicesOpen
                    }"
                ></i>

            </button>


            <MegaMenu
                :open="servicesOpen"
                :title="t('menu.services')"
                :variant="'cards'"
                :icon="'bi-tools'"
                :categories="serviceCategories"
                :all-link="'/services'"
                :all-label="t('megaMenu.allServices')"
                :footer="{
                    title: t('megaMenu.needHelpTitle'),
                    description: t('megaMenu.needHelpDescription'),
                    button: t('megaMenu.contactUs'),
                    link: '/contacts'
                }"
                @close="servicesOpen = false"
            />

        </div>


        <!-- ========================================== -->
        <!-- ОСТАЛЬНЫЕ -->
        <!-- ========================================== -->

        <RouterLink
            v-for="item in mainMenu.slice(1)"
            :key="item.title"
            :to="item.href"
            class="group flex items-center gap-2
             rounded-xl px-3 py-2
             text-sm font-medium
             text-[#252525]
             transition hover:bg-gray-100
             shrink-0 whitespace-nowrap"
        >

            <i
                :class="[
                    'bi',
                    item.icon,
                    'text-[17px]',
                    'text-gray-500',
                    'nav-item-icon'
                ]"
            ></i>

            <span>
                {{ t(item.title) }}
            </span>

        </RouterLink>

    </nav>

</template>

<script setup>
import { onMounted, onBeforeUnmount, ref, watch } from 'vue'
import { useI18n } from 'vue-i18n'
import MegaMenu from './mega-menu/MegaMenu.vue'

import {
    mainMenu,
    serviceCategories,
    fetchProductCategories,
} from './navigation.data.js'

const { t, locale } = useI18n()

const productsOpen = ref(false)
const servicesOpen = ref(false)
const productCategories = ref([])

/*
|--------------------------------------------------------------------------
| MEGA MENU DELAY
|--------------------------------------------------------------------------
*/

const OPEN_DELAY = 300
const CLOSE_DELAY = 100

let productsOpenTimer = null
let productsCloseTimer = null

let servicesOpenTimer = null
let servicesCloseTimer = null

/*
|--------------------------------------------------------------------------
| PRODUCT CATEGORIES
|--------------------------------------------------------------------------
*/

const loadProductCategories = async () => {
    try {
        productCategories.value =
            await fetchProductCategories(locale.value)
    } catch (error) {
        console.error(
            'Failed to load product menu:',
            error,
        )

        productCategories.value = []
    }
}

onMounted(loadProductCategories)

watch(locale, () => {
    loadProductCategories()
})

/*
|--------------------------------------------------------------------------
| PRODUCTS MENU
|--------------------------------------------------------------------------
*/

const openProducts = () => {
    clearTimeout(productsCloseTimer)

    clearTimeout(productsOpenTimer)

    productsOpenTimer = setTimeout(() => {
        productsOpen.value = true
        servicesOpen.value = false
    }, OPEN_DELAY)
}

const closeProducts = () => {
    clearTimeout(productsOpenTimer)

    clearTimeout(productsCloseTimer)

    productsCloseTimer = setTimeout(() => {
        productsOpen.value = false
    }, CLOSE_DELAY)
}

/*
|--------------------------------------------------------------------------
| SERVICES MENU
|--------------------------------------------------------------------------
*/

const openServices = () => {
    clearTimeout(servicesCloseTimer)

    clearTimeout(servicesOpenTimer)

    servicesOpenTimer = setTimeout(() => {
        servicesOpen.value = true
        productsOpen.value = false
    }, OPEN_DELAY)
}

const closeServices = () => {
    clearTimeout(servicesOpenTimer)

    clearTimeout(servicesCloseTimer)

    servicesCloseTimer = setTimeout(() => {
        servicesOpen.value = false
    }, CLOSE_DELAY)
}

/*
|--------------------------------------------------------------------------
| CLEANUP
|--------------------------------------------------------------------------
*/

onBeforeUnmount(() => {
    clearTimeout(productsOpenTimer)
    clearTimeout(productsCloseTimer)

    clearTimeout(servicesOpenTimer)
    clearTimeout(servicesCloseTimer)
})
</script>

<style scoped>
@media (max-width: 1149px) {
    .nav-item-icon {
        display: none;
    }
}
</style>