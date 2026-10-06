<template>
    <ProductsLayout :title="pageTitle" :subtitle="$t('productDetail.subtitle')">
        <!-- ========================================================= -->
        <!-- LOADING -->
        <!-- ========================================================= -->
        <ProductDetailLoading v-if="isLoading" />

        <!-- ========================================================= -->
        <!-- ERROR -->
        <!-- ========================================================= -->
        <ProductDetailError v-else-if="errorMessage" :message="errorMessage" />

        <!-- ========================================================= -->
        <!-- NOT FOUND -->
        <!-- ========================================================= -->
        <ProductDetailNotFound v-else-if="isNotFound" />

        <!-- ========================================================= -->
        <!-- PRODUCT -->
        <!-- ========================================================= -->
        <div v-else-if="product" class="space-y-6">
            <!-- ===================================================== -->
            <!-- BREADCRUMBS -->
            <!-- ===================================================== -->
            <ProductBreadcrumbs :items="breadcrumbs" />

            <!-- ===================================================== -->
            <!-- HERO -->
            <!-- ===================================================== -->
            <ProductDetailHero
                :product="product"
                :image-src="imageSrc"
                :is-in-stock="isInStock"
                :can-manage="canManage"
                :group-dot-class="groupDotClass"
                :group-badge-classes="groupBadgeClasses"
                :back-link="backLink"
                :back-label="backLabel"
                @manage-info="handleManageInfo"
                @status-updated="handleProductStatusUpdated"
            />

            <!-- ===================================================== -->
            <!-- COMPATIBLE PRODUCTS -->
            <!-- ===================================================== -->
            <template v-if="hasCompatibleProducts">
                <ProductCompatible
                    :compatible-products="product.compatible_products"
                    :is-manager="canManage"
                    @edit="openCompatibleEditor"
                />
            </template>

            <ProductSectionPlaceholder
                v-else-if="canManage"
                icon="bi-link-45deg"
                :title="t('compatibleProducts.title')"
                :description="t('compatibleProducts.description')"
                @click="openSectionManager('compatible')"
            />

            <!-- ===================================================== -->
            <!-- CERTIFICATES -->
            <!-- ===================================================== -->
            <template v-if="hasCertificates">
                <ProductImageGallery
                    :images="product.certificates"
                    :gallery-title="$t('certificates.eyebrow')"
                    :gallery-sub-title="$t('certificates.title')"
                    type="certificate"
                    :can-manage="canManage"
                    @manage="openSectionManager('certificates')"
                />
            </template>

            <ProductSectionPlaceholder
                v-else-if="canManage"
                icon="bi-award"
                :title="t('certificates.title')"
                :description="t('certificates.description')"
                @click="openSectionManager('certificates')"
            />

            <!-- ===================================================== -->
            <!-- GALLERY -->
            <!-- ===================================================== -->
            <template v-if="hasGallery">
                <ProductGallery
                    :product="product"
                    :images="galleryImages"
                    :can-manage="canManage"
                    @manage="openSectionManager('gallery')"
                    @updated="handleProductUpdated"
                />
            </template>

            <ProductSectionPlaceholder
                v-else-if="canManage"
                icon="bi-images"
                :title="t('gallery.title')"
                :description="t('gallery.description')"
                @click="openSectionManager('gallery')"
            />

            <!-- ===================================================== -->
            <!-- CTA -->
            <!-- ===================================================== -->
            <ProductDetailCta />
        </div>

        <!-- ========================================================= -->
        <!-- EMPTY -->
        <!-- ========================================================= -->
        <div
            v-else
            class="rounded-2xl border border-slate-200 bg-slate-50 p-6 text-sm text-slate-600"
        >
            {{ $t('productDetail.noData') }}
        </div>

        <!-- ========================================================= -->
        <!-- FULL PRODUCT MANAGEMENT -->
        <!-- ========================================================= -->
        <ProductManagement
            ref="productManagementRef"
            :show-create-button="false"
            @updated="handleProductUpdated"
        />

        <!-- ========================================================= -->
        <!-- SECTION EDIT MODAL -->
        <!-- ========================================================= -->
        <ProductSectionModal
            :is-open="isSectionModalOpen"
            :product="product"
            :section="selectedSection"
            @close="closeSectionModal"
            @updated="handleProductUpdated"
        />
    </ProductsLayout>
</template>

