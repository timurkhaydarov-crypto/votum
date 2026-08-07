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

const createResourceApi = (resource) => ({
    index() {
        return fetchJson(`/api/contacts/${resource}`);
    },

    store(data) {
        return fetchJson(`/api/contacts/${resource}`, {
            method: 'POST',
            body: JSON.stringify(data),
        });
    },

    update(data) {
        return fetchJson(`/api/contacts/${resource}/${data.id}`, {
            method: 'PUT',
            body: JSON.stringify(data),
        });
    },

    destroy(id) {
        return fetchJson(`/api/contacts/${resource}/${id}`, {
            method: 'DELETE',
        });
    },
});

export const contactsApi = {
    phones: createResourceApi('phones'),
    emails: createResourceApi('emails'),
    operatingHours: createResourceApi('operating-hours'),
    socialMedia: createResourceApi('social-media'),

    getDepartments() {
        return fetchJson('/api/contacts/departments').then((departments) =>
            departments.map((department) => ({
                id: department.id,
                value: department.department_name,
            }))
        );
    },
};
