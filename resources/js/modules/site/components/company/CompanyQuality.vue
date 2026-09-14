<template>
    <section class="w-full bg-white">
        <div
            class="mx-auto w-full max-w-7xl px-6 py-20 sm:px-8 sm:py-24 lg:px-10 lg:py-32"
        >
            <div
                class="grid gap-12 lg:grid-cols-[0.8fr_1.2fr] lg:gap-20"
            >
                <div>
                    <CompanySectionEyebrow
                        number="03"
                        :label="t('company.quality.eyebrow')"
                    />

                    <h2
                        class="mt-6 max-w-3xl text-3xl font-semibold leading-[1.08] tracking-[-0.03em] text-slate-900 sm:text-4xl lg:text-5xl"
                    >
                        {{ t('company.quality.title') }}
                    </h2>

                    <p
                        class="mt-7 max-w-xl text-base leading-7 text-slate-600 sm:text-lg sm:leading-8"
                    >
                        {{ t('company.quality.description') }}
                    </p>
                </div>

                <div class="divide-y divide-slate-200 border-y border-slate-200">
                    <CompanyProcessStep
                        number="01"
                        :title="t('company.quality.steps.requirements.title')"
                        :description="
                            t(
                                'company.quality.steps.requirements.description',
                            )
                        "
                    />

                    <CompanyProcessStep
                        number="02"
                        :title="t('company.quality.steps.design.title')"
                        :description="
                            t('company.quality.steps.design.description')
                        "
                    />

                    <CompanyProcessStep
                        number="03"
                        :title="t('company.quality.steps.manufacturing.title')"
                        :description="
                            t(
                                'company.quality.steps.manufacturing.description',
                            )
                        "
                    />

                    <CompanyProcessStep
                        number="04"
                        :title="t('company.quality.steps.testing.title')"
                        :description="
                            t('company.quality.steps.testing.description')
                        "
                    />

                    <CompanyProcessStep
                        number="05"
                        :title="t('company.quality.steps.delivery.title')"
                        :description="
                            t('company.quality.steps.delivery.description')
                        "
                    />
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { useI18n } from 'vue-i18n'
import CompanySectionEyebrow from './shared/CompanySectionEyebrow.vue'
import CompanyProcessStep from './shared/CompanyProcessStep.vue'

const { t } = useI18n()
</script>