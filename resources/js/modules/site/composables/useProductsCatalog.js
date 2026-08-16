import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import { productsApi } from '../services/productsApi.js';
import { normalizeProducts } from '../utils/productNormalizer.js';

export const useProductsCatalog = () => {
    const { locale } = useI18n();

    const products = ref([]);
    const isLoading = ref(false);
    const errorMessage = ref('');

    const setProducts = (rawProducts) => {
        products.value = normalizeProducts(rawProducts, locale.value);
    };

    const runRequest = async (requestFn) => {
        isLoading.value = true;
        errorMessage.value = '';

        try {
            const response = await requestFn();
            setProducts(response);
        } catch (error) {
            errorMessage.value = error?.message || 'Failed to load products';
            products.value = [];
        } finally {
            isLoading.value = false;
        }
    };

    const loadAllProducts = async () => {
        await runRequest(() => productsApi.getAll());
    };

    const loadProductsByCategory = async (categorySlug) => {
        await runRequest(() => productsApi.getByCategorySlug(categorySlug));
    };

    const loadProductsByGroup = async (categorySlug, groupSlug) => {
        await runRequest(() => productsApi.getByGroupSlug(categorySlug, groupSlug));
    };

    return {
        products,
        isLoading,
        errorMessage,
        loadAllProducts,
        loadProductsByCategory,
        loadProductsByGroup,
    };
};
