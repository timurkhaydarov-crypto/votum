<template>
    <div
        class="fixed inset-0 z-[120] flex items-end justify-center bg-slate-950/40 p-0 backdrop-blur-sm sm:items-center sm:p-6"
        @click.self="close"
    >
        <div
            class="flex max-h-[96vh] w-full max-w-5xl flex-col overflow-hidden rounded-t-3xl bg-white shadow-2xl sm:max-h-[92vh] sm:rounded-3xl"
        >
            <!-- ===================================================== -->
            <!-- HEADER -->
            <!-- ===================================================== -->

            <div
                class="flex items-start justify-between gap-5 border-b border-slate-200 px-6 py-5 sm:px-7"
            >
                <div class="min-w-0">
                    <div
                        class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-400"
                    >
                        Product documentation
                    </div>

                    <h2 class="mt-2 truncate text-xl font-bold tracking-tight text-slate-900">
                        {{ productName }}
                    </h2>

                    <div v-if="product.article" class="mt-1 text-sm text-slate-500">
                        {{ product.article }}
                    </div>
                </div>

                <button
                    type="button"
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                    @click="close"
                >
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <!-- ===================================================== -->
            <!-- CONTENT -->
            <!-- ===================================================== -->

            <div class="min-h-0 flex-1 overflow-y-auto p-6 sm:p-7">
                <!-- ERROR -->
                <div
                    v-if="errorMessage"
                    class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700"
                >
                    {{ errorMessage }}
                </div>

                <!-- ================================================= -->
                <!-- DOCUMENT FORM -->
                <!-- ================================================= -->

                <section class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <h3 class="font-semibold text-slate-900">
                                {{
                                    editingDocument ? 'Редактирование документа' : 'Новый документ'
                                }}
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Название и описание документа поддерживают русский и английский
                                языки.
                            </p>
                        </div>

                        <button
                            v-if="editingDocument"
                            type="button"
                            class="rounded-xl p-2 text-slate-400 transition hover:bg-white hover:text-slate-700"
                            @click="resetForm"
                        >
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <div class="mt-5 grid gap-4 lg:grid-cols-2">
                        <!-- TYPE -->
                        <div>
                            <label
                                class="mb-2 block text-xs font-semibold uppercase tracking-[0.08em] text-slate-500"
                            >
                                Тип
                            </label>

                            <input
                                v-model="form.type"
                                type="text"
                                placeholder="manual"
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-100"
                            />
                        </div>

                        <!-- SORT -->
                        <div>
                            <label
                                class="mb-2 block text-xs font-semibold uppercase tracking-[0.08em] text-slate-500"
                            >
                                Порядок
                            </label>

                            <input
                                v-model.number="form.sort_order"
                                type="number"
                                min="0"
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-100"
                            />
                        </div>

                        <!-- RU TITLE -->
                        <div>
                            <label
                                class="mb-2 block text-xs font-semibold uppercase tracking-[0.08em] text-slate-500"
                            >
                                Название RU
                            </label>

                            <input
                                v-model="form.title.ru"
                                type="text"
                                placeholder="Руководство пользователя"
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-100"
                            />
                        </div>

                        <!-- EN TITLE -->
                        <div>
                            <label
                                class="mb-2 block text-xs font-semibold uppercase tracking-[0.08em] text-slate-500"
                            >
                                Название EN
                            </label>

                            <input
                                v-model="form.title.en"
                                type="text"
                                placeholder="User manual"
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-100"
                            />
                        </div>

                        <!-- RU DESCRIPTION -->
                        <div>
                            <label
                                class="mb-2 block text-xs font-semibold uppercase tracking-[0.08em] text-slate-500"
                            >
                                Описание RU
                            </label>

                            <textarea
                                v-model="form.description.ru"
                                rows="4"
                                placeholder="Описание документа"
                                class="w-full resize-none rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-100"
                            ></textarea>
                        </div>

                        <!-- EN DESCRIPTION -->
                        <div>
                            <label
                                class="mb-2 block text-xs font-semibold uppercase tracking-[0.08em] text-slate-500"
                            >
                                Описание EN
                            </label>

                            <textarea
                                v-model="form.description.en"
                                rows="4"
                                placeholder="Document description"
                                class="w-full resize-none rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-100"
                            ></textarea>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center justify-between gap-4">
                        <label class="inline-flex cursor-pointer items-center gap-3">
                            <input
                                v-model="form.is_active"
                                type="checkbox"
                                class="h-4 w-4 rounded border-slate-300 text-slate-900 focus:ring-slate-300"
                            />

                            <span class="text-sm font-medium text-slate-700">
                                Документ активен
                            </span>
                        </label>

                        <button
                            type="button"
                            class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
                            :disabled="isSavingDocument"
                            @click="saveDocument"
                        >
                            <i
                                :class="[
                                    'bi',
                                    isSavingDocument
                                        ? 'bi-arrow-repeat animate-spin'
                                        : editingDocument
                                          ? 'bi-check-lg'
                                          : 'bi-plus-lg',
                                ]"
                            ></i>

                            {{ editingDocument ? 'Сохранить' : 'Создать документ' }}
                        </button>
                    </div>
                </section>

                <!-- ================================================= -->
                <!-- DOCUMENTS -->
                <!-- ================================================= -->

                <section class="mt-6">
                    <div class="flex items-end justify-between gap-4">
                        <div>
                            <h3 class="font-semibold text-slate-900">Документы</h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Загруженные документы и PDF-файлы.
                            </p>
                        </div>

                        <button
                            type="button"
                            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 disabled:opacity-50"
                            :disabled="isLoading"
                            @click="loadDocuments"
                        >
                            <i
                                :class="[
                                    'bi',
                                    isLoading
                                        ? 'bi-arrow-repeat animate-spin'
                                        : 'bi-arrow-clockwise',
                                ]"
                            ></i>

                            Обновить
                        </button>
                    </div>

                    <!-- LOADING -->
                    <div v-if="isLoading" class="mt-4 space-y-3">
                        <div
                            v-for="item in 3"
                            :key="item"
                            class="h-36 animate-pulse rounded-2xl bg-slate-100"
                        ></div>
                    </div>

                    <!-- EMPTY -->
                    <div
                        v-else-if="!documents.length"
                        class="mt-4 rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-10 text-center"
                    >
                        <div
                            class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-slate-400 shadow-sm"
                        >
                            <i class="bi bi-folder2-open text-xl"></i>
                        </div>

                        <div class="mt-3 text-sm font-semibold text-slate-700">
                            Документы отсутствуют
                        </div>

                        <div class="mt-1 text-xs text-slate-500">Создай первый документ выше.</div>
                    </div>

                    <!-- LIST -->
                    <div v-else class="mt-4 space-y-4">
                        <article
                            v-for="document in documents"
                            :key="document.id"
                            class="rounded-2xl border border-slate-200 bg-white p-5"
                        >
                            <!-- TOP -->
                            <div
                                class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between"
                            >
                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h4 class="font-semibold text-slate-900">
                                            {{ getTitle(document) }}
                                        </h4>

                                        <span
                                            class="rounded-lg border border-slate-200 bg-slate-50 px-2 py-1 text-[10px] font-semibold uppercase tracking-[0.08em] text-slate-500"
                                        >
                                            {{ document.type || 'document' }}
                                        </span>

                                        <span
                                            :class="[
                                                'rounded-lg px-2 py-1 text-[10px] font-semibold uppercase tracking-[0.08em]',
                                                document.is_active
                                                    ? 'bg-emerald-50 text-emerald-700'
                                                    : 'bg-slate-100 text-slate-500',
                                            ]"
                                        >
                                            {{ document.is_active ? 'Активен' : 'Выключен' }}
                                        </span>
                                    </div>

                                    <p
                                        v-if="getDescription(document)"
                                        class="mt-2 max-w-3xl text-sm leading-6 text-slate-500"
                                    >
                                        {{ getDescription(document) }}
                                    </p>
                                </div>

                                <div class="flex shrink-0 gap-2">
                                    <button
                                        type="button"
                                        class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                                        @click="startEdit(document)"
                                    >
                                        <i class="bi bi-pencil"></i>

                                        Изменить
                                    </button>

                                    <button
                                        type="button"
                                        class="inline-flex items-center gap-2 rounded-xl border border-rose-200 bg-white px-3.5 py-2.5 text-sm font-semibold text-rose-600 transition hover:bg-rose-50 disabled:opacity-50"
                                        :disabled="deletingDocumentId === document.id"
                                        @click="deleteDocument(document)"
                                    >
                                        <i
                                            :class="[
                                                'bi',
                                                deletingDocumentId === document.id
                                                    ? 'bi-arrow-repeat animate-spin'
                                                    : 'bi-trash',
                                            ]"
                                        ></i>

                                        Удалить
                                    </button>
                                </div>
                            </div>

                            <!-- FILES -->
                            <div class="mt-5 grid gap-3 md:grid-cols-2">
                                <!-- RU -->
                                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                    <div class="flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-red-600"
                                            >
                                                <i class="bi bi-file-earmark-pdf"></i>
                                            </span>

                                            <div>
                                                <div
                                                    class="text-xs font-bold uppercase tracking-[0.1em] text-slate-500"
                                                >
                                                    RU PDF
                                                </div>

                                                <div
                                                    class="mt-1 text-sm font-medium text-slate-800"
                                                >
                                                    {{ getFileName(document, 'ru') }}
                                                </div>
                                            </div>
                                        </div>

                                        <label
                                            class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-50"
                                        >
                                            <i class="bi bi-upload"></i>

                                            Заменить

                                            <input
                                                type="file"
                                                accept="application/pdf,.pdf"
                                                class="hidden"
                                                @change="uploadFile(document, 'ru', $event)"
                                            />
                                        </label>
                                    </div>

                                    <div
                                        v-if="getFile(document, 'ru')"
                                        class="mt-3 flex items-center justify-between gap-3 text-xs text-slate-500"
                                    >
                                        <span>
                                            {{ formatFileSize(getFile(document, 'ru')?.file_size) }}
                                        </span>

                                        <button
                                            type="button"
                                            class="font-semibold text-rose-600 hover:text-rose-700 disabled:opacity-50"
                                            :disabled="isDeletingFile(document.id, 'ru')"
                                            @click="deleteFile(document, 'ru')"
                                        >
                                            {{
                                                isDeletingFile(document.id, 'ru')
                                                    ? 'Удаление...'
                                                    : 'Удалить PDF'
                                            }}
                                        </button>
                                    </div>

                                    <div v-else class="mt-3 text-xs text-amber-600">
                                        PDF ещё не загружен.
                                    </div>
                                </div>

                                <!-- EN -->
                                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                    <div class="flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-red-600"
                                            >
                                                <i class="bi bi-file-earmark-pdf"></i>
                                            </span>

                                            <div>
                                                <div
                                                    class="text-xs font-bold uppercase tracking-[0.1em] text-slate-500"
                                                >
                                                    EN PDF
                                                </div>

                                                <div
                                                    class="mt-1 text-sm font-medium text-slate-800"
                                                >
                                                    {{ getFileName(document, 'en') }}
                                                </div>
                                            </div>
                                        </div>

                                        <label
                                            class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-50"
                                        >
                                            <i class="bi bi-upload"></i>

                                            Заменить

                                            <input
                                                type="file"
                                                accept="application/pdf,.pdf"
                                                class="hidden"
                                                @change="uploadFile(document, 'en', $event)"
                                            />
                                        </label>
                                    </div>

                                    <div
                                        v-if="getFile(document, 'en')"
                                        class="mt-3 flex items-center justify-between gap-3 text-xs text-slate-500"
                                    >
                                        <span>
                                            {{ formatFileSize(getFile(document, 'en')?.file_size) }}
                                        </span>

                                        <button
                                            type="button"
                                            class="font-semibold text-rose-600 hover:text-rose-700 disabled:opacity-50"
                                            :disabled="isDeletingFile(document.id, 'en')"
                                            @click="deleteFile(document, 'en')"
                                        >
                                            {{
                                                isDeletingFile(document.id, 'en')
                                                    ? 'Удаление...'
                                                    : 'Удалить PDF'
                                            }}
                                        </button>
                                    </div>

                                    <div v-else class="mt-3 text-xs text-amber-600">
                                        PDF ещё не загружен.
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </section>
            </div>

            <!-- ===================================================== -->
            <!-- FOOTER -->
            <!-- ===================================================== -->

            <div class="border-t border-slate-200 bg-slate-50 px-6 py-4 sm:px-7">
                <div class="flex justify-end">
                    <button
                        type="button"
                        class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                        @click="close"
                    >
                        Закрыть
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';

