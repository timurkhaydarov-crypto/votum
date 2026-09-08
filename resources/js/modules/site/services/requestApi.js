import { fetchJsonApi } from './fetchJsonApi';

export const requestApi = {
    /**
     * Create request from current session cart.
     *
     * Products are NOT sent from frontend.
     * Laravel takes products and quantities
     * directly from the current session cart.
     */
    store(data) {
        return fetchJsonApi('/api/requests', {
            method: 'POST',
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