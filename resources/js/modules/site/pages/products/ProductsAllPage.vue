<template>
    <ProductsLayout
        title="Вся продукция"
        subtitle="Полный каталог доступной продукции"
    >
        <ProductGrid
            :products="products"
            :is-loading="isLoading"
            :error-message="errorMessage"
        />
    </ProductsLayout>
</template>

<script setup>
import { onMounted } from 'vue';
import ProductGrid from '../../components/products/ProductGrid.vue';
import ProductsLayout from '../../components/products/ProductsLayout.vue';
import { useProductsCatalog } from '../../composables/useProductsCatalog.js';

const {
    products,
    isLoading,
    errorMessage,
    loadAllProducts,
} = useProductsCatalog();

onMounted(() => {
    loadAllProducts();
});
</script>
