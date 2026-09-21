<template>
    <div class="w-full space-y-8">
        <!-- ========================================================= -->
        <!-- LOADING -->
        <!-- ========================================================= -->

        <div v-if="isLoading" class="flex min-h-40 items-center justify-center">
            <div class="flex items-center gap-3 text-sm text-slate-500">
                <i class="bi bi-arrow-repeat animate-spin"></i>

                <span>
                    {{ $t('common.loading') }}
                </span>
            </div>
        </div>

        <template v-else>
            <!-- ===================================================== -->
            <!-- BASIC INFORMATION -->
            <!-- ===================================================== -->

            <section>
                <div class="mb-5">
                    <h3 class="text-base font-semibold text-slate-900">
                        {{ $t('product.form.basic.title') }}
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        {{ $t('product.form.basic.description') }}
                    </p>
                </div>

                <!-- ARTICLE -->

                <div class="mb-5">
                    <Input
                        v-model="form.article"
                        name="article"
                        :placeholder="$t('product.form.article')"
                        icon="bi bi-upc"
                        :required="true"
                        :error="errors.article"
                    />
                </div>

                <!-- NAME -->

                <div class="mb-5">
                    <div class="mb-3">
                        <h4 class="text-sm font-medium text-slate-700">
                            {{ $t('product.form.name.title') }}
                        </h4>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <Input
                            v-model="form.name.ru"
                            name="name_ru"
                            :placeholder="$t('common.russian')"
                            icon="bi bi-translate"
                            :required="true"
                            :error="errors.name_ru"
                        />

                        <Input
                            v-model="form.name.en"
                            name="name_en"
                            :placeholder="$t('common.english')"
                            icon="bi bi-translate"
                            :required="true"
                            :error="errors.name_en"
                        />
                    </div>
                </div>

                <!-- SHORT DESCRIPTION -->

                <div class="mb-5">
                    <div class="mb-3">
                        <h4 class="text-sm font-medium text-slate-700">
                            {{ $t('product.form.shortDescription.title') }}
                        </h4>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <Input
                            v-model="form.short_description.ru"
                            name="short_description_ru"
                            :placeholder="$t('common.russian')"
                            icon="bi bi-translate"
                            :required="true"
                            :error="errors.short_description_ru"
                        />

                        <Input
                            v-model="form.short_description.en"
                            name="short_description_en"
                            :placeholder="$t('common.english')"
                            icon="bi bi-translate"
                            :required="true"
                            :error="errors.short_description_en"
                        />
                    </div>
                </div>

                <!-- FULL DESCRIPTION -->

                <div>
                    <div class="mb-3">
                        <h4 class="text-sm font-medium text-slate-700">
                            {{ $t('product.form.fullDescription.title') }}
                        </h4>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <textarea
                                v-model="form.full_description.ru"
                                rows="7"
                                :placeholder="$t('common.russian')"
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-400 focus:ring-2 focus:ring-slate-100"
                            ></textarea>

                            <p
                                v-if="errors.full_description_ru"
                                class="mt-1.5 text-xs text-red-600"
                            >
                                {{ errors.full_description_ru }}
                            </p>
                        </div>

                        <div>
                            <textarea
                                v-model="form.full_description.en"
                                rows="7"
                                :placeholder="$t('common.english')"
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-400 focus:ring-2 focus:ring-slate-100"
                            ></textarea>

                            <p
                                v-if="errors.full_description_en"
                                class="mt-1.5 text-xs text-red-600"
                            >
                                {{ errors.full_description_en }}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ===================================================== -->
            <!-- MEDIA -->
            <!-- ===================================================== -->

            <section>
                <div class="mb-4">
                    <h3 class="text-base font-semibold text-slate-900">
                        {{ $t('product.form.media.title') }}
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        {{ $t('product.form.media.description') }}
                    </p>
                </div>

                <div class="max-w-2xl space-y-4">
                    <!-- IMAGE -->

                    <div>
                        <FileUpload
                            v-model="form.image_file"
                            name="image_file"
                            accept="image/*"
                            :placeholder="$t('product.form.image')"
                            :button-text="$t('product.form.file.choose')"
                            :current-file-url="imageCurrentFileUrl"
                            :error="errors.image_url"
                            icon="bi bi-image"
                            @update:model-value="handleImageFileChange"
                            @remove-current="removeCurrentImage"
                        />
                    </div>

                    <!-- VIDEO -->

                    <div>
                        <FileUpload
                            v-model="form.video_file"
                            name="video_file"
                            accept="video/*"
                            :placeholder="$t('product.form.video')"
                            :button-text="$t('product.form.file.choose')"
                            :current-file-url="videoCurrentFileUrl"
                            :error="errors.video_url"
                            icon="bi bi-play-btn"
                            @update:model-value="handleVideoFileChange"
                            @remove-current="removeCurrentVideo"
                        />
                    </div>
                </div>
            </section>

            <!-- ===================================================== -->
            <!-- METHODS -->
            <!-- ===================================================== -->

            <section>
                <div class="mb-5">
                    <h3 class="text-base font-semibold text-slate-900">
                        {{ $t('product.form.method.title') }}
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        {{ $t('product.form.method.description') }}
                    </p>
                </div>

                <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                    <label
                        v-for="method in methodOptions"
                        :key="method.key"
                        class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 transition hover:border-slate-300"
                    >
                        <input
                            v-model="form.method[method.key]"
                            type="checkbox"
                            class="h-4 w-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900"
                        />

                        <span class="text-sm font-medium text-slate-700">
                            {{ method.label }}
                        </span>
                    </label>
                </div>
            </section>

            <!-- ===================================================== -->
            <!-- SECTORS -->
            <!-- ===================================================== -->

            <section>
                <div class="mb-5">
                    <h3 class="text-base font-semibold text-slate-900">
                        {{ $t('product.form.sector.title') }}
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        {{ $t('product.form.sector.description') }}
                    </p>
                </div>

                <div class="grid gap-2 sm:grid-cols-3">
                    <label
                        v-for="sector in sectorOptions"
                        :key="sector.key"
                        class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 transition hover:border-slate-300"
                    >
                        <input
                            v-model="form.sector[sector.key]"
                            type="checkbox"
                            class="h-4 w-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900"
                        />

                        <span class="text-sm font-medium text-slate-700">
                            {{ sector.label }}
                        </span>
                    </label>
                </div>
            </section>
        </template>
    </div>
