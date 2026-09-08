<template>
    <section class="bg-slate-50 pt-20 sm:pt-24 lg:pt-28">
        <div
            class="mx-auto max-w-7xl px-6 py-16 sm:px-8 lg:px-10 lg:py-20"
        >
            <!-- Hero -->
            <ServiceHero
                eyebrow="services.training.seminars.eyebrow"
                title="services.training.seminars.title"
                description="services.training.seminars.description"
                request="services.training.seminars.request"
                image="/image/services/training/seminars.webp"
                image-alt="services.training.seminars.imageAlt"
            />

            <!-- Overview -->
            <ServiceOverview
                eyebrow="services.training.seminars.overview.eyebrow"
                title="services.training.seminars.overview.title"
                description="services.training.seminars.overview.description"
            />

            <!-- Directions -->
            <ServiceDirections
                eyebrow="services.training.seminars.directions.eyebrow"
                title="services.training.seminars.directions.title"
                :items="directions"
                translation-prefix="services.training.seminars.directions.items"
                :columns="3"
            />

            <!-- Benefits -->
            <ServiceBenefits
                eyebrow="services.training.seminars.benefits.eyebrow"
                title="services.training.seminars.benefits.title"
                :items="benefits"
                translation-prefix="services.training.seminars.benefits.items"
            />

            <!-- CTA -->
            <ServiceCta
                eyebrow="services.training.seminars.cta.eyebrow"
                title="services.training.seminars.cta.title"
                description="services.training.seminars.cta.description"
                button="services.training.seminars.cta.button"
                button-to="/contacts"
            />
        </div>
    </section>
</template>

<script setup>
import ServiceHero from '../../../components/services/ServiceHero.vue';
import ServiceOverview from '../../../components/services/ServiceOverview.vue';
import ServiceDirections from '../../../components/services/ServiceDirections.vue';
import ServiceBenefits from '../../../components/services/ServiceBenefits.vue';
import ServiceCta from '../../../components/services/ServiceCta.vue';

const directions = [
    {
        key: 'thematic',
    },
    {
        key: 'equipment',
    },
    {
        key: 'practical',
    },
];

const benefits = [
    {
        key: 'practice',
    },
    {
        key: 'equipment',
    },
    {
        key: 'expertise',
    },
    {
        key: 'communication',
    },
];
</script>