<template>
    <ProductsLayout
        :title="categoryTitle"
        subtitle="Продукция в выбранной категории"
    >
        <ProductBreadcrumbs :items="breadcrumbs" />

        <ProductGrid
            :products="products"
            :is-loading="isLoading"
            :error-message="errorMessage"
            @edit="handleEdit"
            @delete="handleDelete"
        >
            <template #actions>
                <div class="ml-auto shrink-0">
                    <ProductManagement
                        ref="productManagementRef"
                        inline-create-button
                        @created="handleProductCreated"
                        @updated="handleProductUpdated"
                        @deleted="handleProductDeleted"
                    />
                </div>
            </template>
        </ProductGrid>
    </ProductsLayout>
</template>


<script setup>
import {
    computed,
    onMounted,
    ref,
    watch,
} from 'vue';

import { useI18n } from 'vue-i18n';
import { useRoute } from 'vue-router';

import ProductBreadcrumbs from '../../components/products/ProductBreadcrumbs.vue';
import ProductGrid from '../../components/products/ProductGrid.vue';
import ProductManagement from '../../components/products/ProductManagement.vue';
import ProductsLayout from '../../components/products/ProductsLayout.vue';

import { useProductBreadcrumbs } from '../../composables/useProductBreadcrumbs.js';
import { useProductsCatalog } from '../../composables/useProductsCatalog.js';


/*
|--------------------------------------------------------------------------
| Route / i18n
|--------------------------------------------------------------------------
*/

const route = useRoute();

const { locale } = useI18n();


/*
|--------------------------------------------------------------------------
| Product management
|--------------------------------------------------------------------------
*/

const productManagementRef = ref(null);


const handleEdit = (product) => {
    productManagementRef.value?.openEdit(product);
};


const handleDelete = (product) => {
    productManagementRef.value?.openDelete(product);
};


/*
|--------------------------------------------------------------------------
| Products catalog
|--------------------------------------------------------------------------
*/

const {
    products,
    isLoading,
    errorMessage,
    loadProductsByCategory,
    addProduct,
    updateProduct,
    removeProduct,
} = useProductsCatalog();


/*
|--------------------------------------------------------------------------
| Category
|--------------------------------------------------------------------------
*/

const categorySlug = computed(() => {
    return route.params.categorySlug || '';
});


/*
|--------------------------------------------------------------------------
| Category title
|--------------------------------------------------------------------------
*/

const categoryTitle = computed(() => {
    return (
        products.value[0]?.categoryTitle ||
        categorySlug.value
    );
});


/*
|--------------------------------------------------------------------------
| Breadcrumbs
|--------------------------------------------------------------------------
*/

const {
    breadcrumbs,
} = useProductBreadcrumbs({
    categorySlug,
    categoryTitle,
});


/*
|--------------------------------------------------------------------------
| Product management events
|--------------------------------------------------------------------------
*/

const handleProductCreated = (product) => {
    addProduct(product);
};


const handleProductUpdated = (product) => {
    updateProduct(product);
};


const handleProductDeleted = (productId) => {
    removeProduct(productId);
};


/*
|--------------------------------------------------------------------------
| Load products
|--------------------------------------------------------------------------
*/

const loadCategoryProducts = () => {
    if (!categorySlug.value) {
        return;
    }

    loadProductsByCategory(
        categorySlug.value
    );
};


/*
|--------------------------------------------------------------------------
| Lifecycle
|--------------------------------------------------------------------------
*/

onMounted(() => {
    loadCategoryProducts();
});


/*
|--------------------------------------------------------------------------
| Route changes
|--------------------------------------------------------------------------
*/

watch(
    () => route.params.categorySlug,
    () => {
        loadCategoryProducts();
    }
);


/*
|--------------------------------------------------------------------------
| Locale changes
|--------------------------------------------------------------------------
*/

watch(
    locale,
    () => {
        loadCategoryProducts();
    }
);
</script>
