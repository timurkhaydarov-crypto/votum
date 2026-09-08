<template>
    <section class="bg-slate-50 pt-20 sm:pt-24 lg:pt-28">
        <div
            class="mx-auto max-w-7xl px-6 py-16 sm:px-8 lg:px-10 lg:py-20"
        >
            <!-- Hero -->
            <ServiceHero
                eyebrow="services.training.qualification.eyebrow"
                title="services.training.qualification.title"
                description="services.training.qualification.description"
                request="services.training.qualification.request"
                image="/image/services/training/qualification.webp"
                image-alt="services.training.qualification.imageAlt"
            />

            <!-- Overview -->
            <ServiceOverview
                eyebrow="services.training.qualification.overview.eyebrow"
                title="services.training.qualification.overview.title"
                description="services.training.qualification.overview.description"
            />

            <!-- Directions -->
            <ServiceDirections
                eyebrow="services.training.qualification.directions.eyebrow"
                title="services.training.qualification.directions.title"
                :items="directions"
                translation-prefix="services.training.qualification.directions.items"
            />

            <!-- Benefits -->
            <ServiceBenefits
                eyebrow="services.training.qualification.benefits.eyebrow"
                title="services.training.qualification.benefits.title"
                :items="benefits"
                translation-prefix="services.training.qualification.benefits.items"
            />

            <!-- CTA -->
            <ServiceCta
                eyebrow="services.training.qualification.cta.eyebrow"
                title="services.training.qualification.cta.title"
                description="services.training.qualification.cta.description"
                button="services.training.qualification.cta.button"
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
        key: 'advanced',
    },
    {
        key: 'methods',
    },
    {
        key: 'equipment',
    },
];

const benefits = [
    {
        key: 'practice',
    },
    {
        key: 'relevance',
    },
    {
        key: 'equipment',
    },
    {
        key: 'flexibility',
    },
];
</script>

