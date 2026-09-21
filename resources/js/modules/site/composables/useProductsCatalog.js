import { ref } from 'vue';
import { useI18n } from 'vue-i18n';

import { productsApi } from '../services/productsApi.js';
import { normalizeProducts } from '../utils/productNormalizer.js';

export const useProductsCatalog = () => {
    const { locale } = useI18n();

    const products = ref([]);
    const isLoading = ref(false);
    const errorMessage = ref('');

    /*
    |--------------------------------------------------------------------------
    | Normalize
    |--------------------------------------------------------------------------
    */

    const normalizeProduct = (product) => {
        const normalized = normalizeProducts(
            [product],
            locale.value
        );

        return normalized[0] || null;
    };

    /*
    |--------------------------------------------------------------------------
    | Set products
    |--------------------------------------------------------------------------
    */

    const setProducts = (rawProducts) => {
        products.value = normalizeProducts(
            rawProducts,
            locale.value
        );
    };

    /*
    |--------------------------------------------------------------------------
    | Add product
    |--------------------------------------------------------------------------
    */

    const addProduct = (product) => {
        const normalizedProduct =
            normalizeProduct(product);

        if (!normalizedProduct) {
            return;
        }

        products.value.unshift(normalizedProduct);
    };

    /*
    |--------------------------------------------------------------------------
    | Update product
    |--------------------------------------------------------------------------
    */

    const updateProduct = (product) => {
        const normalizedProduct =
            normalizeProduct(product);

        if (!normalizedProduct) {
            return;
        }

        const index = products.value.findIndex(
            (item) => item.id === normalizedProduct.id
        );

        if (index === -1) {
            return;
        }

        products.value[index] = normalizedProduct;
    };

    /*
    |--------------------------------------------------------------------------
    | Remove product
    |--------------------------------------------------------------------------
    */

    const removeProduct = (productId) => {
        products.value = products.value.filter(
            (item) => item.id !== productId
        );
    };

    /*
    |--------------------------------------------------------------------------
    | Request
    |--------------------------------------------------------------------------
    */

    const runRequest = async (requestFn) => {
        isLoading.value = true;
        errorMessage.value = '';

        try {
            const response = await requestFn();

            setProducts(response);
        } catch (error) {
            errorMessage.value =
                error?.message ||
                'Failed to load products';

            products.value = [];
        } finally {
            isLoading.value = false;
        }
    };

    /*
    |--------------------------------------------------------------------------
    | Load all products
    |--------------------------------------------------------------------------
    */

    const loadAllProducts = async () => {
        await runRequest(() =>
            productsApi.getAll()
        );
    };

    /*
    |--------------------------------------------------------------------------
    | Load products by category
    |--------------------------------------------------------------------------
    */

    const loadProductsByCategory = async (
        categorySlug
    ) => {
        await runRequest(() =>
            productsApi.getByCategorySlug(
                categorySlug
            )
        );
    };

    /*
    |--------------------------------------------------------------------------
    | Load products by group
    |--------------------------------------------------------------------------
    */

    const loadProductsByGroup = async (
        categorySlug,
        groupSlug
    ) => {
        await runRequest(() =>
            productsApi.getByGroupSlug(
                categorySlug,
                groupSlug
            )
        );
    };

    return {
        products,
        isLoading,
        errorMessage,

        loadAllProducts,
        loadProductsByCategory,
        loadProductsByGroup,

        addProduct,
        updateProduct,
        removeProduct,
    };
};

