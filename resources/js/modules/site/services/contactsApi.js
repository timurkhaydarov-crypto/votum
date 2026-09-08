import { fetchJsonApi } from './fetchJsonApi';

const createResourceApi = (resource) => ({
    index() {
        return fetchJsonApi(`/api/contacts/${resource}`);
    },

    store(data) {
        return fetchJsonApi(`/api/contacts/${resource}`, {
            method: 'POST',
            body: JSON.stringify(data),
        });
    },

    update(data) {
        return fetchJsonApi(`/api/contacts/${resource}/${data.id}`, {
            method: 'PUT',
            body: JSON.stringify(data),
        });
    },

    destroy(id) {
        return fetchJsonApi(`/api/contacts/${resource}/${id}`, {
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
        return fetchJsonApi('/api/contacts/departments').then(
            (departments) =>
                departments.map((department) => ({
                    id: department.id,
                    value: department.department_name,
                }))
        );
    },
};

export const dealersApi = {
    index() {
        return fetchJsonApi('/api/dealers');
    },

    show(id) {
        return fetchJsonApi(`/api/dealers/${id}`);
    },
};