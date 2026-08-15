<template>
    <section>
        <p
            v-if="isLoading"
            class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600"
        >
            Загрузка продукции...
        </p>

        <p
            v-else-if="errorMessage"
            class="rounded-lg border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700"
        >
            {{ errorMessage }}
        </p>

        <p
            v-else-if="!products.length"
            class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600"
        >
            По этому запросу продукция не найдена.
        </p>

        <div
            v-else
            class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3"
        >
            <ProductCard
                v-for="product in products"
                :key="product.id"
                :product="product"
            />
        </div>
    </section>
</template>

<script setup>
import ProductCard from './ProductCard.vue';

defineProps({
    products: {
        type: Array,
        default: () => [],
    },

    isLoading: {
        type: Boolean,
        default: false,
    },

    errorMessage: {
        type: String,
        default: '',
    },
});
</script>
