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
                        number="07"
                        :label="t('company.contact.eyebrow')"
                    />

                    <h2
                        class="mt-6 max-w-3xl text-3xl font-semibold leading-[1.08] tracking-[-0.03em] text-slate-900 sm:text-4xl lg:text-5xl"
                    >
                        {{ t('company.contact.title') }}
                    </h2>

                    <p
                        class="mt-7 max-w-xl text-base leading-7 text-slate-600 sm:text-lg sm:leading-8"
                    >
                        {{ t('company.contact.description') }}
                    </p>
                </div>

                <div
                    class="grid gap-px overflow-hidden rounded-2xl border border-slate-200 bg-slate-200 sm:grid-cols-2"
                >
                    <CompanyContactCard
                        :label="t('company.contact.items.address.label')"
                        :value="t('company.contact.items.address.value')"
                        icon="bi-geo-alt"
                    />

                    <CompanyContactCard
                        :label="t('company.contact.items.phone.label')"
                        :value="t('company.contact.items.phone.value')"
                        icon="bi-telephone"
                    />

                    <CompanyContactCard
                        :label="t('company.contact.items.email.label')"
                        :value="t('company.contact.items.email.value')"
                        icon="bi-envelope"
                    />

                    <CompanyContactCard
                        :label="t('company.contact.items.hours.label')"
                        :value="t('company.contact.items.hours.value')"
                        icon="bi-clock"
                    />
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { useI18n } from 'vue-i18n'
import CompanySectionEyebrow from './shared/CompanySectionEyebrow.vue'
import CompanyContactCard from './shared/CompanyContactCard.vue'

const { t } = useI18n()
</script>