// function getCsrfToken() {
//     return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
// }

// async function fetchJson(url, options = {}) {
//     const headers = {
//         Accept: 'application/json',
//         'Content-Type': 'application/json',
//         'X-Requested-With': 'XMLHttpRequest',
//         ...options.headers,
//     };

//     const csrfToken = getCsrfToken();
//     if (csrfToken) {
//         headers['X-CSRF-TOKEN'] = csrfToken;
//     }

//     const response = await fetch(url, {
//         credentials: 'same-origin',
//         ...options,
//         headers,
//     });

//     const data = await response.json().catch(() => ({}));

//     if (!response.ok) {
//         const error = new Error(data?.message || 'Request failed');
//         error.status = response.status;
//         error.errors = data?.errors || {};
//         throw error;
//     }

//     return data;
// }

import { fetchJsonApi } from './fetchJsonApi';

export const productsApi = {
    getAll() {
        return fetchJsonApi('/api/products/item');
    },

    getById(productId) {
        return fetchJsonApi(`/api/products/item/${encodeURIComponent(productId)}`);
    },

    getByCategorySlug(categorySlug) {
        return fetchJsonApi(`/api/products/category/${encodeURIComponent(categorySlug)}`);
    },

    getByGroupSlug(categorySlug, groupSlug) {
        return fetchJsonApi(`/api/products/category/${encodeURIComponent(categorySlug)}/group/${encodeURIComponent(groupSlug)}`);
    },
};
