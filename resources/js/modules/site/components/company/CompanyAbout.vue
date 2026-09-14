<template>
    <section class="w-full bg-white">
        <div
            class="mx-auto grid w-full max-w-7xl gap-12 px-6 py-20 sm:px-8 sm:py-24 lg:grid-cols-[1.2fr_0.8fr] lg:gap-20 lg:px-10 lg:py-32"
        >
            <div>
                <CompanySectionEyebrow
                    number="01"
                    :label="t('company.about.eyebrow')"
                />

                <h2
                    class="mt-6 max-w-4xl text-3xl font-semibold leading-[1.08] tracking-[-0.03em] text-slate-900 sm:text-4xl lg:text-5xl"
                >
                    {{ t('company.about.title') }}
                </h2>

                <p
                    class="mt-7 max-w-3xl text-base leading-7 text-slate-600 sm:text-lg sm:leading-8"
                >
                    {{ t('company.about.description') }}
                </p>
            </div>

            <div
                class="grid grid-cols-1 divide-y divide-slate-200 border-y border-slate-200"
            >
                <CompanyStat
                    value="20+"
                    :label="t('company.about.stats.products')"
                />

                <CompanyStat
                    value="10+"
                    :label="t('company.about.stats.methods')"
                />

                <CompanyStat
                    value="6+"
                    :label="t('company.about.stats.industries')"
                />
            </div>
        </div>
    </section>
</template>

<script setup>
import { useI18n } from 'vue-i18n'
import CompanySectionEyebrow from './shared/CompanySectionEyebrow.vue'
import CompanyStat from './shared/CompanyStat.vue'

const { t } = useI18n()
</script>