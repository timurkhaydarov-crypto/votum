<template>
    <ProductsLayout
        :title="`Группа: ${groupSlug}`"
        :subtitle="`Продукция группы в категории ${categorySlug}`"
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
    loadProductsByGroup,
} = useProductsCatalog();

const categorySlug = computed(() => route.params.categorySlug || '');
const groupSlug = computed(() => route.params.groupSlug || '');
const categoryTitle = computed(() => {
    return products.value[0]?.categoryTitle || categorySlug.value;
});
const groupTitle = computed(() => {
    return products.value[0]?.groupTitle || groupSlug.value;
});

const {
    breadcrumbs,
} = useProductBreadcrumbs({
    categorySlug,
    categoryTitle,
    groupSlug,
    groupTitle,
});

const loadGroupProducts = () => {
    if (!groupSlug.value) {
        return;
    }

    loadProductsByGroup(groupSlug.value);
};

onMounted(loadGroupProducts);

watch(
    () => route.params.groupSlug,
    () => {
        loadGroupProducts();
    }
);
</script>
