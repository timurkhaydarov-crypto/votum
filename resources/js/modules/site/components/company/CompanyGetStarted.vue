<template>
    <section class="w-full bg-slate-950">
        <div
            class="mx-auto w-full max-w-7xl px-6 py-20 sm:px-8 sm:py-24 lg:px-10 lg:py-32"
        >
            <div
                class="max-w-4xl"
            >
                <CompanySectionEyebrow
                    number="04"
                    :label="t('company.getStarted.eyebrow')"
                    dark
                />

                <h2
                    class="mt-6 max-w-4xl text-3xl font-semibold leading-[1.08] tracking-[-0.03em] text-white sm:text-4xl lg:text-5xl"
                >
                    {{ t('company.getStarted.title') }}
                </h2>

                <p
                    class="mt-7 max-w-2xl text-base leading-7 text-white/75 sm:text-lg sm:leading-8"
                >
                    {{ t('company.getStarted.description') }}
                </p>

                <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                    <RouterLink
                        to="/products"
                        class="inline-flex min-h-12 items-center justify-center rounded-xl bg-white px-6 text-sm font-semibold text-slate-900 transition hover:bg-slate-100"
                    >
                        {{ t('company.getStarted.products') }}
                    </RouterLink>

                    <RouterLink
                        to="/contacts"
                        class="inline-flex min-h-12 items-center justify-center rounded-xl border border-white/30 px-6 text-sm font-semibold text-white transition hover:border-white/60 hover:bg-white/10"
                    >
                        {{ t('company.getStarted.contact') }}
                    </RouterLink>
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