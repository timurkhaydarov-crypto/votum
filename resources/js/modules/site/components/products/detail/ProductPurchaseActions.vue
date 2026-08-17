<template>
    <div class="mt-3">
        <div
            class="mb-2 text-[9px] font-semibold uppercase tracking-[0.15em] text-slate-400"
        >
            Цена
        </div>

        <div class="flex flex-col gap-2.5 sm:flex-row sm:items-center">
            <div
                class="shrink-0 text-xl font-bold tracking-tight text-slate-900"
            >
                {{ priceLabel }}
            </div>

            <div class="hidden h-7 w-px bg-slate-200 sm:block"></div>

            <button
                type="button"
                class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg bg-slate-900 px-4 py-2.5 text-xs font-semibold text-white shadow-sm transition-all duration-200 hover:bg-slate-800 hover:shadow-md active:scale-[0.98]"
            >
                <i class="bi bi-cart3 text-sm"></i>

                Добавить в корзину
            </button>
        </div>
    </div>
</template>

<script setup>
defineProps({
    priceLabel: {
        type: String,
        default: 'По запросу',
    },

    isInStock: {
        type: Boolean,
        default: false,
    },

    backLink: {
        type: String,
        default: '/products',
    },

    backLabel: {
        type: String,
        default: 'Вернуться в каталог',
    },
});
</script>