</template>

<script setup>
import { computed, reactive, ref, watch } from 'vue';

import { useI18n } from 'vue-i18n';

import Input from '../UI/form/Input.vue';
import FileUpload from '../UI/form/FileUpload.vue';

import { ActionType } from '../../constants/actions';
import { productsApi } from '../../services/productsApi.js';
import { uploadsApi } from '../../services/uploadsApi.js';

const { t } = useI18n();

/*
|--------------------------------------------------------------------------
| Props
|--------------------------------------------------------------------------
*/

const props = defineProps({
    settings: {
        type: Object,
        default: () => ({
            type: null,
            action: null,
            item: null,
        }),
    },

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
        default: '',
    },
});

/*
|--------------------------------------------------------------------------
| Emits
|--------------------------------------------------------------------------
*/

const emit = defineEmits(['submit']);

/*
|--------------------------------------------------------------------------
| Default product values
|--------------------------------------------------------------------------
*/

const PRODUCT_DEFAULTS = {
    unit: 'pcs',
    brand_id: 1,
    price: 0,
    quantity: 10,
    status: true,
};

/*
|--------------------------------------------------------------------------
| Form
|--------------------------------------------------------------------------
*/

const createInitialForm = () => ({
    article: '',

    name: {
        ru: '',
        en: '',
    },

    short_description: {
        ru: '',
        en: '',
    },

    full_description: {
        ru: '',
        en: '',
    },

    category_id: null,
    group_id: null,

    image_url: '',
    image_upload_token: null,

    video_url: '',
    video_upload_token: null,

    image_file: null,
    video_file: null,

    method: {
        ut_method: false,
        et_method: false,
        mia_method: false,
        iet_method: false,
        mt_method: false,
        vt_method: false,
    },

    sector: {
        railway: false,
        aerospace: false,
        oil: false,
    },
});

