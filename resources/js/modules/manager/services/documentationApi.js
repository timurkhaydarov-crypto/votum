import { fetchJsonApi } from '../../site/services/fetchJsonApi';

const BASE_URL = '/api/documentation';

export const documentationApi = {
    /*
    |--------------------------------------------------------------------------
    | Public documentation access
    |--------------------------------------------------------------------------
    */

    access(productId, key) {
        return fetchJsonApi(`${BASE_URL}/access`, {
            method: 'POST',

            body: JSON.stringify({
                product_id: productId,
                key,
            }),
        });
    },

    openFile(fileId, key) {
        return fetch(`${BASE_URL}/files/${fileId}/open`, {
            method: 'GET',
            credentials: 'same-origin',

            headers: {
                Accept: 'application/pdf',
                'X-Documentation-Key': key,
            },
        }).then(async (response) => {
            if (!response.ok) {
                let message = 'Не удалось открыть документ.';

                try {
                    const data = await response.json();

                    if (data?.message) {
                        message = data.message;
                    }
                } catch {
                    // Response is not JSON.
                }

                const error = new Error(message);

                error.status = response.status;

                throw error;
            }

            return response.blob();
        });
    },

    /*
    |--------------------------------------------------------------------------
    | Manager — users
    |--------------------------------------------------------------------------
    */

    getUsers() {
        return fetchJsonApi(`${BASE_URL}/users`);
    },

    getUserAccesses(userId) {
        return fetchJsonApi(`${BASE_URL}/users/${userId}/accesses`);
    },

    /*
    |--------------------------------------------------------------------------
    | Manager — documentation keys
    |--------------------------------------------------------------------------
    */

    rotateUserKey(userId) {
        return fetchJsonApi(`${BASE_URL}/users/${userId}/key`, {
            method: 'POST',
            body: JSON.stringify({}),
        });
    },

    revokeUserKey(userId) {
        return fetchJsonApi(`${BASE_URL}/users/${userId}/key`, {
            method: 'DELETE',
        });
    },

    /*
    |--------------------------------------------------------------------------
    | Manager — product access
    |--------------------------------------------------------------------------
    */

    grantProduct(userId, productId, payload = {}) {
        return fetchJsonApi(`${BASE_URL}/users/${userId}/products/${productId}`, {
            method: 'POST',
            body: JSON.stringify(payload),
        });
    },

    revokeProduct(userId, productId) {
        return fetchJsonApi(`${BASE_URL}/users/${userId}/products/${productId}`, {
            method: 'DELETE',
        });
    },

    /*
    |--------------------------------------------------------------------------
    | Manager — product documents
    |--------------------------------------------------------------------------
    */

    getProductDocuments(productId) {
        return fetchJsonApi(`${BASE_URL}/products/${productId}/documents`);
    },

    createProductDocument(productId, payload) {
        return fetchJsonApi(`${BASE_URL}/products/${productId}/documents`, {
            method: 'POST',
            body: JSON.stringify(payload),
        });
    },

    updateProductDocument(productId, documentId, payload) {
        return fetchJsonApi(`${BASE_URL}/products/${productId}/documents/${documentId}`, {
            method: 'PUT',
            body: JSON.stringify(payload),
        });
    },

    deleteProductDocument(productId, documentId) {
        return fetchJsonApi(`${BASE_URL}/products/${productId}/documents/${documentId}`, {
            method: 'DELETE',
        });
    },

    /*
    |--------------------------------------------------------------------------
    | Manager — document files
    |--------------------------------------------------------------------------
    */

    uploadDocumentFile(documentId, locale, file) {
        const formData = new FormData();

        formData.append('locale', locale);

        formData.append('file', file);

        return fetchJsonApi(`${BASE_URL}/documents/${documentId}/files`, {
            method: 'POST',
            body: formData,
        });
    },

    deleteDocumentFile(documentId, fileId) {
        return fetchJsonApi(`${BASE_URL}/documents/${documentId}/files/${fileId}`, {
            method: 'DELETE',
        });
    },
};
