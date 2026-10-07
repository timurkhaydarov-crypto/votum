<template>
    <section>
        <!-- ===================================================== -->
        <!-- GROUP FILTER -->
        <!-- ===================================================== -->
        <div
            v-if="products.length && showGroupFilters"
            class="mb-4 flex flex-wrap items-center gap-2"
        >
            <button
                v-for="group in groups"
                :key="group.slug"
                type="button"
                class="inline-flex h-9 items-center gap-2 rounded-lg border px-3.5 text-xs font-semibold transition-all duration-200"
                :class="
                    activeGroup === group.slug
                        ? 'border-slate-900 bg-slate-900 text-white shadow-sm'
                        : 'border-slate-200 bg-white text-slate-600 hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900'
                "
                @click="activeGroup = group.slug"
            >
                <span class="h-1.5 w-1.5 shrink-0 rounded-full" :class="group.dot"></span>
                <span> {{ group.title }} </span>
                <span
                    class="ml-0.5 text-[10px] font-medium"
                    :class="activeGroup === group.slug ? 'text-white/60' : 'text-slate-400'"
                >
                    {{ group.count }}
                </span>
            </button>
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
    });
/* |-------------------------------------------------------------------------- | Emits |-------------------------------------------------------------------------- */ const emit =
    defineEmits(['edit', 'delete']);
const activeGroup = ref('all');
const searchQuery = ref('');

const groupOptions = [
    {
        slug: 'railway-sector',
        title: () => t('product.form.sectors.railway'),
        dot: 'bg-red-500',
    },
    {
        slug: 'aerospace-sector',
        title: () => t('product.form.sectors.aerospace'),
        dot: 'bg-blue-500',
    },
    {
        slug: 'industrial-sector',
        title: () => t('about.industries.industry'),
        dot: 'bg-orange-500',
    },
];

const groups = computed(() => [
    {
        slug: 'all',
        title: t('common.all'),
        dot: 'bg-slate-400',
        count: props.products.length,
    },
    ...groupOptions.map((group) => ({
        ...group,
        title: group.title(),
        count: props.products.filter((product) => product.groupSlug === group.slug).length,
    })),
]);

const filteredProducts = computed(() => {
    const query = searchQuery.value.trim().toLocaleLowerCase();

    return props.products.filter((product) => {
        const matchesGroup =
            activeGroup.value === 'all' || product.groupSlug === activeGroup.value;

        if (!matchesGroup) {
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
    groups,
    (newGroups) => {
        const exists = newGroups.some((group) => group.slug === activeGroup.value);
        if (!exists) {
            activeGroup.value = 'all';
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
