import { fetchJsonApi } from './fetchJsonApi';

export const cartApi = {
    index() {
        return fetchJsonApi('/api/cart');
    },

    store(data) {
        return fetchJsonApi('/api/cart/items', {
            method: 'POST',
            body: JSON.stringify(data),
        });
    },

    update(productId, data) {
        return fetchJsonApi(
            `/api/cart/items/${encodeURIComponent(productId)}`,
            {
                method: 'PATCH',
                body: JSON.stringify(data),
            }
        );
    },

    destroy(productId) {
        return fetchJsonApi(
            `/api/cart/items/${encodeURIComponent(productId)}`,
            {
                method: 'DELETE',
            }
        );
    },

    clear() {
        return fetchJsonApi('/api/cart', {
            method: 'DELETE',
        });
    },
};