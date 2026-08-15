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
            class="fixed inset-0 z-[60]
                   bg-black/20
                   backdrop-blur-[1px]"
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
            class="fixed right-0 top-0 z-[70]
                   flex h-screen w-[85%]
                   max-w-[380px]
                   flex-col
                   border-l border-[#f1f0ee]
                   bg-[#fdfcfb]
                   shadow-[0_18px_50px_rgba(20,20,20,0.08)]"
        >

            <!-- ======================================== -->
            <!-- HEADER -->
            <!-- ======================================== -->

            <div
                class="flex h-[60px] shrink-0
                       items-center justify-between
                       border-b border-[#f1f0ee]
                       bg-[#fdfcfb]
                       px-5"
            >

                <Logo />

                <button
                    type="button"
                    aria-label="Закрыть меню"
                    class="flex h-9 w-9
                           items-center justify-center
                           rounded-lg
                           text-[#252525]
                           transition-colors duration-200
                           hover:bg-[#f3f1ee]"
                    @click="close"
                >
                    <i class="bi bi-x-lg"></i>
                </button>

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
                        class="group flex items-center gap-2.5
                               rounded-lg px-2.5 py-2.5
                               text-[13.5px] font-medium
                               tracking-[-0.01em] text-[#252525]
                               transition-colors duration-200
                               hover:bg-transparent"
                    >

                        <span
                            class="flex h-8 w-8
                                   items-center justify-center
                                   rounded-md bg-[#efefef] text-gray-600
                                   transition-all duration-200
                                   group-hover:bg-[#252525] group-hover:text-white"
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
                        class="group flex items-center gap-2.5
                               rounded-lg px-2.5 py-2.5
                               text-[13.5px] font-medium
                               tracking-[-0.01em] text-[#252525]
                               transition-colors duration-200
                               hover:bg-transparent"
                    >

                        <span
                            class="flex h-8 w-8
                                   items-center justify-center
                                   rounded-md bg-[#efefef] text-gray-600
                                   transition-all duration-200
                                   group-hover:bg-[#252525] group-hover:text-white"
                        >

                            <i
                                :class="[
                                    'bi',
                                    item.icon,
                                    'text-xl'
                                ]"
                            ></i>

                        </span>


                        <span>
                            {{ t(item.title) }}
                        </span>


                        <i
                            class="bi bi-chevron-right
                                   ml-auto text-sm
                                   text-gray-400"
                        ></i>

                    </RouterLink>

                </div>

            </div>

        </aside>

    </Transition>

</template>


<script setup>
import { onMounted, ref, watch } from 'vue'
import { useI18n } from 'vue-i18n'

import DropdownMenu from './dropdown-menu/DropdownMenu.vue'
import Logo from '../shared/Logo.vue'
import { Icon } from '@/modules/site/constants/icons.js'

import {
    mainMenu,
    serviceCategories,
    fetchProductCategories
} from './navigation.data.js'


defineProps({
    open: {
        type: Boolean,
        default: false
    }
})


const emit = defineEmits([
    'close'
])


const { t, locale } = useI18n()

const productsOpen = ref(false)
const servicesOpen = ref(false)
const productCategories = ref([])

const loadProductCategories = async () => {
    try {
        productCategories.value = await fetchProductCategories(locale.value)
    } catch (error) {
        console.error('Failed to load product menu:', error)
        productCategories.value = []
    }
}

onMounted(loadProductCategories)
watch(locale, () => {
    loadProductCategories()
})


const close = () => {

    productsOpen.value = false
    servicesOpen.value = false

    emit('close')
}


const toggleProducts = () => {

    productsOpen.value = !productsOpen.value

    if (productsOpen.value) {
        servicesOpen.value = false
    }
}


const toggleServices = () => {

    servicesOpen.value = !servicesOpen.value

    if (servicesOpen.value) {
        productsOpen.value = false
    }
}
</script>