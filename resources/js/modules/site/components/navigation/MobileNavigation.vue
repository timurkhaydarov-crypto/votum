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
                   bg-black/30
                   backdrop-blur-[2px]"
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
                   bg-white
                   shadow-2xl"
        >

            <!-- ======================================== -->
            <!-- HEADER -->
            <!-- ======================================== -->

            <div
                class="flex h-[60px] shrink-0
                       items-center justify-between
                       border-b border-gray-100
                       px-5"
            >

                <Logo />

                <button
                    type="button"
                    aria-label="Закрыть меню"
                    class="flex h-10 w-10
                           items-center justify-center
                           rounded-xl
                           text-[#252525]
                           transition
                           hover:bg-gray-100"
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

                    <a
                        href="/"
                        @click="close"
                        class="flex items-center gap-4
                               rounded-2xl px-4 py-3.5
                               text-[15px] font-medium
                               text-[#252525]
                               transition
                               hover:bg-gray-100"
                    >

                        <span
                            class="flex h-10 w-10
                                   items-center justify-center
                                   rounded-xl bg-gray-100"
                        >
                            <i class="bi bi-house-door text-xl"></i>
                        </span>

                        <span>
                            {{ t('menu.home') }}
                        </span>

                    </a>


                    <!-- PRODUCTS -->

                    <DropdownMenu
                        :open="productsOpen"
                        title="Продукция"
                        icon="bi-box-seam"
                        :categories="productCategories"
                        all-link="/products"
                        all-label="Вся продукция"
                        @toggle="toggleProducts"
                        @close="close"
                    />


                    <!-- SERVICES -->

                    <DropdownMenu
                        :open="servicesOpen"
                        title="Услуги"
                        icon="bi-tools"
                        :categories="serviceCategories"
                        all-link="/services"
                        all-label="Все услуги"
                        @toggle="toggleServices"
                        @close="close"
                    />


                    <!-- OTHER MENU ITEMS -->

                    <a
                        v-for="item in mainMenu"
                        :key="item.title"
                        :href="item.href"
                        @click="close"
                        class="flex items-center gap-4
                               rounded-2xl px-4 py-3.5
                               text-[15px] font-medium
                               text-[#252525]
                               transition
                               hover:bg-gray-100"
                    >

                        <span
                            class="flex h-10 w-10
                                   items-center justify-center
                                   rounded-xl bg-gray-100"
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

                    </a>

                </div>

            </div>

        </aside>

    </Transition>

</template>


<script setup>
import { ref } from 'vue'
import { useI18n } from 'vue-i18n'

import DropdownMenu from './dropdown-menu/DropdownMenu.vue'
import Logo from '../shared/Logo.vue'

import {
    mainMenu,
    productCategories,
    serviceCategories
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


const { t } = useI18n()


const productsOpen = ref(false)
const servicesOpen = ref(false)


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