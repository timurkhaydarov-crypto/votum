<template>
    <section ref="gallerySection">
        <!-- HEADER -->
        <SectionHeader :title="t('gallery.title')" :description="t('gallery.description')">
            <template #meta> {{ images.length }} {{ t('common.pcs') }} </template>

            <template #actions>
                <div class="flex items-center gap-1">
                    <!-- ADD IMAGE -->
                    <button
                        v-if="canManage"
                        type="button"
                        class="flex h-7 w-7 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                        :aria-label="t('actions.add')"
                        @click="emit('manage')"
                    >
                        <i class="bi bi-plus-lg text-sm"></i>
                    </button>

                    <!-- TOGGLE SECTION -->
                    <button
                        type="button"
                        class="flex h-7 w-7 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                        :aria-label="isOpen ? t('common.collapse') : t('common.showAll')"
                        @click="toggleSection"
                    >
                        <i
                            class="bi text-xs transition-transform duration-300"
                            :class="isOpen ? 'bi-chevron-up' : 'bi-chevron-down'"
                        ></i>
                    </button>
                </div>
            </template>
        </SectionHeader>

        <!-- CONTENT -->
        <Transition
            enter-active-class="overflow-hidden transition-all duration-300 ease-out"
            enter-from-class="max-h-0 opacity-0 -translate-y-2"
            enter-to-class="max-h-[3000px] opacity-100 translate-y-0"
            leave-active-class="overflow-hidden transition-all duration-300 ease-in"
            leave-from-class="max-h-[3000px] opacity-100 translate-y-0"
            leave-to-class="max-h-0 opacity-0 -translate-y-2"
        >
            <div v-if="isOpen" class="mt-4">
                <!-- GALLERY -->
                <div v-if="images.length" class="grid grid-cols-2 gap-3 md:grid-cols-4">
                    <div
                        v-for="(image, index) in visibleImages"
                        :key="image.id || image.image_url || index"
                        class="group relative aspect-[4/3]"
                    >
                        <!-- IMAGE -->
                        <button
                            type="button"
                            class="relative block h-full w-full overflow-hidden rounded-2xl text-left"
                            @click="openModal(image)"
                        >
                            <div
                                class="relative h-full w-full overflow-hidden rounded-2xl border border-slate-200 bg-slate-50"
                            >
                                <img
                                    :src="image.image_url"
                                    :alt="
                                        getLocalizedValue(image.title) ||
                                        `${product.title} ${index + 1}`
                                    "
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                />

                                <!-- DARK OVERLAY -->
                                <div
                                    class="pointer-events-none absolute inset-0 bg-slate-950/20 opacity-0 transition duration-300 group-hover:opacity-100"
                                ></div>

                                <!-- SEARCH ICON -->
                                <div
                                    class="pointer-events-none absolute inset-0 z-10 flex items-center justify-center opacity-0 transition-all duration-300 group-hover:opacity-100"
                                >
                                    <div
                                        class="flex h-11 w-11 scale-90 items-center justify-center rounded-full bg-slate-900/70 text-white shadow-lg backdrop-blur-sm transition-transform duration-300 group-hover:scale-100"
                                    >
                                        <i class="bi bi-search text-base"></i>
                                    </div>
                                </div>
                            </div>
                        </button>

                        <!-- TOOLTIP -->
                        <div
                            v-if="getLocalizedValue(image.title)"
                            class="pointer-events-none absolute bottom-3 left-3 right-3 z-20 translate-y-2 rounded-lg bg-slate-900/90 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-lg backdrop-blur-sm transition-all duration-200 group-hover:translate-y-0 group-hover:opacity-100"
                        >
                            {{ getLocalizedValue(image.title) }}
                        </div>

                        <!-- MANAGEMENT ACTIONS -->
                        <div
                            v-if="canManage"
                            class="absolute right-2 top-2 z-30 flex items-center gap-1 opacity-0 transition-opacity duration-200 group-hover:opacity-100"
                        >
                            <!-- EDIT -->
                            <button
                                type="button"
                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/95 text-slate-600 shadow-md backdrop-blur-sm transition hover:bg-white hover:text-slate-900 disabled:cursor-not-allowed disabled:opacity-50"
                                :disabled="isSaving(image.id)"
                                :aria-label="t('actions.edit')"
                                @click.stop="openEdit(image)"
                            >
                                <i class="bi bi-pencil text-xs"></i>
                            </button>

                            <!-- DELETE -->
                            <button
                                type="button"
                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/95 text-red-500 shadow-md backdrop-blur-sm transition hover:bg-white hover:text-red-600 disabled:cursor-not-allowed disabled:opacity-50"
                                :disabled="isSaving(image.id)"
                                :aria-label="t('actions.delete')"
                                @click.stop="deleteImage(image)"
                            >
                                <span
                                    v-if="isSaving(image.id)"
                                    class="h-3.5 w-3.5 animate-spin rounded-full border-2 border-red-200 border-t-red-500"
                                ></span>

                                <i v-else class="bi bi-trash text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- EMPTY -->
                <div v-else class="rounded-2xl border border-amber-200 bg-amber-50/50 p-8">
                    <EmptyData />
                </div>

                <!-- SHOW MORE / COLLAPSE -->
                <div v-if="images.length > 4" class="mt-4 flex justify-center">
                    <button
                        type="button"
                        class="group inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-600 shadow-sm transition hover:border-slate-300 hover:text-slate-900"
                        @click="toggleImages"
                    >
                        <span>
                            {{ isAllImagesVisible ? t('common.collapse') : t('common.showMore') }}
                        </span>

                        <i
                            class="bi transition-transform duration-300"
                            :class="isAllImagesVisible ? 'bi-chevron-up' : 'bi-chevron-down'"
                        ></i>
                    </button>
                </div>
            </div>
        </Transition>

        <!-- IMAGE MODAL -->
        <Teleport to="body">
            <Transition
                enter-active-class="transition duration-300 ease-out"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition duration-200 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="selectedImage"
                    class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/90 p-4 backdrop-blur-sm sm:p-6"
                    @click.self="closeModal"
                >
                    <!-- CLOSE BUTTON -->
                    <button
                        type="button"
                        class="absolute right-4 top-4 z-20 flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-white transition hover:bg-white/20 sm:right-6 sm:top-6"
                        :aria-label="t('common.close')"
                        @click="closeModal"
                    >
                        <i class="bi bi-x-lg"></i>
                    </button>

                    <!-- IMAGE CONTENT -->
                    <div class="relative flex max-h-full max-w-7xl flex-col items-center">
                        <img
                            :src="selectedImage.image_url"
                            :alt="getLocalizedValue(selectedImage.title) || product.title"
                            class="max-h-[85vh] max-w-full rounded-xl object-contain shadow-2xl"
                        />

                        <!-- TITLE -->
                        <div
                            v-if="getLocalizedValue(selectedImage.title)"
                            class="mt-4 max-w-2xl text-center text-sm font-medium text-white"
                        >
                            {{ getLocalizedValue(selectedImage.title) }}
                        </div>

                        <!-- DESCRIPTION -->
                        <div
                            v-if="getLocalizedValue(selectedImage.description)"
                            class="mt-2 max-w-2xl text-center text-xs leading-5 text-slate-300"
                        >
                            {{ getLocalizedValue(selectedImage.description) }}
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>

        <!-- EDIT MODAL -->
        <Teleport to="body">
            <Transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="editingImage"
                    class="fixed inset-0 z-[120] flex items-center justify-center bg-slate-950/60 p-4 backdrop-blur-sm"
                    @click.self="closeEdit"
                >
                    <div class="w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl">
                        <!-- HEADER -->
                        <div
                            class="flex items-center justify-between border-b border-slate-200 px-6 py-4"
                        >
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">
                                    {{ t('actions.edit') }}
                                </h3>

                                <p class="mt-1 text-xs text-slate-500">
                                    {{ t('product.form.gallery.title') }}
                                </p>
                            </div>

                            <button
                                type="button"
                                class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700 disabled:opacity-50"
                                :disabled="isEditing"
                                :aria-label="t('common.close')"
                                @click="closeEdit"
                            >
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>

                        <!-- FORM -->
                        <div class="space-y-5 p-6">
                            <div
                                v-if="editError"
                                class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                            >
                                {{ editError }}
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <!-- RU TITLE -->
                                <div>
                                    <label class="mb-1.5 block text-xs font-medium text-slate-600">
                                        {{ t('product.form.gallery.titleRu') }}
                                    </label>

                                    <input
                                        v-model="editingImage.title.ru"
                                        type="text"
                                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-slate-500 focus:ring-1 focus:ring-slate-500 disabled:bg-slate-50"
                                        :disabled="isEditing"
                                    />
                                </div>

                                <!-- EN TITLE -->
                                <div>
                                    <label class="mb-1.5 block text-xs font-medium text-slate-600">
                                        {{ t('product.form.gallery.titleEn') }}
                                    </label>

                                    <input
                                        v-model="editingImage.title.en"
                                        type="text"
                                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-slate-500 focus:ring-1 focus:ring-slate-500 disabled:bg-slate-50"
                                        :disabled="isEditing"
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <!-- RU DESCRIPTION -->
                                <div>
                                    <label class="mb-1.5 block text-xs font-medium text-slate-600">
                                        {{ t('product.form.gallery.descriptionRu') }}
                                    </label>

                                    <textarea
                                        v-model="editingImage.description.ru"
                                        rows="5"
                                        class="w-full resize-none rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-slate-500 focus:ring-1 focus:ring-slate-500 disabled:bg-slate-50"
                                        :disabled="isEditing"
                                    ></textarea>
                                </div>

                                <!-- EN DESCRIPTION -->
                                <div>
                                    <label class="mb-1.5 block text-xs font-medium text-slate-600">
                                        {{ t('product.form.gallery.descriptionEn') }}
                                    </label>

                                    <textarea
                                        v-model="editingImage.description.en"
                                        rows="5"
                                        class="w-full resize-none rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-slate-500 focus:ring-1 focus:ring-slate-500 disabled:bg-slate-50"
                                        :disabled="isEditing"
                                    ></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- FOOTER -->
                        <div
                            class="flex items-center justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4"
                        >
                            <button
                                type="button"
                                class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-50"
                                :disabled="isEditing"
                                @click="closeEdit"
                            >
                                {{ t('actions.cancel') }}
                            </button>

                            <button
                                type="button"
                                class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
                                :disabled="isEditing"
                                @click="saveEdit"
                            >
                                <span
                                    v-if="isEditing"
                                    class="h-4 w-4 animate-spin rounded-full border-2 border-slate-500 border-t-white"
                                ></span>

                                <i v-else class="bi bi-check-lg"></i>

                                {{ isEditing ? t('actions.saving') : t('actions.save') }}
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>
    </section>
