<template>
    <section>
        <!-- =========================================================
             HEADER
             ========================================================= -->

        <div
            class="flex items-start justify-between gap-4"
        >
            <div>
                <h3
                    class="text-sm font-semibold text-slate-900"
                >
                    {{ t('compatibleProducts.title') }}
                </h3>

                <p
                    class="mt-1 text-xs leading-5 text-slate-500"
                >
                    {{ t('compatibleProducts.description') }}
                </p>
            </div>

            <button
                v-if="isManager"
                type="button"
                class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-slate-900 px-3.5 py-2 text-xs font-semibold text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
                :disabled="isLoading"
                @click="openAddModal"
            >
                <i class="bi bi-plus-lg"></i>

                {{ t('actions.add') }}
            </button>
        </div>

        <!-- =========================================================
             ERROR
             ========================================================= -->

        <div
            v-if="error"
            class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
        >
            {{ error }}
        </div>

        <!-- =========================================================
             CURRENT COMPATIBLE PRODUCTS
             ========================================================= -->

        <div class="mt-5">
            <!-- LOADING -->

            <div
                v-if="isLoading"
                class="flex min-h-[160px] items-center justify-center rounded-xl border border-slate-200 bg-slate-50"
            >
                <div
                    class="flex items-center gap-3 text-xs text-slate-500"
                >
                    <span
                        class="h-5 w-5 animate-spin rounded-full border-2 border-slate-200 border-t-slate-700"
                    ></span>

                    {{ t('common.loading') }}
                </div>
            </div>

            <!-- EMPTY -->

            <div
                v-else-if="compatibleProducts.length === 0"
                class="rounded-xl border border-dashed border-slate-200 bg-slate-50 px-6 py-10 text-center"
            >
                <div
                    class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-white text-slate-400 shadow-sm"
                >
                    <i class="bi bi-box-seam"></i>
                </div>

                <p
                    class="mt-3 text-xs font-medium text-slate-500"
                >
                    {{ t('compatibleProducts.empty.title') }}
                </p>
            </div>

            <!-- LIST -->

            <div
                v-else
                class="divide-y divide-slate-200 overflow-hidden rounded-xl border border-slate-200 bg-white"
            >
                <div
                    v-for="item in compatibleProducts"
                    :key="item.id"
                    class="flex items-center justify-between gap-4 px-4 py-3"
                >
                    <div class="min-w-0">
                        <div
                            class="flex items-center gap-2"
                        >
                            <span
                                class="shrink-0 text-[10px] font-semibold text-slate-400"
                            >
                                #{{ item.id }}
                            </span>

                            <span
                                v-if="item.article"
                                class="truncate text-[10px] font-medium uppercase tracking-wide text-slate-400"
                            >
                                {{ item.article }}
                            </span>
                        </div>

                        <p
                            class="mt-1 truncate text-sm font-medium text-slate-800"
                        >
                            {{ productName(item) }}
                        </p>
                    </div>

                    <button
                        v-if="isManager"
                        type="button"
                        class="inline-flex shrink-0 items-center gap-1.5 rounded-lg px-2.5 py-2 text-xs font-medium text-red-500 transition hover:bg-red-50 hover:text-red-700 disabled:cursor-not-allowed disabled:opacity-50"
                        :disabled="isProcessing(item.id)"
                        @click="detachProduct(item)"
                    >
                        <span
                            v-if="isProcessing(item.id)"
                            class="h-3.5 w-3.5 animate-spin rounded-full border-2 border-red-200 border-t-red-500"
                        ></span>

                        <i
                            v-else
                            class="bi bi-link-45deg"
                        ></i>

                        {{ t('actions.remove') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- =========================================================
             ADD MODAL
             ========================================================= -->

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
                    v-if="isAddModalOpen"
                    class="fixed inset-0 z-[120] flex items-center justify-center bg-slate-950/60 p-4 backdrop-blur-sm"
                    @click.self="closeAddModal"
                >
                    <div
                        class="flex max-h-[calc(100vh-2rem)] w-full max-w-4xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl"
                    >
                        <!-- HEADER -->

                        <div
                            class="flex shrink-0 items-center justify-between gap-4 border-b border-slate-200 px-5 py-4 sm:px-6"
                        >
                            <div class="min-w-0">
                                <h2
                                    class="text-lg font-semibold tracking-tight text-slate-900"
                                >
                                    {{ t('compatibleProducts.title') }}
                                </h2>

                                <p
                                    class="mt-1 text-xs text-slate-500"
                                >
                                    {{ t('compatibleProducts.description') }}
                                </p>
                            </div>

                            <button
                                type="button"
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                                :aria-label="t('common.close')"
                                @click="closeAddModal"
                            >
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>

                        <!-- SEARCH -->

                        <div
                            class="shrink-0 border-b border-slate-200 bg-slate-50 px-5 py-4 sm:px-6"
                        >
                            <div class="relative">
                                <i
                                    class="bi bi-search pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"
                                ></i>

                                <input
                                    v-model="search"
                                    type="search"
                                    :placeholder="t('actions.search')"
                                    class="w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-9 pr-4 text-sm outline-none transition placeholder:text-slate-400 focus:border-slate-500 focus:ring-1 focus:ring-slate-500"
                                />
                            </div>
                        </div>

                        <!-- TABLE -->

                        <div
                            class="min-h-0 flex-1 overflow-y-auto"
                        >
                            <!-- LOADING -->

                            <div
                                v-if="isOptionsLoading"
                                class="flex min-h-[300px] items-center justify-center"
                            >
                                <div
                                    class="flex items-center gap-3 text-xs text-slate-500"
                                >
                                    <span
                                        class="h-6 w-6 animate-spin rounded-full border-2 border-slate-200 border-t-slate-700"
                                    ></span>

                                    {{ t('common.loading') }}
                                </div>
                            </div>

                            <!-- ERROR -->

                            <div
                                v-else-if="optionsError"
                                class="m-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                            >
                                {{ optionsError }}
                            </div>

                            <!-- EMPTY -->

                            <div
                                v-else-if="products.length === 0"
                                class="flex min-h-[300px] items-center justify-center px-6"
                            >
                                <div class="text-center">
                                    <div
                                        class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-400"
                                    >
                                        <i
                                            class="bi bi-search"
                                        ></i>
                                    </div>

                                    <p
                                        class="mt-3 text-xs font-medium text-slate-500"
                                    >
                                        {{ t('compatibleProducts.empty.text') }}
                                    </p>
                                </div>
                            </div>

                            <!-- TABLE -->

                            <table
                                v-else
                                class="w-full min-w-[620px] border-collapse text-left"
                            >
                                <thead
                                    class="sticky top-0 z-10 bg-slate-50"
                                >
                                    <tr
                                        class="border-b border-slate-200"
                                    >
                                        <th
                                            class="w-20 px-5 py-3 text-[10px] font-semibold uppercase tracking-wider text-slate-400"
                                        >
                                            ID
                                        </th>

                                        <th
                                            class="w-40 px-5 py-3 text-[10px] font-semibold uppercase tracking-wider text-slate-400"
                                        >
                                            {{ t('product.form.article') }}
                                        </th>

                                        <th
                                            class="px-5 py-3 text-[10px] font-semibold uppercase tracking-wider text-slate-400"
                                        >
                                            {{ t('product.form.name.title') }}
                                        </th>

                                        <th
                                            class="w-32 px-5 py-3 text-right text-[10px] font-semibold uppercase tracking-wider text-slate-400"
                                        ></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr
                                        v-for="item in products"
                                        :key="item.id"
                                        class="border-b border-slate-100 last:border-0 hover:bg-slate-50/70"
                                    >
                                        <td
                                            class="px-5 py-3 text-xs font-semibold text-slate-500"
                                        >
                                            {{ item.id }}
                                        </td>

                                        <td
                                            class="px-5 py-3 text-xs text-slate-500"
                                        >
                                            {{ item.article || '—' }}
                                        </td>

                                        <td
                                            class="px-5 py-3"
                                        >
                                            <div
                                                class="text-sm font-medium text-slate-800"
                                            >
                                                {{ productName(item) }}
                                            </div>
                                        </td>

                                        <td
                                            class="px-5 py-3 text-right"
                                        >
                                            <button
                                                v-if="item.attached"
                                                type="button"
                                                class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-3 py-2 text-xs font-medium text-slate-500"
                                                disabled
                                            >
                                                <i
                                                    class="bi bi-check-lg"
                                                ></i>

                                                {{ t('actions.add') }}
                                            </button>

                                            <button
                                                v-else
                                                type="button"
                                                class="inline-flex items-center gap-1.5 rounded-lg bg-slate-900 px-3 py-2 text-xs font-semibold text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
                                                :disabled="isProcessing(item.id)"
                                                @click="attachProduct(item)"
                                            >
                                                <span
                                                    v-if="isProcessing(item.id)"
                                                    class="h-3.5 w-3.5 animate-spin rounded-full border-2 border-slate-500 border-t-white"
                                                ></span>

                                                <i
                                                    v-else
                                                    class="bi bi-plus-lg"
                                                ></i>

                                                {{ t('actions.add') }}
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- FOOTER -->

                        <div
                            class="flex shrink-0 justify-end border-t border-slate-200 bg-slate-50 px-5 py-4 sm:px-6"
                        >
                            <button
                                type="button"
                                class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-100"
                                @click="closeAddModal"
                            >
                                {{ t('actions.close') }}
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>
    </section>
</template>

<script setup>
import {
    computed,
    onBeforeUnmount,
    ref,
    watch,
} from 'vue';

import { useI18n } from 'vue-i18n';

import { productCompatibilitiesApi } from '../../../../services/productCompatibilitiesApi.js';

const props = defineProps({
    productId: {
        type: [Number, String],
        required: true,
    },

    isManager: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits([
    'updated',
]);

const {
    t,
    locale,
} = useI18n();

/*
|--------------------------------------------------------------------------
| State
|--------------------------------------------------------------------------
*/

const compatibleProducts = ref([]);

const products = ref([]);

const isLoading = ref(false);

const isOptionsLoading = ref(false);

const isAddModalOpen = ref(false);

const error = ref('');

const optionsError = ref('');

const search = ref('');

const processingIds = ref(
    new Set(),
);

let searchTimer = null;

/*
|--------------------------------------------------------------------------
| Locale
|--------------------------------------------------------------------------
*/

const currentLocale = computed(() => {
    return locale.value === 'en'
        ? 'en'
        : 'ru';
});

/*
|--------------------------------------------------------------------------
| Product name
|--------------------------------------------------------------------------
*/

const productName = (product) => {
    if (!product?.name) {
        return '';
    }

    if (
        typeof product.name ===
        'string'
    ) {
        return product.name;
    }

    return (
        product.name[
            currentLocale.value
        ] ??
        product.name.ru ??
        product.name.en ??
        ''
    );
};

/*
|--------------------------------------------------------------------------
| Processing
|--------------------------------------------------------------------------
*/

const isProcessing = (id) => {
    return processingIds.value.has(
        Number(id),
    );
};

const setProcessing = (
    id,
    value,
) => {
    const next = new Set(
        processingIds.value,
    );

    const numericId = Number(id);

    if (value) {
        next.add(numericId);
    } else {
        next.delete(numericId);
    }

    processingIds.value = next;
};

/*
|--------------------------------------------------------------------------
| Load current compatible products
|--------------------------------------------------------------------------
*/

const loadCompatibleProducts =
    async () => {
        if (!props.productId) {
            return;
        }

        isLoading.value = true;
        error.value = '';

        try {
            const response =
                await productCompatibilitiesApi.index(
                    props.productId,
                );

            compatibleProducts.value =
                response?.products
                    ?.filter(
                        (item) =>
                            item.attached,
                    ) ?? [];
        } catch (err) {
            console.error(
                'Failed to load compatible products:',
                err,
            );

            error.value =
                err?.message ||
                t('messages.fail.default');
        } finally {
            isLoading.value = false;
        }
    };

/*
|--------------------------------------------------------------------------
| Load product options
|--------------------------------------------------------------------------
*/

const loadOptions = async (
    value = '',
) => {
    if (!props.productId) {
        return;
    }

    isOptionsLoading.value = true;
    optionsError.value = '';

    try {
        const response =
            await productCompatibilitiesApi.index(
                props.productId,
                value,
            );

        products.value =
            response?.products ?? [];
    } catch (err) {
        console.error(
            'Failed to load compatible product options:',
            err,
        );

        optionsError.value =
            err?.message ||
            t('messages.fail.default');
    } finally {
        isOptionsLoading.value = false;
    }
};

/*
|--------------------------------------------------------------------------
| Open modal
|--------------------------------------------------------------------------
*/

const openAddModal = async () => {
    if (
        !props.isManager ||
        !props.productId
    ) {
        return;
    }

    search.value = '';
    isAddModalOpen.value = true;

    document.body.classList.add(
        'overflow-hidden',
    );

    await loadOptions();
};

/*
|--------------------------------------------------------------------------
| Close modal
|--------------------------------------------------------------------------
*/

const closeAddModal = () => {
    isAddModalOpen.value = false;
    search.value = '';

    if (!compatibleProducts.value.length) {
        /*
         * Nothing special here.
         * Keep body state deterministic.
         */
    }

    document.body.classList.remove(
        'overflow-hidden',
    );
};

/*
|--------------------------------------------------------------------------
| Attach
|--------------------------------------------------------------------------
*/

const attachProduct = async (
    product,
) => {
    if (
        !product?.id ||
        isProcessing(product.id)
    ) {
        return;
    }

    setProcessing(
        product.id,
        true,
    );

    optionsError.value = '';

    try {
        await productCompatibilitiesApi.attach(
            props.productId,
            product.id,
        );

        product.attached = true;

        compatibleProducts.value = [
            ...compatibleProducts.value,
            product,
        ];

        emit('updated');
    } catch (err) {
        console.error(
            'Failed to attach compatible product:',
            err,
        );

        optionsError.value =
            err?.message ||
            t('messages.fail.default');
    } finally {
        setProcessing(
            product.id,
            false,
        );
    }
};

/*
|--------------------------------------------------------------------------
| Detach
|--------------------------------------------------------------------------
*/

const detachProduct = async (
    product,
) => {
    if (
        !product?.id ||
        isProcessing(product.id)
    ) {
        return;
    }

    setProcessing(
        product.id,
        true,
    );

    error.value = '';

    try {
        await productCompatibilitiesApi.detach(
            props.productId,
            product.id,
        );

        compatibleProducts.value =
            compatibleProducts.value.filter(
                (item) =>
                    Number(item.id) !==
                    Number(product.id),
            );

        const modalProduct =
            products.value.find(
                (item) =>
                    Number(item.id) ===
                    Number(product.id),
            );

        if (modalProduct) {
            modalProduct.attached = false;
        }

        emit('updated');
    } catch (err) {
        console.error(
            'Failed to detach compatible product:',
            err,
        );

        error.value =
            err?.message ||
            t('messages.fail.default');
    } finally {
        setProcessing(
            product.id,
            false,
        );
    }
};

/*
|--------------------------------------------------------------------------
| Search watcher
|--------------------------------------------------------------------------
*/

watch(
    search,
    (value) => {
        if (!isAddModalOpen.value) {
            return;
        }

        if (searchTimer) {
            clearTimeout(
                searchTimer,
            );
        }

        searchTimer = setTimeout(
            () => {
                loadOptions(value);
            },
            300,
        );
    },
);

/*
|--------------------------------------------------------------------------
| Product changes
|--------------------------------------------------------------------------
*/

watch(
    () => props.productId,
    async () => {
        await loadCompatibleProducts();

        if (isAddModalOpen.value) {
            await loadOptions(
                search.value,
            );
        }
    },
    {
        immediate: true,
    },
);

/*
|--------------------------------------------------------------------------
| Cleanup
|--------------------------------------------------------------------------
*/

onBeforeUnmount(() => {
    if (searchTimer) {
        clearTimeout(
            searchTimer,
        );
    }

    document.body.classList.remove(
        'overflow-hidden',
    );
});
</script>