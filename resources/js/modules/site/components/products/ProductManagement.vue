<template>
    <div>
        <!-- ===================================================== -->
        <!-- CREATE -->
        <!-- ===================================================== -->

        <div class="mb-6 flex justify-end">
            <button
                v-if="canManage && !isUserLoading"
                type="button"
                class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
                :disabled="
                    isSaving ||
                    isDeleting ||
                    !canCreate
                "
                @click="openCreate"
            >
                <i class="bi bi-plus-lg"></i>

                {{ $t('actions.create') }}
            </button>
        </div>

        <!-- ===================================================== -->
        <!-- CREATE / EDIT DRAWER -->
        <!-- ===================================================== -->

        <DrawersWrapper
            :is-open="isDrawerOpen"
            @close="closeDrawer"
            @submit="submitForm"
        >
            <!-- HEADER -->

            <template #header>
                <div>
                    <h2
                        class="text-lg font-semibold text-slate-900"
                    >
                        {{ drawerTitle }}
                    </h2>

                    <p
                        class="mt-1 text-sm text-slate-500"
                    >
                        {{ drawerDescription }}
                    </p>
                </div>
            </template>

            <!-- BODY -->

            <template #body>
                <ProductForm
                    ref="productFormRef"
                    :settings="formSettings"
                    :category-id="props.categoryId"
                    :group-id="props.groupId"
                    :category-slug="props.categorySlug"
                    @submit="handleFormSubmit"
                />

                <p
                    v-if="formError"
                    class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                >
                    {{ formError }}
                </p>
            </template>

            <!-- FOOTER -->

            <template #footer>
                <div
                    class="flex items-center justify-end gap-3"
                >
                    <button
                        type="button"
                        class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-60"
                        :disabled="isSaving"
                        @click="closeDrawer"
                    >
                        {{ $t('actions.cancel') }}
                    </button>

                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-60"
                        :disabled="isSaving"
                        @click="submitForm"
                    >
                        <i
                            v-if="isSaving"
                            class="bi bi-arrow-repeat animate-spin"
                        ></i>

                        <i
                            v-else
                            class="bi bi-check-lg"
                        ></i>

                        {{
                            isSaving
                                ? $t('actions.saving')
                                : $t('actions.save')
                        }}
                    </button>
                </div>
            </template>
        </DrawersWrapper>

        <!-- ===================================================== -->
        <!-- DELETE CONFIRMATION -->
        <!-- ===================================================== -->

        <ModalWrapper
            :settings="deleteModalSettings"
            :is-open="Boolean(deleteModalSettings.item)"
            @close="closeDelete"
            @submit="confirmDelete"
        />
    </div>
</template>

<script setup>
import {
    computed,
    ref,
} from 'vue';

import { useI18n } from 'vue-i18n';

import ProductForm from './ProductForm.vue';
import DrawersWrapper from '../modals/DrawersWrapper.vue';
import ModalWrapper from '../modals/ModalWrapper.vue';

import { useCurrentUser } from '../../../auth/composables/useCurrentUser.js';
import { productsApi } from '../../services/productsApi.js';
import { ActionType } from '../../constants/actions.js';

/*
|--------------------------------------------------------------------------
| Props
|--------------------------------------------------------------------------
*/

const props = defineProps({
    categoryId: {
        type: [Number, String],
        default: null,
    },

    groupId: {
        type: [Number, String],
        default: null,
    },

    categorySlug: {
        type: String,
        default: null,
    },
});

/*
|--------------------------------------------------------------------------
| Emits
|--------------------------------------------------------------------------
*/

const emit = defineEmits([
    'created',
    'updated',
    'deleted',
]);

/*
|--------------------------------------------------------------------------
| i18n
|--------------------------------------------------------------------------
*/

const { t } = useI18n();

/*
|--------------------------------------------------------------------------
| Current user
|--------------------------------------------------------------------------
*/

const {
    canManage,
    isLoading: isUserLoading,
} = useCurrentUser();

/*
|--------------------------------------------------------------------------
| Drawer state
|--------------------------------------------------------------------------
*/

const isDrawerOpen = ref(false);

const isSaving = ref(false);

const formError = ref('');

const productFormRef = ref(null);

const formSettings = ref({
    type: 'product',
    action: ActionType.CREATE,
    item: null,
});

/*
|--------------------------------------------------------------------------
| Delete state
|--------------------------------------------------------------------------
*/

const isDeleting = ref(false);

const deleteModalSettings = ref({
    type: 'product',
    action: 'delete',
    item: null,
});

/*
|--------------------------------------------------------------------------
| Create / Edit
|--------------------------------------------------------------------------
*/

const isCreate = computed(() => {
    return (
        formSettings.value.action ===
        ActionType.CREATE
    );
});

const canCreate = computed(() => {
    return (
        props.categoryId !== null &&
        props.categoryId !== undefined &&
        props.groupId !== null &&
        props.groupId !== undefined
    );
});

