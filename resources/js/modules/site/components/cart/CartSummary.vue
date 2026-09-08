<template>
    <aside
        class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6"
    >
        <!-- HEADER -->
        <div class="mb-5">
            <div
                class="text-[9px] font-semibold uppercase tracking-[0.15em] text-slate-400"
            >
                {{ t('cart.summary.label') }}
            </div>

            <h2
                class="mt-1 text-lg font-semibold tracking-tight text-slate-900"
            >
                {{ t('cart.summary.title') }}
            </h2>
        </div>

        <!-- INFO -->
        <div
            class="space-y-3 border-b border-slate-200 pb-5"
        >
            <!-- PRODUCTS -->
            <div
                class="flex items-center justify-between gap-4"
            >
                <span class="text-sm text-slate-500">
                    {{ t('cart.summary.products') }}
                </span>

                <span
                    class="text-sm font-semibold text-slate-900"
                >
                    {{ itemCount }}
                </span>
            </div>

            <!-- QUANTITY -->
            <div
                class="flex items-center justify-between gap-4"
            >
                <span class="text-sm text-slate-500">
                    {{ t('cart.summary.quantity') }}
                </span>

                <span
                    class="text-sm font-semibold text-slate-900"
                >
                    {{ count }}
                </span>
            </div>
        </div>

        <!-- TOTAL -->
        <div
            class="flex items-end justify-between gap-4 py-5"
        >
            <span
                class="text-sm font-medium text-slate-600"
            >
                {{ t('cart.summary.total') }}
            </span>

            <span
                class="text-2xl font-bold tracking-tight text-slate-900"
            >
                {{ count }}
            </span>
        </div>

        <!-- ACTIONS -->
        <div class="space-y-2.5">
            <!-- CLEAR -->
            <button
                type="button"
                :disabled="clearing || !itemCount"
                class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-700 transition-all duration-200 hover:border-slate-300 hover:bg-slate-50 active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-50"
                @click="handleClear"
            >
                <i
                    v-if="clearing"
                    class="bi bi-arrow-repeat animate-spin text-sm"
                ></i>

                <i
                    v-else
                    class="bi bi-trash3 text-sm"
                ></i>

                <span>
                    {{
                        clearing
                            ? t('cart.summary.clearing')
                            : t('cart.summary.clear')
                    }}
                </span>
            </button>

            <!-- CHECKOUT -->
            <button
                type="button"
                :disabled="!itemCount || clearing"
                class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-slate-900 px-4 py-3 text-xs font-semibold text-white shadow-sm transition-all duration-200 hover:bg-slate-800 hover:shadow-md active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-50"
                @click="handleCheckout"
            >
                <span>
                    {{ t('cart.summary.checkout') }}
                </span>

                <i class="bi bi-arrow-right text-sm"></i>
            </button>
        </div>
    </aside>
</template>

<script setup>
import { useI18n } from 'vue-i18n';
import { useCart } from '../../composables/useCart';

const emit = defineEmits([
    'checkout',
]);

const { t } = useI18n();

const {
    count,
    itemCount,
    clear,
    clearing,
} = useCart();

/**
 * Clear request.
 */
const handleClear = async () => {
    if (!itemCount.value || clearing.value) {
        return;
    }

    try {
        await clear();
    } catch (error) {
        console.error(
            'Failed to clear request:',
            error,
        );
    }
};

/**
 * Go to request checkout.
 */
const handleCheckout = () => {
    if (!itemCount.value || clearing.value) {
        return;
    }

    emit('checkout');
};
</script>