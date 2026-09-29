<template>
    <section class="space-y-4">
        <SectionHeader
            :eyebrow="galleryTitle"
            :title="gallerySubTitle"
        >
            <template #meta>
                <span
                    class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.08em] text-slate-500"
                >
                    {{ images.length }}
                    {{ $t('common.pcs', 'шт.') }}
                </span>
            </template>

            <template #actions>
                <div class="flex items-center gap-1">
                    <button
                        v-if="props.canManage"
                        type="button"
                        class="flex h-7 items-center gap-1.5 rounded-lg px-2 text-xs font-medium text-slate-500 transition hover:bg-slate-100 hover:text-slate-800"
                        :title="$t('actions.edit', 'Управление')"
                        @click="emit('manage')"
                    >
                        <i class="bi bi-pencil-square"></i>

                        <span class="hidden sm:inline">
                            {{ $t('actions.edit', 'Управление') }}
                        </span>
                    </button>

                    <button
                        type="button"
                        class="flex h-7 w-7 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                        :aria-label="
                            isOpen
                                ? $t('common.collapse', 'Свернуть')
                                : $t('common.showAll', 'Показать все')
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
                </div>
            </template>
        </SectionHeader>

        <Transition
            enter-active-class="transition-all duration-300 ease-out"
            enter-from-class="max-h-0 overflow-hidden opacity-0"
            enter-to-class="max-h-[3000px] opacity-100"
            leave-active-class="transition-all duration-200 ease-in"
            leave-from-class="max-h-[3000px] opacity-100"
            leave-to-class="max-h-0 overflow-hidden opacity-0"
        >
            <div v-show="isOpen">
                <div
                    v-if="visibleImages.length"
                    class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3"
                >
                    <ProductImageCard
                        v-for="(image, index) in visibleImages"
                        :key="image.id || image.src || index"
                        :image-src="image.src"
                        :thumbnail="image.thumbnail"
                        :alt="
                            image.alt ||
                            localizedTitle(image) ||
                            `${$t('gallery.image', 'Изображение')} ${index + 1}`
                        "
                        :type="type"
                        :title="localizedTitle(image)"
                        :description="localizedDescription(image)"
                    />
                </div>

                <div
                    v-else
                    class="flex min-h-[180px] items-center justify-center rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-6 py-10 text-center"
                >
                    <div>
                        <div
                            class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-white text-slate-400 shadow-sm ring-1 ring-slate-200"
                        >
                            <i
                                :class="
                                    type === 'certificate'
                                        ? 'bi bi-award'
                                        : 'bi bi-images'
                                "
                                class="text-xl"
                            ></i>
                        </div>

                        <p
                            class="mt-3 text-sm font-medium text-slate-700"
                        >
                            {{
                                $t(
                                    'gallery.empty',
                                    'Изображения отсутствуют',
                                )
                            }}
                        </p>
                    </div>
                </div>

                <div
                    v-if="images.length > initialVisibleCount"
                    class="mt-5 flex justify-center"
                >
                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-medium text-slate-600 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900"
                        @click="toggleImages"
                    >
                        <span>
                            {{
                                isAllImagesVisible
                                    ? $t('common.hide', 'Скрыть')
                                    : $t('common.showAll', 'Показать все')
                            }}
                        </span>

                        <i
                            class="bi text-xs"
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

    canManage: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['manage']);

const initialVisibleCount = 4;

const isOpen = ref(true);
const visibleCount = ref(initialVisibleCount);

const localizedValue = (value) => {
    if (!value) {
        return '';
    }

    if (typeof value === 'string') {
        return value;
    }

    if (typeof value === 'object') {
        return (
            value[locale.value] ||
            value.ru ||
            value.en ||
            Object.values(value)[0] ||
            ''
        );
    }

    return '';
};

const localizedTitle = (image) => {
    return localizedValue(image?.title);
};

const localizedDescription = (image) => {
    return localizedValue(image?.description);
};

const visibleImages = computed(() => {
    if (visibleCount.value >= props.images.length) {
        return props.images;
    }

    return props.images.slice(0, visibleCount.value);
});

const isAllImagesVisible = computed(() => {
    return visibleCount.value >= props.images.length;
});

const toggleSection = () => {
    isOpen.value = !isOpen.value;
};

const toggleImages = () => {
    if (isAllImagesVisible.value) {
        visibleCount.value = initialVisibleCount;
        return;
    }

    visibleCount.value = props.images.length;
};
</script>

