<template>
    <div class="rounded-2xl border border-rose-200 bg-rose-50 p-6">
        <div class="flex items-start gap-4">
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-rose-100 text-rose-600"
            >
                <i class="bi bi-exclamation-triangle"></i>
            </div>

            <div>
                <h2 class="font-semibold text-rose-900">
                    {{ t('siteUi.product.loadErrorTitle') }}
                </h2>

                <p class="mt-1 text-sm text-rose-700">
                    {{ message || t('siteUi.product.loadErrorDescription') }}
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

defineProps({
    message: {
        type: String,
        default: '',
    },
});
</script>