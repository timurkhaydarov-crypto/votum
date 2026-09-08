import { fetchJsonApi } from './fetchJsonApi';

/**
 * Load product features.
 */
export const fetchProductFeatures = (productId) => {
    return fetchJsonApi(
        `/api/products/${encodeURIComponent(productId)}/features`,
    );
};

/**
 * Load product specifications.
 */
export const fetchProductSpecifications = (productId) => {
    return fetchJsonApi(
        `/api/products/${encodeURIComponent(productId)}/specifications`,
    );
};