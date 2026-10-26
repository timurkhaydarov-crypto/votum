<template>
    <div class="rounded-[2rem] border border-amber-200 bg-amber-50 p-8">
        <div class="max-w-xl">
            <div
                class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 text-amber-700"
            >
                <i class="bi bi-search text-xl"></i>
            </div>

            <h2 class="mt-5 text-2xl font-bold tracking-tight text-slate-900">
                {{ t('siteUi.product.notFoundTitle') }}
            </h2>

            <p class="mt-2 text-sm leading-6 text-slate-600">
                {{ t('siteUi.product.notFoundDescription') }}
            </p>

            <RouterLink
                to="/products"
                class="mt-6 inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
            >
                <i class="bi bi-arrow-left"></i>

                {{ t('productBreadcrumbs.backToCatalog') }}
            </RouterLink>
        </div>
    </div>
</template>

<script setup>
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
</script>