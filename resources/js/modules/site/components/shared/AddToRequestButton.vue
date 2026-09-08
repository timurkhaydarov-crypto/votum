<template>
    <button
        type="button"
        :disabled="isAdding || isInCart"
        class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg px-4 py-2.5 text-xs font-semibold shadow-sm transition-all duration-200 active:scale-[0.98]"
        :class="
            isInCart
                ? 'cursor-default bg-slate-100 text-slate-500'
                : 'bg-slate-900 text-white hover:bg-slate-800 hover:shadow-md disabled:cursor-not-allowed disabled:opacity-60'
        "
        @click="handleAdd"
    >
        <i
            v-if="isAdding"
            class="bi bi-arrow-repeat animate-spin text-sm"
        ></i>

        <i
            v-else-if="isInCart"
            class="bi bi-check-lg text-sm"
        ></i>

        <i
            v-else
            class="bi bi-cart3 text-sm"
        ></i>

        <span>
            {{
                isAdding
                    ? t('cart.adding')
                    : isInCart
                        ? t('cart.inCart')
                        : t('cart.add')
            }}
        </span>
    </button>
</template>

<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { useCart } from '../../composables/useCart';

const props = defineProps({
    productId: {
        type: [Number, String],
        required: true,
    },

    quantity: {
        type: Number,
        default: 1,
    },
});

const { t } = useI18n();

const {
    add,
    has,
    isProductAdding,
} = useCart();

const isInCart = computed(() => {
    return has(props.productId);
});

const isAdding = computed(() => {
    return isProductAdding(props.productId);
});

const handleAdd = async () => {
    if (isInCart.value || isAdding.value) {
        return;
    }

    try {
        await add(
            props.productId,
            props.quantity,
        );
    } catch (error) {
        console.error(
            'Failed to add product to request:',
            error,
        );
    }
};
</script>

