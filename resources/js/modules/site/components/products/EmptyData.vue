<template>
    <div
        class="flex flex-col items-center justify-center py-6 text-center"
    >
        <div
            class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-600"
        >
            <i class="bi bi-info-circle"></i>
        </div>

        <div
            class="mt-3 text-sm font-semibold text-slate-700"
        >
            {{ title || t('siteUi.empty.data') }}
        </div>

        <p
            v-if="text"
            class="mt-1 max-w-md text-xs leading-5 text-slate-500"
        >
            {{ text }}
        </p>
    </div>
</template>

<script setup>
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

defineProps({
    title: {
        type: String,
        default: '',
    },

    text: {
        type: String,
        default: '',
    },
});
</script>