import { fetchJsonApi } from './fetchJsonApi.js';

const BASE_URL =
    '/api/products/item';

/*
|--------------------------------------------------------------------------
| Product compatibilities API
|--------------------------------------------------------------------------
*/

export const productCompatibilitiesApi = {
    /**
     * Load compatible products and product options.
     */
    async index(
        productId,
        search = '',
    ) {
        if (!productId) {
            throw new Error(
                'Product ID is required.',
            );
        }

        const params =
            new URLSearchParams();

        if (search.trim()) {
            params.set(
                'search',
                search.trim(),
            );
        }

        const query =
            params.toString();

        const url =
            `${BASE_URL}/${productId}/compatibilities` +
            (query ? `?${query}` : '');

        return fetchJsonApi(url);
    },

    /**
     * Attach compatible product.
     */
    async attach(
        productId,
        compatibleProductId,
    ) {
        if (
            !productId ||
            !compatibleProductId
        ) {
            throw new Error(
                'Product IDs are required.',
            );
        }

        return fetchJsonApi(
            `${BASE_URL}/${productId}/compatibilities/${compatibleProductId}`,
            {
                method: 'POST',
            },
        );
    },

    /**
     * Detach compatible product.
     */
    async detach(
        productId,
        compatibleProductId,
    ) {
        if (
            !productId ||
            !compatibleProductId
        ) {
            throw new Error(
                'Product IDs are required.',
            );
        }

        return fetchJsonApi(
            `${BASE_URL}/${productId}/compatibilities/${compatibleProductId}`,
            {
                method: 'DELETE',
            },
        );
    },
};

