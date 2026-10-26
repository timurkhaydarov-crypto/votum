<template>
    <div
        class="flex flex-col items-center justify-center py-12 text-center"
    >
        <div
            class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-slate-400"
        >
            <i class="bi bi-info-circle text-xl"></i>
        </div>

        <p class="text-sm font-medium text-slate-700">
            {{ title || t('siteUi.empty.information') }}
        </p>

        <p
            v-if="description"
            class="mt-1 max-w-sm text-xs leading-5 text-slate-400"
        >
            {{ description }}
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

    description: {
        type: String,
        default: '',
    },
});
</script>