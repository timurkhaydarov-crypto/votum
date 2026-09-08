import { computed, ref } from 'vue';
import { cartApi } from '../services/cartApi';

/**
 * Cart state.
 *
 * Shared between all components that use useCart().
 */
const items = ref([]);
const loading = ref(false);
const error = ref(null);
const initialized = ref(false);

/**
 * Product ID currently being added.
 *
 * Only the button for this product should show loading state.
 */
const addingProductId = ref(null);

/**
 * Product ID currently being updated.
 */
const updatingProductId = ref(null);

/**
 * Product ID currently being removed.
 */
const removingProductId = ref(null);

/**
 * Whether the whole cart is currently being cleared.
 */
const clearing = ref(false);

/**
 * Set cart state from API response.
 */
const setCart = (data) => {
    items.value = data?.items ?? [];
};

/**
 * Load current cart.
 */
const fetchCart = async () => {
    loading.value = true;
    error.value = null;

    try {
        const data = await cartApi.index();

        setCart(data);
        initialized.value = true;

        return data;
    } catch (err) {
        error.value =
            err?.message || 'Failed to load cart.';

        throw err;
    } finally {
        loading.value = false;
    }
};

/**
 * Add product to cart.
 *
 * If the product already exists,
 * backend increases its quantity.
 */
const add = async (productId, quantity = 1) => {
    if (isProductAdding(productId)) {
        return null;
    }

    addingProductId.value = Number(productId);
    error.value = null;

    try {
        const data = await cartApi.store({
            product_id: productId,
            quantity,
        });

        /*
         * Update local cart from the response instead of
         * making another GET request.
         */
        if (data?.item) {
            const existingIndex = items.value.findIndex(
                (item) =>
                    Number(item.product_id) === Number(productId),
            );

            if (existingIndex !== -1) {
                items.value[existingIndex] = data.item;
            } else {
                items.value.push(data.item);
            }
        }

        initialized.value = true;

        return data;
    } catch (err) {
        error.value =
            err?.message || 'Failed to add product to cart.';

        throw err;
    } finally {
        addingProductId.value = null;
    }
};

/**
 * Update product quantity.
 *
 * quantity = 0 removes the product.
 */
const updateQuantity = async (productId, quantity) => {
    if (isProductUpdating(productId)) {
        return null;
    }

    updatingProductId.value = Number(productId);
    error.value = null;

    try {
        const data = await cartApi.update(
            productId,
            {
                quantity,
            },
        );

        /*
         * Backend returns no item when quantity becomes 0.
         */
        if (quantity === 0) {
            items.value = items.value.filter(
                (item) =>
                    Number(item.product_id) !== Number(productId),
            );

            return data;
        }

        if (data?.item) {
            const existingIndex = items.value.findIndex(
                (item) =>
                    Number(item.product_id) === Number(productId),
            );

            if (existingIndex !== -1) {
                items.value[existingIndex] = data.item;
            } else {
                items.value.push(data.item);
            }
        }

        return data;
    } catch (err) {
        error.value =
            err?.message || 'Failed to update cart item.';

        throw err;
    } finally {
        updatingProductId.value = null;
    }
};

/**
 * Remove product from cart.
 */
const remove = async (productId) => {
    if (isProductRemoving(productId)) {
        return null;
    }

    removingProductId.value = Number(productId);
    error.value = null;

    try {
        const data = await cartApi.destroy(productId);

        items.value = items.value.filter(
            (item) =>
                Number(item.product_id) !== Number(productId),
        );

        return data;
    } catch (err) {
        error.value =
            err?.message || 'Failed to remove product from cart.';

        throw err;
    } finally {
        removingProductId.value = null;
    }
};

/**
 * Clear cart through API.
 */
const clear = async () => {
    if (clearing.value) {
        return null;
    }

    clearing.value = true;
    error.value = null;

    try {
        const data = await cartApi.clear();

        items.value = [];

        return data;
    } catch (err) {
        error.value =
            err?.message || 'Failed to clear cart.';

        throw err;
    } finally {
        clearing.value = false;
    }
};

/**
 * Reset local cart state only.
 *
 * Used after a request has been successfully created.
 *
 * The backend already clears CartItems inside
 * RequestController::store(), therefore we must NOT
 * send another DELETE /api/cart request here.
 */
const resetLocal = () => {
    items.value = [];
    error.value = null;
};

/**
 * Total quantity of all products.
 *
 * Example:
 *
 * Product A × 4
 * Product B × 3
 *
 * count = 7
 */
const count = computed(() => {
    return items.value.reduce(
        (total, item) =>
            total + Number(item.quantity || 0),
        0,
    );
});

/**
 * Number of different products.
 *
 * Example:
 *
 * Product A × 4
 * Product B × 3
 *
 * itemCount = 2
 */
const itemCount = computed(() => {
    return items.value.length;
});

/**
 * Check whether product exists in cart.
 */
const has = (productId) => {
    return items.value.some(
        (item) =>
            Number(item.product_id) === Number(productId),
    );
};

/**
 * Get cart item by product ID.
 */
const getItem = (productId) => {
    return (
        items.value.find(
            (item) =>
                Number(item.product_id) === Number(productId),
        ) ?? null
    );
};

/**
 * Check whether product is currently being added.
 *
 * Used by AddToRequestButton.vue.
 */
const isProductAdding = (productId) => {
    return (
        addingProductId.value !== null &&
        Number(addingProductId.value) === Number(productId)
    );
};

/**
 * Check whether product is currently being updated.
 */
const isProductUpdating = (productId) => {
    return (
        updatingProductId.value !== null &&
        Number(updatingProductId.value) === Number(productId)
    );
};

/**
 * Check whether product is currently being removed.
 */
const isProductRemoving = (productId) => {
    return (
        removingProductId.value !== null &&
        Number(removingProductId.value) === Number(productId)
    );
};

export function useCart() {
    return {
        // State
        items,
        loading,
        error,
        initialized,

        // Operation state
        addingProductId,
        updatingProductId,
        removingProductId,
        clearing,

        // Computed
        count,
        itemCount,

        // Actions
        fetchCart,
        add,
        updateQuantity,
        remove,
        clear,
        resetLocal,

        // Helpers
        has,
        getItem,

        // Operation helpers
        isProductAdding,
        isProductUpdating,
        isProductRemoving,
    };
}