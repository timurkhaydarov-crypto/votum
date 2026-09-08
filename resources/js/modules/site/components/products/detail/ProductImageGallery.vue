<template>
    <section ref="gallerySection">
        <!-- HEADER -->
        <SectionHeader
            :title="$t(galleryTitle)"
            :description="$t(gallerySubTitle)"
        >
            <!-- IMAGE COUNT -->
            <template #meta>
                {{ images.length }} {{ $t('common.pcs') }}
            </template>

            <!-- COLLAPSE BUTTON -->
            <template #actions>
                <button
                    type="button"
                    class="flex h-7 w-7 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                    :aria-label="
                        isOpen
                            ? $t('common.collapse')
                            : $t('common.showAll')
                    "
                    @click="toggleSection"
                >
                    <i
                        class="bi text-xs transition-transform duration-300"
                        :class="
                            isOpen
                                ? 'bi-chevron-up'
                                : 'bi-chevron-down'
                        "
                    ></i>
                </button>
            </template>
        </SectionHeader>

        <!-- CONTENT -->
        <Transition
            enter-active-class="overflow-hidden transition-all duration-300 ease-out"
            enter-from-class="max-h-0 opacity-0 -translate-y-2"
            enter-to-class="max-h-[3000px] opacity-100 translate-y-0"
            leave-active-class="overflow-hidden transition-all duration-300 ease-in"
            leave-from-class="max-h-[3000px] opacity-100 translate-y-0"
            leave-to-class="max-h-0 opacity-0 -translate-y-2"
        >
            <div
                v-if="isOpen"
                class="mt-4"
            >
                <!-- GALLERY -->
                <div
                    v-if="images.length"
                    class="grid grid-cols-2 gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
                >
                    <ProductImageCard
                        v-for="(image, index) in visibleImages"
                        :key="
                            image.id ||
                            image.src ||
                            index
                        "
                        :image-src="image.src"
                        :thumbnail="image.thumbnail"
                        :alt="
                            image.alt ||
                            localizedTitle(image) ||
                            `${$t('gallery.image')} ${index + 1}`
                        "
                        :type="type"
                        :title="localizedTitle(image)"
                        :description="localizedDescription(image)"
                    />
                </div>

                <!-- EMPTY -->
                <div
                    v-else
                    class="flex min-h-[180px] items-center justify-center rounded-2xl border border-dashed border-slate-200 bg-slate-50"
                >
                    <div class="text-center">
                        <div
                            class="mx-auto mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-white text-slate-400 shadow-sm"
                        >
                            <i class="bi bi-images text-lg"></i>
                        </div>

                        <p
                            class="text-xs font-medium text-slate-500"
                        >
                            {{ $t('gallery.empty') }}
                        </p>
                    </div>
                </div>

                <!-- SHOW MORE / COLLAPSE -->
                <div
                    v-if="images.length > 4"
                    class="mt-4 flex justify-center"
                >
                    <button
                        type="button"
                        class="group inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-600 shadow-sm transition hover:border-slate-300 hover:text-slate-900"
                        @click="toggleImages"
                    >
                        <span>
                            {{
                                isAllImagesVisible
                                    ? $t('common.collapse')
                                    : $t('common.showMore')
                            }}
                        </span>

                        <i
                            class="bi transition-transform duration-300"
                            :class="
                                isAllImagesVisible
                                    ? 'bi-chevron-up'
                                    : 'bi-chevron-down'
                            "
                        ></i>
                    </button>
                </div>
            </div>
        </Transition>
    </section>
</template>

<script setup>
import { computed, ref } from 'vue';
import { useI18n } from 'vue-i18n';

import ProductImageCard from './ProductImageCard.vue';
import SectionHeader from '../SectionHeader.vue';

const { locale } = useI18n();

const props = defineProps({
    images: {
        type: Array,
        default: () => [],
    },

    type: {
        type: String,
        default: 'product',
    },

    galleryTitle: {
        type: String,
        default: '',
    },

    gallerySubTitle: {
        type: String,
        default: '',
    },
});

/*
|--------------------------------------------------------------------------
| Locale
|--------------------------------------------------------------------------
*/

const currentLocale = computed(() => {
    return locale.value === 'en' ? 'en' : 'ru';
});

/*
|--------------------------------------------------------------------------
| Localized title
|--------------------------------------------------------------------------
*/

const localizedTitle = (image) => {
    if (!image?.title) {
        return '';
    }

    if (typeof image.title === 'string') {
        return image.title;
    }

    return (
        image.title[currentLocale.value] ??
        image.title.ru ??
        image.title.en ??
        ''
    );
};

/*
|--------------------------------------------------------------------------
| Localized description
|--------------------------------------------------------------------------
*/

const localizedDescription = (image) => {
    if (!image?.description) {
        return '';
    }

    if (typeof image.description === 'string') {
        return image.description;
    }

    return (
        image.description[currentLocale.value] ??
        image.description.ru ??
        image.description.en ??
        ''
    );
};

/*
|--------------------------------------------------------------------------
| Section
|--------------------------------------------------------------------------
*/

const isOpen = ref(true);

const gallerySection = ref(null);

/*
|--------------------------------------------------------------------------
| Visible count
|--------------------------------------------------------------------------
*/

const visibleCount = ref(4);

/*
|--------------------------------------------------------------------------
| Visible images
|--------------------------------------------------------------------------
*/

const visibleImages = computed(() => {
    return props.images.slice(
        0,
        visibleCount.value
    );
});

/*
|--------------------------------------------------------------------------
| All images visible
|--------------------------------------------------------------------------
*/

const isAllImagesVisible = computed(() => {
    return (
        visibleCount.value >=
        props.images.length
    );
});

/*
|--------------------------------------------------------------------------
| Toggle section
|--------------------------------------------------------------------------
*/

const toggleSection = () => {
    isOpen.value = !isOpen.value;

    if (!isOpen.value) {
        visibleCount.value = 4;
    }
};

/*
|--------------------------------------------------------------------------
| Toggle images
|--------------------------------------------------------------------------
*/

const toggleImages = () => {
    if (isAllImagesVisible.value) {
        visibleCount.value = 4;

        requestAnimationFrame(() => {
            gallerySection.value?.scrollIntoView({
                behavior: 'smooth',
                block: 'start',
            });
        });

        return;
    }

    visibleCount.value = Math.min(
        visibleCount.value + 4,
        props.images.length
    );
};
</script>