<script setup>
import { computed, ref, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import { useRoute } from 'vue-router';

import ProductsLayout from '../../components/products/ProductsLayout.vue';
import ProductBreadcrumbs from '../../components/products/ProductBreadcrumbs.vue';

import ProductDetailLoading from '../../components/products/detail/ProductDetailLoading.vue';
import ProductDetailError from '../../components/products/detail/ProductDetailError.vue';
import ProductDetailNotFound from '../../components/products/detail/ProductDetailNotFound.vue';
import ProductDetailHero from '../../components/products/detail/ProductDetailHero.vue';
import ProductCompatible from '../../components/products/detail/ProductCompatible.vue';
import ProductGallery from '../../components/products/detail/ProductGallery.vue';
import ProductImageGallery from '../../components/products/detail/ProductImageGallery.vue';
import ProductDetailCta from '../../components/products/detail/ProductDetailCta.vue';
import ProductSectionPlaceholder from '../../components/products/detail/ProductSectionPlaceholder.vue';
import ProductManagement from '../../components/products/ProductManagement.vue';
import ProductSectionModal from '../../components/products/detail/ProductSectionModal.vue';

import { useProductsCatalog } from '../../composables/useProductsCatalog.js';
import { useProductDetails } from '../../composables/useProductDetails.js';
import { useProductBreadcrumbs } from '../../composables/useProductBreadcrumbs.js';

const route = useRoute();
const { t, locale } = useI18n();

/* |--------------------------------------------------------------------------
 | Product
 *-------------------------------------------------------------------------- */

const {
    product,
    isLoading,
    isNotFound,
    errorMessage,
    loadProductById,
} = useProductDetails();

/* |--------------------------------------------------------------------------
 | Product management
 *-------------------------------------------------------------------------- */

const productManagementRef = ref(null);

const canManage = computed(() => {
    return Boolean(productManagementRef.value?.canManage);
});

/* |--------------------------------------------------------------------------
 | Section modal
 *-------------------------------------------------------------------------- */

const isSectionModalOpen = ref(false);
const selectedSection = ref(null);

const handleManageInfo = ({ key }) => {
    if (!canManage.value || !key || !product.value) {
        return;
    }

    selectedSection.value = key;
    isSectionModalOpen.value = true;
};

const openSectionManager = (section) => {
    if (!canManage.value || !product.value) {
        return;
    }

    selectedSection.value = section;
    isSectionModalOpen.value = true;
};

const openCompatibleEditor = () => {
    openSectionManager('compatible');
};

const closeSectionModal = () => {
    isSectionModalOpen.value = false;
    selectedSection.value = null;
};

/* |--------------------------------------------------------------------------
 | Product update
 *-------------------------------------------------------------------------- */

const handleProductUpdated = async () => {
    if (!productId.value) {
        return;
    }

    await loadProductById(productId.value, { silent: true });
};

const handleProductStatusUpdated = (status) => {
    if (product.value) {
        product.value.status = status;
    }
};

/* |--------------------------------------------------------------------------
 | Standard transducers
 *-------------------------------------------------------------------------- */

const {
    products: standardTransducers,
    loadProductsByGroup,
} = useProductsCatalog();

/* |--------------------------------------------------------------------------
 | Route
 *-------------------------------------------------------------------------- */

const productId = computed(() => {
    return route.params.productId || '';
});

/* |--------------------------------------------------------------------------
 | Product meta
 *-------------------------------------------------------------------------- */

const pageTitle = computed(() => {
    return (
        product.value?.name ||
        t('productBreadcrumbs.productFallback', {
            id: productId.value,
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

/* |--------------------------------------------------------------------------
 | Breadcrumbs
 *-------------------------------------------------------------------------- */

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

/* |--------------------------------------------------------------------------
 | Helpers
 *-------------------------------------------------------------------------- */

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
            .map((item) => item.trim())
            .filter(Boolean);
    }

    return [];
};

/* |--------------------------------------------------------------------------
 | Compatible products
 *-------------------------------------------------------------------------- */

const hasCompatibleProducts = computed(() => {
    const compatible = product.value?.compatible_products || {};

    return Object.values(compatible).some(
        (products) => Array.isArray(products) && products.length > 0
    );
});

/* |--------------------------------------------------------------------------
 | Certificates
 *-------------------------------------------------------------------------- */

const hasCertificates = computed(() => {
    return (
        Array.isArray(product.value?.certificates) &&
        product.value.certificates.length > 0
    );
});

/* |--------------------------------------------------------------------------
 | Gallery
 *-------------------------------------------------------------------------- */

const galleryImages = computed(() => {
    return normalizeArray(
        product.value?.photogallery ||
            product.value?.gallery ||
            product.value?.galleryImages
    );
});

const hasGallery = computed(() => {
    return galleryImages.value.length > 0;
});

/* |--------------------------------------------------------------------------
 | Product loading
 *-------------------------------------------------------------------------- */

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

    loadProductsByGroup('transducers', 'ultrasonic');
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
        if (product.value && !hasProductTransducers.value) {
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

/* |--------------------------------------------------------------------------
 | Image
 *-------------------------------------------------------------------------- */

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

/* |--------------------------------------------------------------------------
 | Stock
 *-------------------------------------------------------------------------- */

const isInStock = computed(() => {
    if (product.value?.status !== null && product.value?.status !== undefined) {
        return Boolean(product.value.status);
    }

    return Number(product.value?.quantity || 0) > 0;
});

/* |--------------------------------------------------------------------------
 | Group colors
 *-------------------------------------------------------------------------- */

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

/* |--------------------------------------------------------------------------
 | Transducers
 *-------------------------------------------------------------------------- */

const productTransducers = computed(() => {
    const value =
        product.value?.transducers ??
        product.value?.probes ??
        product.value?.converters;

    if (!Array.isArray(value)) {
        return [];
    }

    return value.filter(Boolean);
});

const transducers = computed(() => {
    if (productTransducers.value.length) {
        return productTransducers.value;
    }

    return standardTransducers.value || [];
});
</script>