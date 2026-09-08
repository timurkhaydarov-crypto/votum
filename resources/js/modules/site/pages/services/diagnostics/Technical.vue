<template>
    <section class="bg-slate-50 pt-20 sm:pt-24 lg:pt-28">
        <div
            class="mx-auto max-w-7xl px-6 py-16 sm:px-8 lg:px-10 lg:py-20"
        >
            <ServiceHero
                eyebrow="services.diagnostics.technical.eyebrow"
                title="services.diagnostics.technical.title"
                description="services.diagnostics.technical.description"
                request="services.diagnostics.technical.request"
                image="/image/services/diagnostics/technical.webp"
                image-alt="services.diagnostics.technical.imageAlt"
            />

            <ServiceOverview
                eyebrow="services.diagnostics.technical.overview.eyebrow"
                title="services.diagnostics.technical.overview.title"
                description="services.diagnostics.technical.overview.description"
            />

            <ServiceDirections
                eyebrow="services.diagnostics.technical.directions.eyebrow"
                title="services.diagnostics.technical.directions.title"
                :items="directions"
                translation-prefix="services.diagnostics.technical.directions.items"
                :columns="3"
            />

            <ServiceBenefits
                eyebrow="services.diagnostics.technical.benefits.eyebrow"
                title="services.diagnostics.technical.benefits.title"
                :items="benefits"
                translation-prefix="services.diagnostics.technical.benefits.items"
            />

            <ServiceCta
                eyebrow="services.diagnostics.technical.cta.eyebrow"
                title="services.diagnostics.technical.cta.title"
                description="services.diagnostics.technical.cta.description"
                button="services.diagnostics.technical.cta.button"
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
        key: 'instrumentalDiagnostics',
    },
    {
        key: 'technicalParameters',
    },
    {
        key: 'operatingCondition',
    },
];

const benefits = [
    {
        key: 'comprehensiveApproach',
    },
    {
        key: 'measurementAccuracy',
    },
    {
        key: 'reproducibleResults',
    },
    {
        key: 'expertSupport',
    },
];
</script>