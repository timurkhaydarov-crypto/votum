
import { fetchJsonApi } from './fetchJsonApi';

const BASE_URL = '/api/products/item';

/**
 * Get product gallery.
 */
export function fetchProductGallery(productId) {
    return fetchJsonApi(
        `${BASE_URL}/${encodeURIComponent(productId)}/gallery`
    );
}

/**
 * Create product gallery item.
 *
 * The image must be uploaded first through /api/uploads.
 */
export function createProductGallery(productId, payload) {
    return fetchJsonApi(
        `${BASE_URL}/${encodeURIComponent(productId)}/gallery`,
        {
            method: 'POST',
            body: JSON.stringify(payload),
        }
    );
}

/**
 * Update product gallery item.
 */
export function updateProductGallery(productId, galleryId, payload) {
    return fetchJsonApi(
        `${BASE_URL}/${encodeURIComponent(productId)}/gallery/${encodeURIComponent(
            galleryId
        )}`,
        {
            method: 'PUT',
            body: JSON.stringify(payload),
        }
    );
}

/**
 * Remove gallery item from product.
 *
 * Physical files are intentionally preserved by backend.
 */
export function deleteProductGallery(productId, galleryId) {
    return fetchJsonApi(
        `${BASE_URL}/${encodeURIComponent(productId)}/gallery/${encodeURIComponent(
            galleryId
        )}`,
        {
            method: 'DELETE',
        }
    );
}

