import { fetchJsonApi } from './fetchJsonApi';

const PRODUCT_API_URL = '/api/products';

export const productsApi = {
    getAll() {
        return fetchJsonApi(
            `${PRODUCT_API_URL}/item`
        );
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
        return fetchJsonApi(
            `${PRODUCT_API_URL}/item`,
            {
                method: 'POST',
                body: JSON.stringify(payload),
            }
        );
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

    /*
    |--------------------------------------------------------------------------
    | Product features
    |--------------------------------------------------------------------------
    */

    getFeatures(productId) {
        return fetchJsonApi(
            `${PRODUCT_API_URL}/${encodeURIComponent(productId)}/features`
        );
    },

    updateFeatures(productId, payload) {
        return fetchJsonApi(
            `${PRODUCT_API_URL}/item/${encodeURIComponent(productId)}/features`,
            {
                method: 'PUT',
                body: JSON.stringify(payload),
            }
        );
    },

    /*
    |--------------------------------------------------------------------------
    | Features gallery
    |--------------------------------------------------------------------------
    */

    createFeaturesGallery(
        productId,
        file,
        title
    ) {
        const formData =
            new FormData();

        formData.append(
            'image',
            file
        );

        formData.append(
            'title[ru]',
            title?.ru ?? ''
        );

        formData.append(
            'title[en]',
            title?.en ?? ''
        );

        return fetchJsonApi(
            `${PRODUCT_API_URL}/item/${encodeURIComponent(productId)}/features/gallery`,
            {
                method: 'POST',
                body: formData,
            }
        );
    },

    updateFeaturesGallery(
        productId,
        galleryId,
        payload
    ) {
        return fetchJsonApi(
            `${PRODUCT_API_URL}/item/${encodeURIComponent(productId)}/features/gallery/${encodeURIComponent(galleryId)}`,
            {
                method: 'PUT',
                body: JSON.stringify(
                    payload
                ),
            }
        );
    },

    deleteFeaturesGallery(
        productId,
        galleryId
    ) {
        return fetchJsonApi(
            `${PRODUCT_API_URL}/item/${encodeURIComponent(productId)}/features/gallery/${encodeURIComponent(galleryId)}`,
            {
                method: 'DELETE',
            }
        );
    },

    /*
    |--------------------------------------------------------------------------
    | Specifications
    |--------------------------------------------------------------------------
    */

    getSpecifications(productId) {
        return fetchJsonApi(
            `${PRODUCT_API_URL}/${encodeURIComponent(productId)}/specifications`
        );
    },

    createSpecification(
        productId,
        payload
    ) {
        return fetchJsonApi(
            `${PRODUCT_API_URL}/item/${encodeURIComponent(productId)}/specifications`,
            {
                method: 'POST',
                body: JSON.stringify(
                    payload
                ),
            }
        );
    },

    updateSpecification(
        productId,
        specificationId,
        payload
    ) {
        return fetchJsonApi(
            `${PRODUCT_API_URL}/item/${encodeURIComponent(productId)}/specifications/${encodeURIComponent(specificationId)}`,
            {
                method: 'PUT',
                body: JSON.stringify(
                    payload
                ),
            }
        );
    },

    deleteSpecification(
        productId,
        specificationId
    ) {
        return fetchJsonApi(
            `${PRODUCT_API_URL}/item/${encodeURIComponent(productId)}/specifications/${encodeURIComponent(specificationId)}`,
            {
                method: 'DELETE',
            }
        );
    },
};