const drawerTitle = computed(() => {
    return isCreate.value
        ? t('product.form.createTitle')
        : t('product.form.editTitle');
});

const drawerDescription = computed(() => {
    return isCreate.value
        ? t('product.form.createDescription')
        : t('product.form.editDescription');
});

/*
|--------------------------------------------------------------------------
| Open create
|--------------------------------------------------------------------------
*/

const openCreate = () => {
    if (!canManage.value) {
        return;
    }

    if (
        isSaving.value ||
        isDeleting.value
    ) {
        return;
    }

    if (!canCreate.value) {
        return;
    }

    formError.value = '';

    formSettings.value = {
        type: 'product',
        action: ActionType.CREATE,
        item: null,
    };

    isDrawerOpen.value = true;
};

/*
|--------------------------------------------------------------------------
| Open edit
|--------------------------------------------------------------------------
*/

const openEdit = (product) => {
    if (!canManage.value) {
        return;
    }

    if (
        isSaving.value ||
        isDeleting.value
    ) {
        return;
    }

    if (!product?.id) {
        return;
    }

    formError.value = '';

    formSettings.value = {
        type: 'product',
        action: ActionType.UPDATE,
        item: product,
    };

    isDrawerOpen.value = true;
};

/*
|--------------------------------------------------------------------------
| Close drawer
|--------------------------------------------------------------------------
*/

const closeDrawer = (force = false) => {
    if (isSaving.value && !force) {
        return;
    }

    isDrawerOpen.value = false;

    formError.value = '';

    formSettings.value = {
        type: 'product',
        action: ActionType.CREATE,
        item: null,
    };
};

/*
|--------------------------------------------------------------------------
| Submit form
|--------------------------------------------------------------------------
*/

const submitForm = () => {
    if (isSaving.value) {
        return;
    }

    productFormRef.value?.submit();
};

const handleFormSubmit = async (payload) => {
    if (isSaving.value) {
        return;
    }

    if (isCreate.value) {
        await createProduct(payload);

        return;
    }

    await updateProduct(payload);
};

/*
|--------------------------------------------------------------------------
| Create
|--------------------------------------------------------------------------
*/

const createProduct = async (payload) => {
    isSaving.value = true;

    formError.value = '';

    try {
        const product =
            await productsApi.create(
                payload,
            );

        emit('created', product);

        closeDrawer(true);
    } catch (error) {
        handleFormError(error);
    } finally {
        isSaving.value = false;
    }
};

/*
|--------------------------------------------------------------------------
| Update
|--------------------------------------------------------------------------
*/

const updateProduct = async (payload) => {
    const productId =
        formSettings.value.item?.id ?? null;

    if (!productId) {
        formError.value =
            t('product.form.errors.save');

        return;
    }

    isSaving.value = true;

    formError.value = '';

    try {
        const product =
            await productsApi.update(
                productId,
                payload,
            );

        emit('updated', product);

        closeDrawer(true);
    } catch (error) {
        handleFormError(error);
    } finally {
        isSaving.value = false;
    }
};

/*
|--------------------------------------------------------------------------
| Form errors
|--------------------------------------------------------------------------
*/

const handleFormError = (error) => {
    if (error?.status === 422) {
        productFormRef.value?.applyApiErrors(
            error.errors || {},
        );

        return;
    }

    formError.value =
        error?.message ||
        t('product.form.errors.save');
};

/*
|--------------------------------------------------------------------------
| Delete
|--------------------------------------------------------------------------
*/

const openDelete = (product) => {
    if (!canManage.value) {
        return;
    }

    if (
        isSaving.value ||
        isDeleting.value
    ) {
        return;
    }

    if (!product?.id) {
        return;
    }

    deleteModalSettings.value = {
        type: 'product',
        action: 'delete',
        item: product,
    };
};

/*
|--------------------------------------------------------------------------
| Close delete modal
|--------------------------------------------------------------------------
*/

const closeDelete = () => {
    if (isDeleting.value) {
        return;
    }

    deleteModalSettings.value = {
        type: 'product',
        action: 'delete',
        item: null,
    };
};

/*
|--------------------------------------------------------------------------
| Confirm delete
|--------------------------------------------------------------------------
*/

const confirmDelete = async () => {
    if (isDeleting.value) {
        return;
    }

    const productId =
        deleteModalSettings.value.item?.id;

    if (!productId) {
        closeDelete();

        return;
    }

    isDeleting.value = true;

    try {
        await productsApi.remove(
            productId,
        );

        deleteModalSettings.value = {
            type: 'product',
            action: 'delete',
            item: null,
        };

        emit(
            'deleted',
            productId,
        );
    } catch (error) {
        console.error(
            'Failed to delete product:',
            error,
        );
    } finally {
        isDeleting.value = false;
    }
};

/*
|--------------------------------------------------------------------------
| Expose
|--------------------------------------------------------------------------
*/

defineExpose({
    openCreate,
    openEdit,
    openDelete,
    canManage,
});
</script>