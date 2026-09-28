<template>
    <Transition
        enter-active-class="transition-opacity duration-200 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition-opacity duration-150 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div
            v-if="props.isOpen"
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 p-4 backdrop-blur-sm"
            @click.self="close"
        >
            <Transition
                appear
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="translate-y-3 scale-[0.98] opacity-0"
                enter-to-class="translate-y-0 scale-100 opacity-100"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="translate-y-0 scale-100 opacity-100"
                leave-to-class="translate-y-3 scale-[0.98] opacity-0"
            >
                <div
                    v-if="props.isOpen"
                    class="flex max-h-[calc(100vh-2rem)] w-full max-w-5xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-900/10"
                    role="dialog"
                    aria-modal="true"
                    :aria-label="sectionTitle"
                >
                    <!-- ====================================================
                         HEADER
                         ==================================================== -->
                    <div
                        class="flex shrink-0 items-center justify-between gap-4 border-b border-slate-200 bg-white px-5 py-4 sm:px-6"
                    >
                        <div class="min-w-0">
                            <div
                                class="flex items-center gap-2 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-400"
                            >
                                <i class="bi bi-box-seam"></i>

                                <span class="truncate">
                                    {{ productName }}
                                </span>
                            </div>

                            <h2
                                class="mt-1 truncate text-lg font-semibold tracking-tight text-slate-900"
                            >
                                {{ sectionTitle }}
                            </h2>
                        </div>

                        <button
                            type="button"
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700 disabled:cursor-not-allowed disabled:opacity-50"
                            :aria-label="t('actions.close')"
                            :disabled="isSaving"
                            @click="close"
                        >
                            <i class="bi bi-x-lg text-lg"></i>
                        </button>
                    </div>

                    <!-- ====================================================
                         CONTENT
                         ==================================================== -->
                    <div class="min-h-0 flex-1 overflow-y-auto">
                        <!-- Loading -->
                        <div
                            v-if="isLoading"
                            class="flex min-h-[280px] items-center justify-center px-6 py-12"
                        >
                            <div class="flex flex-col items-center gap-3">
                                <div
                                    class="h-8 w-8 animate-spin rounded-full border-2 border-slate-200 border-t-slate-900"
                                ></div>

                                <span class="text-xs text-slate-500">
                                    {{ t('common.loading') }}
                                </span>
                            </div>
                        </div>

                        <!-- Error -->
                        <div v-else-if="formError" class="p-5 sm:p-6">
                            <div
                                class="rounded-xl border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-700"
                            >
                                <div class="flex items-start gap-3">
                                    <i class="bi bi-exclamation-triangle-fill mt-0.5 shrink-0"></i>

                                    <div class="min-w-0">
                                        <p class="font-medium">
                                            {{ formError }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section -->
                        <div v-else class="p-5 sm:p-6">
                            <!-- ==================================================
                                 DETAILS
                                 ================================================== -->
                            <ProductDetailsSection
                                v-if="props.section === 'details'"
                                v-model="form.details"
                                :is-manager="isManager"
                                :errors="errors"
                            />

                            <!-- ==================================================
                                 FEATURES
                                 ================================================== -->
                            <ProductFeaturesSection
                                v-else-if="props.section === 'features'"
                                v-model="form.features"
                                :gallery="form.features_gallery"
                                :is-manager="isManager"
                                :errors="errors"
                                :max-gallery-items="FEATURES_GALLERY_MAX"
                                @update:gallery="form.features_gallery = $event"
                                @files="addFeaturesGalleryFiles"
                                @remove-gallery-item="removeFeaturesGalleryItem"
                            />

                            <!-- ==================================================
                                 SPECIFICATIONS
                                 ================================================== -->
                            <ProductSpecificationsSection
                                v-else-if="props.section === 'specifications'"
                                v-model="form.specifications"
                                :is-manager="isManager"
                                :errors="errors"
                            />

                            <!-- ==================================================
                                 COMPATIBLE PRODUCTS
                                 ================================================== -->
                            <ProductCompatibleSection
                                v-else-if="props.section === 'compatible'"
                                v-model="form.compatible_product_ids"
                                :products="compatibleOptions"
                                :selected-products="selectedCompatibleProducts"
                                :is-manager="isManager"
                            />

                            <!-- ==================================================
                                 CERTIFICATES
                                 ================================================== -->
                            <ProductCertificatesSection
                                v-else-if="props.section === 'certificates'"
                                v-model="form.certificates"
                                :is-manager="isManager"
                                :errors="errors"
                                @files="addCertificateFiles"
                                @remove="removeCertificate"
                            />

                            <!-- ==================================================
                                 GALLERY
                                 ================================================== -->
                            <ProductGallerySection
                                v-else-if="props.section === 'gallery'"
                                v-model="form.gallery"
                                :is-manager="isManager"
                                :errors="errors"
                                @files="addGalleryFiles"
                                @remove="removeGalleryItem"
                            />
                        </div>
                    </div>

                    <!-- ====================================================
                         FOOTER
                         ==================================================== -->
                    <div class="shrink-0 border-t border-slate-200 bg-white px-6 py-4">
                        <div
                            v-if="formError"
                            class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                        >
                            {{ formError }}
                        </div>

                        <div class="flex w-full items-center justify-end gap-3">
                            <button
                                type="button"
                                class="inline-flex h-10 items-center justify-center rounded-lg border border-slate-300 px-4 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                                @click="close()"
                            >
                                {{ $t('actions.cancel') }}
                            </button>

                            <button
                                v-if="canSaveSection"
                                type="button"
                                :disabled="isSaving"
                                class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-slate-900 px-5 text-sm font-medium text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
                                @click="saveSection"
                            >
                                <i v-if="isSaving" class="bi bi-arrow-repeat animate-spin"></i>

                                <span>
                                    {{ isSaving ? $t('actions.saving') : $t('actions.save') }}
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>
        </div>
    </Transition>
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
import ProductDocumentationSection from './sections/ProductDocumentationSection.vue';
import ProductCompatibleSection from './sections/ProductCompatibleSection.vue';
import ProductCertificatesSection from './sections/ProductCertificatesSection.vue';
import ProductGallerySection from './sections/ProductGallerySection.vue';

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

const emit = defineEmits(['close', 'updated']);

/*
|--------------------------------------------------------------------------
| Modal state
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
    documentationLinks,
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
    originalCertificateIds,
    originalGalleryIds,
    originalFeaturesGalleryIds,
    originalSpecificationIds,
    resetErrors,
    resetForm,
});

const { getProductLabel, getFeaturesImageUrl, loadSectionData } = data;

/*
|--------------------------------------------------------------------------
| Files
|--------------------------------------------------------------------------
*/

const files = useProductSectionFiles({
    props,
    form,
    isManager,
    getFeaturesImageUrl,
});

const {
    FEATURES_GALLERY_MAX,
    addFeaturesGalleryFiles,
    removeFeaturesGalleryItem,
    addCertificateFiles,
    removeCertificate,
    addGalleryFiles,
    removeGalleryItem,
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
    t,
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
| Child section updates
|--------------------------------------------------------------------------
*/

function updateCertificateItem(payload) {
    const { index, certificate } = payload ?? {};

    if (index === undefined || !certificate) {
        return;
    }

    if (!form.value.certificates[index]) {
        return;
    }

    form.value.certificates[index] = certificate;
}

function updateGalleryItem(payload) {
    const { index, changes } = payload ?? {};

    if (index === undefined || !changes) {
        return;
    }

    if (!form.value.gallery[index]) {
        return;
    }

    form.value.gallery[index] = {
        ...form.value.gallery[index],
        ...changes,
    };
}

/*
|--------------------------------------------------------------------------
| Section validation
|--------------------------------------------------------------------------
*/

function isSupportedSection(section) {
    return supportedSections.includes(section);
}

/*
|--------------------------------------------------------------------------
| Watchers
|--------------------------------------------------------------------------
*/

watch(
    [() => props.isOpen, () => props.section, () => props.product?.id],
    async () => {
        if (!props.isOpen) {
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
