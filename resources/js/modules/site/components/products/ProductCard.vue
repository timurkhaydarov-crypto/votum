<template>
    <article
        class="group flex h-full min-w-0 flex-col overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-lg hover:shadow-slate-200/50"
    >
        <!-- IMAGE -->

        <div
            class="relative h-[220px] shrink-0 overflow-hidden bg-slate-50 sm:h-[230px]"
        >
            <div class="absolute inset-0">
                <img
                    :src="imageSrc"
                    :alt="productName"
                    class="h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-[1.025]"
                    loading="lazy"
                />
            </div>

            <div
                class="pointer-events-none absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-white/30 to-transparent"
            ></div>

            <!-- Group -->

            <div
                v-if="variant === 'default'"
                class="absolute left-3 top-3 z-10 max-w-[calc(100%-100px)]"
            >
                <span
                    class="inline-flex max-w-full items-center gap-1.5 rounded-lg bg-slate-900 px-2.5 py-1.5 text-[9px] font-semibold uppercase tracking-[0.08em] text-white shadow-sm"
                >
                    <span
                        class="h-1.5 w-1.5 shrink-0 rounded-full"
                        :class="groupDotClass"
                    ></span>

                    <span class="truncate">
                        {{ badgeText }}
                    </span>
                </span>
            </div>

            <!-- MANAGEMENT -->

            <div
                v-if="canManage && variant === 'default'"
                class="absolute z-auto bottom-3 right-3 z-30 flex gap-1.5"
            >
                <!-- Edit -->

                <button
                    type="button"
                    :aria-label="t('actions.edit')"
                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white/95 text-slate-600 shadow-sm backdrop-blur transition hover:border-slate-900 hover:bg-slate-900 hover:text-white active:scale-95"
                    @click="handleEdit"
                >
                    <i class="bi bi-pencil text-xs"></i>
                </button>

                <!-- Delete -->

                <button
                    type="button"
                    :aria-label="t('actions.delete')"
                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-red-200 bg-white/95 text-red-500 shadow-sm backdrop-blur transition hover:border-red-500 hover:bg-red-500 hover:text-white active:scale-95"
                    @click="handleDelete"
                >
                    <i class="bi bi-trash3 text-xs"></i>
                </button>
            </div>
        </div>

        <!-- CONTENT -->

        <div class="flex flex-1 flex-col p-4">
            <!-- Article / Stock -->

            <div class="flex items-center gap-2">
                <span
                    class="truncate text-[9px] font-medium uppercase tracking-[0.12em] text-slate-400"
                >
                    {{ product.article || '-' }}
                </span>

                <span
                    class="h-1 w-1 shrink-0 rounded-full bg-slate-300"
                ></span>

                <span
                    class="inline-flex shrink-0 items-center gap-1 text-[9px] font-semibold uppercase tracking-[0.08em]"
                    :class="
                        Number(product.quantity || 0) > 0
                            ? 'text-emerald-600'
                            : 'text-slate-400'
                    "
                >
                    <span
                        class="h-1.5 w-1.5 rounded-full"
                        :class="
                            Number(product.quantity || 0) > 0
                                ? 'bg-emerald-500'
                                : 'bg-slate-300'
                        "
                    ></span>

                    {{ inStockLabel }}
                </span>
            </div>

            <!-- Title -->

            <h3
                class="mt-2 line-clamp-2 min-h-[40px] text-base font-semibold leading-5 tracking-tight text-slate-900"
            >
                {{ productName }}
            </h3>

            <!-- Description -->

            <p
                class="mt-1.5 line-clamp-2 min-h-[72px] text-xs leading-[18px] text-slate-500"
            >
                {{ productDescription }}
            </p>

            <!-- PARAMETERS -->

            <div
                v-if="variant === 'default'"
                class="mt-4 grid grid-cols-2 gap-1.5"
            >
                <div
                    class="min-w-0 rounded-lg bg-slate-50 px-2.5 py-2"
                >
                    <div
                        class="text-[8px] font-medium uppercase tracking-[0.1em] text-slate-400"
                    >
                        {{ t('productCard.method') }}
                    </div>

                    <div
                        class="mt-0.5 truncate text-[11px] font-semibold text-slate-700"
                    >
                        {{ product.method || '-' }}
                    </div>
                </div>

                <div
                    class="min-w-0 rounded-lg bg-slate-50 px-2.5 py-2"
                >
                    <div
                        class="text-[8px] font-medium uppercase tracking-[0.1em] text-slate-400"
                    >
                        {{ t('productCard.application') }}
                    </div>

                    <div
                        class="mt-0.5 truncate text-[11px] font-semibold text-slate-700"
                    >
                        {{ categoryTitle || '-' }}
                    </div>
                </div>
            </div>

            <!-- FOOTER -->

            <div class="mt-auto pt-4">
                <div class="mb-3 h-px bg-slate-100"></div>

                <div class="flex items-center justify-between gap-3">
                    <div class="flex w-full shrink-0 gap-1.5">
                        <button
                            v-if="product.status"
                            type="button"
                            :aria-label="t('productCard.addToCart')"
                            :disabled="adding"
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 transition hover:border-slate-900 hover:bg-slate-900 hover:text-white active:scale-95 disabled:cursor-not-allowed disabled:opacity-60"
                            @click="handleAddToCart"
                        >
                            <i
                                v-if="adding"
                                class="bi bi-arrow-repeat animate-spin text-sm"
                            ></i>

                            <i
                                v-else-if="added"
                                class="bi bi-check-lg text-sm"
                            ></i>

                            <svg
                                v-else
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 3h2l2.4 11.2a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 1.9-1.4L21 7H6"
                                />

                                <circle
                                    cx="10"
                                    cy="20"
                                    r="1"
                                />

                                <circle
                                    cx="18"
                                    cy="20"
                                    r="1"
                                />
                            </svg>
                        </button>

                        <RouterLink
                            :to="`/products/item/${product.id}`"
                            class="inline-flex h-9 min-w-0 flex-1 items-center justify-center gap-1.5 rounded-lg bg-slate-900 px-3 text-[11px] font-semibold text-white transition-all hover:bg-slate-800 hover:shadow-md active:scale-[0.98]"
                        >
                            <span class="truncate">
                                {{ t('productCard.viewProduct') }}
                            </span>

                            <svg
                                class="h-3.5 w-3.5 shrink-0"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 12h14M13 6l6 6-6 6"
                                />
                            </svg>
                        </RouterLink>
                    </div>
                </div>
            </div>
        </div>
    </article>
