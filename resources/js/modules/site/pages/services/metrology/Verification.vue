<template>
    <section class="bg-slate-50 pt-20 sm:pt-24 lg:pt-28">
        <div
            class="mx-auto max-w-7xl px-6 py-16 sm:px-8 lg:px-10 lg:py-20"
        >
            <!-- Hero -->
            <ServiceHero
                eyebrow="services.metrology.verification.eyebrow"
                title="services.metrology.verification.title"
                description="services.metrology.verification.description"
                request="services.metrology.verification.request"
                image="/image/services/metrology/verification.webp"
                image-alt="services.metrology.verification.imageAlt"
            />

            <!-- Overview -->
            <ServiceOverview
                eyebrow="services.metrology.verification.overview.eyebrow"
                title="services.metrology.verification.overview.title"
                description="services.metrology.verification.overview.description"
            />

            <!-- Directions -->
            <ServiceDirections
                eyebrow="services.metrology.verification.directions.eyebrow"
                title="services.metrology.verification.directions.title"
                :items="directions"
                translation-prefix="services.metrology.verification.directions.items"
                :columns="3"
            />

            <!-- Benefits -->
            <ServiceBenefits
                eyebrow="services.metrology.verification.benefits.eyebrow"
                title="services.metrology.verification.benefits.title"
                :items="benefits"
                translation-prefix="services.metrology.verification.benefits.items"
            />

            <!-- CTA -->
            <ServiceCta
                eyebrow="services.metrology.verification.cta.eyebrow"
                title="services.metrology.verification.cta.title"
                description="services.metrology.verification.cta.description"
                button="services.metrology.verification.cta.button"
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
        key: 'measuringEquipment',
    },
    {
        key: 'inspectionEquipment',
    },
    {
        key: 'testingEquipment',
    },
];

const benefits = [
    {
        key: 'accuracy',
    },
    {
        key: 'standards',
    },
    {
        key: 'documentation',
    },
    {
        key: 'expertise',
    },
];
</script>