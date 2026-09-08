<template>
    <div
        class="flex flex-col items-center justify-center rounded-2xl border border-slate-200 bg-white px-6 py-16 text-center shadow-sm"
    >
        <!-- ICON -->
        <div
            class="mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100"
        >
            <i class="bi bi-cart3 text-2xl text-slate-400"></i>
        </div>

        <!-- TITLE -->
        <h2
            class="text-lg font-semibold tracking-tight text-slate-900"
        >
            {{ t('cart.empty.title') }}
        </h2>

        <!-- DESCRIPTION -->
        <p
            class="mt-2 max-w-md text-sm leading-6 text-slate-500"
        >
            {{ t('cart.empty.description') }}
        </p>

        <!-- ACTION -->
        <RouterLink
            to="/products"
            class="mt-6 inline-flex items-center gap-2 rounded-lg bg-slate-900 px-5 py-2.5 text-xs font-semibold text-white shadow-sm transition-all duration-200 hover:bg-slate-800 hover:shadow-md active:scale-[0.98]"
        >
            <i class="bi bi-grid text-sm"></i>

            {{ t('cart.empty.viewProducts') }}
        </RouterLink>
    </div>
</template>

<script setup>
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
</script>
