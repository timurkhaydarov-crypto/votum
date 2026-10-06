<template>
    <section
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-[0_8px_30px_rgba(15,23,42,0.06)]"
    >
        <div class="grid lg:grid-cols-[1.05fr_0.95fr]">
            <!-- IMAGE / VIDEO -->

            <div
                class="group/media relative min-h-[340px] overflow-hidden bg-slate-50 sm:min-h-[400px] lg:min-h-[450px]"
            >
                <!-- TECHNICAL BACKGROUND -->

                <div
                    class="pointer-events-none absolute inset-0 opacity-[0.035]"
                    style="
                        background-image:
                            linear-gradient(#0f172a 1px, transparent 1px),
                            linear-gradient(90deg, #0f172a 1px, transparent 1px);
                        background-size: 12px 12px;
                    "
                ></div>

                <!-- CENTER GLOW -->

                <div
                    class="pointer-events-none absolute left-1/2 top-1/2 h-[70%] w-[70%] -translate-x-1/2 -translate-y-1/2 rounded-full bg-white blur-3xl"
                ></div>

                <!-- TOP GRADIENT -->

                <div
                    class="pointer-events-none absolute inset-x-0 top-0 z-[2] h-24 bg-gradient-to-b from-white/60 to-transparent"
                ></div>

                <!-- BOTTOM GRADIENT -->

                <div
                    class="pointer-events-none absolute inset-x-0 bottom-0 z-[2] h-28 bg-gradient-to-t from-slate-100/70 to-transparent"
                ></div>

                <!-- GROUP -->

                <RouterLink
                    :to="`/products/${product.categorySlug}/${product.groupSlug}`"
                    class="absolute left-4 top-4 z-20"
                >
                    <span
                        class="inline-flex max-w-[280px] items-center gap-2 rounded-lg border border-slate-900 bg-slate-900 px-3 py-2 text-[9px] font-semibold uppercase tracking-[0.1em] text-white shadow-lg shadow-slate-900/10 transition-all duration-200 hover:bg-slate-800"
                    >
                        <span
                            class="h-1.5 w-1.5 shrink-0 rounded-full"
                            :class="groupDotClass"
                        ></span>

                        <span class="truncate">
                            {{ product.groupTitle || 'NDT Equipment' }}
                        </span>

                        <i class="bi bi-arrow-up-right text-[9px] opacity-50"></i>
                    </span>
                </RouterLink>

                <!-- CONTROL METHODS -->

                <ProductControlMethods :methods="product.method" />

                <!-- PRODUCT IMAGE / VIDEO -->

                <div class="absolute inset-0 z-[1] flex items-center justify-center">
                    <Transition
                        mode="out-in"
                        enter-active-class="transition duration-300 ease-out"
                        enter-from-class="opacity-0 scale-[0.98]"
                        enter-to-class="opacity-100 scale-100"
                        leave-active-class="transition duration-200 ease-in"
                        leave-from-class="opacity-100"
                        leave-to-class="opacity-0 scale-[0.98]"
                    >
                        <!-- IMAGE -->

                        <img
                            v-if="!isPlaying"
                            key="image"
                            :src="imageSrc"
                            :alt="product.name || 'NDT equipment'"
                            class="h-full w-full object-contain transition duration-700 group-hover/media:scale-[1.015]"
                        />

                        <!-- VIDEO -->

                        <video
                            v-else
                            :key="videoKey"
                            :src="videoSrc"
                            class="h-full w-full object-contain"
                            autoplay
                            muted
                            playsinline
                            preload="auto"
                            @ended="handleVideoEnded"
                            @error="handleVideoError"
                        ></video>
                    </Transition>
                </div>

                <!-- PLAYING INDICATOR -->

                <div
                    v-if="isPlaying"
                    class="absolute left-4 top-16 z-20 inline-flex items-center gap-2 rounded-md border border-white/20 bg-slate-900/90 px-2.5 py-1.5 text-[9px] font-semibold uppercase tracking-[0.1em] text-white shadow-lg backdrop-blur-md"
                >
                    <span class="relative flex h-1.5 w-1.5">
                        <span
                            class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"
                        ></span>

                        <span
                            class="relative inline-flex h-1.5 w-1.5 rounded-full bg-red-500"
                        ></span>
                    </span>

                    {{ $t('product.video.playing') }}
                </div>

                <!-- META -->

                <div
                    class="absolute bottom-4 left-4 right-4 z-20 flex items-end justify-between gap-3"
                >
                    <!-- CATEGORY -->

                    <RouterLink
                        :to="`/products/${product.categorySlug}`"
                        class="group/category min-w-0"
                    >
                        <div
                            class="inline-flex max-w-[280px] items-center gap-1.5 rounded-lg border border-white/80 bg-white/85 px-3 py-2 text-[9px] font-semibold uppercase tracking-[0.1em] text-slate-500 shadow-md backdrop-blur-md transition hover:border-slate-300 hover:text-slate-900"
                        >
                            <i class="bi bi-grid-3x3-gap text-[10px]"></i>

                            <span class="truncate">
                                {{ product.categoryTitle || 'Non-Destructive Testing' }}
                            </span>

                            <i
                                class="bi bi-arrow-up-right text-[9px] opacity-40 transition group-hover/category:opacity-100"
                            ></i>
                        </div>
                    </RouterLink>

                    <!-- VIDEO BUTTON -->

                    <button
                        v-if="product.videoUrl"
                        type="button"
                        class="group/video inline-flex shrink-0 cursor-pointer items-center gap-2 rounded-xl border border-slate-900 bg-slate-900 px-3.5 py-2.5 text-[10px] font-semibold uppercase tracking-[0.08em] text-white shadow-xl shadow-slate-900/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-slate-800 hover:shadow-2xl active:translate-y-0"
                        @click="toggleVideo"
                    >
                        <span
                            class="flex h-5 w-5 items-center justify-center rounded-full bg-white/15 transition group-hover/video:bg-white/25"
                        >
                            <i
                                :class="['bi text-[11px]', isPlaying ? 'bi-image' : 'bi-play-fill']"
                            ></i>
                        </span>

                        {{ isPlaying ? $t('product.video.photo') : $t('product.video.video') }}
                    </button>
                </div>
            </div>

            <!-- INFO -->

            <div
                class="flex flex-col justify-between border-t border-slate-200 p-6 sm:p-7 lg:border-l lg:border-t-0 lg:p-8"
            >
                <ProductQuickInfo
                    :product="product"
                    :is-in-stock="isInStock"
                    :can-manage="canManage"
                    @change-info="openInfoModal"
                    @manage-info="handleManageInfo"
                    @status-updated="emit('statusUpdated', $event)"
                />

                <ProductPurchaseActions
                    :is-in-stock="isInStock"
                    :back-link="backLink"
                    :back-label="backLabel"
                    :product="product"
                />
            </div>
        </div>

        <!-- INFO MODAL -->

        <ProductInfoModal
            :product="product"
            :info-key="selectedInfo"
            :info-data="selectedInfoData"
            :is-loading="isInfoLoading"
            :error="infoError"
            @close="closeInfoModal"
        />

        <!-- DOCUMENTATION MODAL -->

        <ProductDocumentationModal
            :product="product"
            :documents="documentationDocuments"
            :is-open="isDocumentationOpen"
            :is-loading="isDocumentationLoading"
            :error="documentationError"
            :authorized="documentationAuthorized"
            @close="closeDocumentation"
            @submit-key="authorizeDocumentation"
            @open-pdf="openDocumentationPdf"
        />
    </section>
</template>

<script setup>
import { computed, ref } from 'vue';

import {
    fetchProductFeatures,
    fetchProductSpecifications,
} from '@/modules/site/services/productInfoService';

import { documentationApi } from '../../../../manager/services/documentationApi';

import ProductControlMethods from './ProductControlMethods.vue';
import ProductQuickInfo from './ProductQuickInfo.vue';
import ProductPurchaseActions from './ProductPurchaseActions.vue';
import ProductInfoModal from './ProductInfoModal.vue';
import ProductDocumentationModal from './ProductDocumentationModal.vue';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },

    imageSrc: {
        type: String,
        required: true,
    },

    isInStock: {
        type: Boolean,
        default: false,
    },

    canManage: {
        type: Boolean,
        default: false,
    },

    groupDotClass: {
        type: String,
        default: 'bg-slate-400',
    },

    groupBadgeClasses: {
        type: String,
        default: 'border-slate-200 bg-white text-slate-600',
    },

    backLink: {
        type: String,
        default: '/products',
    },

    backLabel: {
        type: String,
        default: '',
    },
});

