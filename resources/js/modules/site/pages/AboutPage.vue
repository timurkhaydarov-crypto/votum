<template>
    <main class="min-h-screen bg-slate-50 text-slate-950">
        <AboutHero />

        <AboutCompany />

        <AboutCompetence />

        <AboutValues />

        <AboutIndustries />
        
        <AboutDiplomas />
        
        <AboutCta />
    </main>
</template>

<script setup>
import AboutHero from '../components/about/AboutHero.vue';
import AboutCompany from '../components/about/AboutCompany.vue';
import AboutCompetence from '../components/about/AboutCompetence.vue';
import AboutValues from '../components/about/AboutValues.vue';
import AboutIndustries from '../components/about/AboutIndustries.vue';
import AboutDiplomas from '../components/about/AboutDiplomas.vue';
import AboutCta from '../components/about/AboutCta.vue';
</script>