const form = reactive(createInitialForm());

/*
|--------------------------------------------------------------------------
| Category slug
|--------------------------------------------------------------------------
|
| Allows edit form to work even if the parent
| does not explicitly pass categorySlug.
|
*/

const resolvedCategorySlug = computed(() => {
    return (
        props.categorySlug ||
        props.settings.item?.categorySlug ||
        props.settings.item?.product?.categorySlug ||
        ''
    );
});

/*
|--------------------------------------------------------------------------
| Existing image URL
|--------------------------------------------------------------------------
*/

const imageCurrentFileUrl = computed(() => {
    if (!form.image_url || !resolvedCategorySlug.value) {
        return '';
    }

    const basename = String(form.image_url).replace(/\.(jpg|jpeg|png|webp)$/i, '');

    return `/image/product/${resolvedCategorySlug.value}/${basename}.webp`;
});

/*
|--------------------------------------------------------------------------
| Existing video URL
|--------------------------------------------------------------------------
*/

const videoCurrentFileUrl = computed(() => {
    if (!form.video_url || !resolvedCategorySlug.value) {
        return '';
    }

    const basename = String(form.video_url).replace(/\.(mp4|webm|mov)$/i, '');

    return `/video/product/${resolvedCategorySlug.value}/${basename}.mp4`;
});

/*
|--------------------------------------------------------------------------
| Errors
|--------------------------------------------------------------------------
*/

const errors = reactive({
    article: '',

    name_ru: '',
    name_en: '',

    short_description_ru: '',
    short_description_en: '',

    full_description_ru: '',
    full_description_en: '',

    image_url: '',
    video_url: '',
});

/*
|--------------------------------------------------------------------------
| State
|--------------------------------------------------------------------------
*/

const isLoading = ref(false);
const isUploading = ref(false);

/*
|--------------------------------------------------------------------------
| Method / Sector options
|--------------------------------------------------------------------------
*/

const methodOptions = [
    {
        key: 'ut_method',
        label: 'UT',
    },

    {
        key: 'et_method',
        label: 'ET',
    },

    {
        key: 'mia_method',
        label: 'MIA',
    },

    {
        key: 'iet_method',
        label: 'IET',
    },

    {
        key: 'mt_method',
        label: 'MT',
    },

    {
        key: 'vt_method',
        label: 'VT',
    },
];

const sectorOptions = [
    {
        key: 'railway',
        label: 'Railway',
    },

    {
        key: 'aerospace',
        label: 'Aerospace',
    },

    {
        key: 'oil',
        label: 'Oil & Gas',
    },
];

/*
|--------------------------------------------------------------------------
| Reset
|--------------------------------------------------------------------------
*/

const resetForm = () => {
    const initial = createInitialForm();

    form.article = initial.article;

    form.name.ru = initial.name.ru;

    form.name.en = initial.name.en;

    form.short_description.ru = initial.short_description.ru;

    form.short_description.en = initial.short_description.en;

    form.full_description.ru = initial.full_description.ru;

    form.full_description.en = initial.full_description.en;

    form.category_id = props.categoryId ?? null;

    form.group_id = props.groupId ?? null;

    form.image_url = '';
    form.image_upload_token = null;
    form.image_file = null;

    form.video_url = '';
    form.video_upload_token = null;
    form.video_file = null;

    form.method.ut_method = false;
    form.method.et_method = false;
    form.method.mia_method = false;
    form.method.iet_method = false;
    form.method.mt_method = false;
    form.method.vt_method = false;

    form.sector.railway = false;
    form.sector.aerospace = false;
    form.sector.oil = false;
};

const resetErrors = () => {
    Object.keys(errors).forEach((key) => {
        errors[key] = '';
    });
};

/*
|--------------------------------------------------------------------------
| API errors
|--------------------------------------------------------------------------
*/