import { documentationApi } from '../services/documentationApi.js';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['close', 'changed']);

/*
|--------------------------------------------------------------------------
| State
|--------------------------------------------------------------------------
*/

const documents = ref([]);

const isLoading = ref(false);
const isSavingDocument = ref(false);

const deletingDocumentId = ref(null);

const errorMessage = ref('');

const editingDocument = ref(null);

const deletingFileState = ref({
    documentId: null,
    locale: null,
});

/*
|--------------------------------------------------------------------------
| Product
|--------------------------------------------------------------------------
*/

const productName = computed(() => {
    const name = props.product?.name;

    if (typeof name === 'string') {
        return name;
    }

    if (name && typeof name === 'object') {
        return name.ru || name.en || 'Без названия';
    }

    return 'Без названия';
});

/*
|--------------------------------------------------------------------------
| Form
|--------------------------------------------------------------------------
*/

const createDefaultForm = () => ({
    type: 'manual',

    title: {
        ru: '',
        en: '',
    },

    description: {
        ru: '',
        en: '',
    },

    sort_order: 0,

    is_active: true,
});

const form = ref(createDefaultForm());

/*
|--------------------------------------------------------------------------
| Load documents
|--------------------------------------------------------------------------
*/

const loadDocuments = async () => {
    if (!props.product?.id) {
        console.error('ProductDocumentsManager: product.id is missing', props.product);

        documents.value = [];

        return;
    }

    isLoading.value = true;
    errorMessage.value = '';

    try {
        const response = await documentationApi.getProductDocuments(props.product.id);

        documents.value = Array.isArray(response)
            ? response
            : (response?.documents ?? response?.data?.documents ?? response?.data ?? []);

        if (!Array.isArray(documents.value)) {
            documents.value = [];
        }
    } catch (error) {
        console.error('Failed to load product documents:', error);

        documents.value = [];

        errorMessage.value = error?.message || 'Не удалось загрузить документацию продукта.';
    } finally {
        isLoading.value = false;
    }
};