</template>

<script setup>
import { computed, ref } from 'vue';

import { useI18n } from 'vue-i18n';

import SectionHeader from '../SectionHeader.vue';
import EmptyData from '../EmptyData.vue';

import { deleteProductGallery, updateProductGallery } from '../../../services/productGalleryApi.js';

const { t, locale } = useI18n();

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },

    images: {
        type: Array,
        default: () => [],
    },

    canManage: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['manage', 'updated']);

/*
|--------------------------------------------------------------------------
| Localization
|--------------------------------------------------------------------------
*/

function getLocaleKey() {
    const currentLocale = String(locale.value || 'ru').toLowerCase();

    if (currentLocale === 'en' || currentLocale.startsWith('en-')) {
        return 'en';
    }

    return 'ru';
}

function getLocalizedValue(value) {
    if (!value) {
        return '';
    }

    if (typeof value === 'object' && !Array.isArray(value)) {
        const language = getLocaleKey();

        return value[language] ?? value.ru ?? value.en ?? '';
    }

    if (typeof value === 'string') {
        return value;
    }

    return '';
}

/*
|--------------------------------------------------------------------------
| Section
|--------------------------------------------------------------------------
*/

const isOpen = ref(true);

const gallerySection = ref(null);

/*
|--------------------------------------------------------------------------
| Gallery
|--------------------------------------------------------------------------
*/

