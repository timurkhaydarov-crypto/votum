<template>
    <section>
        <!-- ===================================================== -->
        <!-- GROUP FILTER -->
        <!-- ===================================================== -->

        <div
            v-if="products.length"
            class="mb-5 flex flex-wrap items-center gap-2"
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
                <span
                    class="h-1.5 w-1.5 shrink-0 rounded-full"
                    :class="group.dot"
                ></span>

                <span>
                    {{ group.title }}
                </span>

                <span
                    class="ml-0.5 text-[10px] font-medium"
                    :class="
                        activeGroup === group.slug
                            ? 'text-white/60'
                            : 'text-slate-400'
                    "
                >
                    {{ group.count }}
                </span>
            </button>
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

        <div
            v-else
            class="
                grid
                grid-cols-1
                gap-5
                sm:grid-cols-2
                xl:grid-cols-3
                2xl:grid-cols-3
            "
        >
            <ProductCard
                v-for="product in filteredProducts"
                :key="product.id"
                :product="product"
            />
        </div>
    </section>
</template>


<script setup>
import { computed, ref, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import ProductCard from './ProductCard.vue';

const { t } = useI18n();


/*
|--------------------------------------------------------------------------
| Props
|--------------------------------------------------------------------------
*/

const props = defineProps({
    products: {
        type: Array,
        default: () => [],
    },

    isLoading: {
        type: Boolean,
        default: false,
    },

    errorMessage: {
        type: String,
        default: '',
    },
});


/*
|--------------------------------------------------------------------------
| Active group
|--------------------------------------------------------------------------
*/

const activeGroup = ref('all');


/*
|--------------------------------------------------------------------------
| Group configuration
|--------------------------------------------------------------------------
*/

const groupConfig = {
    'railway-sector': {
        dot: 'bg-red-500',
    },

    'aerospace-sector': {
        dot: 'bg-blue-500',
    },

    'industrial-sector': {
        dot: 'bg-orange-500',
    },
};


/*
|--------------------------------------------------------------------------
| Unique groups from products
|--------------------------------------------------------------------------
|
| Получаем только те groupSlug, которые реально присутствуют
| в props.products.
|
|--------------------------------------------------------------------------
*/

const groups = computed(() => {
    const uniqueGroups = [
        ...new Set(
            props.products
                .map((product) => product.groupSlug)
                .filter(Boolean)
        ),
    ];

    return [
        {
            slug: 'all',
            title: t('productGrid.all'),
            dot: 'bg-slate-400',
            count: props.products.length,
        },

        ...uniqueGroups.map((slug) => {
            const config = groupConfig[slug];
            const groupProduct = props.products.find(
                (product) => product.groupSlug === slug
            );

            return {
                slug,

                title:
                    groupProduct?.groupTitle ||
                    slug,

                dot:
                    config?.dot ||
                    'bg-slate-400',

                count: props.products.filter(
                    (product) => product.groupSlug === slug
                ).length,
            };
        }),
    ];
});


/*
|--------------------------------------------------------------------------
| Filtered products
|--------------------------------------------------------------------------
*/

const filteredProducts = computed(() => {
    if (activeGroup.value === 'all') {
        return props.products;
    }

    return props.products.filter((product) => {
        return product.groupSlug === activeGroup.value;
    });
});


/*
|--------------------------------------------------------------------------
| Reset active group
|--------------------------------------------------------------------------
|
| Если после обновления products выбранная группа больше
| не существует, возвращаемся на "Все".
|
|--------------------------------------------------------------------------
*/

watch(
    groups,
    (newGroups) => {
        const exists = newGroups.some(
            (group) => group.slug === activeGroup.value
        );

        if (!exists) {
            activeGroup.value = 'all';
        }
    },
    {
        immediate: true,
    }
);
</script>