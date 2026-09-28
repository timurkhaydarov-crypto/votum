<template>
    <div
        class="fixed inset-0 z-[100] flex items-end justify-center bg-slate-950/40 p-0 backdrop-blur-sm sm:items-center sm:p-6"
        @click.self="close"
    >
        <div
            class="flex max-h-[95vh] w-full max-w-4xl flex-col overflow-hidden rounded-t-3xl bg-white shadow-2xl sm:max-h-[92vh] sm:rounded-3xl"
        >
            <!-- HEADER -->
            <div
                class="flex items-start justify-between gap-5 border-b border-slate-200 px-6 py-5 sm:px-7"
            >
                <div class="min-w-0">
                    <div
                        class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-400"
                    >
                        Управление документацией
                    </div>

                    <h2 class="mt-2 truncate text-xl font-bold tracking-tight text-slate-900">
                        {{ user.name || 'Без имени' }}
                    </h2>

                    <div class="mt-1 truncate text-sm text-slate-500">
                        {{ user.email || 'Email не указан' }}
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

            <!-- CONTENT -->
            <div class="min-h-0 flex-1 overflow-y-auto p-6 sm:p-7">
                <!-- ERROR -->
                <div
                    v-if="errorMessage"
                    class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700"
                >
                    {{ errorMessage }}
                </div>

                <!-- ================================================= -->
                <!-- KEY -->
                <!-- ================================================= -->

                <section class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <div class="flex items-center gap-2">
                                <i class="bi bi-key text-slate-500"></i>

                                <h3 class="font-semibold text-slate-900">Ключ документации</h3>
                            </div>

                            <p class="mt-1 text-sm leading-6 text-slate-500">
                                Один ключ используется для всех назначенных этому пользователю
                                продуктов.
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <button
                                type="button"
                                class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 disabled:opacity-50"
                                :disabled="isSaving"
                                @click="rotateKey"
                            >
                                <i
                                    :class="[
                                        'bi',
                                        isRotating
                                            ? 'bi-arrow-repeat animate-spin'
                                            : 'bi-arrow-repeat',
                                    ]"
                                ></i>

                                {{ user.has_documentation_key ? 'Перевыпустить' : 'Создать ключ' }}
                            </button>

                            <button
                                v-if="user.has_documentation_key"
                                type="button"
                                class="inline-flex items-center gap-2 rounded-xl border border-rose-200 bg-white px-4 py-2.5 text-sm font-semibold text-rose-600 transition hover:bg-rose-50 disabled:opacity-50"
                                :disabled="isSaving"
                                @click="revokeKey"
                            >
                                <i class="bi bi-key-fill"></i>

                                Отозвать
                            </button>
                        </div>
                    </div>

                    <!-- GENERATED KEY -->
                    <div
                        v-if="generatedKey"
                        class="mt-5 rounded-2xl border border-amber-200 bg-amber-50 p-4"
                    >
                        <div class="font-semibold text-amber-900">Новый ключ создан</div>

                        <p class="mt-1 text-xs leading-5 text-amber-800">
                            Он показывается только сейчас.
                        </p>

                        <div class="mt-3 flex flex-col gap-2 sm:flex-row">
                            <code
                                class="min-w-0 flex-1 overflow-x-auto rounded-xl border border-amber-200 bg-white px-3 py-2.5 font-mono text-xs text-slate-800"
                            >
                                {{ generatedKey }}
                            </code>

                            <button
                                type="button"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-amber-800"
                                @click="copyKey"
                            >
                                <i class="bi bi-copy"></i>

                                {{ isCopied ? 'Скопировано' : 'Копировать' }}
                            </button>
                        </div>
                    </div>
                </section>

                <!-- ================================================= -->
                <!-- ACCESS LIST -->
                <!-- ================================================= -->

                <section class="mt-6">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h3 class="font-semibold text-slate-900">Доступ к продукции</h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Продукты, к которым пользователь имеет доступ к закрытой
                                документации.
                            </p>
                        </div>

                        <button
                            type="button"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 disabled:opacity-50"
                            :disabled="isLoadingAccesses"
                            @click="loadAccesses"
                        >
                            <i
                                :class="[
                                    'bi',
                                    isLoadingAccesses
                                        ? 'bi-arrow-repeat animate-spin'
                                        : 'bi-arrow-clockwise',
                                ]"
                            ></i>

                            Обновить
                        </button>
                    </div>

                    <div v-if="isLoadingAccesses" class="mt-4 space-y-3">
                        <div
                            v-for="item in 3"
                            :key="item"
                            class="h-24 animate-pulse rounded-2xl bg-slate-100"
                        ></div>
                    </div>

                    <div
                        v-else-if="!accesses.length"
                        class="mt-4 rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center"
                    >
                        <div
                            class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-slate-400 shadow-sm"
                        >
                            <i class="bi bi-file-lock text-xl"></i>
                        </div>

                        <div class="mt-3 text-sm font-semibold text-slate-700">
                            Нет назначенных продуктов
                        </div>
                    </div>

                    <div v-else class="mt-4 space-y-3">
                        <article
                            v-for="access in accesses"
                            :key="access.id"
                            class="rounded-2xl border border-slate-200 bg-white p-4"
                        >
                            <div
                                class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between"
                            >
                                <div class="min-w-0">
                                    <div class="font-semibold text-slate-900">
                                        {{
                                            getProductName(access.product) ||
                                            `Product #${access.product_id}`
                                        }}
                                    </div>

                                    <div
                                        class="mt-1 flex flex-wrap gap-x-3 gap-y-1 text-xs text-slate-500"
                                    >
                                        <span v-if="access.product?.article">
                                            {{ access.product.article }}
                                        </span>

                                        <span
                                            :class="
                                                access.is_valid
                                                    ? 'text-emerald-600'
                                                    : 'text-amber-600'
                                            "
                                        >
                                            {{
                                                access.is_valid
                                                    ? 'Доступ активен'
                                                    : 'Доступ недействителен'
                                            }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    <button
                                        type="button"
                                        class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                                        @click="openDocuments(access.product)"
                                    >
                                        <i class="bi bi-folder2-open"></i>

                                        Документы
                                    </button>

                                    <button
                                        type="button"
                                        class="inline-flex items-center gap-2 rounded-xl border border-rose-200 bg-white px-3.5 py-2.5 text-sm font-semibold text-rose-600 transition hover:bg-rose-50 disabled:opacity-50"
                                        :disabled="isSavingProduct === access.product_id"
                                        @click="revokeProduct(access.product_id)"
                                    >
                                        <i
                                            :class="[
                                                'bi',
                                                isSavingProduct === access.product_id
                                                    ? 'bi-arrow-repeat animate-spin'
                                                    : 'bi-trash',
                                            ]"
                                        ></i>

                                        Удалить
                                    </button>
                                </div>
                            </div>
                        </article>
                    </div>
                </section>

                <!-- ================================================= -->
                <!-- SEARCH PRODUCT -->
                <!-- ================================================= -->

                <section class="mt-6 rounded-2xl border border-slate-200 bg-white p-5">
                    <h3 class="font-semibold text-slate-900">Добавить продукт</h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Найди продукт по названию, артикулу или категории.
                    </p>

                    <div class="mt-4">
                        <ProductSearch
                            v-model="selectedProduct"
                            :exclude-ids="assignedProductIds"
                            @select="handleProductSelect"
                        />
                    </div>

                    <div
                        v-if="selectedProduct"
                        class="mt-4 rounded-xl border border-slate-200 bg-slate-50 p-4"
                    >
                        <div
                            class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                        >
                            <div class="min-w-0">
                                <div class="font-semibold text-slate-900">
                                    {{ getProductName(selectedProduct) }}
                                </div>

                                <div class="mt-1 text-xs text-slate-500">
                                    {{ selectedProduct.article || `ID #${selectedProduct.id}` }}
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <button
                                    type="button"
                                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                                    @click="openDocuments(selectedProduct)"
                                >
                                    <i class="bi bi-folder2-open"></i>

                                    Документы
                                </button>

                                <button
                                    type="button"
                                    class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 disabled:opacity-50"
                                    :disabled="isSavingProduct !== null"
                                    @click="grantProduct"
                                >
                                    <i
                                        :class="[
                                            'bi',
                                            isSavingProduct !== null
                                                ? 'bi-arrow-repeat animate-spin'
                                                : 'bi-plus-lg',
                                        ]"
                                    ></i>

                                    Предоставить доступ
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- FOOTER -->
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

        <!-- DOCUMENT MANAGER -->
        <ProductDocumentsManager
            v-if="documentsProduct"
            :product="documentsProduct"
            @close="closeDocuments"
            @changed="handleDocumentsChanged"
        />
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';

