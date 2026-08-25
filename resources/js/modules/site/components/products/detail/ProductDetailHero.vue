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

                        <i
                            class="bi bi-arrow-up-right text-[9px] opacity-50"
                        ></i>
                    </span>
                </RouterLink>

                <!-- CONTROL METHODS -->
                <div
                    v-if="controlMethods.length"
                    class="absolute right-4 top-4 z-20 flex items-center gap-1.5"
                >
                    <div
                        v-for="method in controlMethods"
                        :key="method.code"
                        class="group/method relative flex h-8 w-8 cursor-default items-center justify-center rounded-lg border border-white/80 bg-white/85 text-slate-500 shadow-md backdrop-blur-md transition-colors duration-200 hover:border-slate-300 hover:text-slate-900"
                    >
                        <i
                            :class="[
                                'bi',
                                method.icon,
                                'text-[13px]',
                            ]"
                        ></i>

                        <!-- METHOD TOOLTIP -->
                        <div
                            class="pointer-events-none absolute right-0 top-full mt-2 w-[340px] translate-y-1 rounded-xl border border-slate-200 bg-white p-4 text-left opacity-0 shadow-xl transition-all duration-200 group-hover/method:translate-y-0 group-hover/method:opacity-100"
                        >
                            <!-- METHOD HEADER -->
                            <div class="flex items-center gap-2">
                                <span
                                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-600"
                                >
                                    <i
                                        :class="[
                                            'bi',
                                            method.icon,
                                            'text-[13px]',
                                        ]"
                                    ></i>
                                </span>

                                <div>
                                    <div
                                        class="text-[10px] font-bold uppercase tracking-[0.08em] text-slate-900"
                                    >
                                        {{ method.title }}
                                    </div>

                                    <div
                                        class="mt-0.5 text-[9px] font-semibold uppercase tracking-[0.1em] text-slate-400"
                                    >
                                        {{ method.code }}
                                    </div>
                                </div>
                            </div>

                            <!-- METHOD DESCRIPTION -->
                            <div
                                class="mt-3 text-[11px] leading-[1.65] text-slate-500"
                            >
                                {{ method.description }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PRODUCT IMAGE / VIDEO -->
                <div
                    class="absolute inset-0 z-[1] flex items-center justify-center"
                >
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
                            key="video"
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
                            <i
                                class="bi bi-grid-3x3-gap text-[10px]"
                            ></i>

                            <span class="truncate">
                                {{
                                    product.categoryTitle ||
                                    'Non-Destructive Testing'
                                }}
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
                                :class="[
                                    'bi text-[11px]',
                                    isPlaying
                                        ? 'bi-image'
                                        : 'bi-play-fill',
                                ]"
                            ></i>
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
                class="flex flex-col justify-between border-t border-slate-200 p-6 sm:p-7 lg:border-l lg:border-t-0 lg:p-8"
            >
                <ProductQuickInfo
                    :product="product"
                    :is-in-stock="isInStock"
                    @change-info="openInfoModal"
                />

                <ProductPurchaseActions
                    :price-label="priceLabel"
                    :is-in-stock="isInStock"
                    :back-link="backLink"
                    :back-label="backLabel"
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
    </section>
</template>

<script setup>
import { computed, ref } from 'vue';
import { useI18n } from 'vue-i18n';

import { fetchProductFeatures } from '@/modules/site/services/productInfoService';

import ProductQuickInfo from './ProductQuickInfo.vue';
import ProductPurchaseActions from './ProductPurchaseActions.vue';
import ProductInfoModal from './ProductInfoModal.vue';

const { locale } = useI18n();

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
| CONTROL METHODS
|--------------------------------------------------------------------------
*/

