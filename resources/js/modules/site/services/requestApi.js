import { fetchJsonApi } from './fetchJsonApi';

export const requestApi = {
    /**
     * Create request from current session cart.
     *
     * Products are NOT sent from frontend.
     * Laravel takes products and quantities
     * directly from the current session cart.
     */
    store(data, locale = 'ru') {
        return fetchJsonApi('/api/requests', {
            method: 'POST',
            headers: {
                'X-App-Locale': locale,
            },
            body: JSON.stringify(data),
        });
    },

    /**
     * Get request by ID.
     */
    show(requestId) {
        return fetchJsonApi(
            `/api/requests/${encodeURIComponent(requestId)}`
        );
    },
};