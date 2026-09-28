<template>
    <div class="space-y-6">
        <div>
            <h3 class="text-base font-semibold text-slate-900">
                {{ $t('compatibleProducts.title') }}
            </h3>

            <p class="mt-1 text-sm leading-6 text-slate-500">
                {{ $t('compatibleProducts.description') }}
            </p>
        </div>

        <!-- Manager -->
        <div
            v-if="isManager"
            class="space-y-3"
        >
            <select
                :value="modelValue"
                multiple
                class="min-h-[280px] w-full rounded-xl border border-slate-300 bg-white px-3 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                @change="updateSelection"
            >
                <option
                    v-for="option in options"
                    :key="option.id"
                    :value="option.id"
                >
                    {{ getLabel(option) }}
                </option>
            </select>

            <div class="text-xs text-slate-400">
                {{ modelValue?.length ?? 0 }}
            </div>
        </div>

        <!-- Readonly -->
        <div
            v-else-if="selectedProducts.length"
            class="space-y-3"
        >
            <div
                v-for="product in selectedProducts"
                :key="product.id"
                class="flex items-center justify-between gap-4 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3"
            >
                <span class="text-sm font-medium text-slate-800">
                    {{ getLabel(product) }}
                </span>
            </div>
        </div>

        <!-- Empty -->
        <div
            v-else
            class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-5 py-10 text-center"
        >
            <i class="bi bi-box-seam text-2xl text-slate-300"></i>

            <h4 class="mt-3 text-sm font-semibold text-slate-700">
                {{ $t('compatibleProducts.empty.title') }}
            </h4>

            <p class="mt-1 text-sm text-slate-500">
                {{ $t('compatibleProducts.empty.text') }}
            </p>
        </div>
    </div>
</template>

<script setup>
import { useI18n } from 'vue-i18n';

const { locale, t } = useI18n();

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => [],
    },

    options: {
        type: Array,
        default: () => [],
    },

    selectedProducts: {
        type: Array,
        default: () => [],
    },

    isManager: {
        type: Boolean,
        default: false,
    },

    getProductLabel: {
        type: Function,
        default: null,
    },
});

const emit = defineEmits([
    'update:modelValue',
]);

function getLabel(product) {
    if (props.getProductLabel) {
        return props.getProductLabel(product);
    }

    const name = product?.name;

    let localizedName = '';

    if (typeof name === 'string') {
        localizedName = name;
    } else if (name) {
        localizedName =
            name[locale.value] ??
            name.ru ??
            name.en ??
            '';
    }

    if (product?.article && localizedName) {
        return `${product.article} — ${localizedName}`;
    }

    return (
        localizedName ||
        product?.article ||
        `#${product?.id ?? ''}`
    );
}

function updateSelection(event) {
    const selectedIds = Array.from(
        event.target.selectedOptions,
    ).map((option) => Number(option.value));

    emit(
        'update:modelValue',
        selectedIds,
    );
}
</script>