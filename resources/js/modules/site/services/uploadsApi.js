import { fetchJsonApi } from './fetchJsonApi';

const UPLOAD_API_URL = '/api/uploads';

export const uploadsApi = {
    async upload(file, type) {
        const formData = new FormData();

        formData.append('file', file);
        formData.append('type', type);

        return fetchJsonApi(UPLOAD_API_URL, {
            method: 'POST',
            body: formData,
        });
    },

    async remove(token) {
        return fetchJsonApi(
            `${UPLOAD_API_URL}/${encodeURIComponent(token)}`,
            {
                method: 'DELETE',
            },
        );
    },
};