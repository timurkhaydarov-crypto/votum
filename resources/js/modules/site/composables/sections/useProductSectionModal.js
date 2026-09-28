import { computed, ref } from 'vue';
import { useI18n } from 'vue-i18n';

export function useProductSectionModal({ props, emit }) {
    const { t, locale } = useI18n();

    const editProduct = ref(null);
    const currentUser = ref(null);

    const isLoading = ref(false);
    const isSaving = ref(false);
    const formError = ref('');

    const originalCertificateIds = ref([]);
    const originalGalleryIds = ref([]);
    const originalFeaturesGalleryIds = ref([]);
    const originalSpecificationIds = ref([]);

    const errors = ref({
        full_description_ru: '',
        full_description_en: '',
        features_ru: '',
        features_en: '',
        specifications: {},
        certificates: {},
        gallery: {},
    });

    const form = ref({
        details: {
            ru: '',
            en: '',
        },

        features: {
            ru: '',
            en: '',
        },

        features_gallery: [],

        specifications: [],

        certificates: [],

        gallery: [],

        compatible_product_ids: [],
    });

    const compatibleOptions = ref([]);

    /*
    |--------------------------------------------------------------------------
    | Только редактируемые секции
    |--------------------------------------------------------------------------
    */

    const supportedSections = [
        'details',
        'features',
        'specifications',
        'compatible',
        'certificates',
        'gallery',
    ];

    const isManager = computed(() => {
        return ['admin', 'manager'].includes(currentUser.value?.role);
    });

    const canSaveSection = computed(() => {
        return supportedSections.includes(props.section);
    });

    const isReadonly = computed(() => {
        return !isManager.value;
    });

    const productName = computed(() => {
        const name = editProduct.value?.name ?? props.product?.name;

        if (!name) {
            return '';
        }

        if (typeof name === 'string') {
            return name;
        }

        return name[locale.value] ?? name.ru ?? name.en ?? '';
    });

    const sectionTitle = computed(() => {
        switch (props.section) {
            case 'details':
                return t('product.info.details.title');

            case 'features':
                return t('product.info.features.title');

            case 'specifications':
                return t('product.info.specifications.title');

            case 'certificates':
                return t('certificates.title');

            case 'gallery':
                return t('gallery.title');

            case 'compatible':
                return t('compatibleProducts.title');

            default:
                return '';
        }
    });

    const selectedCompatibleProducts = computed(() => {
        const ids = new Set((form.value.compatible_product_ids ?? []).map(Number));

        return compatibleOptions.value.filter((product) => ids.has(Number(product.id)));
    });

    function resetErrors() {
        errors.value = {
            full_description_ru: '',
            full_description_en: '',
            features_ru: '',
            features_en: '',
            specifications: {},
            certificates: {},
            gallery: {},
        };
    }

    function resetForm() {
        form.value = {
            details: {
                ru: '',
                en: '',
            },

            features: {
                ru: '',
                en: '',
            },

            features_gallery: [],

            specifications: [],

            certificates: [],

            gallery: [],

            compatible_product_ids: [],
        };

        editProduct.value = null;
        compatibleOptions.value = [];

        originalCertificateIds.value = [];
        originalGalleryIds.value = [];
        originalFeaturesGalleryIds.value = [];
        originalSpecificationIds.value = [];

        resetErrors();

        formError.value = '';
    }

    function clearFieldError(section, field) {
        if (errors.value[section] && typeof errors.value[section] === 'object') {
            delete errors.value[section][field];
        }
    }

    function close(force = false) {
        if (isSaving.value && !force) {
            return;
        }

        emit('close');
    }

    return {
        t,
        locale,

        editProduct,
        currentUser,

        isLoading,
        isSaving,
        formError,

        originalCertificateIds,
        originalGalleryIds,
        originalFeaturesGalleryIds,
        originalSpecificationIds,

        errors,
        form,

        compatibleOptions,
        supportedSections,

        isManager,
        canSaveSection,
        isReadonly,

        productName,
        sectionTitle,
        selectedCompatibleProducts,

        resetErrors,
        resetForm,
        clearFieldError,
        close,
    };
}
