<template>
    <ProductsLayout
        :title="t('megaMenu.allProducts')"
        :subtitle="t('siteUi.catalog.fullCatalog')"
    >
        <ProductGrid
            :products="products"
            :is-loading="isLoading"
            :error-message="errorMessage"
            filter-by-category
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
    onMounted,
    ref,
} from 'vue';
import { useI18n } from 'vue-i18n';

import ProductGrid from '../../components/products/ProductGrid.vue';
import ProductManagement from '../../components/products/ProductManagement.vue';
import ProductsLayout from '../../components/products/ProductsLayout.vue';

import { useProductsCatalog } from '../../composables/useProductsCatalog.js';

const { t } = useI18n();

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
    loadAllProducts,
    addProduct,
    updateProduct,
    removeProduct,
} = useProductsCatalog();


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

onMounted(() => {
    loadAllProducts();
});
</script>
