<template>
    <section
        class="overflow-hidden rounded-[1.75rem] border border-slate-200 bg-slate-900 text-white"
    >
        <div class="relative p-7 sm:p-10 lg:p-12">
            <div
                class="absolute -right-20 -top-20 h-72 w-72 rounded-full bg-white/5 blur-3xl"
            ></div>

            <div class="relative max-w-4xl">
                <div
                    class="text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-400"
                >
                    05 / APPLICATION
                </div>

                <h2
                    class="mt-3 text-2xl font-bold tracking-tight sm:text-3xl"
                >
                    Область применения
                </h2>

                <p
                    v-if="available"
                    class="mt-5 max-w-3xl text-sm leading-7 text-slate-300 sm:text-base"
                >
                    {{ product.application || product.categoryTitle }}
                </p>

                <div
                    v-else
                    class="mt-5 inline-flex items-center gap-2 rounded-xl border border-amber-300/20 bg-amber-300/10 px-4 py-3 text-sm text-amber-200"
                >
                    <i class="bi bi-info-circle"></i>

                    Информация пока не заполнена
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
defineProps({
    product: {
        type: Object,
        required: true,
    },

    available: {
        type: Boolean,
        default: false,
    },
});
</script>