const emit = defineEmits(['manageInfo', 'statusUpdated']);

const isPlaying = ref(false);

const selectedInfo = ref(null);
const selectedInfoData = ref(null);
const isInfoLoading = ref(false);
const infoError = ref(null);

/*
|--------------------------------------------------------------------------
| DOCUMENTATION
|--------------------------------------------------------------------------
*/

const isDocumentationOpen = ref(false);
const isDocumentationLoading = ref(false);
const documentationAuthorized = ref(false);
const documentationDocuments = ref([]);
const documentationError = ref(null);

/*
|--------------------------------------------------------------------------
| VIDEO FORMAT
|--------------------------------------------------------------------------
*/

const videoFormat = ref('webm');

const videoBasename = computed(() => {
    if (!props.product?.videoUrl) {
        return '';
    }

    return String(props.product.videoUrl).replace(/\.(mp4|webm|mov)$/i, '');
});

const videoSrc = computed(() => {
    if (!videoBasename.value || !props.product?.categorySlug) {
        return '';
    }

    return `/video/product/${props.product.categorySlug}/${videoBasename.value}.${videoFormat.value}`;
});

const videoKey = computed(() => {
    return `video-${videoFormat.value}-${videoBasename.value}`;
});

/*
|--------------------------------------------------------------------------
| INFO MODAL
|--------------------------------------------------------------------------
*/

