<template>
    <div class="space-y-6">
        <!-- ============================================================ HEADER ============================================================ -->
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-sm font-semibold text-slate-900">{{ t('gallery.title') }}</h3>
                <p class="mt-1 text-xs text-slate-500">{{ t('gallery.description') }}</p>
            </div>
            <div v-if="isManager" class="flex items-center gap-2">
                <!-- Save all -->
                <button
                    type="button"
                    class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-slate-900 px-4 text-sm font-medium text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
                    :disabled="isUploading || !pendingItems.length"
                    @click="saveAll"
                >
                    <i v-if="isUploading" class="bi bi-arrow-repeat animate-spin"></i>
                    <i v-else class="bi bi-check-lg"></i>
                    <span> {{ isUploading ? t('actions.saving') : t('actions.save') }} </span>
                </button>
                <!-- Add -->
                <button
                    type="button"
                    class="inline-flex h-10 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 text-sm font-medium text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-50"
                    :disabled="isUploading"
                    @click="openFilePicker"
                >
                    <i class="bi bi-plus-lg"></i> <span> {{ t('actions.add') }} </span>
                </button>
            </div>
        </div>
        <!-- ============================================================ FILE INPUT ============================================================ -->
        <input
            ref="fileInput"
            type="file"
            class="hidden"
            accept="image/jpeg,image/png,image/webp"
            multiple
            @change="handleFileChange"
        />
        <!-- ============================================================ ERROR ============================================================ -->
        <div
            v-if="errorMessage"
            class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
        >
            <div class="flex items-start gap-3">
                <i class="bi bi-exclamation-triangle-fill mt-0.5 shrink-0"></i>
                <span> {{ errorMessage }} </span>
            </div>
        </div>
        <!-- ============================================================ GALLERY ============================================================ -->
        <div v-if="gallery.length" class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div
                v-for="image in gallery"
                :key="image.id"
                class="overflow-hidden rounded-xl border border-slate-200 bg-white"
            >
                <!-- Image -->
                <div class="relative aspect-[4/3] bg-slate-100">
                    <img
                        :src="image.preview_url || image.thumbnail || image.image_url"
                        :alt="getLocalizedValue(image.title) || t('gallery.image')"
                        class="h-full w-full object-cover"
                    />
                    <!-- Existing / pending badge -->
                    <div
                        class="absolute left-3 top-3 rounded-md bg-slate-900/75 px-2 py-1 text-[10px] font-medium uppercase tracking-wide text-white backdrop-blur-sm"
                    >
                        {{ image.is_pending ? t('common.notAvailable') : t('gallery.photo') }}
                    </div>
                    <!-- Delete pending item -->
                    <button
                        v-if="image.is_pending && isManager"
                        type="button"
                        class="absolute right-3 top-3 flex h-9 w-9 items-center justify-center rounded-lg bg-white/95 text-slate-600 shadow-sm transition hover:bg-white hover:text-red-600"
                        :aria-label="t('actions.delete')"
                        :disabled="isUploading"
                        @click="removePendingItem(image)"
                    >
                        <i class="bi bi-trash3"></i>
                    </button>
                </div>
                <!-- Existing image -->
                <div v-if="!image.is_pending" class="space-y-2 p-4">
                    <div
                        v-if="getLocalizedValue(image.title)"
                        class="text-sm font-medium text-slate-900"
                    >
                        {{ getLocalizedValue(image.title) }}
                    </div>
                    <div
                        v-if="getLocalizedValue(image.description)"
                        class="text-xs leading-5 text-slate-500"
                    >
                        {{ getLocalizedValue(image.description) }}
                    </div>
                </div>
                <!-- Pending image -->
                <div v-else class="space-y-4 p-4">
                    <!-- Russian title -->
                    <div>
                        <label class="mb-1.5 block text-xs font-medium text-slate-700">
                            {{ t('product.form.name.ru') }}
                        </label>
                        <input
                            v-model="image.title.ru"
                            type="text"
                            class="h-10 w-full rounded-lg border border-slate-300 px-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-500 focus:ring-1 focus:ring-slate-500"
                            :disabled="isUploading"
                        />
                    </div>
                    <!-- English title -->
                    <div>
                        <label class="mb-1.5 block text-xs font-medium text-slate-700">
                            {{ t('product.form.name.en') }}
                        </label>
                        <input
                            v-model="image.title.en"
                            type="text"
                            class="h-10 w-full rounded-lg border border-slate-300 px-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-500 focus:ring-1 focus:ring-slate-500"
                            :disabled="isUploading"
                        />
                    </div>
                    <!-- Russian description -->
                    <div>
                        <label class="mb-1.5 block text-xs font-medium text-slate-700">
                            {{ t('product.form.fullDescription.ru') }}
                        </label>
                        <textarea
                            v-model="image.description.ru"
                            rows="3"
                            class="w-full resize-y rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-500 focus:ring-1 focus:ring-slate-500"
                            :disabled="isUploading"
                        ></textarea>
                    </div>
                    <!-- English description -->
                    <div>
                        <label class="mb-1.5 block text-xs font-medium text-slate-700">
                            {{ t('product.form.fullDescription.en') }}
                        </label>
                        <textarea
                            v-model="image.description.en"
                            rows="3"
                            class="w-full resize-y rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-500 focus:ring-1 focus:ring-slate-500"
                            :disabled="isUploading"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================ EMPTY ============================================================ -->
        <div
            v-else
            class="flex min-h-[240px] items-center justify-center rounded-xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12"
        >
            <div class="text-center">
                <div
                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-white text-slate-400 shadow-sm ring-1 ring-slate-200"
                >
                    <i class="bi bi-images text-xl"></i>
                </div>
                <p class="mt-4 text-sm font-medium text-slate-700">{{ t('gallery.empty') }}</p>
            </div>
        </div>
    </div>
