<template>
    <section class="bg-slate-50 pt-20 sm:pt-24 lg:pt-28">
        <div
            class="mx-auto max-w-7xl px-6 py-16 sm:px-8 lg:px-10 lg:py-20"
        >
            <!-- Hero -->
            <ServiceHero
                eyebrow="services.metrology.calibration.eyebrow"
                title="services.metrology.calibration.title"
                description="services.metrology.calibration.description"
                request="services.metrology.calibration.request"
                image="/image/services/metrology/calibration.webp"
                image-alt="services.metrology.calibration.imageAlt"
            />

            <!-- Overview -->
            <ServiceOverview
                eyebrow="services.metrology.calibration.overview.eyebrow"
                title="services.metrology.calibration.overview.title"
                description="services.metrology.calibration.overview.description"
            />

            <!-- Directions -->
            <ServiceDirections
                eyebrow="services.metrology.calibration.directions.eyebrow"
                title="services.metrology.calibration.directions.title"
                :items="directions"
                translation-prefix="services.metrology.calibration.directions.items"
                :columns="3"
            />

            <!-- Benefits -->
            <ServiceBenefits
                eyebrow="services.metrology.calibration.benefits.eyebrow"
                title="services.metrology.calibration.benefits.title"
                :items="benefits"
                translation-prefix="services.metrology.calibration.benefits.items"
            />

            <!-- CTA -->
            <ServiceCta
                eyebrow="services.metrology.calibration.cta.eyebrow"
                title="services.metrology.calibration.cta.title"
                description="services.metrology.calibration.cta.description"
                button="services.metrology.calibration.cta.button"
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
        key: 'parameters',
    },
];

const benefits = [
    {
        key: 'accuracy',
    },
    {
        key: 'reliability',
    },
    {
        key: 'documentation',
    },
    {
        key: 'expertise',
    },
];
</script>