import { documentationApi } from '../services/documentationApi.js';

import ProductSearch from './ProductSearch.vue';
import ProductDocumentsManager from './ProductDocumentsManager.vue';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['close', 'changed']);

const accesses = ref([]);

const isLoadingAccesses = ref(false);
const isSaving = ref(false);
const isRotating = ref(false);
const isSavingProduct = ref(null);

const errorMessage = ref('');

const generatedKey = ref('');
const isCopied = ref(false);

const selectedProduct = ref(null);
const documentsProduct = ref(null);

/*
|--------------------------------------------------------------------------
| Assigned products
|--------------------------------------------------------------------------
*/

const assignedProductIds = computed(() => {
    return accesses.value
        .map((access) => Number(access.product_id ?? access.product?.id))
        .filter(Boolean);
});

/*
|--------------------------------------------------------------------------
| Load accesses
|--------------------------------------------------------------------------
*/

const loadAccesses = async () => {
    isLoadingAccesses.value = true;
    errorMessage.value = '';

    try {
        const response = await documentationApi.getUserAccesses(props.user.id);

        accesses.value = Array.isArray(response)
            ? response
            : (response?.accesses ?? response?.data?.accesses ?? response?.data ?? []);

        if (!Array.isArray(accesses.value)) {
            accesses.value = [];
        }
    } catch (error) {
        console.error('Failed to load documentation accesses:', error);

        accesses.value = [];

        errorMessage.value = error?.message || 'Не удалось загрузить доступы.';
    } finally {
        isLoadingAccesses.value = false;
    }
};

