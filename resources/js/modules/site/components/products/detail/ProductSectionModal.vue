<template>
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
                v-if="isOpen"
                class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/40 px-4 py-6 backdrop-blur-sm"
                @click.self="handleClose"
            >
                <Transition
                    appear
                    enter-active-class="transition duration-200 ease-out"
                    enter-from-class="scale-95 opacity-0"
                    enter-to-class="scale-100 opacity-100"
                    leave-active-class="transition duration-150 ease-in"
                    leave-from-class="scale-100 opacity-100"
                    leave-to-class="scale-95 opacity-0"
                >
                    <div
                        class="w-full max-w-2xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl"
                        role="dialog"
                        aria-modal="true"
                        aria-labelledby="product-section-modal-title"
                    >
                        <!-- Header -->
                        <div
                            class="flex items-start justify-between gap-4 border-b border-slate-200 px-5 py-4"
                        >
                            <div class="min-w-0">
                                <h2
                                    id="product-section-modal-title"
                                    class="text-lg font-semibold text-slate-900"
                                >
                                    {{ sectionTitle }}
                                </h2>

                                <p
                                    v-if="productName"
                                    class="mt-1 truncate text-xs text-slate-500"
                                >
                                    {{ productName }}
                                </p>
                            </div>

                            <button
                                type="button"
                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700 disabled:cursor-not-allowed disabled:opacity-50"
                                :disabled="isSaving"
                                :aria-label="$t('actions.close')"
                                @click="handleClose"
                            >
                                <i class="bi bi-x-lg text-sm"></i>
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="max-h-[70vh] overflow-y-auto px-5 py-5">
                            <div
                                v-if="isLoading"
                                class="flex min-h-48 items-center justify-center"
                            >
                                <div
                                    class="flex items-center gap-3 text-sm text-slate-500"
                                >
                                    <i
                                        class="bi bi-arrow-repeat animate-spin"
                                    ></i>

                                    <span>
                                        {{ $t('common.loading') }}
                                    </span>
                                </div>
                            </div>

                            <template v-else>
                                <p
                                    v-if="formError"
                                    class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                                >
                                    {{ formError }}
                                </p>

                                <!-- Details -->
                                <div
                                    v-if="section === 'details'"
                                    class="space-y-5"
                                >
                                    <div>
                                        <label
                                            class="mb-2 block text-sm font-medium text-slate-700"
                                        >
                                            {{ $t('common.russian') }}
                                        </label>

                                        <textarea
                                            v-model="form.details.ru"
                                            rows="8"
                                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-400 focus:ring-2 focus:ring-slate-100"
                                        ></textarea>

                                        <p
                                            v-if="
                                                errors.full_description_ru
                                            "
                                            class="mt-1.5 text-xs text-red-600"
                                        >
                                            {{
                                                errors.full_description_ru
                                            }}
                                        </p>
                                    </div>

                                    <div>
                                        <label
                                            class="mb-2 block text-sm font-medium text-slate-700"
                                        >
                                            {{ $t('common.english') }}
                                        </label>

                                        <textarea
                                            v-model="form.details.en"
                                            rows="8"
                                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-400 focus:ring-2 focus:ring-slate-100"
                                        ></textarea>

                                        <p
                                            v-if="
                                                errors.full_description_en
                                            "
                                            class="mt-1.5 text-xs text-red-600"
                                        >
                                            {{
                                                errors.full_description_en
                                            }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Features -->
                                <div
                                    v-else-if="section === 'features'"
                                    class="space-y-6"
                                >
                                    <div class="grid gap-5 sm:grid-cols-2">
                                        <div>
                                            <label
                                                class="mb-2 block text-sm font-medium text-slate-700"
                                            >
                                                {{ $t('common.russian') }}
                                            </label>

                                            <textarea
                                                v-model="form.features.ru"
                                                rows="8"
                                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-400 focus:ring-2 focus:ring-slate-100"
                                            ></textarea>

                                            <p
                                                v-if="errors.features_ru"
                                                class="mt-1.5 text-xs text-red-600"
                                            >
                                                {{ errors.features_ru }}
                                            </p>
                                        </div>

                                        <div>
                                            <label
                                                class="mb-2 block text-sm font-medium text-slate-700"
                                            >
                                                {{ $t('common.english') }}
                                            </label>

                                            <textarea
                                                v-model="form.features.en"
                                                rows="8"
                                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-400 focus:ring-2 focus:ring-slate-100"
                                            ></textarea>

                                            <p
                                                v-if="errors.features_en"
                                                class="mt-1.5 text-xs text-red-600"
                                            >
                                                {{ errors.features_en }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Features gallery -->
                                    <div>
                                        <div
                                            class="mb-4 flex items-start justify-between gap-4"
                                        >
                                            <div>
                                                <h3
                                                    class="text-sm font-semibold text-slate-900"
                                                >
                                                    {{
                                                        $t(
                                                            'product.form.featuresGallery.title'
                                                        )
                                                    }}
                                                </h3>

                                                <p
                                                    class="mt-1 text-xs text-slate-500"
                                                >
                                                    {{
                                                        $t(
                                                            'product.form.featuresGallery.description'
                                                        )
                                                    }}
                                                </p>

                                                <p
                                                    class="mt-1 text-[11px] text-slate-400"
                                                >
                                                    {{
                                                        form.features_gallery
                                                            .length
                                                    }}
                                                    /
                                                    {{
                                                        FEATURES_GALLERY_MAX
                                                    }}
                                                </p>
                                            </div>

                                            <button
                                                v-if="
                                                    form.features_gallery
                                                        .length <
                                                    FEATURES_GALLERY_MAX
                                                "
                                                type="button"
                                                class="inline-flex shrink-0 items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-700 transition hover:border-slate-300 hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-50"
                                                :disabled="isSaving"
                                                @click="
                                                    openFeaturesGalleryPicker
                                                "
                                            >
                                                <i class="bi bi-plus-lg"></i>

                                                {{ $t('actions.add') }}
                                            </button>

                                            <input
                                                ref="featuresGalleryInput"
                                                type="file"
                                                accept="image/jpeg,image/png,image/webp"
                                                multiple
                                                class="hidden"
                                                @change="
                                                    handleFeaturesGalleryFiles
                                                "
                                            />
                                        </div>

                                        <div
                                            v-if="form.features_gallery.length"
                                            class="grid grid-cols-1 gap-4 sm:grid-cols-2"
                                        >
                                            <div
                                                v-for="(
                                                    item, index
                                                ) in form.features_gallery"
                                                :key="
                                                    item.id ??
                                                    `new-${index}`
                                                "
                                                class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50"
                                            >
                                                <div class="relative">
                                                    <img
                                                        :src="
                                                            item.preview_url
                                                        "
                                                        :alt="
                                                            item.title?.ru ||
                                                            item.title?.en ||
                                                            ''
                                                        "
                                                        class="aspect-[4/3] h-full w-full object-cover"
                                                        loading="lazy"
                                                    />

                                                    <div
                                                        class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent p-3 pt-10"
                                                    >
                                                        <span
                                                            class="text-[10px] font-semibold text-white"
                                                        >
                                                            #{{ index + 1 }}
                                                        </span>
                                                    </div>

                                                    <button
                                                        type="button"
                                                        class="absolute right-2 top-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white/90 text-slate-500 shadow-sm transition hover:bg-white hover:text-red-500 disabled:cursor-not-allowed disabled:opacity-50"
                                                        :disabled="isSaving"
                                                        :aria-label="
                                                            $t(
                                                                'actions.remove'
                                                            )
                                                        "
                                                        @click="
                                                            removeFeaturesGalleryItem(
                                                                index
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="bi bi-trash3"
                                                        ></i>
                                                    </button>
                                                </div>

                                                <div class="space-y-2 p-3">
                                                    <input
                                                        v-model="
                                                            item.title.ru
                                                        "
                                                        type="text"
                                                        :placeholder="
                                                            $t(
                                                                'common.russian'
                                                            )
                                                        "
                                                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-100"
                                                    />

                                                    <input
                                                        v-model="
                                                            item.title.en
                                                        "
                                                        type="text"
                                                        :placeholder="
                                                            $t(
                                                                'common.english'
                                                            )
                                                        "
                                                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-100"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            v-else
                                            class="rounded-xl border border-dashed border-slate-200 bg-slate-50 px-4 py-8 text-center text-sm text-slate-500"
                                        >
                                            {{
                                                $t(
                                                    'common.notAvailable'
                                                )
                                            }}
                                        </div>

                                        <p
                                            class="mt-3 text-xs leading-5 text-slate-400"
                                        >
                                            {{
                                                $t(
                                                    'product.form.featuresGallery.limit',
                                                    'До 4 изображений. Размер каждого файла — не более 100 КБ. Изображения сохраняются в WebP.'
                                                )
                                            }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Specifications -->
                                <div
                                    v-else-if="section === 'specifications'"
                                    class="space-y-4"
                                >
                                    <div
                                        class="flex items-center justify-between gap-3"
                                    >
                                        <div>
                                            <h3
                                                class="text-sm font-semibold text-slate-900"
                                            >
                                                {{
                                                    $t(
                                                        'product.info.specifications.title'
                                                    )
                                                }}
                                            </h3>

                                            <p
                                                class="mt-1 text-xs text-slate-500"
                                            >
                                                {{
                                                    $t(
                                                        'product.form.specifications.description'
                                                    )
                                                }}
                                            </p>
                                        </div>

                                        <button
                                            type="button"
                                            class="inline-flex shrink-0 items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-700 transition hover:border-slate-300 hover:bg-slate-50"
                                            @click="addSpecification"
                                        >
                                            <i class="bi bi-plus-lg"></i>

                                            {{ $t('actions.add') }}
                                        </button>
                                    </div>

                                    <div
                                        v-if="form.specifications.length"
                                        class="space-y-3"
                                    >
                                        <div
                                            v-for="(
                                                item, index
                                            ) in form.specifications"
                                            :key="item.id ?? index"
                                            class="rounded-xl border border-slate-200 bg-slate-50/70 p-4"
                                        >
                                            <div
                                                class="flex items-center justify-between gap-3"
                                            >
                                                <span
                                                    class="text-xs font-semibold text-slate-500"
                                                >
                                                    #{{ index + 1 }}
                                                </span>

                                                <button
                                                    type="button"
                                                    class="text-slate-400 transition hover:text-red-500"
                                                    :aria-label="
                                                        $t(
                                                            'actions.remove'
                                                        )
                                                    "
                                                    @click="
                                                        removeSpecification(
                                                            index
                                                        )
                                                    "
                                                >
                                                    <i
                                                        class="bi bi-trash3"
                                                    ></i>
                                                </button>
                                            </div>

                                            <div
                                                class="mt-3 grid gap-4 lg:grid-cols-2"
                                            >
                                                <div>
                                                    <p
                                                        class="mb-2 text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-400"
                                                    >
                                                        {{
                                                            $t(
                                                                'product.form.specifications.name'
                                                            )
                                                        }}
                                                        —
                                                        {{
                                                            $t(
                                                                'common.russian'
                                                            )
                                                        }}
                                                    </p>

                                                    <input
                                                        v-model="
                                                            item.name.ru
                                                        "
                                                        type="text"
                                                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-100"
                                                    />
                                                </div>

                                                <div>
                                                    <p
                                                        class="mb-2 text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-400"
                                                    >
                                                        {{
                                                            $t(
                                                                'product.form.specifications.name'
                                                            )
                                                        }}
                                                        —
                                                        {{
                                                            $t(
                                                                'common.english'
                                                            )
                                                        }}
                                                    </p>

                                                    <input
                                                        v-model="
                                                            item.name.en
                                                        "
                                                        type="text"
                                                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-100"
                                                    />
                                                </div>

                                                <div>
                                                    <p
                                                        class="mb-2 text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-400"
                                                    >
                                                        {{
                                                            $t(
                                                                'product.form.specifications.value'
                                                            )
                                                        }}
                                                        —
                                                        {{
                                                            $t(
                                                                'common.russian'
                                                            )
                                                        }}
                                                    </p>

                                                    <input
                                                        v-model="
                                                            item.value.ru
                                                        "
                                                        type="text"
                                                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-100"
                                                    />
                                                </div>

                                                <div>
                                                    <p
                                                        class="mb-2 text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-400"
                                                    >
                                                        {{
                                                            $t(
                                                                'product.form.specifications.value'
                                                            )
                                                        }}
                                                        —
                                                        {{
                                                            $t(
                                                                'common.english'
                                                            )
                                                        }}
                                                    </p>

                                                    <input
                                                        v-model="
                                                            item.value.en
                                                        "
                                                        type="text"
                                                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-100"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        v-else
                                        class="rounded-xl border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-center text-sm text-slate-500"
                                    >
                                        {{ $t('common.notAvailable') }}
                                    </div>
                                </div>

                                <!-- Documentation -->
                                <div
                                    v-else-if="section === 'documentation'"
                                    class="space-y-4"
                                >
                                    <div
                                        class="rounded-xl border border-slate-200 bg-slate-50 p-4"
                                    >
                                        <div
                                            class="flex items-start gap-3"
                                        >
                                            <div
                                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-slate-500 shadow-sm"
                                            >
                                                <i
                                                    class="bi bi-file-earmark-text text-lg"
                                                ></i>
                                            </div>

                                            <div class="min-w-0">
                                                <h3
                                                    class="text-sm font-semibold text-slate-900"
                                                >
                                                    {{
                                                        $t(
                                                            'product.info.documentation.title'
                                                        )
                                                    }}
                                                </h3>

                                                <p
                                                    class="mt-1 text-sm leading-6 text-slate-500"
                                                >
                                                    {{
                                                        $t(
                                                            'product.info.documentation.description',
                                                            'Документы и технические материалы товара.'
                                                        )
                                                    }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        v-if="documentationLinks.length"
                                        class="space-y-2"
                                    >
                                        <a
                                            v-for="item in documentationLinks"
                                            :key="item.url"
                                            :href="item.url"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="flex items-center justify-between gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 transition hover:border-slate-300 hover:bg-slate-50"
                                        >
                                            <span
                                                class="flex min-w-0 items-center gap-2"
                                            >
                                                <i
                                                    :class="[
                                                        'bi',
                                                        item.icon,
                                                        'text-slate-400',
                                                    ]"
                                                ></i>

                                                <span class="truncate">
                                                    {{ item.label }}
                                                </span>
                                            </span>

                                            <i
                                                class="bi bi-box-arrow-up-right shrink-0 text-slate-400"
                                            ></i>
                                        </a>
                                    </div>

                                    <div
                                        v-else
                                        class="rounded-xl border border-dashed border-amber-200 bg-amber-50/60 px-4 py-6 text-center text-sm text-amber-700"
                                    >
                                        {{ $t('common.notAvailable') }}
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Footer -->
                        <div
                            class="flex items-center justify-end gap-3 border-t border-slate-200 bg-slate-50/70 px-5 py-4"
                        >
                            <button
                                type="button"
                                class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-60"
                                :disabled="isSaving"
                                @click="handleClose"
                            >
                                {{ $t('actions.cancel') }}
                            </button>

                            <button
                                v-if="!isReadonly"
                                type="button"
                                class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-60"
                                :disabled="
                                    isLoading ||
                                    isSaving ||
                                    !editProduct
                                "
                                @click="saveSection"
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
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup>
import {
    computed,
    onBeforeUnmount,
    reactive,
    ref,
    watch,
} from 'vue';
import { useI18n } from 'vue-i18n';
import { productsApi } from '../../../services/productsApi.js';

const { t } = useI18n();

const FEATURES_GALLERY_MAX = 4;
const FEATURES_GALLERY_MAX_SIZE = 100 * 1024;

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

const emit = defineEmits([
    'close',
    'updated',
]);

const editProduct = ref(null);

const isLoading = ref(false);
const isSaving = ref(false);

const formError = ref('');

const featuresGalleryInput = ref(null);

const originalFeaturesGalleryIds = ref([]);
const originalSpecificationIds = ref([]);

const errors = reactive({
    full_description_ru: '',
    full_description_en: '',
    features_ru: '',
    features_en: '',
});

const form = reactive({
    details: {
        ru: '',
        en: '',
    },

    features: {
        ru: '',
        en: '',
    },

    features_gallery: [],

    specifications: [],
});

const supportedSections = [
    'details',
    'features',
    'specifications',
    'documentation',
];

/*
|--------------------------------------------------------------------------
| Computed
|--------------------------------------------------------------------------
*/

const productName = computed(() => {
    const name = props.product?.name;

    if (typeof name === 'string') {
        return name;
    }

    return name?.ru || name?.en || '';
});

const sectionTitle = computed(() => {
    const keyMap = {
        details: 'product.info.details.title',
        features: 'product.info.features.title',
        specifications:
            'product.info.specifications.title',
        documentation:
            'product.info.documentation.title',
    };

    const key = keyMap[props.section];

    return key
        ? t(key)
        : t('actions.edit');
});

const isReadonly = computed(() => {
    return props.section === 'documentation';
});

const documentationLinks = computed(() => {
    const product =
        editProduct.value ||
        props.product;

    if (!product) {
        return [];
    }

    const links = [];

    const pdfUrl =
        product.pdf_url ||
        product.pdfUrl ||
        {};

    Object.entries(pdfUrl).forEach(
        ([locale, available]) => {
            if (!available) {
                return;
            }

            const imageUrl =
                product.image_url ||
                product.imageUrl;

            if (!imageUrl) {
                return;
            }

            links.push({
                url: `/document/specification/${locale}/${imageUrl}.pdf`,

                label:
                    locale === 'ru'
                        ? `${t('common.russian')} PDF`
                        : `${t('common.english')} PDF`,

                icon: 'bi-file-earmark-pdf',
            });
        }
    );

    return links;
});

/*
|--------------------------------------------------------------------------
| Form helpers
|--------------------------------------------------------------------------
*/

const resetForm = () => {
    revokeLocalPreviews();

    form.details.ru = '';
    form.details.en = '';

    form.features.ru = '';
    form.features.en = '';

    form.features_gallery = [];

    form.specifications = [];

    originalFeaturesGalleryIds.value = [];
    originalSpecificationIds.value = [];

    errors.full_description_ru = '';
    errors.full_description_en = '';
    errors.features_ru = '';
    errors.features_en = '';

    formError.value = '';
};

const revokeLocalPreviews = () => {
    form.features_gallery.forEach(
        (item) => {
            if (
                item.file &&
                item.preview_url
            ) {
                URL.revokeObjectURL(
                    item.preview_url
                );
            }
        }
    );
};

const normalizeLocalizedObject = (
    value
) => {
    return {
        ru: value?.ru ?? '',
        en: value?.en ?? '',
    };
};

/*
|--------------------------------------------------------------------------
| Features gallery image URL
|--------------------------------------------------------------------------
*/

const getProductImageName = (
    filename = ''
) => {
    const value = filename
        .split('/')
        .pop()
        .trim();

    if (!value) {
        return '';
    }

    return value
        .replace(
            /\.(webp|jpg|jpeg|png)$/i,
            ''
        )
        .replace(
            /_[1-4]$/i,
            ''
        );
};

const getFeaturesImageUrl = (
    filename
) => {
    if (!filename) {
        return '';
    }

    const cleanFilename = filename
        .split('/')
        .pop()
        .trim()
        .replace(
            /\.(webp|jpg|jpeg|png)$/i,
            ''
        );

    if (!cleanFilename) {
        return '';
    }

    const imageName =
        getProductImageName(
            cleanFilename
        );

    if (!imageName) {
        return '';
    }

    return `/image/features/${encodeURIComponent(
        imageName
    )}/${encodeURIComponent(
        cleanFilename
    )}.webp`;
};

const normalizeFeaturesGallery = (
    gallery
) => {
    if (!Array.isArray(gallery)) {
        return [];
    }

    return gallery.map(
        (item) => ({
            id:
                item?.id ??
                null,

            title:
                normalizeLocalizedObject(
                    item?.title
                ),

            image_url:
                item?.image_url ??
                '',

            preview_url:
                getFeaturesImageUrl(
                    item?.image_url
                ),

            file: null,
        })
    );
};

const normalizeSpecifications = (
    specifications
) => {
    if (!Array.isArray(specifications)) {
        return [];
    }

    return specifications.map(
        (item) => ({
            id:
                item?.id ??
                null,

            name:
                normalizeLocalizedObject(
                    item?.name
                ),

            value:
                normalizeLocalizedObject(
                    item?.value
                ),
        })
    );
};

/*
|--------------------------------------------------------------------------
| Load section data
|--------------------------------------------------------------------------
*/

const loadSectionData = async () => {
    if (!props.isOpen) {
        return;
    }

    if (
        !props.product?.id ||
        !supportedSections.includes(
            props.section
        )
    ) {
        return;
    }

    resetForm();

    const productId =
        props.product.id;

    /*
    |--------------------------------------------------------------------------
    | Documentation
    |--------------------------------------------------------------------------
    */

    if (
        props.section ===
        'documentation'
    ) {
        editProduct.value =
            props.product;

        return;
    }

    isLoading.value = true;

    try {
        /*
        |--------------------------------------------------------------------------
        | Features
        |--------------------------------------------------------------------------
        */

        if (
            props.section ===
            'features'
        ) {
            const response =
                await productsApi.getFeatures(
                    productId
                );

            editProduct.value =
                props.product;

            form.features =
                normalizeLocalizedObject(
                    response?.features
                );

            form.features_gallery =
                normalizeFeaturesGallery(
                    response?.gallery
                );

            originalFeaturesGalleryIds.value =
                form.features_gallery
                    .map(
                        (item) =>
                            item.id
                    )
                    .filter(Boolean);

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Specifications
        |--------------------------------------------------------------------------
        */

        if (
            props.section ===
            'specifications'
        ) {
            const response =
                await productsApi.getSpecifications(
                    productId
                );

            editProduct.value =
                props.product;

            form.specifications =
                normalizeSpecifications(
                    response?.specifications
                );

            originalSpecificationIds.value =
                form.specifications
                    .map(
                        (item) =>
                            item.id
                    )
                    .filter(Boolean);

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Details
        |--------------------------------------------------------------------------
        */

        const response =
            await productsApi.getEdit(
                productId
            );

        editProduct.value =
            response?.product ??
            response ??
            null;

        const product =
            editProduct.value;

        if (!product) {
            formError.value =
                t(
                    'product.form.errors.save'
                );

            return;
        }

        form.details.ru =
            product.full_description
                ?.ru ??
            '';

        form.details.en =
            product.full_description
                ?.en ??
            '';

        form.features =
            normalizeLocalizedObject(
                product.features
            );

        form.features_gallery =
            normalizeFeaturesGallery(
                product.features_gallery
            );

        form.specifications =
            normalizeSpecifications(
                product.specifications
            );

        originalSpecificationIds.value =
            form.specifications
                .map(
                    (item) =>
                        item.id
                )
                .filter(Boolean);

    } catch (error) {
        console.error(
            'Failed to load section:',
            error
        );

        formError.value =
            error?.message ||
            t(
                'product.form.errors.save'
            );
    } finally {
        isLoading.value = false;
    }
};

/*
|--------------------------------------------------------------------------
| Modal
|--------------------------------------------------------------------------
*/

const handleClose = () => {
    if (isSaving.value) {
        return;
    }

    emit('close');
};

/*
|--------------------------------------------------------------------------
| Features gallery
|--------------------------------------------------------------------------
*/

const openFeaturesGalleryPicker = () => {
    if (
        form.features_gallery.length >=
        FEATURES_GALLERY_MAX
    ) {
        formError.value =
            t(
                'product.form.featuresGallery.maxReached',
                'Можно загрузить не более 4 изображений.'
            );

        return;
    }

    featuresGalleryInput.value?.click();
};

const handleFeaturesGalleryFiles = (
    event
) => {
    const files = Array.from(
        event.target.files || []
    );

    if (!files.length) {
        return;
    }

    formError.value = '';

    const availableSlots =
        FEATURES_GALLERY_MAX -
        form.features_gallery.length;

    if (availableSlots <= 0) {
        formError.value =
            t(
                'product.form.featuresGallery.maxReached',
                'Можно загрузить не более 4 изображений.'
            );

        event.target.value = '';

        return;
    }

    for (
        const file of files.slice(
            0,
            availableSlots
        )
    ) {
        if (
            ![
                'image/jpeg',
                'image/png',
                'image/webp',
            ].includes(file.type)
        ) {
            formError.value =
                t(
                    'product.form.featuresGallery.invalidType',
                    'Разрешены только JPG, PNG и WebP.'
                );

            continue;
        }

        if (
            file.size >
            FEATURES_GALLERY_MAX_SIZE
        ) {
            formError.value =
                t(
                    'product.form.featuresGallery.maxSize',
                    'Размер изображения не должен превышать 100 КБ.'
                );

            continue;
        }

        const previewUrl =
            URL.createObjectURL(file);

        form.features_gallery.push({
            id: null,

            title: {
                ru: '',
                en: '',
            },

            image_url: null,

            preview_url:
                previewUrl,

            file,
        });
    }

    event.target.value = '';
};

const removeFeaturesGalleryItem = (
    index
) => {
    const item =
        form.features_gallery[index];

    if (
        item?.file &&
        item?.preview_url
    ) {
        URL.revokeObjectURL(
            item.preview_url
        );
    }

    form.features_gallery.splice(
        index,
        1
    );
};

/*
|--------------------------------------------------------------------------
| Specifications
|--------------------------------------------------------------------------
*/

const addSpecification = () => {
    form.specifications.push({
        id: null,

        name: {
            ru: '',
            en: '',
        },

        value: {
            ru: '',
            en: '',
        },
    });
};

const removeSpecification = (
    index
) => {
    form.specifications.splice(
        index,
        1
    );
};

const validateSpecifications = () => {
    formError.value = '';

    for (
        let index = 0;
        index < form.specifications.length;
        index++
    ) {
        const item =
            form.specifications[index];

        const nameRu =
            item?.name?.ru?.trim() ?? '';

        const nameEn =
            item?.name?.en?.trim() ?? '';

        const valueRu =
            item?.value?.ru?.trim() ?? '';

        const valueEn =
            item?.value?.en?.trim() ?? '';

        if (!nameRu) {
            formError.value =
                `${t(
                    'product.form.specifications.name'
                )} — ${t(
                    'common.russian'
                )} (${index + 1})`;
            return false;
        }

        if (!nameEn) {
            formError.value =
                `${t(
                    'product.form.specifications.name'
                )} — ${t(
                    'common.english'
                )} (${index + 1})`;
            return false;
        }

        if (!valueRu) {
            formError.value =
                `${t(
                    'product.form.specifications.value'
                )} — ${t(
                    'common.russian'
                )} (${index + 1})`;
            return false;
        }

        if (!valueEn) {
            formError.value =
                `${t(
                    'product.form.specifications.value'
                )} — ${t(
                    'common.english'
                )} (${index + 1})`;
            return false;
        }
    }

    return true;
};

const syncSpecifications = async (
    productId
) => {
    const currentItems =
        form.specifications;

    const currentIds =
        new Set(
            currentItems
                .map(
                    (item) =>
                        item.id
                )
                .filter(Boolean)
        );

    /*
    |--------------------------------------------------------------------------
    | Delete removed specifications
    |--------------------------------------------------------------------------
    */

    for (
        const specificationId of
            originalSpecificationIds.value
    ) {
        if (
            !currentIds.has(
                specificationId
            )
        ) {
            await productsApi.deleteSpecification(
                productId,
                specificationId
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Update existing / create new
    |--------------------------------------------------------------------------
    */

    for (
        const item of currentItems
    ) {
        const payload = {
            name: {
                ru:
                    item.name.ru.trim(),

                en:
                    item.name.en.trim(),
            },

            value: {
                ru:
                    item.value.ru.trim(),

                en:
                    item.value.en.trim(),
            },
        };

        if (item.id) {
            await productsApi.updateSpecification(
                productId,
                item.id,
                payload
            );

            continue;
        }

        const response =
            await productsApi.createSpecification(
                productId,
                payload
            );

        const specification =
            response?.specification;

        if (specification?.id) {
            item.id =
                specification.id;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Refresh original IDs
    |--------------------------------------------------------------------------
    */

    originalSpecificationIds.value =
        form.specifications
            .map(
                (item) =>
                    item.id
            )
            .filter(Boolean);
};

const saveSpecifications = async (
    productId
) => {
    await syncSpecifications(
        productId
    );
};

/*
|--------------------------------------------------------------------------
| Details payload
|--------------------------------------------------------------------------
*/

const buildPayload = () => {
    const product =
        editProduct.value;

    if (!product) {
        return null;
    }

    const payload = {
        article:
            product.article ?? '',

        name:
            product.name ?? {
                ru: '',
                en: '',
            },

        short_description:
            product.short_description ?? {
                ru: '',
                en: '',
            },

        full_description:
            product.full_description ?? {
                ru: '',
                en: '',
            },

        category_id:
            product.category_id,

        group_id:
            product.group_id,

        group_ids:
            Array.isArray(
                product.group_ids
            )
                ? product.group_ids
                : product.group_id
                  ? [product.group_id]
                  : [],

        brand_id:
            product.brand_id,

        unit:
            product.unit ?? 'pcs',

        price:
            product.price ?? null,

        quantity:
            Number(
                product.quantity ?? 0
            ),

        status:
            Boolean(
                product.status
            ),

        note:
            product.note ?? null,

        image_url:
            product.image_url ??
            null,

        video_url:
            product.video_url ??
            null,

        certificate_ids:
            Array.isArray(
                product.certificate_ids
            )
                ? product.certificate_ids
                : [],

        compatible_product_ids:
            Array.isArray(
                product.compatible_product_ids
            )
                ? product.compatible_product_ids
                : [],

        method:
            product.method ?? {
                ut_method: false,
                et_method: false,
                mia_method: false,
                iet_method: false,
                mt_method: false,
                vt_method: false,
            },

        sector:
            product.sector ?? {
                railway: false,
                aerospace: false,
                oil: false,
            },

        gallery:
            Array.isArray(
                product.gallery
            )
                ? product.gallery
                : [],
    };

    if (
        props.section ===
        'details'
    ) {
        payload.full_description = {
            ru:
                form.details.ru.trim(),

            en:
                form.details.en.trim(),
        };
    }

    return payload;
};

/*
|--------------------------------------------------------------------------
| Features validation
|--------------------------------------------------------------------------
*/

const validateFeaturesGallery = () => {
    if (
        form.features_gallery.length >
        FEATURES_GALLERY_MAX
    ) {
        formError.value =
            t(
                'product.form.featuresGallery.maxReached',
                'Можно загрузить не более 4 изображений.'
            );

        return false;
    }

    for (
        const item of
            form.features_gallery
    ) {
        if (
            item.file &&
            item.file.size >
                FEATURES_GALLERY_MAX_SIZE
        ) {
            formError.value =
                t(
                    'product.form.featuresGallery.maxSize',
                    'Размер изображения не должен превышать 100 КБ.'
                );

            return false;
        }
    }

    return true;
};

/*
|--------------------------------------------------------------------------
| Features gallery sync
|--------------------------------------------------------------------------
*/

const syncFeaturesGallery = async (
    productId
) => {
    const currentItems =
        form.features_gallery;

    const currentIds =
        new Set(
            currentItems
                .map(
                    (item) =>
                        item.id
                )
                .filter(Boolean)
        );

    /*
    |--------------------------------------------------------------------------
    | Delete removed existing images
    |--------------------------------------------------------------------------
    */

    for (
        const galleryId of
            originalFeaturesGalleryIds.value
    ) {
        if (
            !currentIds.has(
                galleryId
            )
        ) {
            await productsApi.deleteFeaturesGallery(
                productId,
                galleryId
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Update existing titles
    |--------------------------------------------------------------------------
    */

    for (
        const item of currentItems
    ) {
        if (!item.id) {
            continue;
        }

        await productsApi.updateFeaturesGallery(
            productId,
            item.id,
            {
                title: {
                    ru:
                        item.title.ru.trim(),

                    en:
                        item.title.en.trim(),
                },
            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Upload new files
    |--------------------------------------------------------------------------
    */

    for (
        const item of currentItems
    ) {
        if (!item.file) {
            continue;
        }

        const response =
            await productsApi.createFeaturesGallery(
                productId,
                item.file,
                {
                    ru:
                        item.title.ru.trim(),

                    en:
                        item.title.en.trim(),
                }
            );

        const gallery =
            response?.gallery;

        if (!gallery?.id) {
            continue;
        }

        item.id =
            gallery.id;

        item.image_url =
            gallery.image_url;

        if (item.preview_url) {
            URL.revokeObjectURL(
                item.preview_url
            );
        }

        item.preview_url =
            getFeaturesImageUrl(
                gallery.image_url
            );

        item.file = null;
    }
};

const saveFeatures = async (
    productId
) => {
    await productsApi.updateFeatures(
        productId,
        {
            features: {
                ru:
                    form.features.ru.trim(),

                en:
                    form.features.en.trim(),
            },
        }
    );

    await syncFeaturesGallery(
        productId
    );
};

/*
|--------------------------------------------------------------------------
| Generic validation
|--------------------------------------------------------------------------
*/

const validate = () => {
    formError.value = '';

    errors.full_description_ru = '';
    errors.full_description_en = '';

    errors.features_ru = '';
    errors.features_en = '';

    if (
        props.section ===
        'details'
    ) {
        if (
            !form.details.ru.trim()
        ) {
            errors.full_description_ru =
                t(
                    'validation.input.required'
                );
        }

        if (
            !form.details.en.trim()
        ) {
            errors.full_description_en =
                t(
                    'validation.input.required'
                );
        }

        return (
            !errors.full_description_ru &&
            !errors.full_description_en
        );
    }

    if (
        props.section ===
        'features'
    ) {
        if (
            !form.features.ru.trim()
        ) {
            errors.features_ru =
                t(
                    'validation.input.required'
                );
        }

        if (
            !form.features.en.trim()
        ) {
            errors.features_en =
                t(
                    'validation.input.required'
                );
        }

        return (
            !errors.features_ru &&
            !errors.features_en
        );
    }

    if (
        props.section ===
        'specifications'
    ) {
        return validateSpecifications();
    }

    return true;
};

/*
|--------------------------------------------------------------------------
| Save
|--------------------------------------------------------------------------
*/

const saveSection = async () => {
    if (
        isSaving.value ||
        isLoading.value ||
        isReadonly.value
    ) {
        return;
    }

    if (!validate()) {
        return;
    }

    if (
        props.section ===
            'features' &&
        !validateFeaturesGallery()
    ) {
        return;
    }

    const productId =
        editProduct.value?.id ??
        props.product?.id;

    if (!productId) {
        formError.value =
            t(
                'product.form.errors.save'
            );

        return;
    }

    isSaving.value = true;
    formError.value = '';

    try {
        /*
        |--------------------------------------------------------------------------
        | Features
        |--------------------------------------------------------------------------
        */

        if (
            props.section ===
            'features'
        ) {
            await saveFeatures(
                productId
            );

            emit('updated', {
                section:
                    'features',
            });

            emit('close');

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Specifications
        |--------------------------------------------------------------------------
        */

        if (
            props.section ===
            'specifications'
        ) {
            await saveSpecifications(
                productId
            );

            emit('updated', {
                section:
                    'specifications',
            });

            emit('close');

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Details
        |--------------------------------------------------------------------------
        */

        const payload =
            buildPayload();

        if (!payload) {
            return;
        }

        const updatedProduct =
            await productsApi.update(
                productId,
                payload
            );

        emit(
            'updated',
            updatedProduct
        );

        emit('close');

    } catch (error) {
        console.error(
            'Failed to save section:',
            error
        );

        if (
            error?.status ===
            422
        ) {
            const messages =
                Object.values(
                    error.errors || {}
                )
                    .flat()
                    .filter(Boolean);

            formError.value =
                messages[0] ||
                error?.message ||
                t(
                    'product.form.errors.save'
                );
        } else {
            formError.value =
                error?.message ||
                t(
                    'product.form.errors.save'
                );
        }
    } finally {
        isSaving.value = false;
    }
};

/*
|--------------------------------------------------------------------------
| Watch
|--------------------------------------------------------------------------
*/

watch(
    [
        () => props.isOpen,
        () => props.section,
        () => props.product?.id,
    ],
    () => {
        if (props.isOpen) {
            loadSectionData();
        }
    },
    {
        immediate: true,
    }
);

onBeforeUnmount(() => {
    revokeLocalPreviews();
});
</script>