<template>
    <section class="w-full bg-slate-900">
        <div
            class="mx-auto w-full max-w-7xl px-6 py-20 sm:px-8 sm:py-24 lg:px-10 lg:py-32"
        >
            <div
                class="grid gap-12 lg:grid-cols-[0.8fr_1.2fr] lg:gap-20"
            >
                <div>
                    <CompanySectionEyebrow
                        number="01"
                        :label="t('company.certifications.eyebrow')"
                        dark
                    />

                    <h2
                        class="mt-6 max-w-3xl text-3xl font-semibold leading-[1.08] tracking-[-0.03em] text-white sm:text-4xl lg:text-5xl"
                    >
                        {{ t('company.certifications.title') }}
                    </h2>

                    <p
                        class="mt-7 max-w-xl text-base leading-7 text-white/75 sm:text-lg sm:leading-8"
                    >
                        {{ t('company.certifications.description') }}
                    </p>
                </div>

                <div
                    class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3"
                >
                    <CompanyCertificationCard
                        :title="t('company.certifications.items.quality.title')"
                        :description="
                            t(
                                'company.certifications.items.quality.description',
                            )
                        "
                    />

                    <CompanyCertificationCard
                        :title="t('company.certifications.items.safety.title')"
                        :description="
                            t(
                                'company.certifications.items.safety.description',
                            )
                        "
                    />

                    <CompanyCertificationCard
                        :title="t('company.certifications.items.metrology.title')"
                        :description="
                            t(
                                'company.certifications.items.metrology.description',
                            )
                        "
                    />

                    <CompanyCertificationCard
                        :title="t('company.certifications.items.ndt.title')"
                        :description="
                            t(
                                'company.certifications.items.ndt.description',
                            )
                        "
                    />

                    <CompanyCertificationCard
                        :title="t('company.certifications.items.production.title')"
                        :description="
                            t(
                                'company.certifications.items.production.description',
                            )
                        "
                    />

                    <CompanyCertificationCard
                        :title="t('company.certifications.items.international.title')"
                        :description="
                            t(
                                'company.certifications.items.international.description',
                            )
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
import CompanyCertificationCard from './shared/CompanyCertificationCard.vue'

const { t } = useI18n()
</script>