const visibleCount = ref(4);

const selectedImage = ref(null);

const editingImage = ref(null);

const isEditing = ref(false);

const editError = ref('');

const savingIds = ref(new Set());

/*
|--------------------------------------------------------------------------
| Visible images
|--------------------------------------------------------------------------
*/

const visibleImages = computed(() => {
    return props.images.slice(0, visibleCount.value);
});

/*
|--------------------------------------------------------------------------
| Is all images visible
|--------------------------------------------------------------------------
*/

const isAllImagesVisible = computed(() => {
    return visibleCount.value >= props.images.length;
});

/*
|--------------------------------------------------------------------------
| Toggle section
|--------------------------------------------------------------------------
*/

const toggleSection = () => {
    isOpen.value = !isOpen.value;

    if (!isOpen.value) {
        visibleCount.value = 4;
    }
};

/*
|--------------------------------------------------------------------------
| Toggle images
|--------------------------------------------------------------------------
*/

const toggleImages = () => {
    if (isAllImagesVisible.value) {
        visibleCount.value = 4;

        requestAnimationFrame(() => {
            gallerySection.value?.scrollIntoView({
                behavior: 'smooth',
                block: 'start',
            });
        });

        return;
    }

    visibleCount.value = Math.min(visibleCount.value + 4, props.images.length);
};