/*
|--------------------------------------------------------------------------
| Key
|--------------------------------------------------------------------------
*/

const rotateKey = async () => {
    isRotating.value = true;
    isSaving.value = true;
    errorMessage.value = '';
    generatedKey.value = '';
    isCopied.value = false;

    try {
        const response = await documentationApi.rotateUserKey(props.user.id);

        generatedKey.value = response?.key ?? response?.data?.key ?? '';

        emit('changed');
    } catch (error) {
        console.error('Failed to rotate documentation key:', error);

        errorMessage.value = error?.message || 'Не удалось создать ключ.';
    } finally {
        isRotating.value = false;
        isSaving.value = false;
    }
};

const revokeKey = async () => {
    if (!window.confirm('Отозвать ключ документации пользователя?')) {
        return;
    }

    isSaving.value = true;
    errorMessage.value = '';

    try {
        await documentationApi.revokeUserKey(props.user.id);

        generatedKey.value = '';

        emit('changed');
    } catch (error) {
        console.error('Failed to revoke documentation key:', error);

        errorMessage.value = error?.message || 'Не удалось отозвать ключ.';
    } finally {
        isSaving.value = false;
    }
};

/*
|--------------------------------------------------------------------------
| Product access
|--------------------------------------------------------------------------
*/

const handleProductSelect = (product) => {
    selectedProduct.value = product;
};

const grantProduct = async () => {
    if (!selectedProduct.value?.id) {
        return;
    }

    const currentProductId = selectedProduct.value.id;

    isSavingProduct.value = currentProductId;
    errorMessage.value = '';

    try {
        await documentationApi.grantProduct(props.user.id, currentProductId, {
            is_active: true,
        });

        selectedProduct.value = null;

        await loadAccesses();

        emit('changed');
    } catch (error) {
        console.error('Failed to grant documentation access:', error);

        errorMessage.value = error?.message || 'Не удалось предоставить доступ.';
    } finally {
        isSavingProduct.value = null;
    }
};

const revokeProduct = async (productId) => {
    if (!productId) {
        return;
    }

    if (!window.confirm('Удалить доступ пользователя к этому продукту?')) {
        return;
    }

    isSavingProduct.value = productId;
    errorMessage.value = '';

    try {
        await documentationApi.revokeProduct(props.user.id, productId);

        await loadAccesses();

        emit('changed');
    } catch (error) {
        console.error('Failed to revoke documentation access:', error);

        errorMessage.value = error?.message || 'Не удалось удалить доступ.';
    } finally {
        isSavingProduct.value = null;
    }
};

/*
|--------------------------------------------------------------------------
| Documents
|--------------------------------------------------------------------------
*/

const openDocuments = (product) => {
    if (!product?.id) {
        console.error('Cannot open documents: product.id is missing', product);

        errorMessage.value = 'Не удалось определить продукт для документации.';

        return;
    }

    documentsProduct.value = product;

    document.body.classList.add('overflow-hidden');
};

const closeDocuments = () => {
    documentsProduct.value = null;

    document.body.classList.remove('overflow-hidden');
};

const handleDocumentsChanged = async () => {
    await loadAccesses();

    emit('changed');
};

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

const getProductName = (product) => {
    if (!product) {
        return '';
    }

    if (typeof product.name === 'string') {
        return product.name;
    }

    if (product.name && typeof product.name === 'object') {
        return product.name.ru || product.name.en || '';
    }

    return '';
};

/*
|--------------------------------------------------------------------------
| Copy
|--------------------------------------------------------------------------
*/

const copyKey = async () => {
    if (!generatedKey.value) {
        return;
    }

    try {
        await navigator.clipboard.writeText(generatedKey.value);

        isCopied.value = true;

        window.setTimeout(() => {
            isCopied.value = false;
        }, 2000);
    } catch (error) {
        console.error('Failed to copy documentation key:', error);
    }
};

/*
|--------------------------------------------------------------------------
| Close
|--------------------------------------------------------------------------
*/

const close = () => {
    closeDocuments();

    emit('close');
};

onMounted(() => {
    loadAccesses();
});
</script>
