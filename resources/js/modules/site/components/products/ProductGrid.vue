<template>
    <section>
        <!-- ===================================================== -->
        <!-- PRODUCT FILTER -->
        <!-- ===================================================== -->
        <div
            v-if="products.length && showGroupFilters"
            class="mb-4 flex flex-wrap items-center gap-2"
        >
            <template
                v-for="filter in filters"
                :key="filter.slug"
            >
                <RouterLink
                    v-if="filterByCategory"
                    :to="categoryLink(filter.slug)"
                    class="inline-flex h-9 items-center gap-2 rounded-lg border border-slate-200 bg-white px-3.5 text-xs font-semibold text-slate-600 transition-all duration-200 hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900"
                >
                    <span class="h-1.5 w-1.5 shrink-0 rounded-full" :class="filter.dot"></span>
                    <span>{{ filter.title }}</span>
                    <span class="ml-0.5 text-[10px] font-medium text-slate-400">
                        {{ filter.count }}
                    </span>
                </RouterLink>

                <button
                    v-else
                    type="button"
                    class="inline-flex h-9 items-center gap-2 rounded-lg border px-3.5 text-xs font-semibold transition-all duration-200"
                    :class="
                        activeFilter === filter.slug
                            ? 'border-slate-900 bg-slate-900 text-white shadow-sm'
                            : 'border-slate-200 bg-white text-slate-600 hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900'
                    "
                    @click="activeFilter = filter.slug"
                >
                    <span class="h-1.5 w-1.5 shrink-0 rounded-full" :class="filter.dot"></span>
                    <span>{{ filter.title }}</span>
                    <span
                        class="ml-0.5 text-[10px] font-medium"
                        :class="activeFilter === filter.slug ? 'text-white/60' : 'text-slate-400'"
                    >
                        {{ filter.count }}
                    </span>
                </button>
            </template>
        </div>
        <div
            v-if="products.length || $slots.actions"
            class="mb-5 flex flex-wrap items-start justify-between gap-3"
        >
            <label v-if="products.length" class="relative block w-full max-w-xl">
                <i
                    class="bi bi-search pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"
                    aria-hidden="true"
                ></i>
                <input
                    v-model="searchQuery"
                    type="search"
                    :aria-label="t('actions.search')"
                    :placeholder="t('actions.search')"
                    class="h-11 w-full rounded-xl border border-slate-200 bg-white pl-10 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-400 focus:ring-2 focus:ring-slate-900/5"
                />
            </label>
            <slot name="actions"></slot>
        </div>
        <!-- ===================================================== -->
        <!-- LOADING -->
        <!-- ===================================================== -->
        <p
            v-if="isLoading"
            class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600"
        >
            Загрузка продукции...
        </p>
        <!-- ===================================================== -->
        <!-- ERROR -->
        <!-- ===================================================== -->
        <p
            v-else-if="errorMessage"
            class="rounded-lg border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700"
        >
            {{ errorMessage }}
        </p>
        <!-- ===================================================== -->
        <!-- EMPTY -->
        <!-- ===================================================== -->
        <p
            v-else-if="!filteredProducts.length"
            class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600"
        >
            По этому запросу продукция не найдена.
        </p>
        <!-- ===================================================== -->
        <!-- PRODUCTS -->
        <!-- ===================================================== -->
        <div v-else class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-3">
            <ProductCard
                v-for="product in filteredProducts"
                :key="product.id"
                :product="product"
                @edit="handleEdit"
                @delete="handleDelete"
            />
        </div>
    </section>
</template>
<script setup>
import { computed, ref, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import ProductCard from './ProductCard.vue';
/* |-------------------------------------------------------------------------- | i18n |-------------------------------------------------------------------------- */ const {
    t,
} = useI18n();
/* |-------------------------------------------------------------------------- | Props |-------------------------------------------------------------------------- */ const props =
    defineProps({
        products: { type: Array, default: () => [] },
        isLoading: { type: Boolean, default: false },
        errorMessage: { type: String, default: '' },
        showGroupFilters: { type: Boolean, default: true },
        filterByCategory: { type: Boolean, default: false },
    });
/* |-------------------------------------------------------------------------- | Emits |-------------------------------------------------------------------------- */ const emit =
    defineEmits(['edit', 'delete']);
const activeFilter = ref('all');
const searchQuery = ref('');

const filterDots = {
    'railway-sector': 'bg-red-500',
    'aerospace-sector': 'bg-blue-500',
    'industrial-sector': 'bg-orange-500',
};

const filters = computed(() => {
    const options = props.filterByCategory
        ? props.products
            .filter((product) => product.categorySlug)
            .map((product) => ({
                slug: product.categorySlug,
                title: product.categoryTitle,
            }))
        : props.products.flatMap((product) => product.groups || []);
    const uniqueOptions = new Map();

    options.forEach((option) => {
        if (option.slug && !uniqueOptions.has(option.slug)) {
            uniqueOptions.set(option.slug, option);
        }
    });

    return [
        {
            slug: 'all',
            title: t('common.all'),
            dot: 'bg-slate-400',
            count: props.products.length,
        },
        ...Array.from(uniqueOptions.values()).map((option) => {
            return {
                slug: option.slug,
                title: option.title || option.slug,
                dot: filterDots[option.slug] || 'bg-slate-400',
                count: props.filterByCategory
                    ? props.products.filter((product) => product.categorySlug === option.slug).length
                    : props.products.filter((product) =>
                        product.groups?.some((group) => group.slug === option.slug)
                    ).length,
            };
        }),
    ];
});

const categoryLink = (slug) => slug === 'all' ? '/products' : `/products/${slug}`;

const filteredProducts = computed(() => {
    const query = searchQuery.value.trim().toLocaleLowerCase();

    return props.products.filter((product) => {
        const matchesFilter =
            props.filterByCategory ||
            activeFilter.value === 'all' ||
            product.groups?.some((group) => group.slug === activeFilter.value);

        if (!matchesFilter) {
            return false;
        }

        if (!query) {
            return true;
        }

        const searchableText = [
            product.article,
            product.name,
            product.shortDescription,
            product.fullDescription,
            product.groupTitle,
            product.categoryTitle,
            product.application,
            product.method,
        ]
            .filter(Boolean)
            .join(' ')
            .toLocaleLowerCase();

        return searchableText.includes(query);
    });
});
/* |-------------------------------------------------------------------------- | Reset active group |-------------------------------------------------------------------------- | | Если после обновления products выбранная группа больше | не существует, возвращаемся на "Все". | |-------------------------------------------------------------------------- */ watch(
    filters,
    (newFilters) => {
        const exists = newFilters.some((filter) => filter.slug === activeFilter.value);
        if (!exists) {
            activeFilter.value = 'all';
        }
    },
    { immediate: true }
);
/* |-------------------------------------------------------------------------- | Edit |-------------------------------------------------------------------------- */ const handleEdit =
    (product) => {
        emit('edit', product);
    };
/* |-------------------------------------------------------------------------- | Delete |-------------------------------------------------------------------------- */ const handleDelete =
    (product) => {
        emit('delete', product);
    };
</script>
