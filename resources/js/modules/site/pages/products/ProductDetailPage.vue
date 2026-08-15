<template>
    <ProductsLayout
        :title="pageTitle"
        subtitle="Детальная карточка продукции"
    >
        <p
            v-if="isLoading"
            class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600"
        >
            Загрузка товара...
        </p>

        <p
            v-else-if="errorMessage"
            class="rounded-lg border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700"
        >
            {{ errorMessage }}
        </p>

        <article
            v-else-if="product"
            class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm"
        >
            <ProductBreadcrumbs :items="breadcrumbs" />

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-500">
                        Артикул: {{ product.article || '-' }}
                    </p>

                    <h2 class="mt-2 text-xl font-semibold text-slate-900">
                        {{ product.name || 'Без названия' }}
                    </h2>

                    <p class="mt-3 text-sm leading-6 text-slate-700">
                        {{ product.fullDescription || product.shortDescription || 'Описание отсутствует.' }}
                    </p>
                </div>

                <div class="space-y-3 rounded-lg bg-slate-50 p-4 text-sm">
                    <p>
                        <span class="font-medium text-slate-900">Категория:</span>
                        <span class="text-slate-700"> {{ product.categoryTitle || '-' }}</span>
                    </p>

                    <p>
                        <span class="font-medium text-slate-900">Группа:</span>
                        <span class="text-slate-700"> {{ product.groupTitle || '-' }}</span>
                    </p>

                    <p>
                        <span class="font-medium text-slate-900">Цена:</span>
                        <span class="text-slate-700"> {{ product.price ? `${product.price} ₽` : 'По запросу' }}</span>
                    </p>

                    <p>
                        <span class="font-medium text-slate-900">Остаток:</span>
                        <span class="text-slate-700"> {{ product.quantity ?? 0 }}</span>
                    </p>
                </div>
            </div>

            <div class="mt-5 border-t border-slate-200 pt-4">
                <RouterLink
                    :to="backLink"
                    class="inline-flex items-center gap-2 text-sm font-medium text-slate-700 transition hover:text-slate-900"
                >
                    <i class="bi bi-arrow-left"></i>
                    <span>{{ backLabel }}</span>
                </RouterLink>
            </div>
        </article>
    </ProductsLayout>
</template>

<script setup>
import { computed, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import { useI18n } from 'vue-i18n';
import ProductBreadcrumbs from '../../components/products/ProductBreadcrumbs.vue';
import ProductsLayout from '../../components/products/ProductsLayout.vue';
import { useProductDetails } from '../../composables/useProductDetails.js';
import { useProductBreadcrumbs } from '../../composables/useProductBreadcrumbs.js';

const route = useRoute();
const { t } = useI18n();

const {
    product,
    isLoading,
    errorMessage,
    loadProductById,
} = useProductDetails();

const productId = computed(() => route.params.productId || '');
const pageTitle = computed(() => {
    return product.value?.name || t('productBreadcrumbs.productFallback', {
        id: productId.value || '',
    });
});

const categorySlug = computed(() => product.value?.categorySlug || '');
const categoryTitle = computed(() => product.value?.categoryTitle || '');
const groupSlug = computed(() => product.value?.groupSlug || '');
const groupTitle = computed(() => product.value?.groupTitle || '');
const productTitle = computed(() => product.value?.name || '');

const {
    breadcrumbs,
    backLink,
    backLabel,
} = useProductBreadcrumbs({
    categorySlug,
    categoryTitle,
    groupSlug,
    groupTitle,
    productTitle,
    productId,
});

const loadDetails = () => {
    if (!productId.value) {
        return;
    }

    loadProductById(productId.value);
};

onMounted(loadDetails);

watch(
    () => route.params.productId,
    () => {
        loadDetails();
    }
);
</script>