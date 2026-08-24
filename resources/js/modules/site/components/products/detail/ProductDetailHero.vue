<template>
    <section
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-[0_8px_30px_rgba(15,23,42,0.06)]">
        <div class="grid lg:grid-cols-[1.05fr_0.95fr]">

            <!-- IMAGE / VIDEO -->
            <div
                class="group/media relative min-h-[340px] overflow-hidden bg-slate-50 sm:min-h-[400px] lg:min-h-[450px]">
                <!-- TECHNICAL BACKGROUND -->
                <div class="pointer-events-none absolute inset-0 opacity-[0.035]" style="
                        background-image:
                            linear-gradient(#0f172a 1px, transparent 1px),
                            linear-gradient(90deg, #0f172a 1px, transparent 1px);
                        background-size: 12px 12px;
                    "></div>

                <!-- CENTER GLOW -->
                <div
                    class="pointer-events-none absolute left-1/2 top-1/2 h-[70%] w-[70%] -translate-x-1/2 -translate-y-1/2 rounded-full bg-white blur-3xl">
                </div>

                <!-- TOP GRADIENT -->
                <div
                    class="pointer-events-none absolute inset-x-0 top-0 z-[2] h-24 bg-gradient-to-b from-white/60 to-transparent">
                </div>

                <!-- BOTTOM GRADIENT -->
                <div
                    class="pointer-events-none absolute inset-x-0 bottom-0 z-[2] h-28 bg-gradient-to-t from-slate-100/70 to-transparent">
                </div>

                <!-- GROUP -->
                <RouterLink :to="`/products/${product.categorySlug}/${product.groupSlug}`"
                    class="absolute left-4 top-4 z-20">
                    <span
                        class="inline-flex max-w-[280px] items-center gap-2 rounded-lg border border-slate-900 bg-slate-900 px-3 py-2 text-[9px] font-semibold uppercase tracking-[0.1em] text-white shadow-lg shadow-slate-900/10 transition-all duration-200 hover:bg-slate-800">
                        <span class="h-1.5 w-1.5 shrink-0 rounded-full" :class="groupDotClass"></span>

                        <span class="truncate">
                            {{ product.groupTitle || 'NDT Equipment' }}
                        </span>

                        <i class="bi bi-arrow-up-right text-[9px] opacity-50"></i>
                    </span>
                </RouterLink>

                <!-- PRODUCT IMAGE / VIDEO -->
                <div class="absolute inset-0 z-[1] flex items-center justify-center">
                    <Transition mode="out-in" enter-active-class="transition duration-300 ease-out"
                        enter-from-class="opacity-0 scale-[0.98]" enter-to-class="opacity-100 scale-100"
                        leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100"
                        leave-to-class="opacity-0 scale-[0.98]">
                        <!-- IMAGE -->
                        <img v-if="!isPlaying" key="image" :src="imageSrc" :alt="product.name || 'NDT equipment'"
                            class="h-full w-full object-contain transition duration-700 group-hover/media:scale-[1.015]" />

                        <!-- VIDEO -->
                        <video v-else key="video" :src="videoSrc" class="h-full w-full object-contain" autoplay muted
                            playsinline preload="auto" @ended="handleVideoEnded" @error="handleVideoError"></video>
                    </Transition>
                </div>

                <!-- PLAYING INDICATOR -->
                <div v-if="isPlaying"
                    class="absolute left-4 top-16 z-20 inline-flex items-center gap-2 rounded-md border border-white/20 bg-slate-900/90 px-2.5 py-1.5 text-[9px] font-semibold uppercase tracking-[0.1em] text-white shadow-lg backdrop-blur-md">
                    <span class="relative flex h-1.5 w-1.5">
                        <span
                            class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span>

                        <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-red-500"></span>
                    </span>

                    {{ $t('product.video.playing') }}
                </div>

                <!-- META -->
                <div class="absolute bottom-4 left-4 right-4 z-20 flex items-end justify-between gap-3">
                    <!-- CATEGORY -->
                    <RouterLink :to="`/products/${product.categorySlug}`" class="group/category min-w-0">
                        <div
                            class="inline-flex max-w-[280px] items-center gap-1.5 rounded-lg border border-white/80 bg-white/85 px-3 py-2 text-[9px] font-semibold uppercase tracking-[0.1em] text-slate-500 shadow-md backdrop-blur-md transition hover:border-slate-300 hover:text-slate-900">
                            <i class="bi bi-grid-3x3-gap text-[10px]"></i>

                            <span class="truncate">
                                {{
                                    product.categoryTitle ||
                                    'Non-Destructive Testing'
                                }}
                            </span>

                            <i
                                class="bi bi-arrow-up-right text-[9px] opacity-40 transition group-hover/category:opacity-100"></i>
                        </div>
                    </RouterLink>

                    <!-- VIDEO BUTTON -->
                    <button v-if="product.videoUrl" type="button"
                        class="group/video inline-flex shrink-0 cursor-pointer items-center gap-2 rounded-xl border border-slate-900 bg-slate-900 px-3.5 py-2.5 text-[10px] font-semibold uppercase tracking-[0.08em] text-white shadow-xl shadow-slate-900/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-slate-800 hover:shadow-2xl active:translate-y-0"
                        @click="toggleVideo">
                        <span
                            class="flex h-5 w-5 items-center justify-center rounded-full bg-white/15 transition group-hover/video:bg-white/25">
                            <i :class="[
                                'bi text-[11px]',
                                isPlaying
                                    ? 'bi-image'
                                    : 'bi-play-fill',
                            ]"></i>
                        </span>

                        {{
                            isPlaying
                                ? $t('product.video.photo')
                                : $t('product.video.video')
                        }}
                    </button>
                </div>
            </div>

            <!-- INFO -->
            <div
                class="flex flex-col justify-between border-t border-slate-200 p-6 sm:p-7 lg:border-l lg:border-t-0 lg:p-8">
                <ProductQuickInfo :product="product" :is-in-stock="isInStock" @change-info="openInfoModal" />

                <ProductPurchaseActions :price-label="priceLabel" :is-in-stock="isInStock" :back-link="backLink"
                    :back-label="backLabel" />
            </div>
        </div>

        <!-- INFO MODAL -->
        <ProductInfoModal :product="product" :info-key="selectedInfo" :info-data="selectedInfoData"
            :is-loading="isInfoLoading" :error="infoError" @close="closeInfoModal" />
    </section>
</template>

<script setup>
import { computed, ref } from 'vue';

import ProductQuickInfo from './ProductQuickInfo.vue';
import ProductPurchaseActions from './ProductPurchaseActions.vue';
import ProductInfoModal from './ProductInfoModal.vue';

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

    priceLabel: {
        type: String,
        default: '',
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

const isPlaying = ref(false);
const selectedInfo = ref(null);
const selectedInfoData = ref(null);
const isInfoLoading = ref(false);
const infoError = ref(null);
/*
|--------------------------------------------------------------------------
| Info modal
|--------------------------------------------------------------------------
*/

const openInfoModal = async (key) => {
    console.log('openInfoModal:', key);

    selectedInfo.value = key;
    selectedInfoData.value = null;
    infoError.value = null;
    isInfoLoading.value = true;

    document.body.classList.add('overflow-hidden');

    try {
        if (key === 'features') {
            console.log(
                'Fetching functionality for product ID:',
                props.product.id,
            );

            const response = await fetch(
                `/api/products/${props.product.id}/features`,
                {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                },
            );

            if (!response.ok) {
                throw new Error(
                    `Failed to load functionality: ${response.status}`,
                );
            }

            const data = await response.json();
            selectedInfoData.value = data.features;
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
    document.body.classList.remove('overflow-hidden');
};

/*
|--------------------------------------------------------------------------
| Video
|--------------------------------------------------------------------------
*/

const videoSrc = computed(() => {
    if (!props.product.videoUrl) {
        return '';
    }

    return `/video/product/${props.product.categorySlug}/${props.product.videoUrl}.mp4`;
});

const toggleVideo = () => {
    if (!props.product.videoUrl) {
        return;
    }

    isPlaying.value = !isPlaying.value;
};

const handleVideoEnded = () => {
    isPlaying.value = false;
};

const handleVideoError = (event) => {
    console.error(
        'Unable to load product video:',
        videoSrc.value,
        event.target?.error,
    );

    isPlaying.value = false;
};
</script>