/*
|--------------------------------------------------------------------------
| Form
|--------------------------------------------------------------------------
*/

const resetForm = () => {
    editingDocument.value = null;

    form.value = createDefaultForm();
};

const startEdit = (document) => {
    editingDocument.value = document;

    form.value = {
        type: document.type || 'manual',

        title: {
            ru: document.title?.ru || '',
            en: document.title?.en || '',
        },

        description: {
            ru: document.description?.ru || '',
            en: document.description?.en || '',
        },

        sort_order: Number(document.sort_order || 0),

        is_active: Boolean(document.is_active),
    };

    window.scrollTo({
        top: 0,
        behavior: 'smooth',
    });
};

/*
|--------------------------------------------------------------------------
| Save document
|--------------------------------------------------------------------------
*/

const saveDocument = async () => {
    if (!form.value.type || !form.value.title.ru || !form.value.title.en) {
        errorMessage.value = 'Заполни тип и название документа на RU и EN.';

        return;
    }

    if (!props.product?.id) {
        errorMessage.value = 'Не удалось определить продукт.';

        return;
    }

    isSavingDocument.value = true;
    errorMessage.value = '';

    const payload = {
        type: form.value.type,

        title: {
            ru: form.value.title.ru,
            en: form.value.title.en,
        },

        description: {
            ru: form.value.description.ru || null,
            en: form.value.description.en || null,
        },

        sort_order: Number(form.value.sort_order || 0),

        is_active: Boolean(form.value.is_active),
    };

    try {
        if (editingDocument.value) {
            await documentationApi.updateProductDocument(
                props.product.id,
                editingDocument.value.id,
                payload
            );
        } else {
            await documentationApi.createProductDocument(props.product.id, payload);
        }

        resetForm();

        await loadDocuments();

        emit('changed');
    } catch (error) {
        console.error('Failed to save product document:', error);

        errorMessage.value = error?.message || 'Не удалось сохранить документ.';
    } finally {
        isSavingDocument.value = false;
    }
};

