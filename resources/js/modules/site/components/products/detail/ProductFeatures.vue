<template>
    <section>
        <SectionHeader
            eyebrow="04 / CAPABILITIES"
            title="Функциональные особенности"
            description="Ключевые функции и возможности прибора."
        />

        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
            <ProductFeatureCard
                v-for="(feature, index) in features"
                :key="index"
                :feature="feature"
            />

            <div
                v-if="!features.length"
                class="col-span-full rounded-2xl border border-amber-200 bg-amber-50/50 p-6"
            >
                <EmptyData />
            </div>
        </div>
    </section>
</template>

<script setup>
import SectionHeader from '../SectionHeader.vue';
import EmptyData from '../EmptyData.vue';
import ProductFeatureCard from './ProductFeatureCard.vue';

defineProps({
    features: {
        type: Array,
        default: () => [],
    },
});
</script>