/*
|--------------------------------------------------------------------------
| Image modal
|--------------------------------------------------------------------------
*/

const openModal = (image) => {
    selectedImage.value = image;

    document.body.classList.add('overflow-hidden');
};

const closeModal = () => {
    selectedImage.value = null;

    if (!editingImage.value) {
        document.body.classList.remove('overflow-hidden');
    }
};

/*
|--------------------------------------------------------------------------
| Edit
|--------------------------------------------------------------------------
*/

const openEdit = (image) => {
    editError.value = '';

    editingImage.value = {
        id: image.id,

        title: {
            ru: image.title?.ru ?? '',
            en: image.title?.en ?? '',
        },

        description: {
            ru: image.description?.ru ?? '',
            en: image.description?.en ?? '',
        },
    };

    document.body.classList.add('overflow-hidden');
};

const closeEdit = () => {
    if (isEditing.value) {
        return;
    }

    editingImage.value = null;
    editError.value = '';

    if (!selectedImage.value) {
        document.body.classList.remove('overflow-hidden');
    }
};

const saveEdit = async () => {
    if (!editingImage.value || isEditing.value) {
        return;
    }

    const item = editingImage.value;

    if (!item.title.ru.trim() || !item.title.en.trim()) {
        editError.value = 'Required fields are missing.';
        return;
    }

    isEditing.value = true;
    editError.value = '';

    try {
        await updateProductGallery(props.product.id, item.id, {
            title: {
                ru: item.title.ru,
                en: item.title.en,
            },

            description: {
                ru: item.description.ru || null,

                en: item.description.en || null,
            },
        });

        const originalImage = props.images.find((image) => Number(image.id) === Number(item.id));

        if (originalImage) {
            originalImage.title = {
                ...item.title,
            };

            originalImage.description = {
                ...item.description,
            };
        }

        editingImage.value = null;

        document.body.classList.remove('overflow-hidden');

        emit('updated');
    } catch (error) {
        console.error('Failed to update gallery image:', error);

        editError.value = error?.message || 'Failed to update gallery image.';
    } finally {
        isEditing.value = false;
    }
};

/*
|--------------------------------------------------------------------------
| Delete
|--------------------------------------------------------------------------
*/

const setSaving = (id, value) => {
    const next = new Set(savingIds.value);

    if (value) {
        next.add(id);
    } else {
        next.delete(id);
    }

    savingIds.value = next;
};

const isSaving = (id) => {
    return savingIds.value.has(id);
};

const deleteImage = async (image) => {
    if (!image?.id || isSaving(image.id)) {
        return;
    }

    const confirmed = window.confirm(t('messages.confirm.delete'));

    if (!confirmed) {
        return;
    }

    setSaving(image.id, true);

    try {
        await deleteProductGallery(props.product.id, image.id);

        if (selectedImage.value?.id === image.id) {
            closeModal();
        }

        emit('updated');
    } catch (error) {
        console.error('Failed to delete gallery image:', error);

        window.alert(error?.message || 'Failed to delete gallery image.');
    } finally {
        setSaving(image.id, false);
    }
};
</script>
