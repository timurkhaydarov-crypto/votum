<template>
    <ProductsLayout
        :title="pageTitle"
        :subtitle="pageSubtitle"
    >
        <ProductBreadcrumbs :items="breadcrumbs" />
        <ProductManagement
            ref="productManagementRef"
            :category-id="categoryId"
            :group-id="groupId"
            :category-slug="categorySlug"
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

import { productsApi } from '../../services/productsApi.js';

/*
|--------------------------------------------------------------------------
| Route / i18n
|--------------------------------------------------------------------------
*/

const route = useRoute();

const {
    locale,
    t,
} = useI18n();

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
    loadProductsByGroup,
    addProduct,
    updateProduct,
    removeProduct,
} = useProductsCatalog();

/*
|--------------------------------------------------------------------------
| Route params
|--------------------------------------------------------------------------
*/

const categorySlug = computed(() => {
    return route.params.categorySlug || '';
});

const groupSlug = computed(() => {
    return route.params.groupSlug || '';
});

/*
|--------------------------------------------------------------------------
| Product context
|--------------------------------------------------------------------------
|
| Category and group are determined from route slugs.
| This works even when the group does not contain products yet.
|
*/

const categoryId = ref(null);
const groupId = ref(null);

const loadProductContext = async () => {
    categoryId.value = null;
    groupId.value = null;

    if (
        !categorySlug.value ||
        !groupSlug.value
    ) {
        return;
    }

    try {
        const response = await productsApi.getCreate();

        const categories =
            response?.options?.categories ?? [];

        const groups =
            response?.options?.groups ?? [];

        const category = categories.find(
            (item) => item.slug === categorySlug.value
        );

        const group = groups.find(
            (item) => item.slug === groupSlug.value
        );

        categoryId.value = category?.id ?? null;
        groupId.value = group?.id ?? null;
    } catch (error) {
        categoryId.value = null;
        groupId.value = null;

        console.error(
            'Failed to load product context:',
            error
        );
    }
};

/*
|--------------------------------------------------------------------------
| Titles
|--------------------------------------------------------------------------
*/

const categoryTitle = computed(() => {
    return (
        products.value[0]?.categoryTitle ||
        categorySlug.value
    );
});

const groupTitle = computed(() => {
    return (
        products.value[0]?.groupTitle ||
        groupSlug.value
    );
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
    groupSlug,
    groupTitle,
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

const loadGroupProducts = () => {
    if (
        !categorySlug.value ||
        !groupSlug.value
    ) {
        return;
    }

    loadProductsByGroup(
        categorySlug.value,
        groupSlug.value
    );
};

/*
|--------------------------------------------------------------------------
| Lifecycle
|--------------------------------------------------------------------------
*/

onMounted(() => {
    loadProductContext();
    loadGroupProducts();
});

/*
|--------------------------------------------------------------------------
| Route changes
|--------------------------------------------------------------------------
*/

watch(
    () => [
        route.params.categorySlug,
        route.params.groupSlug,
    ],
    () => {
        loadProductContext();
        loadGroupProducts();
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
        loadGroupProducts();
    }
);
</script>

