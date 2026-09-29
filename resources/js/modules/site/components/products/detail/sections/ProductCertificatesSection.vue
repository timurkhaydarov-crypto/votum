<template>
    <section class="space-y-5">
        <!-- =========================================================
             HEADER
             ========================================================= -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <div class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">
                    {{ $t('certificates.eyebrow') }}
                </div>

                <h3 class="mt-1 text-lg font-semibold text-slate-900">
                    {{ $t('certificates.title') }}
                </h3>

                <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-500">
                    {{ $t('certificates.description') }}
                </p>
            </div>

            <button
                v-if="props.isManager"
                type="button"
                class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
                :disabled="isWorking"
                @click="openCreateForm"
            >
                <i class="bi bi-plus-lg"></i>
                {{ $t('actions.add') }}
            </button>
        </div>

        <!-- =========================================================
             SEARCH
             ========================================================= -->
        <div class="relative">
            <input
                v-model="search"
                type="search"
                class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-400 focus:ring-2 focus:ring-slate-900/5"
                :placeholder="$t('actions.search')"
            />

            <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
        </div>

        <!-- =========================================================
             ERROR
             ========================================================= -->
        <div
            v-if="error"
            class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
        >
            <i class="bi bi-exclamation-circle mt-0.5"></i>
            <span>{{ error }}</span>
        </div>

        <!-- =========================================================
             LOADING
             ========================================================= -->
        <div
            v-if="isLoading"
            class="flex min-h-[240px] items-center justify-center rounded-2xl border border-slate-200 bg-slate-50"
        >
            <div class="flex items-center gap-3 text-sm text-slate-500">
                <span
                    class="h-5 w-5 animate-spin rounded-full border-2 border-slate-300 border-t-slate-700"
                ></span>

                {{ $t('common.loading') }}
            </div>
        </div>

        <!-- =========================================================
             EMPTY
             ========================================================= -->
        <div
            v-else-if="!certificates.length"
            class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center"
        >
            <div
                class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-white text-slate-400 shadow-sm"
            >
                <i class="bi bi-patch-check text-xl"></i>
            </div>

            <div class="mt-4 text-sm font-semibold text-slate-700">
                {{ search ? $t('common.notAvailable') : $t('certificates.empty') }}
            </div>
        </div>

        <!-- =========================================================
             LIST
             ========================================================= -->
        <div v-else class="space-y-8">
            <!-- =====================================================
                 ATTACHED CERTIFICATES
                 ===================================================== -->
            <section v-if="attachedCertificates.length">
                <div class="mb-4 flex items-center gap-3">
                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600"
                    >
                        <i class="bi bi-link-45deg text-lg"></i>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-slate-900">
                            {{ $t('certificates.title') }}
                        </h4>

                        <p class="mt-0.5 text-xs text-slate-400">
                            {{ attachedCertificates.length }}
                        </p>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <article
                        v-for="certificate in attachedCertificates"
                        :key="`attached-${certificate.id}`"
                        class="overflow-hidden rounded-2xl border border-emerald-200 bg-white"
                    >
                        <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                            <img
                                v-if="certificate.thumbnail || certificate.image"
                                :src="certificate.thumbnail || certificate.image"
                                :alt="localizedValue(certificate.title)"
                                class="h-full w-full object-contain p-4"
                            />

                            <div
                                v-else
                                class="flex h-full items-center justify-center text-slate-400"
                            >
                                <i class="bi bi-image text-3xl"></i>
                            </div>

                            <div
                                class="absolute left-3 top-3 inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-[11px] font-semibold text-emerald-700"
                            >
                                <i class="bi bi-check-circle-fill"></i>
                                {{ $t('actions.enable') }}
                            </div>
                        </div>

                        <div class="p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h4
                                        class="truncate text-sm font-semibold text-slate-900"
                                        :title="localizedValue(certificate.title)"
                                    >
                                        {{ localizedValue(certificate.title) }}
                                    </h4>

                                    <p
                                        v-if="localizedValue(certificate.description)"
                                        class="mt-1 line-clamp-2 text-xs leading-5 text-slate-500"
                                    >
                                        {{ localizedValue(certificate.description) }}
                                    </p>
                                </div>
                            </div>

                            <div v-if="props.isManager" class="mt-4 grid grid-cols-2 gap-2">
                                <button
                                    type="button"
                                    class="inline-flex items-center justify-center gap-2 rounded-lg border px-3 py-2 text-xs font-semibold transition disabled:cursor-not-allowed disabled:opacity-50"
                                    :class="getAttachButtonClass(certificate.id)"
                                    :disabled="isWorking || workingCertificateId === certificate.id"
                                    @click="toggleAttach(certificate)"
                                >
                                    <span
                                        v-if="workingCertificateId === certificate.id"
                                        class="h-3.5 w-3.5 animate-spin rounded-full border-2 border-current border-t-transparent"
                                    ></span>

                                    <i v-else :class="getAttachButtonIcon(certificate.id)"></i>

                                    {{ $t('actions.remove') }}
                                </button>

                                <button
                                    type="button"
                                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-50"
                                    :disabled="isWorking"
                                    @click="openEditForm(certificate)"
                                >
                                    <i class="bi bi-pencil"></i>
                                    {{ $t('actions.edit') }}
                                </button>

                                <button
                                    v-if="isAdmin"
                                    type="button"
                                    class="col-span-2 inline-flex items-center justify-center gap-2 rounded-lg border border-red-200 bg-white px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-50"
                                    :disabled="isWorking"
                                    @click="deleteCertificate(certificate)"
                                >
                                    <span
                                        v-if="deletingCertificateId === certificate.id"
                                        class="h-3.5 w-3.5 animate-spin rounded-full border-2 border-red-300 border-t-red-600"
                                    ></span>

                                    <i v-else class="bi bi-trash"></i>

                                    {{ $t('actions.delete') }}
                                </button>
                            </div>
                        </div>
                    </article>
                </div>
            </section>

            <!-- =====================================================
                 UNATTACHED CERTIFICATES
                 ===================================================== -->
            <section v-if="unattachedCertificates.length">
                <div class="mb-4 flex items-center gap-3">
                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100 text-slate-500"
                    >
                        <i class="bi bi-award text-lg"></i>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-slate-900">
                            {{ $t('common.available') }}
                        </h4>

                        <p class="mt-0.5 text-xs text-slate-400">
                            {{ unattachedCertificates.length }}
                        </p>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <article
                        v-for="certificate in unattachedCertificates"
                        :key="`unattached-${certificate.id}`"
                        class="overflow-hidden rounded-2xl border border-slate-200 bg-white"
                    >
                        <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                            <img
                                v-if="certificate.thumbnail || certificate.image"
                                :src="certificate.thumbnail || certificate.image"
                                :alt="localizedValue(certificate.title)"
                                class="h-full w-full object-contain p-4"
                            />

                            <div
                                v-else
                                class="flex h-full items-center justify-center text-slate-400"
                            >
                                <i class="bi bi-image text-3xl"></i>
                            </div>
                        </div>

                        <div class="p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h4
                                        class="truncate text-sm font-semibold text-slate-900"
                                        :title="localizedValue(certificate.title)"
                                    >
                                        {{ localizedValue(certificate.title) }}
                                    </h4>

                                    <p
                                        v-if="localizedValue(certificate.description)"
                                        class="mt-1 line-clamp-2 text-xs leading-5 text-slate-500"
                                    >
                                        {{ localizedValue(certificate.description) }}
                                    </p>
                                </div>
                            </div>

                            <div v-if="props.isManager" class="mt-4 grid grid-cols-2 gap-2">
                                <button
                                    type="button"
                                    class="inline-flex items-center justify-center gap-2 rounded-lg border px-3 py-2 text-xs font-semibold transition disabled:cursor-not-allowed disabled:opacity-50"
                                    :class="getAttachButtonClass(certificate.id)"
                                    :disabled="isWorking || workingCertificateId === certificate.id"
                                    @click="toggleAttach(certificate)"
                                >
                                    <span
                                        v-if="workingCertificateId === certificate.id"
                                        class="h-3.5 w-3.5 animate-spin rounded-full border-2 border-current border-t-transparent"
                                    ></span>

                                    <i v-else :class="getAttachButtonIcon(certificate.id)"></i>

                                    {{ $t('actions.add') }}
                                </button>

                                <button
                                    type="button"
                                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-50"
                                    :disabled="isWorking"
                                    @click="openEditForm(certificate)"
                                >
                                    <i class="bi bi-pencil"></i>
                                    {{ $t('actions.edit') }}
                                </button>

                                <button
                                    v-if="isAdmin"
                                    type="button"
                                    class="col-span-2 inline-flex items-center justify-center gap-2 rounded-lg border border-red-200 bg-white px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-50"
                                    :disabled="isWorking"
                                    @click="deleteCertificate(certificate)"
                                >
                                    <span
                                        v-if="deletingCertificateId === certificate.id"
                                        class="h-3.5 w-3.5 animate-spin rounded-full border-2 border-red-300 border-t-red-600"
                                    ></span>

                                    <i v-else class="bi bi-trash"></i>

                                    {{ $t('actions.delete') }}
                                </button>
                            </div>
                        </div>
                    </article>
                </div>
            </section>
        </div>
    </section>

    <!-- =========================================================
         CREATE / EDIT MODAL
         ========================================================= -->
    <Teleport to="body">
        <div
            v-if="showForm"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/50 p-4"
            @click.self="closeForm"
        >
            <div
                class="relative flex max-h-[90vh] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl"
            >
                <!-- HEADER -->
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                    <div>
                        <div
                            class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400"
                        >
                            {{ isEditMode ? $t('actions.edit') : $t('actions.add') }}
                        </div>

                        <h3 class="mt-1 text-lg font-semibold text-slate-900">
                            {{
                                isEditMode
                                    ? localizedValue(editingCertificate?.title)
                                    : $t('actions.create')
                            }}
                        </h3>
                    </div>

                    <button
                        type="button"
                        class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                        :disabled="isSaving"
                        @click="closeForm"
                    >
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <!-- CONTENT -->
                <div class="min-h-0 flex-1 overflow-y-auto p-6">
                    <div
                        v-if="formError"
                        class="mb-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                    >
                        <i class="bi bi-exclamation-circle mt-0.5"></i>

                        <span>{{ formError }}</span>
                    </div>

                    <div class="space-y-5">
                        <!-- RU TITLE -->
                        <div>
                            <label class="mb-2 block text-xs font-semibold text-slate-700">
                                {{ $t('product.form.name.ru') }}

                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                v-model="form.title.ru"
                                type="text"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-400 focus:ring-2 focus:ring-slate-900/5"
                                :disabled="isSaving"
                            />
                        </div>

                        <!-- EN TITLE -->
                        <div>
                            <label class="mb-2 block text-xs font-semibold text-slate-700">
                                {{ $t('product.form.name.en') }}

                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                v-model="form.title.en"
                                type="text"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-400 focus:ring-2 focus:ring-slate-900/5"
                                :disabled="isSaving"
                            />
                        </div>

                        <!-- RU DESCRIPTION -->
                        <div>
                            <label class="mb-2 block text-xs font-semibold text-slate-700">
                                {{ $t('product.form.fullDescription.ru') }}
                            </label>

                            <textarea
                                v-model="form.description.ru"
                                rows="3"
                                class="w-full resize-y rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-400 focus:ring-2 focus:ring-slate-900/5"
                                :disabled="isSaving"
                            ></textarea>
                        </div>

                        <!-- EN DESCRIPTION -->
                        <div>
                            <label class="mb-2 block text-xs font-semibold text-slate-700">
                                {{ $t('product.form.fullDescription.en') }}
                            </label>

                            <textarea
                                v-model="form.description.en"
                                rows="3"
                                class="w-full resize-y rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-400 focus:ring-2 focus:ring-slate-900/5"
                                :disabled="isSaving"
                            ></textarea>
                        </div>

                        <!-- IMAGE -->
                        <div>
                            <label class="mb-2 block text-xs font-semibold text-slate-700">
                                {{ isEditMode ? $t('actions.update') : $t('product.form.image') }}

                                <span v-if="!isEditMode" class="text-red-500"> * </span>
                            </label>

                            <div
                                class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50"
                            >
                                <div
                                    v-if="imagePreview || currentImage"
                                    class="relative flex min-h-[220px] items-center justify-center border-b border-slate-200 bg-white p-4"
                                >
                                    <img
                                        :src="imagePreview || currentImage"
                                        alt=""
                                        class="max-h-[260px] max-w-full object-contain"
                                    />

                                    <button
                                        v-if="imagePreview"
                                        type="button"
                                        class="absolute right-3 top-3 flex h-8 w-8 items-center justify-center rounded-lg bg-white text-slate-500 shadow-sm ring-1 ring-slate-200 transition hover:text-red-600"
                                        :disabled="isSaving"
                                        @click="clearSelectedImage"
                                    >
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>

                                <label
                                    class="flex cursor-pointer items-center justify-center gap-2 px-4 py-5 text-sm font-medium text-slate-600 transition hover:bg-slate-100"
                                    :class="isSaving ? 'pointer-events-none opacity-50' : ''"
                                >
                                    <i class="bi bi-cloud-arrow-up"></i>

                                    {{ $t('actions.upload') }}

                                    <input
                                        type="file"
                                        class="hidden"
                                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                        :disabled="isSaving"
                                        @change="handleImageChange"
                                    />
                                </label>
                            </div>

                            <p class="mt-2 text-[11px] leading-5 text-slate-400">
                                JPG, JPEG, PNG или WEBP.
                            </p>
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
                        :disabled="isSaving"
                        @click="closeForm"
                    >
                        {{ $t('actions.cancel') }}
                    </button>

                    <button
                        type="button"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
                        :disabled="isSaving"
                        @click="submitForm"
                    >
                        <span
                            v-if="isSaving"
                            class="h-4 w-4 animate-spin rounded-full border-2 border-white/30 border-t-white"
                        ></span>

                        <i v-else class="bi bi-check-lg"></i>

                        {{ submitButtonLabel }}
                    </button>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script setup>
