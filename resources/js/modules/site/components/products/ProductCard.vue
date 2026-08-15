<template>
    <article
        class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow"
    >
        <p class="mb-1 text-xs uppercase tracking-wide text-slate-500">
            {{ product.article || 'No article' }}
        </p>

        <h3 class="text-base font-semibold text-slate-900">
            {{ product.name || 'Untitled product' }}
        </h3>

        <p class="mt-2 line-clamp-3 text-sm text-slate-600">
            {{ product.shortDescription || product.fullDescription || 'No description' }}
        </p>

        <div class="mt-4 flex flex-wrap gap-2 text-xs text-slate-500">
            <span
                v-if="product.categoryTitle"
                class="rounded bg-slate-100 px-2 py-1"
            >
                {{ product.categoryTitle }}
            </span>

            <span
                v-if="product.groupTitle"
                class="rounded bg-slate-100 px-2 py-1"
            >
                {{ product.groupTitle }}
            </span>
        </div>

        <div class="mt-4 flex items-center justify-between text-sm">
            <span class="font-semibold text-slate-900">
                {{ product.price ? `${product.price} ₽` : 'Цена по запросу' }}
            </span>

            <span class="text-slate-500">
                Остаток: {{ product.quantity ?? 0 }}
            </span>
        </div>
    </article>
</template>

<script setup>
defineProps({
    product: {
        type: Object,
        required: true,
    },
});
</script>
