<template>
    <article
        class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5"
    >
        <div class="flex gap-4">
            <!-- IMAGE -->
            <div
                class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-xl border border-slate-200 bg-slate-50 sm:h-28 sm:w-28"
            >
                <img
                    v-if="product?.image_url"
                    :src="product.image_url"
                    :alt="productName"
                    class="h-full w-full object-contain p-2"
                />

                <i
                    v-else
                    class="bi bi-image text-2xl text-slate-300"
                ></i>
            </div>

            <!-- CONTENT -->
            <div class="min-w-0 flex-1">
                <!-- ARTICLE -->
                <div
                    class="text-[9px] font-semibold uppercase tracking-[0.15em] text-slate-400"
                >
                    {{ product?.article }}
                </div>

                <!-- NAME -->
                <h3
                    class="mt-1 text-sm font-semibold leading-5 text-slate-900 sm:text-base"
                >
                    {{ productName }}
                </h3>

                <!-- QUANTITY / ACTIONS -->
                <div
                    class="mt-4 flex flex-wrap items-center gap-3"
                >
                    <!-- QUANTITY CONTROL -->
                    <div
                        class="inline-flex items-center overflow-hidden rounded-lg border border-slate-200 bg-white"
                    >
                        <!-- DECREASE -->
                        <button
                            type="button"
                            :disabled="
                                isUpdating ||
                                item.quantity <= 1
                            "
                            class="flex h-9 w-9 items-center justify-center text-slate-600 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
                            :aria-label="t('cart.decrease')"
                            @click="decrease"
                        >
                            <i class="bi bi-dash"></i>
                        </button>

                        <!-- QUANTITY -->
                        <div
                            class="flex h-9 min-w-10 items-center justify-center border-x border-slate-200 px-2 text-sm font-semibold text-slate-900"
                        >
                            <i
                                v-if="isUpdating"
                                class="bi bi-arrow-repeat animate-spin text-sm text-slate-400"
                            ></i>

                            <span v-else>
                                {{ item.quantity }}
                            </span>
                        </div>

                        <!-- INCREASE -->
                        <button
                            type="button"
                            :disabled="
                                isUpdating ||
                                !canIncrease
                            "
                            class="flex h-9 w-9 items-center justify-center text-slate-600 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
                            :aria-label="t('cart.increase')"
                            @click="increase"
                        >
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>

                    <!-- UNIT -->
                    <span
                        v-if="product?.unit"
                        class="text-xs text-slate-400"
                    >
                        {{ getUnitLabel(product.unit) }}
                    </span>

                    <!-- AVAILABLE -->
                    <span
                        v-if="
                            product?.available_quantity != null
                        "
                        class="text-xs text-slate-400"
                    >
                        {{ t('cart.item.available') }}:
                        {{ product.available_quantity }}
                    </span>
                </div>
            </div>

            <!-- REMOVE -->
            <button
                type="button"
                :disabled="isRemoving"
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-slate-400 transition hover:bg-red-50 hover:text-red-500 disabled:cursor-not-allowed disabled:opacity-50"
                :title="t('cart.remove')"
                :aria-label="t('cart.remove')"
                @click="handleRemove"
            >
                <i
                    v-if="isRemoving"
                    class="bi bi-arrow-repeat animate-spin text-sm"
                ></i>

                <i
                    v-else
                    class="bi bi-trash3 text-sm"
                ></i>
            </button>
        </div>

        <!-- LIMIT MESSAGE -->
        <div
            v-if="
                !canIncrease &&
                product?.available_quantity
            "
            class="mt-3 rounded-lg bg-slate-50 px-3 py-2 text-xs text-slate-500"
        >
            {{ t('cart.item.maxQuantity') }}
        </div>
    </article>
</template>

<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { useCart } from '../../composables/useCart';

const props = defineProps({
    item: {
        type: Object,
        required: true,
    },
});

const { t, locale } = useI18n();

const {
    updateQuantity,
    remove,
    isProductUpdating,
    isProductRemoving,
} = useCart();

const product = computed(() => {
    return props.item?.product ?? null;
});

/**
 * Localized product name.
 */
const productName = computed(() => {
    if (!product.value) {
        return '';
    }

    return (
        product.value.name?.[locale.value] ||
        product.value.name?.ru ||
        product.value.name?.en ||
        product.value.article ||
        ''
    );
});

/**
 * Product quantity update state.
 */
const isUpdating = computed(() => {
    return isProductUpdating(props.item.product_id);
});

/**
 * Product remove state.
 */
const isRemoving = computed(() => {
    return isProductRemoving(props.item.product_id);
});

/**
 * Whether product quantity can be increased.
 */
const canIncrease = computed(() => {
    const available = Number(
        product.value?.available_quantity,
    );

    /*
     * No available quantity limit.
     */
    if (
        !Number.isFinite(available) ||
        available <= 0
    ) {
        return true;
    }

    return (
        Number(props.item.quantity) < available
    );
});

/**
 * Get localized unit label.
 */
const getUnitLabel = (unit) => {
    if (unit === 'pcs') {
        return t('common.pcs');
    }

    return unit;
};

/**
 * Increase quantity.
 */
const increase = async () => {
    if (
        isUpdating.value ||
        !canIncrease.value
    ) {
        return;
    }

    try {
        await updateQuantity(
            props.item.product_id,
            Number(props.item.quantity) + 1,
        );
    } catch (error) {
        console.error(
            'Failed to increase cart item quantity:',
            error,
        );
    }
};

/**
 * Decrease quantity.
 */
const decrease = async () => {
    if (
        isUpdating.value ||
        Number(props.item.quantity) <= 1
    ) {
        return;
    }

    try {
        await updateQuantity(
            props.item.product_id,
            Number(props.item.quantity) - 1,
        );
    } catch (error) {
        console.error(
            'Failed to decrease cart item quantity:',
            error,
        );
    }
};

/**
 * Remove item from cart.
 */
const handleRemove = async () => {
    if (isRemoving.value) {
        return;
    }

    try {
        await remove(props.item.product_id);
    } catch (error) {
        console.error(
            'Failed to remove cart item:',
            error,
        );
    }
};
</script>