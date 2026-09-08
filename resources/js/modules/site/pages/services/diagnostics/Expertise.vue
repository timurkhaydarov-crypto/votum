<template>
    <section class="bg-slate-50 pt-20 sm:pt-24 lg:pt-28">
        <div
            class="mx-auto max-w-7xl px-6 py-16 sm:px-8 lg:px-10 lg:py-20"
        >
            <ServiceHero
                eyebrow="services.diagnostics.expertise.eyebrow"
                title="services.diagnostics.expertise.title"
                description="services.diagnostics.expertise.description"
                request="services.diagnostics.expertise.request"
                image="/image/services/diagnostics/expertise.webp"
                image-alt="services.diagnostics.expertise.imageAlt"
            />

            <ServiceOverview
                eyebrow="services.diagnostics.expertise.overview.eyebrow"
                title="services.diagnostics.expertise.overview.title"
                description="services.diagnostics.expertise.overview.description"
            />

            <ServiceDirections
                eyebrow="services.diagnostics.expertise.directions.eyebrow"
                title="services.diagnostics.expertise.directions.title"
                :items="directions"
                translation-prefix="services.diagnostics.expertise.directions.items"
                :columns="3"
            />

            <ServiceBenefits
                eyebrow="services.diagnostics.expertise.benefits.eyebrow"
                title="services.diagnostics.expertise.benefits.title"
                :items="benefits"
                translation-prefix="services.diagnostics.expertise.benefits.items"
            />

            <ServiceCta
                eyebrow="services.diagnostics.expertise.cta.eyebrow"
                title="services.diagnostics.expertise.cta.title"
                description="services.diagnostics.expertise.cta.description"
                button="services.diagnostics.expertise.cta.button"
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
        key: 'technicalAssessment',
    },
    {
        key: 'failureAnalysis',
    },
    {
        key: 'diagnosticConclusion',
    },
];

const benefits = [
    {
        key: 'objectiveAssessment',
    },
    {
        key: 'detailedAnalysis',
    },
    {
        key: 'practicalRecommendations',
    },
    {
        key: 'professionalExpertise',
    },
];
</script>