/*
|--------------------------------------------------------------------------
| Delete document
|--------------------------------------------------------------------------
*/

const deleteDocument = async (document) => {
    if (!window.confirm(`Удалить документ "${getTitle(document)}"?`)) {
        return;
    }

    deletingDocumentId.value = document.id;

    errorMessage.value = '';

    try {
        await documentationApi.deleteProductDocument(props.product.id, document.id);

        if (editingDocument.value?.id === document.id) {
            resetForm();
        }

        await loadDocuments();

        emit('changed');
    } catch (error) {
        console.error('Failed to delete product document:', error);

        errorMessage.value = error?.message || 'Не удалось удалить документ.';
    } finally {
        deletingDocumentId.value = null;
    }
};

/*
|--------------------------------------------------------------------------
| Files
|--------------------------------------------------------------------------
*/

const getFile = (document, locale) => {
    if (!Array.isArray(document?.files)) {
        return null;
    }

    return document.files.find((file) => file.locale === locale) || null;
};

const getFileName = (document, locale) => {
    const file = getFile(document, locale);

    return file?.original_name || 'PDF не загружен';
};

const uploadFile = async (document, locale, event) => {
    const file = event.target?.files?.[0];

    if (event.target) {
        event.target.value = '';
    }

    if (!file) {
        return;
    }

    if (file.type !== 'application/pdf') {
        errorMessage.value = 'Разрешены только PDF-файлы.';

        return;
    }

    if (file.size > 50 * 1024 * 1024) {
        errorMessage.value = 'Максимальный размер PDF — 50 МБ.';

        return;
    }

    if (!document?.id) {
        errorMessage.value = 'Не удалось определить документ.';

        return;
    }

    errorMessage.value = '';

    deletingFileState.value = {
        documentId: document.id,
        locale,
        uploading: true,
    };

    try {
        await documentationApi.uploadDocumentFile(document.id, locale, file);

        await loadDocuments();

        emit('changed');
    } catch (error) {
        console.error('Failed to upload document file:', error);

        errorMessage.value = error?.message || 'Не удалось загрузить PDF.';
    } finally {
        deletingFileState.value = {
            documentId: null,
            locale: null,
            uploading: false,
        };
    }
};

