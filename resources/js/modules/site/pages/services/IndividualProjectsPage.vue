<template>
    <section class="bg-slate-50 pt-20 sm:pt-24 lg:pt-28">
        <div
            class="mx-auto max-w-7xl px-6 py-16 sm:px-8 lg:px-10 lg:py-20"
        >
            <ServiceHero
                eyebrow="services.individualProjects.eyebrow"
                title="services.individualProjects.title"
                description="services.individualProjects.description"
                request="services.individualProjects.request"
                image="/image/services/diagnostics/technical.webp"
                image-alt="services.individualProjects.imageAlt"
            />

            <ServiceOverview
                eyebrow="services.individualProjects.overview.eyebrow"
                title="services.individualProjects.overview.title"
                description="services.individualProjects.overview.description"
            />

            <ServiceDirections
                eyebrow="services.individualProjects.directions.eyebrow"
                title="services.individualProjects.directions.title"
                :items="directions"
                translation-prefix="services.individualProjects.directions.items"
                :columns="3"
            />

            <ServiceBenefits
                eyebrow="services.individualProjects.benefits.eyebrow"
                title="services.individualProjects.benefits.title"
                :items="benefits"
                translation-prefix="services.individualProjects.benefits.items"
            />

            <ServiceCta
                eyebrow="services.individualProjects.cta.eyebrow"
                title="services.individualProjects.cta.title"
                description="services.individualProjects.cta.description"
                button="services.individualProjects.cta.button"
                button-to="/contacts"
            />
        </div>
    </section>
</template>

<script setup>
import { useI18n } from 'vue-i18n'
import ServiceHero from '../../components/services/ServiceHero.vue'
import ServiceOverview from '../../components/services/ServiceOverview.vue'
import ServiceDirections from '../../components/services/ServiceDirections.vue'
import ServiceBenefits from '../../components/services/ServiceBenefits.vue'
import ServiceCta from '../../components/services/ServiceCta.vue'

const directions = [
    { key: 'requirementsAnalysis' },
    { key: 'technicalDesign' },
    { key: 'integratedDevelopment' },
]

const benefits = [
    { key: 'taskSpecific' },
    { key: 'interdisciplinaryTeam' },
    { key: 'singleCycle' },
    { key: 'qualityTesting' },
]
</script>