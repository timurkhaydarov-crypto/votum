import { productsApi } from '../../services/productsApi.js';
import { fetchJsonApi } from '../../services/fetchJsonApi.js';

export function useProductSectionData({
    props,
    locale,
    editProduct,
    currentUser,
    isLoading,
    formError,
    form,
    compatibleOptions,
    originalFeaturesGalleryIds,
    originalSpecificationIds,
    resetErrors,
    resetForm,
}) {
    /*
    |--------------------------------------------------------------------------
    | Localized helpers
    |--------------------------------------------------------------------------
    */

    function normalizeLocalizedObject(value) {
        if (!value) {
            return {
                ru: '',
                en: '',
            };
        }

        if (typeof value === 'string') {
            return {
                ru: value,
                en: value,
            };
        }

        return {
            ru: value.ru ?? '',
            en: value.en ?? '',
        };
    }

    function getProductLabel(product) {
        if (!product) {
            return '';
        }

        const name = product.name;

        if (typeof name === 'string') {
            return name;
        }

        if (name && typeof name === 'object') {
            return name[locale.value] ?? name.ru ?? name.en ?? product.article ?? `#${product.id}`;
        }

        return product.article ?? `#${product.id}`;
    }

    /*
    |--------------------------------------------------------------------------
    | Features
    |--------------------------------------------------------------------------
    */

    function getFeaturesImageUrl(imageUrl) {
        if (!imageUrl) {
            return '';
        }

        const filename = String(imageUrl).split('/').pop().trim();

        if (!filename) {
            return '';
        }

        const baseName = filename.replace(/\.(webp|jpg|jpeg|png)$/i, '');

        const folder = baseName.replace(/_\d+$/, '');

        if (!folder) {
            return '';
        }

        return (
            `/image/features/` +
            `${encodeURIComponent(folder)}/` +
            `${encodeURIComponent(baseName)}.webp`
        );
    }

    function normalizeFeaturesGallery(items) {
        if (!Array.isArray(items)) {
            return [];
        }

        return items.map((item) => {
            const imageUrl = item.image_url ?? item.image ?? '';

            return {
                id: item.id ?? null,

                title: normalizeLocalizedObject(item.title),

                image_url: imageUrl,

                image_name: getFeaturesImageUrl(imageUrl),

                preview_url: item.preview_url ?? getFeaturesImageUrl(imageUrl),

                is_new: false,

                file: null,
            };
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Specifications
    |--------------------------------------------------------------------------
    */

    function normalizeSpecifications(items) {
        if (!Array.isArray(items)) {
            return [];
        }

        return items.map((item) => ({
            id: item.id ?? null,

            name: normalizeLocalizedObject(item.name),

            value: normalizeLocalizedObject(item.value),
        }));
    }

    /*
    |--------------------------------------------------------------------------
    | Current authenticated user
    |--------------------------------------------------------------------------
    */

    async function loadCurrentUser() {
        const response = await fetchJsonApi('/api/user');

        currentUser.value = response?.user ?? response ?? null;

        return currentUser.value;
    }

    /*
    |--------------------------------------------------------------------------
    | Load universal section data
    |--------------------------------------------------------------------------
    |
    | Gallery and certificates are intentionally excluded.
    |
    */

    async function loadSectionData() {
        if (!props.isOpen || !props.product?.id || !props.section) {
            return;
        }

        isLoading.value = true;
        formError.value = '';

        resetErrors();
        resetForm();

        try {
            await loadCurrentUser();

            const productId = props.product.id;

            /*
            |--------------------------------------------------------------------------
            | FEATURES
            |--------------------------------------------------------------------------
            */

            if (props.section === 'features') {
                const response = await productsApi.getFeatures(productId);

                const features = response?.features ?? response?.data ?? response ?? {};

                form.value.features = {
                    ru: features.description_ru ?? features.ru ?? features.description?.ru ?? '',

                    en: features.description_en ?? features.en ?? features.description?.en ?? '',
                };

                form.value.features_gallery = normalizeFeaturesGallery(
                    response?.gallery ?? response?.features_gallery ?? features.gallery ?? []
                );

                originalFeaturesGalleryIds.value = form.value.features_gallery
                    .filter((item) => item.id)
                    .map((item) => item.id);

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | SPECIFICATIONS
            |--------------------------------------------------------------------------
            */

            if (props.section === 'specifications') {
                const response = await productsApi.getSpecifications(productId);

                const specifications = response?.specifications ?? response?.data ?? response ?? [];

                form.value.specifications = normalizeSpecifications(specifications);

                originalSpecificationIds.value = form.value.specifications
                    .filter((item) => item.id)
                    .map((item) => item.id);

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | DETAILS / COMPATIBLE
            |--------------------------------------------------------------------------
            */

            const response = await productsApi.getEdit(productId);

            const product = response?.product ?? response?.data ?? response ?? {};

            editProduct.value = product;

            /*
            |--------------------------------------------------------------------------
            | DETAILS
            |--------------------------------------------------------------------------
            */

            form.value.details = {
                ru: product.full_description?.ru ?? product.full_description_ru ?? '',

                en: product.full_description?.en ?? product.full_description_en ?? '',
            };

            /*
            |--------------------------------------------------------------------------
            | FEATURES
            |--------------------------------------------------------------------------
            */

            form.value.features = {
                ru: product.features?.ru ?? product.features?.description_ru ?? '',

                en: product.features?.en ?? product.features?.description_en ?? '',
            };

            /*
            |--------------------------------------------------------------------------
            | FEATURES GALLERY
            |--------------------------------------------------------------------------
            */

            form.value.features_gallery = normalizeFeaturesGallery(
                product.features?.gallery ?? product.features_gallery ?? []
            );

            originalFeaturesGalleryIds.value = form.value.features_gallery
                .filter((item) => item.id)
                .map((item) => item.id);

            /*
            |--------------------------------------------------------------------------
            | SPECIFICATIONS
            |--------------------------------------------------------------------------
            */

            form.value.specifications = normalizeSpecifications(product.specifications ?? []);

            originalSpecificationIds.value = form.value.specifications
                .filter((item) => item.id)
                .map((item) => item.id);

            /*
            |--------------------------------------------------------------------------
            | COMPATIBLE PRODUCTS
            |--------------------------------------------------------------------------
            */

            compatibleOptions.value =
                product.options?.products ??
                response?.options?.products ??
                response?.products ??
                [];

            form.value.compatible_product_ids = (
                product.compatible_product_ids ??
                product.compatibleProducts?.map((item) => item.id) ??
                product.compatible_products?.map((item) => item.id) ??
                []
            ).map(Number);
        } catch (error) {
            console.error('Failed to load product section:', error);

            formError.value = error?.message ?? 'Не удалось загрузить данные раздела.';
        } finally {
            isLoading.value = false;
        }
    }

    return {
        normalizeLocalizedObject,
        getProductLabel,
        getFeaturesImageUrl,
        normalizeFeaturesGallery,
        normalizeSpecifications,
        loadCurrentUser,
        loadSectionData,
    };
}
