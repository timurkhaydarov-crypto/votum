function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}

async function fetchJson(url, options = {}) {
    const headers = {
        Accept: 'application/json',
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

async function postJson(url, payload) {
    return fetchJson(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(payload),
    });
}

export const authApi = {
    login(payload) {
        return postJson('/auth/login', payload);
    },
    register(payload) {
        return postJson('/auth/register', payload);
    },
    forgotPassword(payload) {
        return postJson('/auth/forgot-password', payload);
    },
    resetPassword(payload) {
        return postJson('/auth/reset-password', payload);
    },
    async me() {
        return fetchJson('/api/user');
    },
    async logout() {
        return postJson('/auth/logout', {});
    },
};
