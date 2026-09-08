function getXsrfToken() {
    const match = document.cookie.match(
        /(?:^|;\s*)XSRF-TOKEN=([^;]+)/
    );

    return match
        ? decodeURIComponent(match[1])
        : null;
}

async function ensureCsrfCookie() {
    const response = await fetch('/sanctum/csrf-cookie', {
        method: 'GET',
        credentials: 'same-origin',
        headers: {
            Accept: 'application/json',
        },
    });

    if (!response.ok) {
        throw new Error('Failed to initialize CSRF protection.');
    }
}

export async function fetchJsonApi(url, options = {}) {
    const method = (options.method || 'GET').toUpperCase();

    if (['POST', 'PUT', 'PATCH', 'DELETE'].includes(method)) {
        await ensureCsrfCookie();
    }

    const headers = {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        ...options.headers,
    };

    const xsrfToken = getXsrfToken();

    if (xsrfToken) {
        headers['X-XSRF-TOKEN'] = xsrfToken;
    }

    const response = await fetch(url, {
        credentials: 'same-origin',
        ...options,
        headers,
    });

    const data = await response.json().catch(() => ({}));

    if (!response.ok) {
        const error = new Error(
            data?.message || 'Request failed'
        );

        error.status = response.status;
        error.errors = data?.errors || {};

        throw error;
    }

    return data;
}