const normalizeApiErrorKey = (key) => {
    const aliases = {
        'name.ru': 'name_ru',
        'name.en': 'name_en',

        'short_description.ru': 'short_description_ru',

        'short_description.en': 'short_description_en',

        'full_description.ru': 'full_description_ru',

        'full_description.en': 'full_description_en',
    };

    if (aliases[key]) {
        return aliases[key];
    }

    return key.replace(/\./g, '_');
};

const applyApiErrors = (apiErrors = {}) => {
    resetErrors();

    Object.entries(apiErrors).forEach(([key, messages]) => {
        const normalizedKey = normalizeApiErrorKey(key);

        if (Object.prototype.hasOwnProperty.call(errors, normalizedKey)) {
            errors[normalizedKey] = Array.isArray(messages) ? messages[0] : messages;
        }
    });
};

/*
|--------------------------------------------------------------------------
| File upload
|--------------------------------------------------------------------------
*/

const uploadFile = async (file, type) => {
    if (typeof File === 'undefined' || !(file instanceof File)) {
        return null;
    }

    isUploading.value = true;

    try {
        const response = await uploadsApi.upload(file, type);

        const token = response?.upload?.token ?? null;

        if (!token) {
            throw new Error('Upload token was not returned by server.');
        }

        return token;
    } finally {
        isUploading.value = false;
    }
};

/*
|--------------------------------------------------------------------------
| Image
|--------------------------------------------------------------------------
*/

const handleImageFileChange = async (file) => {
    const oldToken = form.image_upload_token;

    if (typeof File === 'undefined' || !(file instanceof File)) {
        form.image_file = null;
        form.image_upload_token = null;
        form.image_url = '';

        if (oldToken) {
            await uploadsApi.remove(oldToken).catch(() => {});
        }

        return;
    }

    errors.image_url = '';

    try {
        const token = await uploadFile(file, 'image');

        form.image_upload_token = token;

        if (oldToken && oldToken !== token) {
            await uploadsApi.remove(oldToken).catch(() => {});
        }
    } catch (error) {
        form.image_upload_token = null;
        form.image_file = null;

        errors.image_url = error?.message || t('product.form.file.uploadError');
    }
};

/*
|--------------------------------------------------------------------------
| Remove current image
|--------------------------------------------------------------------------
*/

const removeCurrentImage = () => {
    form.image_file = null;
    form.image_upload_token = null;
    form.image_url = '';
};

/*
|--------------------------------------------------------------------------
| Video
|--------------------------------------------------------------------------
*/

const handleVideoFileChange = async (file) => {
    const oldToken = form.video_upload_token;

    if (typeof File === 'undefined' || !(file instanceof File)) {
        form.video_file = null;
        form.video_upload_token = null;
        form.video_url = '';

        if (oldToken) {
            await uploadsApi.remove(oldToken).catch(() => {});
        }

        return;
    }

    errors.video_url = '';

    try {
        const token = await uploadFile(file, 'video');

        form.video_upload_token = token;

        if (oldToken && oldToken !== token) {
            await uploadsApi.remove(oldToken).catch(() => {});
        }
    } catch (error) {
        form.video_upload_token = null;
        form.video_file = null;

        errors.video_url = error?.message || t('product.form.file.uploadError');
    }
};

/*
|--------------------------------------------------------------------------
| Remove current video
|--------------------------------------------------------------------------
*/

const removeCurrentVideo = () => {
    form.video_file = null;
    form.video_upload_token = null;
    form.video_url = '';
};

/*
|--------------------------------------------------------------------------
| Populate form
|--------------------------------------------------------------------------
*/

const populateForm = (product) => {
    resetForm();

    if (!product) {
        return;
    }

    form.article = product.article ?? '';

    form.name.ru = product.name?.ru ?? '';

    form.name.en = product.name?.en ?? '';

    form.short_description.ru = product.short_description?.ru ?? '';

    form.short_description.en = product.short_description?.en ?? '';

    form.full_description.ru = product.full_description?.ru ?? '';

    form.full_description.en = product.full_description?.en ?? '';

    form.category_id = product.category_id ?? props.categoryId ?? null;

    form.group_id = product.group_id ?? props.groupId ?? null;

    form.image_url = product.image_url ?? '';

    form.image_upload_token = null;

    form.video_url = product.video_url ?? '';

    form.video_upload_token = null;

    form.image_file = null;
    form.video_file = null;

    form.method = {
        ut_method: Boolean(product.method?.ut_method),

        et_method: Boolean(product.method?.et_method),

        mia_method: Boolean(product.method?.mia_method),

        iet_method: Boolean(product.method?.iet_method),

        mt_method: Boolean(product.method?.mt_method),

        vt_method: Boolean(product.method?.vt_method),
    };

    form.sector = {
        railway: Boolean(product.sector?.railway),

        aerospace: Boolean(product.sector?.aerospace),

        oil: Boolean(product.sector?.oil),
    };
};

