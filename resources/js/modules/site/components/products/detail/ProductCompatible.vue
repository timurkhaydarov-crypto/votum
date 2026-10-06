<template>
    <section>
        <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <!-- HEADER -->

            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <div class="mt-2 flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 text-slate-700"
                        >
                            <i class="bi bi-box-seam text-lg"></i>
                        </div>

                        <h2 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                            {{ $t('compatibleProducts.title') }}
                        </h2>
                    </div>

                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-500">
                        {{ $t('compatibleProducts.description') }}
                    </p>
                </div>

                <div class="flex shrink-0 items-center gap-2">
                    <!-- EDIT -->

                    <button
                        v-if="isManager"
                        type="button"
                        class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900"
                        @click="emit('edit')"
                    >
                        <i class="bi bi-pencil"></i>
                    </button>

                    <!-- TOTAL -->

                    <div
                        v-if="totalProducts"
                        class="rounded-lg bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-500"
                    >
                        {{ totalProducts }}
                        {{ productWord }}
                    </div>
                </div>
            </div>

            <!-- CATEGORIES -->

            <div v-if="categoryCollections.length" class="mt-8 space-y-10">
                <div
                    v-for="category in categoryCollections"
                    :key="category.slug"
                    :ref="(el) => setCategoryRef(category.slug, el)"
                >
                    <!-- CATEGORY HEADER -->

                    <div class="mb-5 flex items-center justify-between gap-4">
                        <div>
                            <h3 class="mt-1 text-xl font-bold tracking-tight text-slate-900">
                                {{ category.title }}
                            </h3>
                        </div>

                        <div
                            class="shrink-0 rounded-lg bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-500"
                        >
                            {{ category.products.length }}
                        </div>
                    </div>

                    <!-- PRODUCTS -->

                    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                        <ProductCard
                            v-for="(product, index) in visibleProducts(category)"
                            :key="product.id || product.article || index"
                            :product="product"
                            variant="compatible"
                        />
                    </div>

                    <!-- SHOW MORE / COLLAPSE -->

                    <div v-if="category.products.length > 4" class="mt-6 flex justify-center">
                        <button
                            type="button"
                            class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-xs font-semibold text-slate-700 shadow-sm transition-all duration-200 hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900 hover:shadow-md active:scale-[0.98]"
                            @click="toggleCategory(category.slug)"
                        >
                            <span>
                                {{
                                    isCategoryExpanded(category)
                                        ? $t('common.collapse')
                                        : $t('common.showMore')
                                }}
                            </span>

                            <svg
                                class="h-4 w-4 transition-transform duration-200"
                                :class="isCategoryExpanded(category) ? 'rotate-180' : ''"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 9l6 6 6-6"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- EMPTY -->

            <div
                v-else
                class="mt-8 rounded-2xl border border-dashed border-amber-200 bg-amber-50/60 p-6"
            >
                <MissingContent
                    :title="$t('compatibleProducts.empty.title')"
                    :text="$t('compatibleProducts.empty.text')"
                />
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed, nextTick, ref } from 'vue';
import { useI18n } from 'vue-i18n';

import MissingContent from '../MissingContent.vue';
import ProductCard from '../ProductCard.vue';

const props = defineProps({
    compatibleProducts: {
        type: Object,
        default: () => ({}),
    },

    isManager: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['edit']);
const { t } = useI18n();

/*
|--------------------------------------------------------------------------
| Category titles
|--------------------------------------------------------------------------
*/

const categoryTitleKeys = {
    'industrial-ndt': 'industrialNdt',
    'flaw-detectors': 'flawDetectors',
    'scanning-devices': 'scanningDevices',
    transducers: 'transducers',
    'reference-standards': 'referenceStandards',
};

/*
|--------------------------------------------------------------------------
| Category order
|--------------------------------------------------------------------------
*/

const categoryOrder = [
    'industrial-ndt',
    'flaw-detectors',
    'scanning-devices',
    'transducers',
    'reference-standards',
];

/*
|--------------------------------------------------------------------------
| Visible counts
|--------------------------------------------------------------------------
*/

const visibleCounts = ref({});

/*
|--------------------------------------------------------------------------
| Category refs
|--------------------------------------------------------------------------
*/

const categoryRefs = ref({});

const setCategoryRef = (slug, el) => {
    if (el) {
        categoryRefs.value[slug] = el;
    }
};

/*
|--------------------------------------------------------------------------
| Category collections
|--------------------------------------------------------------------------
*/

const categoryCollections = computed(() => {
    return categoryOrder
        .filter((slug) => {
            return props.compatibleProducts?.[slug]?.length;
        })
        .map((slug) => ({
            slug,

            title: categoryTitleKeys[slug]
                ? t(`compatibleProducts.categories.${categoryTitleKeys[slug]}`)
                : slug,

            products: props.compatibleProducts[slug],
        }));
});

/*
|--------------------------------------------------------------------------
| Visible count
|--------------------------------------------------------------------------
*/

const getVisibleCount = (category) => {
    const current = visibleCounts.value[category.slug];

    if (current) {
        return current;
    }

    return Math.min(4, category.products.length);
};

/*
|--------------------------------------------------------------------------
| Visible products
|--------------------------------------------------------------------------
*/

const visibleProducts = (category) => {
    return category.products.slice(0, getVisibleCount(category));
};

/*
|--------------------------------------------------------------------------
| Is category expanded
|--------------------------------------------------------------------------
*/

const isCategoryExpanded = (category) => {
    return getVisibleCount(category) >= category.products.length;
};

/*
|--------------------------------------------------------------------------
| Toggle category
|--------------------------------------------------------------------------
*/

const toggleCategory = async (categorySlug) => {
    const category = categoryCollections.value.find((item) => item.slug === categorySlug);

    if (!category) {
        return;
    }

    const currentCount = getVisibleCount(category);

    /*
    |--------------------------------------------------------------------------
    | Collapse
    |--------------------------------------------------------------------------
    */

    if (currentCount >= category.products.length) {
        visibleCounts.value[categorySlug] = Math.min(4, category.products.length);

        await nextTick();

        categoryRefs.value[categorySlug]?.scrollIntoView({
            behavior: 'smooth',
            block: 'start',
        });

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Show more
    |--------------------------------------------------------------------------
    */

    visibleCounts.value[categorySlug] = Math.min(currentCount + 4, category.products.length);
};

/*
|--------------------------------------------------------------------------
| Total products
|--------------------------------------------------------------------------
*/

const totalProducts = computed(() => {
    return categoryCollections.value.reduce(
        (total, category) => total + category.products.length,
        0
    );
});

/*
|--------------------------------------------------------------------------
| Product word
|--------------------------------------------------------------------------
*/

const productWord = computed(() => {
    const count = totalProducts.value;

    if (count === 1) {
        return t('compatibleProducts.product.one');
    }

    if (count >= 2 && count <= 4) {
        return t('compatibleProducts.product.few');
    }

    return t('compatibleProducts.product.many');
});
</script>
