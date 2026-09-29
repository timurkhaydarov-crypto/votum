import { fetchJsonApi } from './fetchJsonApi';

export const productCertificatesApi = {
    index(params = {}) {
        const query = new URLSearchParams();

        if (params.search) {
            query.set('search', params.search);
        }

        const queryString = query.toString();

        return fetchJsonApi(`/api/products/certificates${queryString ? `?${queryString}` : ''}`);
    },

    productCertificates(productId) {
        return fetchJsonApi(`/api/products/item/${encodeURIComponent(productId)}/certificates`);
    },

    attach(productId, certificateId) {
        return fetchJsonApi(
            `/api/products/item/${encodeURIComponent(productId)}/certificates/${encodeURIComponent(
                certificateId
            )}`,
            {
                method: 'POST',
            }
        );
    },

    detach(productId, certificateId) {
        return fetchJsonApi(
            `/api/products/item/${encodeURIComponent(productId)}/certificates/${encodeURIComponent(
                certificateId
            )}`,
            {
                method: 'DELETE',
            }
        );
    },

    store(productId, formData) {
        return fetchJsonApi(`/api/products/item/${encodeURIComponent(productId)}/certificates`, {
            method: 'POST',
            body: formData,
        });
    },

    update(certificateId, formData) {
        return fetchJsonApi(`/api/products/certificates/${encodeURIComponent(certificateId)}`, {
            method: 'POST',
            body: formData,
        });
    },

    delete(certificateId) {
        return fetchJsonApi(`/api/products/certificates/${encodeURIComponent(certificateId)}`, {
            method: 'DELETE',
        });
    },
};
