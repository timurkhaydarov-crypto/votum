<template>
    <ProductsLayout
        title="Вся продукция"
        subtitle="Полный каталог доступной продукции"
    >
        <ProductManagement
            ref="productManagementRef"
            @created="handleProductCreated"
            @updated="handleProductUpdated"
            @deleted="handleProductDeleted"
        />

        <ProductGrid
            :products="products"
            :is-loading="isLoading"
            :error-message="errorMessage"
            @edit="handleEdit"
            @delete="handleDelete"
        />
    </ProductsLayout>
</template>


<script setup>
import {
    onMounted,
    ref,
} from 'vue';

import ProductGrid from '../../components/products/ProductGrid.vue';
import ProductManagement from '../../components/products/ProductManagement.vue';
import ProductsLayout from '../../components/products/ProductsLayout.vue';

import { useProductsCatalog } from '../../composables/useProductsCatalog.js';


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