const openInfoModal = async (key) => {
    /*
     * Documentation имеет собственный modal-flow.
     */
    if (key === 'documentation') {
        openDocumentation();
        return;
    }

    if (!props.product?.id) {
        console.warn('Cannot open product information: product is not available.');

        return;
    }

    selectedInfo.value = key;
    selectedInfoData.value = null;
    infoError.value = null;
    isInfoLoading.value = true;

    document.body.classList.add('overflow-hidden');

    try {
        switch (key) {
            case 'details':
                selectedInfoData.value = props.product.fullDescription;
                break;

            case 'features':
                selectedInfoData.value = await fetchProductFeatures(props.product.id);
                break;

            case 'specifications':
                selectedInfoData.value = await fetchProductSpecifications(props.product.id);
                break;

            default:
                selectedInfoData.value = null;
        }
    } catch (error) {
        console.error('Failed to load product info:', error);

        infoError.value = 'Не удалось загрузить информацию';
    } finally {
        isInfoLoading.value = false;
    }
};

const closeInfoModal = () => {
    selectedInfo.value = null;
    selectedInfoData.value = null;
    infoError.value = null;
    isInfoLoading.value = false;

    /*
     * Не снимаем overflow-hidden, если documentation
     * modal всё ещё открыт.
     */
    if (!isDocumentationOpen.value) {
        document.body.classList.remove('overflow-hidden');
    }
};

/*
|--------------------------------------------------------------------------
| DOCUMENTATION MODAL
|--------------------------------------------------------------------------
*/