/*
|--------------------------------------------------------------------------
| Delete file
|--------------------------------------------------------------------------
*/

const deleteFile = async (document, locale) => {
    const file = getFile(document, locale);

    if (!file) {
        return;
    }

    if (!window.confirm(`Удалить PDF "${file.original_name}"?`)) {
        return;
    }

    deletingFileState.value = {
        documentId: document.id,
        locale,
        uploading: false,
    };

    errorMessage.value = '';

    try {
        await documentationApi.deleteDocumentFile(document.id, file.id);

        await loadDocuments();

        emit('changed');
    } catch (error) {
        console.error('Failed to delete document file:', error);

        errorMessage.value = error?.message || 'Не удалось удалить PDF.';
    } finally {
        deletingFileState.value = {
            documentId: null,
            locale: null,
            uploading: false,
        };
    }
};

const isDeletingFile = (documentId, locale) => {
    return (
        deletingFileState.value.documentId === documentId &&
        deletingFileState.value.locale === locale
    );
};

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

const getTitle = (document) => {
    return document?.title?.ru || document?.title?.en || 'Без названия';
};

const getDescription = (document) => {
    return document?.description?.ru || document?.description?.en || '';
};

const formatFileSize = (size) => {
    if (!size) {
        return '';
    }

    if (size < 1024) {
        return `${size} B`;
    }

    if (size < 1024 * 1024) {
        return `${(size / 1024).toFixed(1)} KB`;
    }

    return `${(size / 1024 / 1024).toFixed(1)} MB`;
};

/*
|--------------------------------------------------------------------------
| Close
|--------------------------------------------------------------------------
*/

const close = () => {
    document.body.classList.remove('overflow-hidden');

    emit('close');
};

onMounted(() => {
    loadDocuments();
});
</script>
