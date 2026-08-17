<template>
    <ProductsLayout
        :title="pageTitle"
        subtitle="Детальная информация о приборе неразрушающего контроля"
    >
        <ProductDetailLoading v-if="isLoading" />

        <ProductDetailError
            v-else-if="errorMessage"
            :message="errorMessage"
        />

        <ProductDetailNotFound
            v-else-if="isNotFound"
        />

        <div
            v-else-if="product"
            class="space-y-6"
        >
            <ProductBreadcrumbs :items="breadcrumbs" />

            <ProductDetailHero
                :product="product"
                :image-src="imageSrc"
                :is-in-stock="isInStock"
                :price-label="priceLabel"
                :group-dot-class="groupDotClass"
                :group-badge-classes="groupBadgeClasses"
                :back-link="backLink"
                :back-label="backLabel"
            />

            <ProductFeatures
                :features="features"
            />

            <ProductTechnicalCharacteristics
                :characteristics="technicalCharacteristics"
            />

            <ProductTransducers
                :transducers="transducers"
                :is-loading="isLoadingTransducers"
                :error-message="transducersErrorMessage"
                :has-product-transducers="hasProductTransducers"
            />

            <ProductApplication
                :product="product"
                :available="applicationAvailable"
            />

            <ProductDocuments
                :documents="documents"
            />

            <ProductGallery
                :product="product"
                :images="galleryImages"
            />

            <ProductDetailCta />
        </div>

        <div
            v-else
            class="rounded-2xl border border-slate-200 bg-slate-50 p-6 text-sm text-slate-600"
        >
            Нет данных о продукции.
        </div>
    </ProductsLayout>
</template>

<script setup>
import { computed, watch } from 'vue';
import { useRoute } from 'vue-router';
import { useI18n } from 'vue-i18n';

import ProductsLayout from '../../components/products/ProductsLayout.vue';
import ProductBreadcrumbs from '../../components/products/ProductBreadcrumbs.vue';

import ProductDetailLoading from '../../components/products/detail/ProductDetailLoading.vue';
import ProductDetailError from '../../components/products/detail/ProductDetailError.vue';
import ProductDetailNotFound from '../../components/products/detail/ProductDetailNotFound.vue';

import ProductDetailHero from '../../components/products/detail/ProductDetailHero.vue';
import ProductFeatures from '../../components/products/detail/ProductFeatures.vue';
import ProductTechnicalCharacteristics from '../../components/products/detail/ProductTechnicalCharacteristics.vue';
import ProductTransducers from '../../components/products/detail/ProductTransducers.vue';
import ProductApplication from '../../components/products/detail/ProductApplication.vue';
import ProductDocuments from '../../components/products/detail/ProductDocuments.vue';
import ProductGallery from '../../components/products/detail/ProductGallery.vue';
import ProductDetailCta from '../../components/products/detail/ProductDetailCta.vue';

import { useProductsCatalog } from '../../composables/useProductsCatalog.js';
import { useProductDetails } from '../../composables/useProductDetails.js';
import { useProductBreadcrumbs } from '../../composables/useProductBreadcrumbs.js';

const route = useRoute();
const { t, locale } = useI18n();

const {
    product,
    isLoading,
    isNotFound,
    errorMessage,
    loadProductById,
} = useProductDetails();

const {
    products: standardTransducers,
    isLoading: isLoadingTransducers,
    errorMessage: transducersErrorMessage,
    loadProductsByGroup,
} = useProductsCatalog();

const productId = computed(() => {
    return route.params.productId || '';
});

const pageTitle = computed(() => {
    return (
        product.value?.name ||
        t('productBreadcrumbs.productFallback', {
            id: productId.value || '',
        })
    );
});

const categorySlug = computed(() => {
    return product.value?.categorySlug || '';
});

const categoryTitle = computed(() => {
    return product.value?.categoryTitle || '';
});

const groupSlug = computed(() => {
    return product.value?.groupSlug || '';
});

const groupTitle = computed(() => {
    return product.value?.groupTitle || '';
});

const productTitle = computed(() => {
    return product.value?.name || '';
});

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

const hasValue = (value) => {
    if (value === null || value === undefined) {
        return false;
    }

    if (typeof value === 'string') {
        return value.trim().length > 0;
    }

    if (Array.isArray(value)) {
        return value.length > 0;
    }

    return true;
};

const normalizeArray = (value) => {
    if (!value) {
        return [];
    }

    if (Array.isArray(value)) {
        return value.filter(Boolean);
    }

    if (typeof value === 'string') {
        return value
            .split(/[,;\n]/)
            .map(item => item.trim())
            .filter(Boolean);
    }

    return [];
};

/*
|--------------------------------------------------------------------------
| Product loading
|--------------------------------------------------------------------------
*/

const hasProductTransducers = computed(() => {
    const value =
        product.value?.transducers ??
        product.value?.probes ??
        product.value?.converters;

    return Array.isArray(value) && value.length > 0;
});

const loadStandardTransducers = () => {
    if (hasProductTransducers.value) {
        return;
    }

    loadProductsByGroup(
        'transducers',
        'ultrasonic'
    );
};

