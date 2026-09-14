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
                        number="02"
                        :label="t('company.manufacturing.eyebrow')"
                    />

                    <h2
                        class="mt-6 max-w-3xl text-3xl font-semibold leading-[1.08] tracking-[-0.03em] text-slate-900 sm:text-4xl lg:text-5xl"
                    >
                        {{ t('company.manufacturing.title') }}
                    </h2>

                    <p
                        class="mt-7 max-w-xl text-base leading-7 text-slate-600 sm:text-lg sm:leading-8"
                    >
                        {{ t('company.manufacturing.description') }}
                    </p>
                </div>

                <div
                    class="grid gap-px overflow-hidden rounded-2xl border border-slate-200 bg-slate-200 sm:grid-cols-2"
                >
                    <CompanyCapabilityCard
                        number="01"
                        :title="t('company.manufacturing.items.engineering.title')"
                        :description="
                            t(
                                'company.manufacturing.items.engineering.description',
                            )
                        "
                    />

                    <CompanyCapabilityCard
                        number="02"
                        :title="t('company.manufacturing.items.electronics.title')"
                        :description="
                            t(
                                'company.manufacturing.items.electronics.description',
                            )
                        "
                    />

                    <CompanyCapabilityCard
                        number="03"
                        :title="t('company.manufacturing.items.software.title')"
                        :description="
                            t(
                                'company.manufacturing.items.software.description',
                            )
                        "
                    />

                    <CompanyCapabilityCard
                        number="04"
                        :title="t('company.manufacturing.items.testing.title')"
                        :description="
                            t(
                                'company.manufacturing.items.testing.description',
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
import CompanyCapabilityCard from './shared/CompanyCapabilityCard.vue'

const { t } = useI18n()
</script>