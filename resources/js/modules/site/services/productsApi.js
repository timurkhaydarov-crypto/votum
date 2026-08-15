function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}

async function fetchJson(url, options = {}) {
    const headers = {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        ...options.headers,
    };

    const csrfToken = getCsrfToken();
    if (csrfToken) {
        headers['X-CSRF-TOKEN'] = csrfToken;
    }

    const response = await fetch(url, {
        credentials: 'same-origin',
        ...options,
        headers,
    });

    const data = await response.json().catch(() => ({}));

    if (!response.ok) {
        const error = new Error(data?.message || 'Request failed');
        error.status = response.status;
        error.errors = data?.errors || {};
        throw error;
    }

    return data;
}

export const productsApi = {
    getAll() {
        return fetchJson('/api/products/item');
    },

    getById(productId) {
        return fetchJson(`/api/products/item/${encodeURIComponent(productId)}`);
    },

    getByCategorySlug(categorySlug) {
        return fetchJson(`/api/products/category/${encodeURIComponent(categorySlug)}`);
    },

    getByGroupSlug(groupSlug) {
        return fetchJson(`/api/products/group/${encodeURIComponent(groupSlug)}`);
    },
};