</template>
<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import {
    createProductGallery,
    deleteProductGallery,
    fetchProductGallery,
} from '../../../services/productGalleryApi.js';
import { uploadsApi } from '../../../services/uploadsApi.js';
const props = defineProps({
    product: { type: Object, default: null },
    isManager: { type: Boolean, default: false },
});
const emit = defineEmits(['updated']);
const { t, locale } = useI18n();
const fileInput = ref(null);
const gallery = ref([]);
const isUploading = ref(false);
const errorMessage = ref('');
const productId = computed(() => {
    return props.product?.id ?? null;
});
/* |-------------------------------------------------------------------------- | Localization |-------------------------------------------------------------------------- */ function getLocaleKey() {
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
/* |-------------------------------------------------------------------------- | Pending items |-------------------------------------------------------------------------- */ const pendingItems =
    computed(() => {
        return gallery.value.filter((item) => item.is_pending);
    });
/* |-------------------------------------------------------------------------- | File picker |-------------------------------------------------------------------------- */ function openFilePicker() {
    if (!props.isManager || isUploading.value) {
        return;
    }
    fileInput.value?.click();
}
function handleFileChange(event) {
    const files = Array.from(event.target?.files ?? []);
    if (!files.length) {
        return;
    }
    errorMessage.value = '';
    for (const file of files) {
        if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
            continue;
        }
        gallery.value.push({
            id: `pending-${Date.now()}-${Math.random()}`,
            is_pending: true,
            file,
            preview_url: URL.createObjectURL(file),
            title: { ru: '', en: '' },
            description: { ru: '', en: '' },
        });
    }
    if (fileInput.value) {
        fileInput.value.value = '';
    }
}
/* |-------------------------------------------------------------------------- | Pending item removal |-------------------------------------------------------------------------- */ function removePendingItem(
    item
) {
    if (!props.isManager || isUploading.value) {
        return;
    }
    const index = gallery.value.indexOf(item);
    if (index === -1) {
        return;
    }
    revokePreview(item);
    gallery.value.splice(index, 1);
}
/* |-------------------------------------------------------------------------- | Save |-------------------------------------------------------------------------- */ async function savePending(
    item
) {
    if (!item?.is_pending || !item.file || !productId.value) {
        return false;
    }
    try {
        const uploadResponse = await uploadsApi.upload(item.file, 'image');
        const uploadToken = uploadResponse?.upload?.token ?? uploadResponse?.token;
        if (!uploadToken) {
            throw new Error(t('messages.fail.create'));
        }
        await createProductGallery(productId.value, {
            token: uploadToken,
            title: { ru: item.title.ru.trim(), en: item.title.en.trim() },
            description: {
                ru: item.description.ru.trim() || null,
                en: item.description.en.trim() || null,
            },
        });
        revokePreview(item);
        const index = gallery.value.indexOf(item);
        if (index !== -1) {
            gallery.value.splice(index, 1);
        }
        return true;
    } catch (error) {
        console.error('Failed to save gallery item:', error);
        errorMessage.value = error?.message ?? t('messages.fail.create');
        return false;
    }
}
async function saveAll() {
    if (isUploading.value || !props.isManager || !pendingItems.value.length) {
        return;
    }
    errorMessage.value = '';
    isUploading.value = true;
    try {
        const items = [...pendingItems.value];
        for (const item of items) {
            const saved = await savePending(item);
            if (!saved) {
                return;
            }
        }
        if (!pendingItems.value.length) {
            emit('updated');
        }
    } finally {
        isUploading.value = false;
    }
}
/* |-------------------------------------------------------------------------- | Existing gallery |-------------------------------------------------------------------------- */ async function loadGallery() {
    if (!productId.value) {
        return;
    }
    try {
        const response = await fetchProductGallery(productId.value);
        const items = response?.gallery ?? response?.data ?? response ?? [];
        gallery.value = Array.isArray(items)
            ? items.map((item) => ({ ...item, is_pending: false }))
            : [];
    } catch (error) {
        console.error('Failed to load product gallery:', error);
        errorMessage.value = error?.message ?? t('messages.fail.default');
    }
}
/* |-------------------------------------------------------------------------- | Delete existing gallery item |-------------------------------------------------------------------------- */ async function deleteExistingItem(
    item
) {
    if (!props.isManager || isUploading.value || !item?.id || !productId.value) {
        return;
    }
    try {
        await deleteProductGallery(productId.value, item.id);
        const index = gallery.value.indexOf(item);
        if (index !== -1) {
            gallery.value.splice(index, 1);
        }
    } catch (error) {
        console.error('Failed to delete gallery item:', error);
        errorMessage.value = error?.message ?? t('messages.fail.delete');
    }
}
/* |-------------------------------------------------------------------------- | Preview cleanup |-------------------------------------------------------------------------- */ function revokePreview(
    item
) {
    if (item?.preview_url && item.preview_url.startsWith('blob:')) {
        URL.revokeObjectURL(item.preview_url);
    }
}
function revokeAllPreviews() {
    for (const item of gallery.value) {
        revokePreview(item);
    }
}
/* |-------------------------------------------------------------------------- | Lifecycle |-------------------------------------------------------------------------- */ onMounted(
    () => {
        loadGallery();
    }
);
onBeforeUnmount(() => {
    revokeAllPreviews();
});
</script>
