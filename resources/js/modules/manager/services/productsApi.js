import { fetchJsonApi } from '../../site/services/fetchJsonApi';

const BASE_URL = '/api/products/item';

let productsCache = null;
let productsRequest = null;

export const productsApi = {
    async getProducts({ force = false } = {}) {
        if (productsCache && !force) {
            return productsCache;
        }

        if (productsRequest && !force) {
            return productsRequest;
        }

        productsRequest = fetchJsonApi(BASE_URL)
            .then((response) => {
                const products = Array.isArray(response)
                    ? response
                    : response?.data ?? [];

                productsCache = products;

                return products;
            })
            .finally(() => {
                productsRequest = null;
            });

        return productsRequest;
    },

    clearCache() {
        productsCache = null;
    },
};