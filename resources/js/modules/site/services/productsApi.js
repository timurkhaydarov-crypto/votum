import { fetchJsonApi } from './fetchJsonApi';

const PRODUCT_API_URL = '/api/products';

export const productsApi = {
    getAll() {
        return fetchJsonApi(`${PRODUCT_API_URL}/item`);
    },

    getByCategorySlug(categorySlug) {
        return fetchJsonApi(
            `${PRODUCT_API_URL}/category/${encodeURIComponent(categorySlug)}`
        );
    },

    getByGroupSlug(categorySlug, groupSlug) {
        return fetchJsonApi(
            `${PRODUCT_API_URL}/category/${encodeURIComponent(categorySlug)}/group/${encodeURIComponent(groupSlug)}`
        );
    },

    getById(productId) {
        return fetchJsonApi(
            `${PRODUCT_API_URL}/item/${encodeURIComponent(productId)}`
        );
    },

    getCreate() {
        return fetchJsonApi(
            `${PRODUCT_API_URL}/item/create`
        );
    },

    getEdit(productId) {
        return fetchJsonApi(
            `${PRODUCT_API_URL}/item/${encodeURIComponent(productId)}/edit`
        );
    },

    create(payload) {
        return fetchJsonApi(`${PRODUCT_API_URL}/item`, {
            method: 'POST',
            body: JSON.stringify(payload),
        });
    },

    update(productId, payload) {
        return fetchJsonApi(
            `${PRODUCT_API_URL}/item/${encodeURIComponent(productId)}`,
            {
                method: 'PUT',
                body: JSON.stringify(payload),
            }
        );
    },

    remove(productId) {
        return fetchJsonApi(
            `${PRODUCT_API_URL}/item/${encodeURIComponent(productId)}`,
            {
                method: 'DELETE',
            }
        );
    },
};