<template>
    <ProductsLayout
        :title="pageTitle"
        :subtitle="pageSubtitle"
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
import { useI18n } from 'vue-i18n';
import ProductBreadcrumbs from '../../components/products/ProductBreadcrumbs.vue';
import ProductGrid from '../../components/products/ProductGrid.vue';
import ProductsLayout from '../../components/products/ProductsLayout.vue';
import { useProductsCatalog } from '../../composables/useProductsCatalog.js';
import { useProductBreadcrumbs } from '../../composables/useProductBreadcrumbs.js';

const route = useRoute();
const { locale, t } = useI18n();

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
const pageTitle = computed(() => {
    return t('productPages.groupTitle', {
        group: groupTitle.value,
    });
});
const pageSubtitle = computed(() => {
    return t('productPages.groupSubtitle', {
        category: categoryTitle.value,
    });
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
    if (!categorySlug.value || !groupSlug.value) {
        return;
    }

    loadProductsByGroup(categorySlug.value, groupSlug.value);
};

onMounted(loadGroupProducts);

watch(
    () => [route.params.categorySlug, route.params.groupSlug],
    () => {
        loadGroupProducts();
    }
);

watch(locale, () => {
    loadGroupProducts();
});
</script>