/*
|--------------------------------------------------------------------------
| Load product for edit
|--------------------------------------------------------------------------
*/

const loadProduct = async (productId) => {
    if (!productId) {
        resetForm();

        return;
    }

    isLoading.value = true;
    resetErrors();

    try {
        const response = await productsApi.getEdit(productId);

        populateForm(response?.product ?? null);
    } catch (error) {
        console.error('Failed to load product:', error);
    } finally {
        isLoading.value = false;
    }
};

/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/

const validate = () => {
    resetErrors();

    let valid = true;

    if (!form.article.trim()) {
        errors.article = t('validation.input.required');

        valid = false;
    }

    if (!form.name.ru.trim()) {
        errors.name_ru = t('validation.input.required');

        valid = false;
    }

    if (!form.name.en.trim()) {
        errors.name_en = t('validation.input.required');

        valid = false;
    }

    if (!form.short_description.ru.trim()) {
        errors.short_description_ru = t('validation.input.required');

        valid = false;
    }

    if (!form.short_description.en.trim()) {
        errors.short_description_en = t('validation.input.required');

        valid = false;
    }

    if (!form.full_description.ru.trim()) {
        errors.full_description_ru = t('validation.input.required');

        valid = false;
    }

    if (!form.full_description.en.trim()) {
        errors.full_description_en = t('validation.input.required');

        valid = false;
    }

    if (!form.category_id) {
        return false;
    }

    if (!form.group_id) {
        return false;
    }

    return valid;
};

/*
|--------------------------------------------------------------------------
| Submit
|--------------------------------------------------------------------------
*/

const submit = () => {
    if (isUploading.value) {
        return;
    }

    if (!validate()) {
        return;
    }

    const payload = {
        article: form.article.trim(),

        name: {
            ru: form.name.ru.trim(),

            en: form.name.en.trim(),
        },

        short_description: {
            ru: form.short_description.ru.trim(),

            en: form.short_description.en.trim(),
        },

        full_description: {
            ru: form.full_description.ru.trim(),

            en: form.full_description.en.trim(),
        },

        category_id: form.category_id,

        group_id: form.group_id,

        unit: PRODUCT_DEFAULTS.unit,

        brand_id: PRODUCT_DEFAULTS.brand_id,

        price: PRODUCT_DEFAULTS.price,

        quantity: PRODUCT_DEFAULTS.quantity,

        status: PRODUCT_DEFAULTS.status,

        image_url: form.image_url.trim() || null,

        image_upload_token: form.image_upload_token,

        video_url: form.video_url.trim() || null,

        video_upload_token: form.video_upload_token,

        method: {
            ...form.method,
        },

        sector: {
            ...form.sector,
        },
    };

    emit('submit', payload);
};

/*
|--------------------------------------------------------------------------
| Watch settings
|--------------------------------------------------------------------------
*/

watch(
    () => [props.settings.action, props.settings.item, props.categoryId, props.groupId],

    async () => {
        const productId =
            props.settings.action === ActionType.UPDATE
                ? (props.settings.item?.product?.id ?? props.settings.item?.id ?? null)
                : null;

        if (productId) {
            await loadProduct(productId);

            return;
        }

        isLoading.value = false;

        resetErrors();
        resetForm();
    },

    {
        immediate: true,
    }
);

/*
|--------------------------------------------------------------------------
| Expose
|--------------------------------------------------------------------------
*/

defineExpose({
    submit,
    applyApiErrors,
});
</script>
