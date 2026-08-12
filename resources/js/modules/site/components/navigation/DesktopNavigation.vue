<template>

    <nav class="absolute left-1/2 hidden
           -translate-x-1/2
           items-center gap-1
           lg:flex">

        <!-- Главная -->

        <a href="/" class="group flex items-center gap-2
             rounded-xl px-3 py-2
             text-sm font-medium
             text-[#252525]
             transition hover:bg-gray-100">
            <i class="bi bi-house-door text-[17px]
               text-gray-500
               group-hover:text-[#252525]
               nav-item-icon"></i>

            <span>{{ t('menu.home') }}</span>
        </a>


        <!-- ========================================== -->
        <!-- ПРОДУКЦИЯ -->
        <!-- ========================================== -->

        <div class="relative" @mouseenter="openProducts" @mouseleave="closeProducts" @contextmenu.prevent>

            <button type="button" class="group flex items-center gap-2
               rounded-xl px-3 py-2
               text-sm font-medium
               text-[#252525]
               transition hover:bg-gray-100">

                <i class="bi bi-box-seam text-[17px]
                 text-gray-500 nav-item-icon"></i>

                <span>{{ t('menu.products') }}</span>

                <i class="bi bi-chevron-down
                 text-[10px] text-gray-400
                 transition-transform" :class="{
                    'rotate-180': productsOpen
                }"></i>

            </button>


            <MegaMenu :open="productsOpen" :variant="'content'" title="Продукция" :icon="'bi-box-seam'" :categories="productCategories"
                all-link="/products" all-label="Вся продукция" :footer="{
                    title: 'Нужна помощь с выбором оборудования?',
                    description: 'Наши специалисты помогут подобрать решение',
                    button: 'Связаться',
                    link: '/contacts'
                }" />

        </div>


        <!-- ========================================== -->
        <!-- УСЛУГИ -->
        <!-- ========================================== -->

        <div class="relative" @mouseenter="openServices" @mouseleave="closeServices" @contextmenu.prevent>

            <button type="button" class="group flex items-center gap-2
               rounded-xl px-3 py-2
               text-sm font-medium
               text-[#252525]
               transition hover:bg-gray-100">

                <i class="bi bi-tools text-[17px]
                 text-gray-500 nav-item-icon"></i>

                <span>{{ t('menu.services') }}</span>

                <i class="bi bi-chevron-down
                 text-[10px] text-gray-400
                 transition-transform" :class="{
                    'rotate-180': servicesOpen
                }"></i>

            </button>


            <MegaMenu :open="servicesOpen" title="Услуги" :variant="'cards'" :icon="'bi-tools'" :categories="serviceCategories"
                all-link="/services" all-label="Все услуги" :footer="{
                    title: 'Нужна консультация?',
                    description: 'Мы поможем подобрать нужную услугу',
                    button: 'Связаться',
                    link: '/contacts'
                }" />

        </div>


        <!-- ========================================== -->
        <!-- ОСТАЛЬНЫЕ -->
        <!-- ========================================== -->

        <a v-for="item in mainMenu.slice(1)" :key="item.title" :href="item.href" class="group flex items-center gap-2
             rounded-xl px-3 py-2
             text-sm font-medium
             text-[#252525]
             transition hover:bg-gray-100 shrink-0 whitespace-nowrap">

            <i :class="[
                'bi',
                item.icon,
                'text-[17px]',
                'text-gray-500',
                'nav-item-icon'
            ]"></i>

            <span>
                {{ t(item.title) }}
            </span>

        </a>

    </nav>

</template>
<script setup>
import { ref } from 'vue'
import { useI18n } from 'vue-i18n'
import MegaMenu from './mega-menu/MegaMenu.vue'

import {
    mainMenu,
    productCategories,
    serviceCategories
} from './navigation.data.js'

const { t } = useI18n()
const productsOpen = ref(false)
const servicesOpen = ref(false)


const openProducts = () => {
    productsOpen.value = true
    servicesOpen.value = false
}


const openServices = () => {
    servicesOpen.value = true
    productsOpen.value = false
}


const closeProducts = () => {
    productsOpen.value = false
}


const closeServices = () => {
    servicesOpen.value = false
}
</script>
<style scoped>
@media (max-width: 1149px) {
  .nav-item-icon {
    display: none;
  }
}
</style>