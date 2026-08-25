/**
 * Load product features.
 */
export const fetchProductFeatures = async (productId) => {
    const response = await fetch(
        `/api/products/${productId}/features`,
        {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        },
    );

    if (!response.ok) {
        throw new Error(
            `Failed to load product features: ${response.status}`,
        );
    }

    return response.json();
};