import { computed, onBeforeUnmount, onMounted, reactive, ref, watch } from 'vue';

import { useI18n } from 'vue-i18n';

import { productCertificatesApi } from '../../../../services/productCertificatesApi';

const props = defineProps({
    productId: {
        type: [Number, String],
        required: true,
    },

    isManager: {
        type: Boolean,
        default: false,
    },

    isAdmin: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['updated']);

const { locale, t } = useI18n();

/*
|--------------------------------------------------------------------------
| State
|--------------------------------------------------------------------------
*/

const certificates = ref([]);
const attachedCertificateIds = ref(new Set());

const search = ref('');
const isLoading = ref(false);
const isSaving = ref(false);
const isWorking = ref(false);

const error = ref('');
const formError = ref('');

const workingCertificateId = ref(null);
const deletingCertificateId = ref(null);

const showForm = ref(false);
const isEditMode = ref(false);

const editingCertificate = ref(null);

const imageFile = ref(null);
const imagePreview = ref('');
const currentImage = ref('');

let searchTimer = null;

/*
|--------------------------------------------------------------------------
| Form
|--------------------------------------------------------------------------
*/

const form = reactive({
    title: {
        ru: '',
        en: '',
    },

    description: {
        ru: '',
        en: '',
    },
});

/*
|--------------------------------------------------------------------------
| Computed / helpers
|--------------------------------------------------------------------------
*/

const submitButtonLabel = computed(() => {
    if (isSaving.value) {
        return t('actions.saving');
    }

    if (isEditMode.value) {
        return t('actions.save');
    }

    return t('actions.create');
});

function localizedValue(value) {
    if (!value) {
        return '';
    }

    if (typeof value === 'string') {
        return value;
    }

    if (typeof value === 'object') {
        return value[locale.value] || value.ru || value.en || Object.values(value)[0] || '';
    }

    return String(value);
}

function normalizeListResponse(response) {
    if (Array.isArray(response)) {
        return response;
    }

    if (Array.isArray(response?.data)) {
        return response.data;
    }

    if (Array.isArray(response?.certificates)) {
        return response.certificates;
    }

    return [];
}

function isAttached(certificateId) {
    return attachedCertificateIds.value.has(Number(certificateId));
}

function getAttachButtonClass(certificateId) {
    return isAttached(certificateId)
        ? 'border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100'
        : 'border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100';
}

function getAttachButtonIcon(certificateId) {
    return isAttached(certificateId) ? 'bi bi-link-45deg' : 'bi bi-link';
}

const attachedCertificates = computed(() => {
    return certificates.value.filter((certificate) => isAttached(certificate.id));
});

const unattachedCertificates = computed(() => {
    return certificates.value.filter((certificate) => !isAttached(certificate.id));
});

/*
|--------------------------------------------------------------------------
| Load
|--------------------------------------------------------------------------
*/

async function loadCertificates() {
    try {
        const response = await productCertificatesApi.index({
            search: search.value.trim(),
        });

        certificates.value = normalizeListResponse(response);
    } catch (exception) {
        console.error('Failed to load certificates:', exception);
        error.value = getErrorMessage(exception);
    }
}

async function loadProductCertificates() {
    try {
        const response = await productCertificatesApi.productCertificates(props.productId);

        const list = normalizeListResponse(response);

        attachedCertificateIds.value = new Set(
            list.map((certificate) => Number(certificate.id)).filter(Number.isFinite)
        );
    } catch (exception) {
        console.error('Failed to load product certificates:', exception);

        error.value = getErrorMessage(exception);
    }
}

async function loadData() {
    isLoading.value = true;
    error.value = '';

    try {
        await Promise.all([loadCertificates(), loadProductCertificates()]);
    } finally {
        isLoading.value = false;
    }
}

/*
|--------------------------------------------------------------------------
| Search
|--------------------------------------------------------------------------
*/

watch(search, () => {
    window.clearTimeout(searchTimer);

    searchTimer = window.setTimeout(async () => {
        await loadCertificates();
    }, 300);
});

watch(
    () => props.productId,
    async () => {
        if (!props.productId) {
            return;
        }

        await loadProductCertificates();
    }
);

/*
|--------------------------------------------------------------------------
| Attach / detach
|--------------------------------------------------------------------------
*/

async function toggleAttach(certificate) {
    if (isWorking.value || !certificate?.id) {
        return;
    }

    error.value = '';
    isWorking.value = true;
    workingCertificateId.value = certificate.id;

    try {
        if (isAttached(certificate.id)) {
            await productCertificatesApi.detach(props.productId, certificate.id);

            const nextIds = new Set(attachedCertificateIds.value);

            nextIds.delete(Number(certificate.id));
            attachedCertificateIds.value = nextIds;
        } else {
            await productCertificatesApi.attach(props.productId, certificate.id);

            const nextIds = new Set(attachedCertificateIds.value);

            nextIds.add(Number(certificate.id));
            attachedCertificateIds.value = nextIds;
        }

        emit('updated');
    } catch (exception) {
        console.error('Failed to toggle certificate:', exception);

        error.value = getErrorMessage(exception);
    } finally {
        isWorking.value = false;
        workingCertificateId.value = null;
    }
}

/*
|--------------------------------------------------------------------------
| Create / edit
|--------------------------------------------------------------------------
*/

function resetForm() {
    form.title.ru = '';
    form.title.en = '';

    form.description.ru = '';
    form.description.en = '';

    imageFile.value = null;

    revokeImagePreview();

    currentImage.value = '';
    editingCertificate.value = null;
    formError.value = '';
}

function openCreateForm() {
    resetForm();

    isEditMode.value = false;
    showForm.value = true;
}

function openEditForm(certificate) {
    resetForm();

    isEditMode.value = true;
    editingCertificate.value = certificate;

    form.title.ru = certificate?.title?.ru ?? '';
    form.title.en = certificate?.title?.en ?? '';

    form.description.ru = certificate?.description?.ru ?? '';

    form.description.en = certificate?.description?.en ?? '';

    currentImage.value = certificate?.image || '';

    showForm.value = true;
}

function closeForm() {
    if (isSaving.value) {
        return;
    }

    showForm.value = false;
    resetForm();
}

/*
|--------------------------------------------------------------------------
| Image
|--------------------------------------------------------------------------
*/

const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

function handleImageChange(event) {
    const file = event.target?.files?.[0];

    if (!file) {
        return;
    }

    formError.value = '';

    if (!allowedTypes.includes(file.type)) {
        event.target.value = '';

        formError.value = t('messages.fail.create');

        return;
    }

    imageFile.value = file;

    revokeImagePreview();

    imagePreview.value = URL.createObjectURL(file);
}

function clearSelectedImage() {
    imageFile.value = null;
    revokeImagePreview();
}

function revokeImagePreview() {
    if (imagePreview.value) {
        URL.revokeObjectURL(imagePreview.value);
        imagePreview.value = '';
    }
}

/*
|--------------------------------------------------------------------------
| Submit
|--------------------------------------------------------------------------
*/

async function submitForm() {
    if (isSaving.value) {
        return;
    }

    formError.value = '';

    if (!form.title.ru.trim() || !form.title.en.trim()) {
        formError.value = t('validation.input.required');
        return;
    }

    if (!isEditMode.value && !imageFile.value) {
        formError.value = t('product.form.image');
        return;
    }

    const formData = new FormData();

    formData.append('title[ru]', form.title.ru.trim());
    formData.append('title[en]', form.title.en.trim());

    if (form.description.ru.trim()) {
        formData.append('description[ru]', form.description.ru.trim());
    }

    if (form.description.en.trim()) {
        formData.append('description[en]', form.description.en.trim());
    }

    if (imageFile.value) {
        formData.append('image', imageFile.value);
    }

    isSaving.value = true;

    try {
        if (isEditMode.value && editingCertificate.value) {
            formData.append('_method', 'PUT');

            await productCertificatesApi.update(editingCertificate.value.id, formData);
        } else {
            await productCertificatesApi.store(props.productId, formData);
        }

        showForm.value = false;
        resetForm();

        await Promise.all([loadCertificates(), loadProductCertificates()]);

        emit('updated');
    } catch (exception) {
        console.error('Failed to save certificate:', exception);

        formError.value = getErrorMessage(exception);
    } finally {
        isSaving.value = false;
    }
}

/*
|--------------------------------------------------------------------------
| Delete
|--------------------------------------------------------------------------
*/

async function deleteCertificate(certificate) {
    if (isWorking.value || !certificate?.id) {
        return;
    }

    const title = localizedValue(certificate.title);

    const confirmed = window.confirm(`${t('messages.confirm.delete')}\n\n${title}`);

    if (!confirmed) {
        return;
    }

    error.value = '';
    isWorking.value = true;
    deletingCertificateId.value = certificate.id;

    try {
        await productCertificatesApi.delete(certificate.id);

        const nextIds = new Set(attachedCertificateIds.value);

        nextIds.delete(Number(certificate.id));
        attachedCertificateIds.value = nextIds;

        await Promise.all([loadCertificates(), loadProductCertificates()]);

        emit('updated');
    } catch (exception) {
        console.error('Failed to delete certificate:', exception);

        error.value = getErrorMessage(exception);
    } finally {
        isWorking.value = false;
        deletingCertificateId.value = null;
    }
}

/*
|--------------------------------------------------------------------------
| Error
|--------------------------------------------------------------------------
*/

function getErrorMessage(exception) {
    if (typeof exception === 'string') {
        return exception;
    }

    if (exception?.message) {
        return exception.message;
    }

    if (exception?.response?.message) {
        return exception.response.message;
    }

    if (exception?.response?.error) {
        return exception.response.error;
    }

    if (exception?.response?.data?.message) {
        return exception.response.data.message;
    }

    if (exception?.response?.data?.errors) {
        const errors = exception.response.data.errors;

        return Object.values(errors).flat().join(' ');
    }

    return t('messages.fail.default');
}

/*
|--------------------------------------------------------------------------
| Lifecycle
|--------------------------------------------------------------------------
*/

onMounted(async () => {
    await loadData();
});

onBeforeUnmount(() => {
    window.clearTimeout(searchTimer);
    revokeImagePreview();
});
</script>