const openDocumentation = () => {
    if (!props.product?.id) {
        console.warn('Cannot open documentation: product is not available.');

        return;
    }

    documentationError.value = null;
    documentationDocuments.value = [];
    documentationAuthorized.value = false;
    isDocumentationLoading.value = false;

    isDocumentationOpen.value = true;

    document.body.classList.add('overflow-hidden');
};

const authorizeDocumentation = async (key) => {
    if (!props.product?.id) {
        documentationError.value = 'Не удалось определить продукт.';

        return;
    }

    if (!key) {
        documentationError.value = 'Введите ключ доступа.';

        return;
    }

    documentationError.value = null;
    isDocumentationLoading.value = true;

    try {
        const response = await documentationApi.access(props.product.id, key);

        documentationDocuments.value = response?.documents || [];

        documentationAuthorized.value = response?.authorized === true;
    } catch (error) {
        console.error('Failed to authorize documentation:', error);

        documentationAuthorized.value = false;
        documentationDocuments.value = [];

        if (error?.status === 401) {
            documentationError.value = 'Неверный ключ доступа.';
        } else if (error?.status === 403) {
            documentationError.value =
                'Ключ не предоставляет доступ к документации этого продукта.';
        } else {
            documentationError.value = error?.message || 'Не удалось получить документацию.';
        }
    } finally {
        isDocumentationLoading.value = false;
    }
};

const closeDocumentation = () => {
    isDocumentationOpen.value = false;

    documentationAuthorized.value = false;
    documentationDocuments.value = [];
    documentationError.value = null;
    isDocumentationLoading.value = false;

    if (!selectedInfo.value) {
        document.body.classList.remove('overflow-hidden');
    }
};

const openDocumentationPdf = async ({ file, key }) => {
    if (!file?.id || !key) {
        return;
    }

    try {
        const blob = await documentationApi.openFile(file.id, key);

        const blobUrl = URL.createObjectURL(blob);

        const pdfWindow = window.open(blobUrl, '_blank');

        if (!pdfWindow) {
            URL.revokeObjectURL(blobUrl);

            documentationError.value =
                'Браузер заблокировал открытие PDF. Разрешите всплывающие окна для сайта.';

            return;
        }

        setTimeout(() => {
            URL.revokeObjectURL(blobUrl);
        }, 60_000);
    } catch (error) {
        console.error('Failed to open documentation PDF:', error);

        if (error?.status === 401) {
            documentationError.value = 'Ключ доступа недействителен.';
        } else if (error?.status === 403) {
            documentationError.value = 'Доступ к этому документу запрещён.';
        } else if (error?.status === 404) {
            documentationError.value = 'Файл документации не найден.';
        } else {
            documentationError.value = error?.message || 'Не удалось открыть PDF.';
        }
    }
};

/*
|--------------------------------------------------------------------------
| VIDEO
|--------------------------------------------------------------------------
*/

const toggleVideo = () => {
    if (!props.product?.videoUrl) {
        return;
    }

    if (!isPlaying.value) {
        /*
         * При новом запуске всегда сначала пробуем WebM.
         */
        videoFormat.value = 'webm';
    }

    isPlaying.value = !isPlaying.value;
};

const handleVideoEnded = () => {
    isPlaying.value = false;
    videoFormat.value = 'webm';
};

const handleVideoError = (event) => {
    /*
     * Если WebM не воспроизводится,
     * переключаемся на MP4.
     */
    if (videoFormat.value === 'webm') {
        console.warn('WebM video failed, switching to MP4:', videoSrc.value);

        videoFormat.value = 'mp4';

        return;
    }

    /*
     * Если не работает даже MP4 —
     * прекращаем воспроизведение.
     */
    console.error('Unable to load product video:', videoSrc.value, event.target?.error);

    isPlaying.value = false;
};

/*
|--------------------------------------------------------------------------
| MANAGER
|--------------------------------------------------------------------------
*/

const handleManageInfo = ({ key, product }) => {
    if (!props.canManage) {
        return;
    }

    emit('manageInfo', {
        key,
        product,
    });
};
</script>
