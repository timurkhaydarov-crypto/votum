<template>
    <div>
        <!-- ARTICLE / STOCK -->
        <div class="flex flex-wrap items-center gap-2">
            <span
                class="text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-400"
            >
                {{
                    product.article ||
                    $t('product.articleFallback')
                }}
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
        <div class="mt-3 flex items-center gap-3">
            <h1
                class="max-w-2xl text-2xl font-bold leading-tight tracking-[-0.025em] text-slate-900 sm:text-[1.75rem]"
            >
                {{
                    product.name ||
                    $t('product.noName')
                }}
            </h1>

            <!-- PDF -->
            <a
                v-if="hasPdf"
                :href="pdfSrc"
                target="_blank"
                rel="noopener noreferrer"
                class="relative top-[1px] flex h-8 w-8 shrink-0 cursor-pointer items-center justify-center text-slate-400 transition-colors duration-200 hover:text-red-500"
                :title="$t('product.pdf')"
                :aria-label="$t('product.pdf')"
            >
                <i
                    class="bi bi-file-earmark-pdf block text-[20px] leading-none"
                ></i>
            </a>
        </div>

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
                :disabled="item.disabled()"
                :can-manage="canManage"
                :no-data-label="$t('common.notAvailable')"
                :add-label="$t('actions.add')"
                :edit-label="$t('actions.edit')"
                @select="handleInfoSelect(item.key)"
                @manage="handleInfoManage(item.key)"
            />
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

import InfoItem from './InfoItem.vue';

const { t, locale } = useI18n();

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },

    isInStock: {
        type: Boolean,
        default: false,
    },

    canManage: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits([
    'changeInfo',
    'manageInfo',
]);

/*
|--------------------------------------------------------------------------
| PDF
|--------------------------------------------------------------------------
*/

const hasPdf = computed(() => {
    return Boolean(
        props.product.pdfUrl?.[locale.value]
    );
});

const pdfSrc = computed(() => {
    if (!hasPdf.value) {
        return '';
    }

    return `/document/specification/${locale.value}/${props.product.imageUrl}.pdf`;
});

/*
|--------------------------------------------------------------------------
| INFO NAVIGATION
|--------------------------------------------------------------------------
*/

const handleInfoSelect = (key) => {
    const item = infoItems.find(
        (item) => item.key === key
    );

    if (!item || item.disabled()) {
        return;
    }

    emit('changeInfo', key);
};

const handleInfoManage = (key) => {
    if (!props.canManage) {
        return;
    }

    emit('manageInfo', {
        key,
        product: props.product,
    });
};

/*
|--------------------------------------------------------------------------
| INFO ITEMS
|--------------------------------------------------------------------------
*/

const infoItems = [
    {
        key: 'details',

        label: () =>
            t('product.info.details.title'),

        icon: 'bi-info-circle',

        value: () =>
            props.product.fullDescription
                ? t('common.more')
                : '',

        disabled: () => false,
    },

    {
        key: 'features',

        label: () =>
            t('product.info.features.title'),

        icon: 'bi-stars',

        value: () =>
            props.product.hasFeatures
                ? t('common.more')
                : '',

        disabled: () =>
            !props.product.hasFeatures,
    },

    {
        key: 'specifications',

        label: () =>
            t('product.info.specifications.title'),

        icon: 'bi-sliders',

        value: () =>
            props.product.hasSpecifications
                ? t('common.more')
                : '',

        disabled: () =>
            !props.product.hasSpecifications,
    },

    {
        key: 'documentation',

        label: () =>
            t('product.info.documentation.title'),

        icon: 'bi-file-earmark-text',

        /*
         * Документация теперь открывается через
         * ключ доступа.
         *
         * Поэтому наличие старых URL:
         * documentationUrl
         * characteristicsUrl
         * technicalSpecificationsUrl
         *
         * больше не определяет активность пункта.
         */
        value: () =>
            t('common.available'),

        disabled: () => false,
    },
];
</script>

