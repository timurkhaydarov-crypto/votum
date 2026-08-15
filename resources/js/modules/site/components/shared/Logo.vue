<template>
    <!-- Logo -->
    <RouterLink to="/" class="flex shrink-0 items-center gap-2">
        <div class="flex h-9 w-9 items-center justify-center">
            <img :src="'/image/logo.svg'" alt="Logo" class="h-9 w-9" />
        </div>

        <div class="hidden w-[220px] flex-col text-[#00979f] sm:flex">
            <span class="block w-full text-xl font-bold leading-none tracking-[0.06em]">
                {{ $t('logo.Title') }}
            </span>
            <span :class="['block w-full text-[7px] font-medium leading-none', subtitleTrackingClass]">
                {{ $t('logo.Subtitle') }}
            </span>
        </div>
    </RouterLink>
</template>
<script setup>
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

const { locale } = useI18n()

const subtitleTrackingClass = computed(() =>
    locale.value === 'en' ? 'tracking-[0.09em]' : 'tracking-[0.03em]'
)
</script>
