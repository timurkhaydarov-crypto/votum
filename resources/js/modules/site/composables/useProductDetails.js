import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import { productsApi } from '../services/productsApi.js';
import { normalizeProduct } from '../utils/productNormalizer.js';

export const useProductDetails = () => {
    const { locale } = useI18n();

    const product = ref(null);
    const isLoading = ref(false);
    const isNotFound = ref(false);
    const errorMessage = ref('');

    const loadProductById = async (productId) => {
        isLoading.value = true;
        isNotFound.value = false;
        errorMessage.value = '';

        try {
            const response = await productsApi.getById(productId);
            product.value = normalizeProduct(response, locale.value);
        } catch (error) {
            product.value = null;

            if (error?.status === 404) {
                isNotFound.value = true;
                return;
            }

            errorMessage.value = error?.message || 'Failed to load product';
        } finally {
            isLoading.value = false;
        }
    };

    return {
        product,
        isLoading,
        isNotFound,
        errorMessage,
        loadProductById,
    };
};