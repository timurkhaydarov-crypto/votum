vue
<template>
    <main class="min-h-screen bg-slate-50">
        <div
            class="mx-auto w-full max-w-7xl px-4 pb-8 pt-28 sm:px-6 sm:pb-12 sm:pt-32 lg:px-8"
        >
            <!-- HEADER -->
            <header class="mb-8">
                <div
                    class="mb-2 text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-400"
                >
                    {{ t('cart.eyebrow') }}
                </div>

                <div
                    class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"
                >
                    <div>
                        <h1
                            class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"
                        >
                            {{ t('cart.title') }}
                        </h1>

                        <p
                            class="mt-2 max-w-2xl text-sm leading-6 text-slate-500"
                        >
                            {{ t('cart.description') }}
                        </p>
                    </div>

                    <!-- CLEAR -->
                    <button
                        v-if="items.length"
                        type="button"
                        :disabled="clearing"
                        class="inline-flex w-fit items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-50"
                        @click="handleClear"
                    >
                        <i
                            v-if="clearing"
                            class="bi bi-arrow-repeat animate-spin"
                        ></i>

                        <i
                            v-else
                            class="bi bi-trash3"
                        ></i>

                        {{ t('cart.clear') }}
                    </button>
                </div>
            </header>

            <!-- LOADING -->
            <section
                v-if="loading && !initialized"
                class="flex min-h-[300px] items-center justify-center rounded-2xl border border-slate-200 bg-white"
            >
                <div
                    class="flex items-center gap-3 text-sm text-slate-500"
                >
                    <i
                        class="bi bi-arrow-repeat animate-spin text-lg"
                    ></i>

                    {{ t('cart.loading') }}
                </div>
            </section>

            <!-- EMPTY -->
            <EmptyCart
                v-else-if="items.length === 0"
            />

            <!-- CART -->
            <div
                v-else
                class="grid grid-cols-1 gap-6 lg:grid-cols-[minmax(0,1fr)_360px] lg:items-start"
            >
                <!-- ITEMS -->
                <section class="min-w-0 space-y-4">
                    <CartItem
                        v-for="item in items"
                        :key="item.id"
                        :item="item"
                    />
                </section>

                <!-- SUMMARY -->
                <aside
                    class="lg:sticky lg:top-28 lg:self-start"
                >
                    <CartSummary
                        @checkout="handleCheckout"
                    />
                </aside>
            </div>
        </div>

        <!-- REQUEST MODAL -->
        <RequestModal
            v-if="requestModalOpen"
            :with-products="true"
            subject="Запрос на оборудование"
            context="cart"
            @close="handleCloseRequestModal"
            @success="handleRequestSuccess"
        />
    </main>
</template>

<script setup>
import {
    onMounted,
    ref,
} from 'vue';

import { useI18n } from 'vue-i18n';

import { useCart } from '../composables/useCart';

import CartItem from '../components/cart/CartItem.vue';
import CartSummary from '../components/cart/CartSummary.vue';
import EmptyCart from '../components/cart/EmptyCart.vue';
import RequestModal from '../components/request/RequestModal.vue';

const { t } = useI18n();

const {
    items,
    loading,
    initialized,
    clearing,
    fetchCart,
    clear,
} = useCart();

/**
 * Request modal state.
 */
const requestModalOpen = ref(false);

/**
 * Clear entire cart.
 */
const handleClear = async () => {
    if (clearing.value) {
        return;
    }

    try {
        await clear();
    } catch (error) {
        console.error(
            'Failed to clear cart:',
            error,
        );
    }
};

/**
 * Open request modal.
 */
const handleCheckout = () => {
    if (!items.value.length) {
        return;
    }

    requestModalOpen.value = true;
};

/**
 * Close request modal.
 */
const handleCloseRequestModal = () => {
    requestModalOpen.value = false;
};

/**
 * Request successfully created.
 *
 * RequestController clears the cart on the server.
 * RequestForm resets the local cart state.
 * After successful creation we close the modal.
 */
const handleRequestSuccess = (data) => {
    console.log(
        'Request created successfully:',
        data,
    );

    requestModalOpen.value = false;
};

/**
 * Load cart on page mount.
 */
onMounted(async () => {
    if (initialized.value) {
        return;
    }

    try {
        await fetchCart();
    } catch (error) {
        console.error(
            'Failed to load cart:',
            error,
        );
    }
});
</script>

