<template>
    <section>
        <!-- HEADER -->
        <SectionHeader
            :title="$t('gallery.title')"
            :description="$t('gallery.description')"
        >
            <template #meta>
                {{ images.length }} {{ $t('common.pcs') }}
            </template>

            <template #actions>
                <button
                    type="button"
                    class="flex h-7 w-7 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                    :aria-label="
                        isOpen
                            ? $t('gallery.collapse')
                            : $t('gallery.expand')
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
            <div v-if="isOpen" class="mt-4">
                <!-- GALLERY -->
                <div
                    v-if="images.length"
                    class="grid grid-cols-2 gap-3 md:grid-cols-3"
                >
                    <button
                        v-for="(image, index) in visibleImages"
                        :key="image.id || image.image_url || index"
                        type="button"
                        class="group relative aspect-[4/3] overflow-visible text-left"
                        @click="openModal(image)"
                    >
                        <!-- IMAGE -->
                        <div
                            class="relative h-full w-full overflow-hidden rounded-2xl border border-slate-200 bg-slate-50"
                        >
                            <img
                                :src="image.image_url"
                                :alt="
                                    image.title?.ru ||
                                    `${product.title} ${index + 1}`
                                "
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                            />

                            <!-- DARK OVERLAY -->
                            <div
                                class="pointer-events-none absolute inset-0 bg-slate-950/20 opacity-0 transition duration-300 group-hover:opacity-100"
                            ></div>

                            <!-- SEARCH ICON -->
                            <div
                                class="pointer-events-none absolute inset-0 z-10 flex items-center justify-center opacity-0 transition-all duration-300 group-hover:opacity-100"
                            >
                                <div
                                    class="flex h-11 w-11 scale-90 items-center justify-center rounded-full bg-slate-900/70 text-white shadow-lg backdrop-blur-sm transition-transform duration-300 group-hover:scale-100"
                                >
                                    <i class="bi bi-search text-base"></i>
                                </div>
                            </div>
                        </div>

                        <!-- TOOLTIP -->
                        <div
                            v-if="image.title?.ru"
                            class="pointer-events-none absolute bottom-3 left-3 right-3 z-20 translate-y-2 rounded-lg bg-slate-900/90 px-3 py-2 text-xs font-medium text-white opacity-0 shadow-lg backdrop-blur-sm transition-all duration-200 group-hover:translate-y-0 group-hover:opacity-100"
                        >
                            {{ image.title.ru }}
                        </div>
                    </button>
                </div>

                <!-- EMPTY -->
                <div
                    v-else
                    class="rounded-2xl border border-amber-200 bg-amber-50/50 p-8"
                >
                    <EmptyData />
                </div>

                <!-- SHOW MORE / LESS -->
                <div
                    v-if="images.length > 3"
                    class="mt-4 flex justify-center"
                >
                    <button
                        type="button"
                        class="group inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-600 shadow-sm transition hover:border-slate-300 hover:text-slate-900"
                        @click="showAll = !showAll"
                    >
                        <span>
                            {{
                                showAll
                                    ? $t('gallery.showLess')
                                    : $t('gallery.showMore')
                            }}
                        </span>

                        <i
                            class="bi transition-transform duration-300"
                            :class="
                                showAll
                                    ? 'bi-chevron-up'
                                    : 'bi-chevron-down'
                            "
                        ></i>
                    </button>
                </div>
            </div>
        </Transition>

        <!-- IMAGE MODAL -->
        <Teleport to="body">
            <Transition
                enter-active-class="transition duration-300 ease-out"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition duration-200 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="selectedImage"
                    class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/90 p-4 backdrop-blur-sm sm:p-6"
                    @click.self="closeModal"
                >
                    <!-- CLOSE BUTTON -->
                    <button
                        type="button"
                        class="absolute right-4 top-4 z-20 flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-white transition hover:bg-white/20 sm:right-6 sm:top-6"
                        :aria-label="$t('gallery.close')"
                        @click="closeModal"
                    >
                        <i class="bi bi-x-lg"></i>
                    </button>

                    <!-- IMAGE CONTENT -->
                    <div
                        class="relative flex max-h-full max-w-7xl flex-col items-center"
                    >
                        <img
                            :src="selectedImage.image_url"
                            :alt="
                                selectedImage.title?.ru ||
                                product.title
                            "
                            class="max-h-[85vh] max-w-full rounded-xl object-contain shadow-2xl"
                        />

                        <!-- TITLE -->
                        <div
                            v-if="selectedImage.title?.ru"
                            class="mt-4 max-w-2xl text-center text-sm font-medium text-white"
                        >
                            {{ selectedImage.title.ru }}
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>
    </section>
</template>

<script setup>
import { computed, ref } from 'vue';

import SectionHeader from '../SectionHeader.vue';
import EmptyData from '../EmptyData.vue';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },

    images: {
        type: Array,
        default: () => [],
    },
});

const isOpen = ref(true);
const showAll = ref(false);
const selectedImage = ref(null);

const visibleImages = computed(() => {
    return showAll.value
        ? props.images
        : props.images.slice(0, 3);
});

const toggleSection = () => {
    isOpen.value = !isOpen.value;

    if (!isOpen.value) {
        showAll.value = false;
    }
};

const openModal = (image) => {
    selectedImage.value = image;
    document.body.classList.add('overflow-hidden');
};

const closeModal = () => {
    selectedImage.value = null;
    document.body.classList.remove('overflow-hidden');
};
</script>