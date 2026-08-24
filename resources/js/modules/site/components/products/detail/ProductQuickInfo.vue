<template>
    <div>
        <!-- ARTICLE / STOCK -->
        <div class="flex flex-wrap items-center gap-2">
            <span
                class="text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-400"
            >
                {{ product.article || $t('product.articleFallback') }}
            </span>

            <span
                class="h-0.5 w-0.5 rounded-full bg-slate-300"
            ></span>

            <span
                :class="[
                    'inline-flex items-center gap-1.5 text-[10px] font-semibold',
                    isInStock
                        ? 'text-emerald-600'
                        : 'text-slate-400',
                ]"
            >
                <span
                    :class="[
                        'h-1.5 w-1.5 rounded-full',
                        isInStock
                            ? 'bg-emerald-500'
                            : 'bg-slate-300',
                    ]"
                ></span>

                {{
                    isInStock
                        ? $t('product.inStock')
                        : $t('product.outOfStock')
                }}
            </span>
        </div>

        <!-- TITLE -->
        <h1
            class="mt-3 max-w-2xl text-2xl font-bold leading-tight tracking-[-0.025em] text-slate-900 sm:text-[1.75rem]"
        >
            {{ product.name || $t('product.noName') }}
        </h1>

        <!-- DESCRIPTION -->
        <p class="mt-3 max-w-xl text-sm leading-6 text-slate-500">
            {{
                product.shortDescription ||
                $t('product.defaultDescription')
            }}
        </p>

        <div class="my-5 h-px bg-slate-200"></div>

        <!-- INFO NAVIGATION -->
        <div class="grid grid-cols-2 gap-2.5">
            <InfoItem
                v-for="item in infoItems"
                :key="item.key"
                :label="item.label()"
                :value="item.value()"
                :icon="item.icon"
                @select="handleInfoSelect(item.key)"
            />
        </div>
    </div>
</template>

<script setup>
import { useI18n } from 'vue-i18n';

import InfoItem from './InfoItem.vue';

const { t } = useI18n();

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },

    isInStock: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits([
    'changeInfo',
]);

const handleInfoSelect = (key) => {
    console.log('ProductQuickInfo → changeInfo:', key);

    emit('changeInfo', key);
};

const infoItems = [
    {
        key: 'details',

        label: () => t(
            'product.info.details.title',
        ),

        icon: 'bi-info-circle',

        value: () => '',
    },

    {
        key: 'features',

        label: () => t(
            'product.info.features.title',
        ),

        icon: 'bi-stars',

        value: () =>
            props.product.features?.length ||
            props.product.functionalFeatures?.length
                ? t('product.info.available')
                : t('product.info.notAvailable'),
    },

    {
        key: 'technical',

        label: () => t(
            'product.info.technical.title',
        ),

        icon: 'bi-sliders',

        value: () =>
            props.product.frequency ||
            props.product.display ||
            props.product.channels
                ? t('product.info.available')
                : t('product.info.notAvailable'),
    },

    {
        key: 'documentation',

        label: () => t(
            'product.info.documentation.title',
        ),

        icon: 'bi-file-earmark-text',

        value: () =>
            props.product.documentationUrl ||
            props.product.characteristicsUrl ||
            props.product.technicalSpecificationsUrl
                ? t('product.info.available')
                : t('product.info.notAvailable'),
    },
];
</script>