</template>

<script setup>
import {
    computed,
    ref,
} from 'vue';

import { useI18n } from 'vue-i18n';

import { useCart } from '../../composables/useCart';
import { useCurrentUser } from '../../../auth/composables/useCurrentUser.js';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },

    variant: {
        type: String,
        default: 'default',
    },
});

const emit = defineEmits([
    'edit',
    'delete',
]);

const { t, locale } = useI18n();

const {
    add,
} = useCart();

const {
    canManage,
} = useCurrentUser();

/*
|--------------------------------------------------------------------------
| Management
|--------------------------------------------------------------------------
*/

const handleEdit = () => {
    if (!canManage.value) {
        return;
    }

    emit('edit', props.product);
};

const handleDelete = () => {
    if (!canManage.value) {
        return;
    }

    emit('delete', props.product);
};

/*
|--------------------------------------------------------------------------
| Cart
|--------------------------------------------------------------------------
*/

const adding = ref(false);
const added = ref(false);

let addedTimer = null;

const handleAddToCart = async () => {
    if (
        adding.value ||
        !props.product?.id
    ) {
        return;
    }

    adding.value = true;

    try {
        await add(
            props.product.id,
            1,
        );

        added.value = true;

        clearTimeout(addedTimer);

        addedTimer = window.setTimeout(() => {
            added.value = false;
        }, 1200);
    } catch (error) {
        console.error(
            'Failed to add product to cart:',
            error,
        );
    } finally {
        adding.value = false;
    }
};

/*
|--------------------------------------------------------------------------
| Localization
|--------------------------------------------------------------------------
*/

const localizedValue = (value) => {
    if (
        value === null ||
        value === undefined
    ) {
        return null;
    }

    if (typeof value === 'string') {
        return value;
    }

    if (typeof value === 'object') {
        return (
            value[locale.value] ||
            value.ru ||
            value.en ||
            Object.values(value)[0] ||
            null
        );
    }

    return String(value);
};

const productName = computed(() => {
    return (
        localizedValue(props.product.name) ||
        t('productCard.untitledProduct')
    );
});

const productDescription = computed(() => {
    return (
        localizedValue(
            props.product.shortDescription,
        ) ||
        localizedValue(
            props.product.short_description,
        ) ||
        localizedValue(
            props.product.fullDescription,
        ) ||
        localizedValue(
            props.product.full_description,
        ) ||
        t('productCard.noDescription')
    );
});

const categoryTitle = computed(() => {
    return (
        localizedValue(
            props.product.categoryTitle,
        ) ||
        localizedValue(
            props.product.category?.title,
        ) ||
        localizedValue(
            props.product.category?.category,
        ) ||
        null
    );
});

const badgeText = computed(() => {
    return (
        localizedValue(
            props.product.groupTitle,
        ) ||
        localizedValue(
            props.product.group?.title,
        ) ||
        localizedValue(
            props.product.group?.group,
        ) ||
        t('productCard.badgeFallback')
    );
});

const groupDotClass = computed(() => {
    const groupSlug = String(
        props.product.groupSlug ||
        props.product.group?.slug ||
        '',
    )
        .trim()
        .toLowerCase();

    const groupColors = {
        'railway-sector': 'bg-red-500',
        'aerospace-sector': 'bg-blue-500',
        'industrial-sector': 'bg-orange-500',
    };

    return (
        groupColors[groupSlug] ||
        'bg-slate-400'
    );
});

const inStockLabel = computed(() => {
    return Number(
        props.product.quantity || 0,
    ) > 0
        ? t('productCard.inStock')
        : t('productCard.outOfStock');
});

const imageSrc = computed(() => {
    const image =
        props.product.imageUrl ||
        props.product.image_url;

    if (!image) {
        return '/image/logo.svg';
    }

    if (
        image.startsWith('http://') ||
        image.startsWith('https://') ||
        image.startsWith('/')
    ) {
        return image;
    }

    const categorySlug =
        props.product.categorySlug ||
        props.product.category?.slug;

    const imageName = image.includes('.')
        ? image
        : `${image}.webp`;

    if (!categorySlug) {
        return `/image/product/${imageName}`;
    }

    return `/image/product/${categorySlug}/${imageName}`;
});
</script>