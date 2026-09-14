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
                    class="relative min-h-[360px] overflow-hidden rounded-2xl border border-slate-200 bg-white"
                >
                    <div
                        class="absolute inset-0 bg-[radial-gradient(circle_at_center,_rgba(15,23,42,0.08)_1px,_transparent_1px)] [background-size:24px_24px]"
                    ></div>

                    <div
                        class="absolute left-1/2 top-1/2 h-24 w-24 -translate-x-1/2 -translate-y-1/2 rounded-full border border-slate-300"
                    ></div>

                    <div
                        class="absolute left-1/2 top-1/2 h-3 w-3 -translate-x-1/2 -translate-y-1/2 rounded-full bg-slate-900"
                    ></div>

                    <div
                        class="absolute left-[18%] top-[24%] h-2 w-2 rounded-full bg-slate-400"
                    ></div>

                    <div
                        class="absolute right-[20%] top-[28%] h-2 w-2 rounded-full bg-slate-400"
                    ></div>

                    <div
                        class="absolute bottom-[22%] left-[25%] h-2 w-2 rounded-full bg-slate-400"
                    ></div>

                    <div
                        class="absolute bottom-[25%] right-[17%] h-2 w-2 rounded-full bg-slate-400"
                    ></div>

                    <div
                        class="absolute bottom-6 left-6 text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500"
                    >
                        {{ t('company.global.mapLabel') }}
                    </div>

                    <div
                        class="absolute left-1/2 top-1/2 mt-5 -translate-x-1/2 text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-700"
                    >
                        {{ t('company.global.locations.headquarters') }}
                    </div>
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