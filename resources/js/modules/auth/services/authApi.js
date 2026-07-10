async function postJson(url, payload) {
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify(payload),
        credentials: 'same-origin',
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

export const authApi = {
    login(payload) {
        return postJson('/login', payload);
    },
    register(payload) {
        return postJson('/register', payload);
    },
    forgotPassword(payload) {
        return postJson('/forgot-password', payload);
    },
    resetPassword(payload) {
        return postJson('/reset-password', payload);
    },
};
