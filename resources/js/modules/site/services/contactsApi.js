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

export const contactsApi = {
    async getPhones() {
        return fetchJson('/api/contacts/phones');
    },
    async addPhone(data) {
        return fetchJson('/api/contacts/phones', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });
    },
    async updatePhone(data) {
        return fetchJson(`/api/contacts/phones/${data.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });
    },
    async deletePhone(id) {
        return fetchJson(`/api/contacts/phones/${id}`, {
            method: 'DELETE',
        });
    },
    async getEmails() {
        return fetchJson('/api/contacts/emails');
    },
    async addEmail(emailData) {
        return fetchJson('/api/contacts/emails', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(emailData),
        });
    },
    async deleteEmail(id) {
        return fetchJson(`/api/contacts/emails/${id}`, {
            method: 'DELETE',
        });
    },
    async updateEmail(data) {
        return fetchJson(`/api/contacts/emails/${data.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });
    },
    async getOperatingHours() {
        return fetchJson('/api/contacts/operating-hours');
    },
    async addOperatingHours(data) {
        return fetchJson('/api/contacts/operating-hours', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });
    },

    async updateOperatingHours(data) {
        return fetchJson(`/api/contacts/operating-hours/${data.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });
    },

    async deleteOperatingHours(id) {
        return fetchJson(`/api/contacts/operating-hours/${id}`, {
            method: 'DELETE',
        });
    },
    
    async getSocialMedia() {
        return fetchJson('/api/contacts/social-media');
    },
    async getDepartments() {
        return fetchJson('/api/contacts/departments').then(departments => departments.map(department => ({
            id: department.id,
            value: department.department_name,
        })));
    },
};
