<template>
    <section class="mt-8">
        <!-- HEADER -->
        <div class="mb-4 flex items-end justify-between gap-4">
            <div>
                <div
                    class="mb-1 text-[9px] font-semibold uppercase tracking-[0.14em] text-slate-400"
                >
                    {{ galleryTitle }}
                </div>

                <h2
                    class="text-lg font-bold tracking-tight text-slate-900"
                >
                    {{ gallerySubTitle }}
                </h2>
            </div>

            <div
                v-if="images.length"
                class="hidden text-[10px] font-medium uppercase tracking-[0.1em] text-slate-400 sm:block"
            >
                {{ images.length }}
                {{ images.length === 1 ? type : gallerySubTitle }}
            </div>
        </div>
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
                :alt="image.alt || `${type} image ${index + 1}`"
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
                    Изображения отсутствуют
                </p>
            </div>
        </div>
    </section>
</template>

<script setup>
import ProductImageCard from './ProductImageCard.vue';

defineProps({
    images: {
        type: Array,
        default: () => [],
    },
    type: {
        type: String,
        default: 'Product',
    },
    galleryTitle: {
        type: String,
        default: 'gallery',
    },
    gallerySubTitle: {
        type: String,
        default: '',
    },
});
</script>