<template>
    <div
        v-if="isOpen"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/60 p-4"
    >
        <div
            class="relative flex max-h-[90vh] w-full max-w-6xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl"
        >
            <!-- =====================================================
                 HEADER
                 ===================================================== -->
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <div class="min-w-0">
                    <div
                        class="flex items-center gap-2 text-xs font-medium uppercase tracking-wide text-slate-400"
                    >
                        <span>
                            {{ t('certificates.title', 'Раздел продукта') }}
                        </span>

                        <i class="bi bi-chevron-right"></i>

                        <span class="truncate">
                            {{ sectionTitle }}
                        </span>
                    </div>

                    <h2 class="mt-1 truncate text-xl font-semibold text-slate-900">
                        {{ productName }}
                    </h2>
                </div>

                <button
                    type="button"
                    class="ml-4 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700 disabled:cursor-not-allowed disabled:opacity-50"
                    :disabled="isSaving"
                    @click="close"
                >
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <!-- =====================================================
                 CONTENT
                 ===================================================== -->
            <div class="min-h-0 flex-1 overflow-y-auto">
                <!-- Loading -->
                <div v-if="isLoading" class="flex min-h-[320px] items-center justify-center">
                    <div class="flex items-center gap-3 text-sm text-slate-500">
                        <span
                            class="h-5 w-5 animate-spin rounded-full border-2 border-slate-300 border-t-slate-700"
                        ></span>

                        {{ t('common.loading', 'Загрузка...') }}
                    </div>
                </div>

                <!-- Error -->
                <div v-else-if="formError" class="p-6">
                    <div
                        class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                    >
                        {{ formError }}
                    </div>
                </div>

                <!-- Section -->
                <div v-else class="p-6">
                    <!-- =================================================
                         DETAILS
                         ================================================= -->
                    <ProductDetailsSection
                        v-if="props.section === 'details'"
                        :form="form"
                        :errors="errors"
                        :is-manager="isManager"
                    />

                    <!-- =================================================
                         FEATURES
                         ================================================= -->
                    <ProductFeaturesSection
                        v-else-if="props.section === 'features'"
                        :form="form"
                        :errors="errors"
                        :is-manager="isManager"
                        :get-features-image-url="getFeaturesImageUrl"
                        :add-features-gallery-files="addFeaturesGalleryFiles"
                        :remove-features-gallery-item="removeFeaturesGalleryItem"
                        :features-gallery-max="FEATURES_GALLERY_MAX"
                    />

                    <!-- =================================================
                         SPECIFICATIONS
                         ================================================= -->
                    <ProductSpecificationsSection
                        v-else-if="props.section === 'specifications'"
                        :form="form"
                        :errors="errors"
                        :is-manager="isManager"
                    />

                    <!-- =================================================
                         COMPATIBLE
                         ================================================= -->
                    <ProductCompatibleSection
                        v-else-if="props.section === 'compatible'"
                        :form="form"
                        :errors="errors"
                        :compatible-options="compatibleOptions"
                        :selected-products="selectedCompatibleProducts"
                        :is-manager="isManager"
                    />

                    <!-- =================================================
                         CERTIFICATES
                         ================================================= -->
                    <ProductCertificatesSection
                        v-else-if="props.section === 'certificates'"
                        :product-id="props.product?.id"
                        :is-manager="isManager"
                        :is-admin="isAdmin"
                        @updated="handleSectionUpdated"
                    />

                    <!-- =================================================
                         GALLERY
                         ================================================= -->
                    <ProductGalleryManager
                        v-else-if="props.section === 'gallery'"
                        :product="props.product"
                        :is-manager="isManager"
                        @updated="handleSectionUpdated"
                    />

                    <!-- =================================================
                         UNSUPPORTED
                         ================================================= -->
                    <div
                        v-else
                        class="flex min-h-[240px] items-center justify-center rounded-xl border border-dashed border-slate-300 bg-slate-50"
                    >
                        <div class="text-center text-sm text-slate-500">
                            {{ t('products.sections.unsupported', 'Раздел не поддерживается.') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- =====================================================
                 FOOTER
                 ===================================================== -->
            <div
                v-if="
                    props.section !== 'certificates' &&
                    props.section !== 'gallery' &&
                    canSaveSection
                "
                class="flex items-center justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4"
            >
                <button
                    type="button"
                    class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-50"
                    :disabled="isSaving"
                    @click="close"
                >
                    {{ t('common.cancel', 'Отмена') }}
                </button>

                <button
                    type="button"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
                    :disabled="isSaving"
                    @click="saveSection"
                >
                    <span
                        v-if="isSaving"
                        class="h-4 w-4 animate-spin rounded-full border-2 border-slate-500 border-t-white"
                    ></span>

                    <i v-else class="bi bi-check-lg"></i>

                    {{
                        isSaving
                            ? t('common.saving', 'Сохранение...')
                            : t('common.save', 'Сохранить')
                    }}
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onBeforeUnmount, watch } from 'vue';

import { useProductSectionModal } from '../../../composables/sections/useProductSectionModal.js';
import { useProductSectionData } from '../../../composables/sections/useProductSectionData.js';
import { useProductSectionFiles } from '../../../composables/sections/useProductSectionFiles.js';
import { useProductSectionSave } from '../../../composables/sections/useProductSectionSave.js';

import ProductDetailsSection from './sections/ProductDetailsSection.vue';
import ProductFeaturesSection from './sections/ProductFeaturesSection.vue';
import ProductSpecificationsSection from './sections/ProductSpecificationsSection.vue';
import ProductCompatibleSection from './sections/ProductCompatibleSection.vue';
import ProductCertificatesSection from './sections/ProductCertificatesSection.vue';
import ProductGalleryManager from './ProductGalleryManager.vue';

/*
|--------------------------------------------------------------------------
| Props
|--------------------------------------------------------------------------
*/

const props = defineProps({
    isOpen: {
        type: Boolean,
        default: false,
    },

    product: {
        type: Object,
        default: null,
    },

    section: {
        type: String,
        default: null,
    },
});

/*
|--------------------------------------------------------------------------
| Emits
|--------------------------------------------------------------------------
*/

const emit = defineEmits(['close', 'updated']);

/*
|--------------------------------------------------------------------------
| Modal
|--------------------------------------------------------------------------
*/

const modal = useProductSectionModal({
    props,
    emit,
});

const {
    t,
    locale,
    editProduct,
    currentUser,
    isLoading,
    isSaving,
    formError,
    originalFeaturesGalleryIds,
    originalSpecificationIds,
    errors,
    form,
    compatibleOptions,
    supportedSections,
    isManager,
    isAdmin,
    canSaveSection,
    productName,
    sectionTitle,
    selectedCompatibleProducts,
    resetErrors,
    resetForm,
    close,
} = modal;

/*
|--------------------------------------------------------------------------
| Section data
|--------------------------------------------------------------------------
*/

const data = useProductSectionData({
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
});

const { loadSectionData, loadCurrentUser, getFeaturesImageUrl } = data;

/*
|--------------------------------------------------------------------------
| Files
|--------------------------------------------------------------------------
*/

const files = useProductSectionFiles({
    form,
    isManager,
    getFeaturesImageUrl,
});

const {
    FEATURES_GALLERY_MAX,
    addFeaturesGalleryFiles,
    removeFeaturesGalleryItem,
    revokeAllPreviews,
} = files;

/*
|--------------------------------------------------------------------------
| Save
|--------------------------------------------------------------------------
*/

const save = useProductSectionSave({
    props,
    emit,
    isSaving,
    formError,
    errors,
    form,
    originalFeaturesGalleryIds,
    originalSpecificationIds,
    isManager,
    close,
});

const { saveSection } = save;

/*
|--------------------------------------------------------------------------
| Supported section
|--------------------------------------------------------------------------
*/

function isSupportedSection(section) {
    return supportedSections.includes(section);
}

/*
|--------------------------------------------------------------------------
| Section update
|--------------------------------------------------------------------------
*/

function handleSectionUpdated() {
    emit('updated');
    close();
}

/*
|--------------------------------------------------------------------------
| Load section data
|--------------------------------------------------------------------------
*/

watch(
    [() => props.isOpen, () => props.section, () => props.product?.id],
    async () => {
        if (!props.isOpen) {
            return;
        }

        /*
         * Gallery and certificates have their own APIs.
         *
         * We only need the current authenticated user
         * because isManager/isAdmin depend on currentUser.
         */
        if (props.section === 'gallery' || props.section === 'certificates') {
            try {
                await loadCurrentUser();
            } catch (error) {
                console.error('Failed to load current user:', error);
            }

            return;
        }

        if (!isSupportedSection(props.section)) {
            return;
        }

        await loadSectionData();
    },
    {
        immediate: true,
    }
);

/*
|--------------------------------------------------------------------------
| Cleanup
|--------------------------------------------------------------------------
*/

onBeforeUnmount(() => {
    revokeAllPreviews();
});
</script>
