<template>
    <section>
        <!-- HEADER -->
        <SectionHeader
            :title="$t('certificates.title')"
            :description="$t('certificates.description')"
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
                            ? $t('certificates.collapse')
                            : $t('certificates.expand')
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
                    class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
                >
                    <ProductImageCard
                        v-for="(image, index) in images"
                        :key="image.id || image.src || index"
                        :image-src="image.src"
                        :thumbnail="image.thumbnail"
                        :alt="
                            image.alt ||
                            `${$t('gallery.image')} ${index + 1}`
                        "
                        :type="type"
                        :title="image.title?.ru || ''"
                        :description="image.description?.ru || ''"
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

                        <p class="text-xs font-medium text-slate-500">
                            {{ $t('gallery.empty') }}
                        </p>
                    </div>
                </div>
            </div>
        </Transition>
    </section>
</template>

<script setup>
import { ref } from 'vue';

import ProductImageCard from './ProductImageCard.vue';
import SectionHeader from '../SectionHeader.vue';

defineProps({
    images: {
        type: Array,
        default: () => [],
    },

    type: {
        type: String,
        default: 'Product',
    },
});

const isOpen = ref(true);

const toggleSection = () => {
    isOpen.value = !isOpen.value;
};
</script>