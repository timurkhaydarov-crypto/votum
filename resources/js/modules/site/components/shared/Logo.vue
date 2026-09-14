<template>
    <RouterLink
        to="/"
        class="flex shrink-0 items-center gap-2"
    >
        <!-- LOGO ICON -->

        <div
            class="flex h-9 w-9 shrink-0 items-center justify-center"
        >
            <img
                :src="'/image/logo.svg'"
                alt="Logo"
                class="h-9 w-9"
            />
        </div>

        <!-- EXPANDED LOGO -->
        <!--
            Показывается:
            1. если передан mobile
            2. или на экранах lg и шире
        -->

        <div
            v-if="mobile"
            class="flex w-[180px] flex-col text-[#0f172b]"
        >
            <span
                class="block w-full text-[16px] font-bold leading-none tracking-[0.06em]"
            >
                {{ $t('logo.title') }}
            </span>

            <span
                :class="[
                    'block w-full text-[6px] font-medium leading-none',
                    subtitleTrackingClass
                ]"
            >
                {{ $t('logo.subtitle') }}
            </span>
        </div>

        <div
            v-else
            class="hidden w-[180px] flex-col text-[#0f172b] lg:flex"
        >
            <span
                class="block w-full text-[16px] font-bold leading-none tracking-[0.06em]"
            >
                {{ $t('logo.title') }}
            </span>

            <span
                :class="[
                    'block w-full text-[6px] font-medium leading-none',
                    subtitleTrackingClass
                ]"
            >
                {{ $t('logo.subtitle') }}
            </span>
        </div>
    </RouterLink>
</template>

<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

defineProps({
    mobile: {
        type: Boolean,
        default: false,
    },
});

const { locale } = useI18n();

const subtitleTrackingClass = computed(() => {
    return locale.value === 'en'
        ? 'tracking-[0.09em]'
        : 'tracking-[0.03em]';
});
</script>

