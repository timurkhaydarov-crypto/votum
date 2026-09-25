<template>
    <div class="relative">
        <!-- SEARCH -->
        <div class="relative">
            <i
                class="bi bi-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"
            ></i>

            <input
                v-model="searchQuery"
                type="text"
                :placeholder="placeholder"
                class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-11 pr-10 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-400 focus:ring-2 focus:ring-slate-100"
                @focus="showResults = true"
            />

            <button
                v-if="searchQuery"
                type="button"
                class="absolute right-3 top-1/2 flex h-7 w-7 -translate-y-1/2 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                @click="clearSearch"
            >
                <i class="bi bi-x"></i>
            </button>
        </div>

        <!-- LOADING -->
        <div
            v-if="isLoading"
            class="mt-3 flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500"
        >
            <i class="bi bi-arrow-repeat animate-spin"></i>

            Загрузка продукции...
        </div>

        <!-- ERROR -->
        <div
            v-else-if="errorMessage"
            class="mt-3 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700"
        >
            {{ errorMessage }}
        </div>

        <!-- RESULTS -->
        <div
            v-else-if="
                showResults &&
                searchQuery.trim() &&
                filteredProducts.length
            "
            class="absolute left-0 right-0 z-30 mt-2 max-h-80 overflow-y-auto rounded-2xl border border-slate-200 bg-white p-2 shadow-2xl"
        >
            <button
                v-for="product in filteredProducts"
                :key="product.id"
                type="button"
                class="flex w-full items-start gap-3 rounded-xl px-3 py-3 text-left transition hover:bg-slate-50"
                @click="selectProduct(product)"
            >
                <!-- IMAGE -->
                <div
                    class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-slate-100"
                >
                    <img
                        v-if="getProductImage(product)"
                        :src="getProductImage(product)"
                        :alt="getProductName(product)"
                        class="h-full w-full object-contain"
                        @error="handleImageError"
                    />

                    <i
                        v-else
                        class="bi bi-box text-lg text-slate-300"
                    ></i>
                </div>

                <!-- DATA -->
                <div class="min-w-0 flex-1">
                    <div
                        class="truncate text-sm font-semibold text-slate-900"
                    >
                        {{ getProductName(product) }}
                    </div>

                    <div
                        class="mt-1 flex flex-wrap gap-x-3 gap-y-1 text-xs text-slate-500"
                    >
                        <span v-if="product.article">
                            {{ product.article }}
                        </span>

                        <span v-if="product.categoryTitle">
                            {{ product.categoryTitle }}
                        </span>
                    </div>
                </div>

                <i
                    class="bi bi-arrow-right mt-1 text-slate-300"
                ></i>
            </button>
        </div>

        <!-- NO RESULTS -->
        <div
            v-else-if="
                showResults &&
                searchQuery.trim() &&
                !filteredProducts.length
            "
            class="absolute left-0 right-0 z-30 mt-2 rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-xl"
        >
            <div
                class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-400"
            >
                <i class="bi bi-search"></i>
            </div>

            <div
                class="mt-3 text-sm font-semibold text-slate-700"
            >
                Продукт не найден
            </div>

            <div
                class="mt-1 text-xs text-slate-500"
            >
                Измени поисковый запрос.
            </div>
        </div>
    </div>
</template>

<script setup>
import {
    computed,
    onBeforeUnmount,
    onMounted,
    ref,
} from 'vue';

import { productsApi } from '../services/productsApi.js';

const props = defineProps({
    modelValue: {
        type: Object,
        default: null,
    },

    excludeIds: {
        type: Array,
        default: () => [],
    },

    placeholder: {
        type: String,
        default: 'Поиск по названию или артикулу...',
    },
});

const emit = defineEmits([
    'update:modelValue',
    'select',
]);

const products = ref([]);
const searchQuery = ref('');
const showResults = ref(false);

const isLoading = ref(false);
const errorMessage = ref('');

let blurTimer = null;

/*
|--------------------------------------------------------------------------
| Load
|--------------------------------------------------------------------------
*/

const loadProducts = async () => {
    isLoading.value = true;
    errorMessage.value = '';

    try {
        products.value =
            await productsApi.getProducts();
    } catch (error) {
        console.error(
            'Failed to load products:',
            error,
        );

        errorMessage.value =
            error?.message ||
            'Не удалось загрузить продукцию.';
    } finally {
        isLoading.value = false;
    }
};

/*
|--------------------------------------------------------------------------
| Search
|--------------------------------------------------------------------------
*/

const normalizedQuery = computed(() => {
    return searchQuery.value
        .trim()
        .toLowerCase();
});

const filteredProducts = computed(() => {
    const query = normalizedQuery.value;

    if (!query) {
        return [];
    }

    return products.value
        .filter(product => {
            if (
                props.excludeIds.includes(
                    Number(product.id),
                )
            ) {
                return false;
            }

            const name =
                getProductName(product)
                    .toLowerCase();

            const article =
                String(
                    product.article || '',
                ).toLowerCase();

            const category =
                String(
                    product.categoryTitle || '',
                ).toLowerCase();

            return (
                name.includes(query) ||
                article.includes(query) ||
                category.includes(query)
            );
        })
        .slice(0, 30);
});

/*
|--------------------------------------------------------------------------
| Selection
|--------------------------------------------------------------------------
*/

const selectProduct = product => {
    emit(
        'update:modelValue',
        product,
    );

    emit(
        'select',
        product,
    );

    searchQuery.value =
        getProductName(product);

    showResults.value = false;
};

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

const getProductName = product => {
    if (!product) {
        return '';
    }

    if (
        typeof product.name === 'string'
    ) {
        return product.name;
    }

    if (
        product.name &&
        typeof product.name === 'object'
    ) {
        return (
            product.name.ru ||
            product.name.en ||
            ''
        );
    }

    return '';
};

const getProductImage = product => {
    if (!product?.imageUrl) {
        return '';
    }

    if (
        product.imageUrl.startsWith('/') ||
        product.imageUrl.startsWith('http://') ||
        product.imageUrl.startsWith('https://')
    ) {
        return product.imageUrl;
    }

    const imageName =
        product.imageUrl.includes('.')
            ? product.imageUrl
            : `${product.imageUrl}.webp`;

    if (product.categorySlug) {
        return `/image/product/${product.categorySlug}/${imageName}`;
    }

    return `/image/product/${imageName}`;
};

const handleImageError = event => {
    event.target.style.display = 'none';
};

const clearSearch = () => {
    searchQuery.value = '';

    emit(
        'update:modelValue',
        null,
    );

    showResults.value = false;
};

/*
|--------------------------------------------------------------------------
| Outside click
|--------------------------------------------------------------------------
*/

const handleDocumentClick = event => {
    if (!event.target.closest('.relative')) {
        showResults.value = false;
    }
};

const handleFocus = () => {
    showResults.value = true;
};

onMounted(async () => {
    document.addEventListener(
        'click',
        handleDocumentClick,
    );

    await loadProducts();
});

onBeforeUnmount(() => {
    document.removeEventListener(
        'click',
        handleDocumentClick,
    );

    if (blurTimer) {
        window.clearTimeout(blurTimer);
    }
});
</script>