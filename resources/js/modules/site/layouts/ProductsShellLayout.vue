<template>
    <section class="min-h-screen bg-slate-100 sm:pt-[100px]">
        <TopPagePanel class="hidden sm:block" />

        <MainMenu class="hidden bg-white sm:fixed sm:inset-x-0 sm:top-[40px] sm:z-[60] sm:block" />

        <RouterView />
    </section>
</template>

<script setup>
import TopPagePanel from '../components/TopPagePanel/index.vue';
import MainMenu from '../components/navigation/MainHeader.vue';
</script>