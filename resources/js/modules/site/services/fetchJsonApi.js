function getXsrfToken() {
    const match = document.cookie.match(
        /(?:^|;\s*)XSRF-TOKEN=([^;]+)/
    );

    return match
        ? decodeURIComponent(match[1])
        : null;
}

let csrfInitialized = false;

async function ensureCsrfCookie() {
    if (csrfInitialized) {
        return;
    }

    const response = await fetch('/sanctum/csrf-cookie', {
        method: 'GET',
        credentials: 'same-origin',
        headers: {
            Accept: 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
    });

    if (!response.ok) {
        throw new Error(
            'Failed to initialize CSRF protection.'
        );
    }

    csrfInitialized = true;
}

export async function fetchJsonApi(url, options = {}) {
    const method = (
        options.method || 'GET'
    ).toUpperCase();

    /*
    |--------------------------------------------------------------------------
    | Initialize Sanctum session / CSRF cookie
    |--------------------------------------------------------------------------
    */

    await ensureCsrfCookie();

    /*
    |--------------------------------------------------------------------------
    | Headers
    |--------------------------------------------------------------------------
    */

    const headers = {
        Accept: 'application/json',

        'X-Requested-With': 'XMLHttpRequest',

        ...options.headers,
    };

    /*
    |--------------------------------------------------------------------------
    | JSON body
    |--------------------------------------------------------------------------
    */

    if (
        options.body
        && !(options.body instanceof FormData)
        && !(options.body instanceof Blob)
    ) {
        headers['Content-Type'] = 'application/json';
    }

    /*
    |--------------------------------------------------------------------------
    | XSRF token
    |--------------------------------------------------------------------------
    */

    const xsrfToken = getXsrfToken();

    if (xsrfToken) {
        headers['X-XSRF-TOKEN'] = xsrfToken;
    }

    /*
    |--------------------------------------------------------------------------
    | Request
    |--------------------------------------------------------------------------
    */

    const response = await fetch(url, {
        ...options,

        method,

        credentials: 'same-origin',

        headers,
    });

    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    const data = await response
        .json()
        .catch(() => ({}));

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