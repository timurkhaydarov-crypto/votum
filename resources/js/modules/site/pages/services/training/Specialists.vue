<template>
    <section class="bg-slate-50 pt-20 sm:pt-24 lg:pt-28">
        <div
            class="mx-auto max-w-7xl px-6 py-16 sm:px-8 lg:px-10 lg:py-20"
        >
            <ServiceHero
                eyebrow="services.training.specialists.eyebrow"
                title="services.training.specialists.title"
                description="services.training.specialists.description"
                request="services.training.specialists.request"
                image="/image/services/training/specialists.webp"
                image-alt="services.training.specialists.imageAlt"
            />

            <ServiceOverview
                eyebrow="services.training.specialists.overview.eyebrow"
                title="services.training.specialists.overview.title"
                description="services.training.specialists.overview.description"
            />

            <ServiceDirections
                eyebrow="services.training.specialists.directions.eyebrow"
                title="services.training.specialists.directions.title"
                :items="directions"
                translation-prefix="services.training.specialists.directions.items"
            />

            <ServiceBenefits
                eyebrow="services.training.specialists.benefits.eyebrow"
                title="services.training.specialists.benefits.title"
                :items="benefits"
                translation-prefix="services.training.specialists.benefits.items"
            />

            <ServiceCta
                eyebrow="services.training.specialists.cta.eyebrow"
                title="services.training.specialists.cta.title"
                description="services.training.specialists.cta.description"
                button="services.training.specialists.cta.button"
                to="/contacts"
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
        key: 'basic',
    },
    {
        key: 'methods',
    },
    {
        key: 'certification',
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
        key: 'experience',
    },
    {
        key: 'result',
    },
];
</script>