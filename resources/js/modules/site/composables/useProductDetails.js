import { ref } from 'vue';
import { productsApi } from '../services/productsApi.js';
import { normalizeProduct } from '../utils/productNormalizer.js';

export const useProductDetails = () => {
    const product = ref(null);
    const isLoading = ref(false);
    const errorMessage = ref('');

    const loadProductById = async (productId) => {
        isLoading.value = true;
        errorMessage.value = '';

        try {
            const response = await productsApi.getById(productId);
            product.value = normalizeProduct(response);
        } catch (error) {
            product.value = null;
            errorMessage.value = error?.message || 'Failed to load product';
        } finally {
            isLoading.value = false;
        }
    };

    return {
        product,
        isLoading,
        errorMessage,
        loadProductById,
    };
};