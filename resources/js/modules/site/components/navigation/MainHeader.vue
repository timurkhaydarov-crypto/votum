<template>
    <header class="relative z-50 w-full bg-white">

        <nav class="relative flex h-[60px] w-full items-center
             px-4 sm:px-6 lg:px-8 shadow-[0_12px_24px_-14px_rgba(0,0,0,0.35)]">

            <Logo />


            <!-- Desktop -->
            <DesktopNavigation />


            <!-- Mobile button -->
            <button type="button" aria-label="Открыть меню" class="ml-auto flex h-10 w-10
               items-center justify-center
               rounded-xl text-[#252525]
               transition hover:bg-gray-100
               md:hidden" @click="openMobileMenu">
                <i class="bi bi-list text-2xl"></i>
            </button>

        </nav>


        <!-- Mobile -->
        <MobileNavigation :open="mobileMenuOpen" @close="closeMobileMenu" />

    </header>
</template>
<script setup>
import { ref } from 'vue'

import DesktopNavigation from './DesktopNavigation.vue'
import MobileNavigation from './MobileNavigation.vue'
import Logo from '../shared/Logo.vue'

const mobileMenuOpen = ref(false)

const openMobileMenu = () => {
    mobileMenuOpen.value = true
}

const closeMobileMenu = () => {
    mobileMenuOpen.value = false
}
</script>