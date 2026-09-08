<template>
    <section class="bg-slate-50 pt-20 sm:pt-24 lg:pt-28">
        <div
            class="mx-auto max-w-7xl px-6 py-16 sm:px-8 lg:px-10 lg:py-20"
        >
            <ServiceHero
                eyebrow="services.diagnostics.equipment.eyebrow"
                title="services.diagnostics.equipment.title"
                description="services.diagnostics.equipment.description"
                request="services.diagnostics.equipment.request"
                image="/image/services/diagnostics/equipment.webp"
                image-alt="services.diagnostics.equipment.imageAlt"
            />

            <ServiceOverview
                eyebrow="services.diagnostics.equipment.overview.eyebrow"
                title="services.diagnostics.equipment.overview.title"
                description="services.diagnostics.equipment.overview.description"
            />

            <ServiceDirections
                eyebrow="services.diagnostics.equipment.directions.eyebrow"
                title="services.diagnostics.equipment.directions.title"
                :items="directions"
                translation-prefix="services.diagnostics.equipment.directions.items"
                :columns="3"
            />

            <ServiceBenefits
                eyebrow="services.diagnostics.equipment.benefits.eyebrow"
                title="services.diagnostics.equipment.benefits.title"
                :items="benefits"
                translation-prefix="services.diagnostics.equipment.benefits.items"
            />

            <ServiceCta
                eyebrow="services.diagnostics.equipment.cta.eyebrow"
                title="services.diagnostics.equipment.cta.title"
                description="services.diagnostics.equipment.cta.description"
                button="services.diagnostics.equipment.cta.button"
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
        key: 'visualInspection',
    },
    {
        key: 'ultrasonicInspection',
    },
    {
        key: 'specializedEquipment',
    },
];

const benefits = [
    {
        key: 'modernTechnology',
    },
    {
        key: 'accuracy',
    },
    {
        key: 'reliability',
    },
    {
        key: 'expertSupport',
    },
];
</script>