const controlMethodMap = {
    UT: {
        icon: 'bi-soundwave',

        title: {
            ru: 'Ультразвуковой контроль',
            en: 'Ultrasonic Testing',
        },

        description: {
            ru: 'Ультразвуковой контроль использует высокочастотные звуковые волны для обнаружения внутренних дефектов и неоднородностей материала. Метод позволяет выявлять трещины, расслоения, непровары, поры и другие дефекты, определять их расположение и глубину залегания. Применяется для контроля металлов, сварных соединений, композитов и других конструкционных материалов.',
            en: 'Ultrasonic Testing uses high-frequency sound waves to detect internal defects and material discontinuities. The method can identify cracks, delaminations, lack of fusion, voids and other defects, while determining their location and depth. It is widely used for testing metals, welds, composites and other structural materials.',
        },
    },

    ET: {
        icon: 'bi-activity',

        title: {
            ru: 'Вихретоковый контроль',
            en: 'Eddy Current Testing',
        },

        description: {
            ru: 'Вихретоковый контроль основан на анализе электромагнитного взаимодействия вихревых токов с контролируемым материалом. Метод позволяет обнаруживать поверхностные и подповерхностные трещины, коррозионные повреждения, нарушения структуры и изменения толщины. Особенно эффективен для электропроводящих материалов и широко применяется в авиационной, энергетической и машиностроительной промышленности.',
            en: 'Eddy Current Testing analyzes the electromagnetic interaction between induced eddy currents and the inspected material. It can detect surface and near-surface cracks, corrosion damage, structural changes and variations in thickness. The method is particularly effective for electrically conductive materials and is widely used in aerospace, power generation and mechanical engineering.',
        },
    },

    MIA: {
        icon: 'bi-graph-up',

        title: {
            ru: 'Механический импедансный анализ',
            en: 'Mechanical Impedance Analysis',
        },

        description: {
            ru: 'Механический импедансный анализ оценивает состояние объекта по изменению его механических характеристик при контролируемом воздействии. Метод позволяет выявлять дефекты, ослабление соединений, нарушения целостности и изменения жёсткости конструкции. Применяется для диагностики композитных конструкций, клеевых соединений, многослойных материалов и других объектов.',
            en: 'Mechanical Impedance Analysis evaluates the condition of a structure by analyzing changes in its mechanical response under controlled excitation. The method can detect defects, weakened bonds, integrity issues and changes in structural stiffness. It is used for testing composite structures, bonded joints, layered materials and other components.',
        },
    },

    IET: {
        icon: 'bi-bullseye',

        title: {
            ru: 'Ударно-эховый метод',
            en: 'Impact-Echo Testing',
        },

        description: {
            ru: 'Ударно-эховый метод основан на анализе отражения упругих волн, возникающих после механического импульса. Метод позволяет обнаруживать внутренние дефекты, пустоты, расслоения, трещины и другие нарушения сплошности, а также оценивать толщину конструкций. Особенно широко применяется для контроля бетона, железобетона, каменных и других массивных конструкций.',
            en: 'Impact-Echo Testing analyzes the reflection of stress waves generated by a mechanical impact. It can detect internal defects, voids, delaminations, cracks and other discontinuities, as well as determine structural thickness. The method is particularly useful for inspecting concrete, reinforced concrete, masonry and other solid structures.',
        },
    },

    MT: {
        icon: 'bi-magnet',

        title: {
            ru: 'Магнитопорошковый контроль',
            en: 'Magnetic Particle Testing',
        },

        description: {
            ru: 'Магнитопорошковый контроль применяется для выявления поверхностных и близко расположенных подповерхностных дефектов в ферромагнитных материалах. Контролируемый объект намагничивается, а специальные магнитные частицы концентрируются в местах утечки магнитного поля, образуя видимый индикатор дефекта. Метод эффективен для обнаружения трещин, непроваров и других нарушений сплошности.',
            en: 'Magnetic Particle Testing is used to detect surface and near-surface defects in ferromagnetic materials. The inspected component is magnetized, and magnetic particles accumulate at locations where magnetic flux leaks, forming a visible indication of the defect. The method is effective for detecting cracks, lack of fusion and other discontinuities.',
        },
    },

    VT: {
        icon: 'bi-eye',

        title: {
            ru: 'Визуальный контроль',
            en: 'Visual Testing',
        },

        description: {
            ru: 'Визуальный контроль является одним из основных методов неразрушающего контроля и основан на непосредственном или оптическом осмотре поверхности объекта. Метод позволяет обнаруживать видимые трещины, коррозию, механические повреждения, деформации, нарушения геометрии и качество сварных соединений. Для расширения возможностей контроля могут использоваться камеры, эндоскопы, увеличительные системы и специализированные системы визуализации.',
            en: 'Visual Testing is one of the fundamental non-destructive testing methods and is based on direct or optical inspection of an object’s surface. It can reveal visible cracks, corrosion, mechanical damage, deformation, geometric irregularities and weld quality issues. Cameras, video endoscopes, magnification systems and specialized imaging equipment can be used to extend inspection capabilities.',
        },
    },
};

const controlMethods = computed(() => {
    if (!props.product.method) {
        return [];
    }

    return props.product.method
        .split(',')
        .map((method) => method.trim().toUpperCase())
        .filter((code) => controlMethodMap[code])
        .map((code) => ({
            code,
            icon: controlMethodMap[code].icon,
            title:
                controlMethodMap[code].title[locale.value] ||
                controlMethodMap[code].title.en,
            description:
                controlMethodMap[code].description[locale.value] ||
                controlMethodMap[code].description.en,
        }));
});

/*
|--------------------------------------------------------------------------
| INFO MODAL
|--------------------------------------------------------------------------
*/

const openInfoModal = async (key) => {
    selectedInfo.value = key;
    selectedInfoData.value = null;
    infoError.value = null;
    isInfoLoading.value = true;

    document.body.classList.add('overflow-hidden');

    try {
        switch (key) {
            case 'details':
                selectedInfoData.value =
                    props.product.fullDescription;
                break;

            case 'features':
                selectedInfoData.value =
                    await fetchProductFeatures(
                        props.product.id,
                    );
                break;

            default:
                selectedInfoData.value = null;
        }
    } catch (error) {
        console.error(
            'Failed to load product info:',
            error,
        );

        infoError.value =
            'Не удалось загрузить информацию';
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
| VIDEO
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