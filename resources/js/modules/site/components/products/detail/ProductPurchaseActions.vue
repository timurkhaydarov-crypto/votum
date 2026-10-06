<template>
    <div class="mt-3">
        <div
            class="mb-2 text-[9px] font-semibold uppercase tracking-[0.15em] text-slate-400"
        >
            {{ t('productCard.price') }}
        </div>

        <div
            class="flex flex-col gap-2.5 sm:flex-row sm:items-center"
        >
            <div
                class="shrink-0 text-xl font-bold tracking-tight text-slate-900"
            >
                {{t('common.byRequest')}}
            </div>

            <div
                class="hidden h-7 w-px bg-slate-200 sm:block"
            ></div>

            <AddToRequestButton
            v-if="product.status"
                :product-id="product.id"
            />
        </div>
    </div>
</template>

<script setup>
import { useI18n } from 'vue-i18n';
import AddToRequestButton from '../../../components/shared/AddToRequestButton.vue';

const { t } = useI18n();

defineProps({
    isInStock: {
        type: Boolean,
        default: false,
    },

    backLink: {
        type: String,
        default: '/products',
    },

    backLabel: {
        type: String,
        default: '',
    },

    product: {
        type: Object,
        required: true,
    },
});
</script>

