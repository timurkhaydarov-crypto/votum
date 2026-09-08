<template>
    <section class="bg-slate-50 pt-20 sm:pt-24 lg:pt-28">
        <div
            class="mx-auto max-w-7xl px-6 py-16 sm:px-8 lg:px-10 lg:py-20"
        >
            <!-- Hero -->
            <ServiceHero
                eyebrow="services.metrology.expertise.eyebrow"
                title="services.metrology.expertise.title"
                description="services.metrology.expertise.description"
                request="services.metrology.expertise.request"
                image="/image/services/metrology/expertise.webp"
                image-alt="services.metrology.expertise.imageAlt"
            />

            <!-- Overview -->
            <ServiceOverview
                eyebrow="services.metrology.expertise.overview.eyebrow"
                title="services.metrology.expertise.overview.title"
                description="services.metrology.expertise.overview.description"
            />

            <!-- Directions -->
            <ServiceDirections
                eyebrow="services.metrology.expertise.directions.eyebrow"
                title="services.metrology.expertise.directions.title"
                :items="directions"
                translation-prefix="services.metrology.expertise.directions.items"
                :columns="3"
            />

            <!-- Benefits -->
            <ServiceBenefits
                eyebrow="services.metrology.expertise.benefits.eyebrow"
                title="services.metrology.expertise.benefits.title"
                :items="benefits"
                translation-prefix="services.metrology.expertise.benefits.items"
            />

            <!-- CTA -->
            <ServiceCta
                eyebrow="services.metrology.expertise.cta.eyebrow"
                title="services.metrology.expertise.cta.title"
                description="services.metrology.expertise.cta.description"
                button="services.metrology.expertise.cta.button"
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
        key: 'equipment',
    },
    {
        key: 'documentation',
    },
    {
        key: 'measurement',
    },
];

const benefits = [
    {
        key: 'independentAssessment',
    },
    {
        key: 'technicalAnalysis',
    },
    {
        key: 'compliance',
    },
    {
        key: 'expertise',
    },
];
</script>