const loadDetails = async () => {
    if (!productId.value) {
        return;
    }

    await loadProductById(productId.value);

    if (!hasProductTransducers.value) {
        loadStandardTransducers();
    }
};

watch(
    () => route.params.productId,
    () => {
        loadDetails();
    },
    {
        immediate: true,
    }
);

watch(
    product,
    () => {
        if (
            product.value &&
            !hasProductTransducers.value
        ) {
            loadStandardTransducers();
        }
    },
    {
        immediate: true,
    }
);

watch(locale, () => {
    loadDetails();
});

/*
|--------------------------------------------------------------------------
| Image
|--------------------------------------------------------------------------
*/

const imageSrc = computed(() => {
    const image = product.value?.imageUrl;

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

    if (!product.value?.categorySlug) {
        return `/image/product/${image}`;
    }

    const imageName = image.includes('.')
        ? image
        : `${image}.webp`;

    return `/image/product/${product.value.categorySlug}/${imageName}`;
});

/*
|--------------------------------------------------------------------------
| Stock
|--------------------------------------------------------------------------
*/

const isInStock = computed(() => {
    return Number(product.value?.quantity || 0) > 0;
});

/*
|--------------------------------------------------------------------------
| Price
|--------------------------------------------------------------------------
*/

const priceLabel = computed(() => {
    return product.value?.price
        ? `${product.value.price} ₽`
        : 'По запросу';
});

/*
|--------------------------------------------------------------------------
| Group colors
|--------------------------------------------------------------------------
*/

const groupDotClass = computed(() => {
    switch (product.value?.groupSlug) {
        case 'railway-sector':
            return 'bg-red-500';

        case 'aerospace-sector':
            return 'bg-blue-500';

        case 'industrial-sector':
            return 'bg-orange-500';

        default:
            return 'bg-slate-400';
    }
});

const groupBadgeClasses = computed(() => {
    switch (product.value?.groupSlug) {
        case 'railway-sector':
            return 'border-red-100 bg-red-50 text-red-700';

        case 'aerospace-sector':
            return 'border-blue-100 bg-blue-50 text-blue-700';

        case 'industrial-sector':
            return 'border-orange-100 bg-orange-50 text-orange-700';

        default:
            return 'border-slate-200 bg-white text-slate-600';
    }
});

/*
|--------------------------------------------------------------------------
| Technical characteristics
|--------------------------------------------------------------------------
*/

const technicalCharacteristics = computed(() => {
    const p = product.value || {};

    return [
        {
            key: 'frequency',
            label: 'Диапазон частот',
            value: p.frequency,
        },
        {
            key: 'display',
            label: 'Дисплей',
            value: p.display,
        },
        {
            key: 'channels',
            label: 'Количество каналов',
            value: p.channels,
        },
        {
            key: 'dynamicRange',
            label: 'Динамический диапазон',
            value: p.dynamicRange,
        },
        {
            key: 'measurementRange',
            label: 'Диапазон измерений',
            value: p.measurementRange,
        },
        {
            key: 'resolution',
            label: 'Разрешение',
            value: p.resolution,
        },
        {
            key: 'dimensions',
            label: 'Габариты',
            value: p.dimensions,
        },
        {
            key: 'weight',
            label: 'Масса',
            value: p.weight,
        },
        {
            key: 'power',
            label: 'Питание',
            value: p.power,
        },
    ].map(item => ({
        ...item,
        available: hasValue(item.value),
    }));
});

/*
|--------------------------------------------------------------------------
| Features
|--------------------------------------------------------------------------
*/

const features = computed(() => {
    return normalizeArray(
        product.value?.features ||
        product.value?.functionalFeatures
    );
});

/*
|--------------------------------------------------------------------------
| Transducers
|--------------------------------------------------------------------------
*/

const productTransducers = computed(() => {
    const value =
        product.value?.transducers ??
        product.value?.probes ??
        product.value?.converters;

    if (!value) {
        return [];
    }

    if (Array.isArray(value)) {
        return value.filter(Boolean);
    }

    return [];
});

const transducers = computed(() => {
    if (productTransducers.value.length) {
        return productTransducers.value;
    }

    return standardTransducers.value || [];
});

/*
|--------------------------------------------------------------------------
| Application
|--------------------------------------------------------------------------
*/

const applicationAvailable = computed(() => {
    return hasValue(
        product.value?.application ||
        product.value?.applications ||
        product.value?.categoryTitle
    );
});

/*
|--------------------------------------------------------------------------
| Documents
|--------------------------------------------------------------------------
*/

const documents = computed(() => {
    const p = product.value || {};

    return {
        characteristics:
            p.characteristicsUrl ||
            p.technicalSpecificationsUrl ||
            '',

        certificates:
            p.certificatesUrl ||
            '',

        documentation:
            p.documentationUrl ||
            '',

        software:
            p.softwareUrl ||
            '',
    };
});

/*
|--------------------------------------------------------------------------
| Gallery
|--------------------------------------------------------------------------
*/

const galleryImages = computed(() => {
    return normalizeArray(
        product.value?.photogallery ||
        product.value?.gallery ||
        product.value?.galleryImages
    );
});
</script>