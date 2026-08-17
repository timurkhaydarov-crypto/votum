<template>
    <section>
        <SectionHeader
            eyebrow="07 / GALLERY"
            title="Фотогалерея"
            description="Визуальный обзор оборудования."
        />

        <div
            v-if="images.length"
            class="grid grid-cols-2 gap-3 md:grid-cols-3"
        >
            <div
                v-for="(image, index) in images"
                :key="index"
                class="group relative aspect-[4/3] overflow-hidden rounded-2xl border border-slate-200 bg-slate-50"
            >
                <img
                    :src="image"
                    :alt="`${product.name} ${index + 1}`"
                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                />

                <div
                    class="absolute inset-0 bg-gradient-to-t from-slate-900/30 via-transparent to-transparent opacity-0 transition group-hover:opacity-100"
                ></div>
            </div>
        </div>

        <div
            v-else
            class="rounded-2xl border border-amber-200 bg-amber-50/50 p-8"
        >
            <EmptyData />
        </div>
    </section>
</template>

<script setup>
import SectionHeader from '../SectionHeader.vue';
import EmptyData from '../EmptyData.vue';

defineProps({
    product: {
        type: Object,
        required: true,
    },

    images: {
        type: Array,
        default: () => [],
    },
});
</script>