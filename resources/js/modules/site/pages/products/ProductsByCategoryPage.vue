<template>
    <ProductsLayout
        :title="`Категория: ${categorySlug}`"
        subtitle="Продукция в выбранной категории"
    >
        <ProductBreadcrumbs :items="breadcrumbs" />

        <ProductGrid
            :products="products"
            :is-loading="isLoading"
            :error-message="errorMessage"
        />
    </ProductsLayout>
</template>

<script setup>
import { computed, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import ProductBreadcrumbs from '../../components/products/ProductBreadcrumbs.vue';
import ProductGrid from '../../components/products/ProductGrid.vue';
import ProductsLayout from '../../components/products/ProductsLayout.vue';
import { useProductsCatalog } from '../../composables/useProductsCatalog.js';
import { useProductBreadcrumbs } from '../../composables/useProductBreadcrumbs.js';

const route = useRoute();

const {
    products,
    isLoading,
    errorMessage,
    loadProductsByCategory,
} = useProductsCatalog();

const categorySlug = computed(() => route.params.categorySlug || '');
const categoryTitle = computed(() => {
    return products.value[0]?.categoryTitle || categorySlug.value;
});

const {
    breadcrumbs,
} = useProductBreadcrumbs({
    categorySlug,
    categoryTitle,
});

const loadCategoryProducts = () => {
    if (!categorySlug.value) {
        return;
    }

    loadProductsByCategory(categorySlug.value);
};

onMounted(loadCategoryProducts);

watch(
    () => route.params.categorySlug,
    () => {
        loadCategoryProducts();
    }
);
</script>
