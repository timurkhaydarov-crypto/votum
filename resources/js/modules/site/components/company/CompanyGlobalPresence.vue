<template>
    <section class="w-full bg-slate-50">
        <div
            class="mx-auto w-full max-w-7xl px-6 py-20 sm:px-8 sm:py-24 lg:px-10 lg:py-32"
        >
            <div
                class="grid gap-12 lg:grid-cols-[0.8fr_1.2fr] lg:gap-20"
            >
                <div>
                    <CompanySectionEyebrow
                        number="05"
                        :label="t('company.global.eyebrow')"
                    />

                    <h2
                        class="mt-6 max-w-3xl text-3xl font-semibold leading-[1.08] tracking-[-0.03em] text-slate-900 sm:text-4xl lg:text-5xl"
                    >
                        {{ t('company.global.title') }}
                    </h2>

                    <p
                        class="mt-7 max-w-xl text-base leading-7 text-slate-600 sm:text-lg sm:leading-8"
                    >
                        {{ t('company.global.description') }}
                    </p>
                </div>
                <div
                    class="overflow-hidden rounded-2xl border border-slate-200"
                >
                    <img
                        :src="'/image/GeographySection.webp'"
                        :alt="t('company.global.title')"
                        class="block aspect-[4/3] h-auto w-full object-contain"
                        loading="lazy"
                    />
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { useI18n } from 'vue-i18n'
import CompanySectionEyebrow from './shared/CompanySectionEyebrow.vue'

const { t } = useI18n()
</script>