<template>
    <main class="min-h-screen bg-slate-50 pt-20 text-slate-950 sm:pt-24 lg:pt-28">
        <div class="mx-auto max-w-7xl px-6 py-16 sm:px-8 lg:px-10 lg:py-20">
            <header class="mb-12 max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                    {{ t('menu.services') }}
                </p>
                <h1 class="mt-4 text-3xl font-semibold tracking-[-0.035em] sm:text-4xl lg:text-5xl">
                    {{ t('megaMenu.allServices') }}
                </h1>
                <p class="mt-5 text-base leading-7 text-slate-600 sm:text-lg sm:leading-8">
                    {{ t('about.competence.description') }}
                </p>
            </header>

            <div class="space-y-12">
                <section
                    v-for="category in categories"
                    :key="category.key"
                    :aria-labelledby="`services-${category.key}`"
                >
                    <h2
                        :id="`services-${category.key}`"
                        class="mb-5 text-2xl font-semibold tracking-tight"
                    >
                        {{ t(`about.competence.${category.key}.title`) }}
                    </h2>

                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        <RouterLink
                            v-for="service in category.items"
                            :key="service.key"
                            :to="service.href"
                            class="group rounded-2xl border border-slate-200 bg-white p-6 transition hover:-translate-y-1 hover:border-slate-300 hover:shadow-lg hover:shadow-slate-200/50"
                        >
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-100 text-slate-700 transition group-hover:bg-slate-950 group-hover:text-white">
                                <i :class="['bi', service.icon, 'text-lg']" aria-hidden="true"></i>
                            </div>
                            <h3 class="mt-5 text-lg font-semibold">
                                {{ t(`services.${service.translationKey}.title`) }}
                            </h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">
                                {{ t(`services.${service.translationKey}.description`) }}
                            </p>
                            <span class="mt-5 inline-flex items-center gap-2 text-sm font-semibold">
                                {{ t('megaMenu.details') }}
                                <i class="bi bi-arrow-right transition-transform group-hover:translate-x-1" aria-hidden="true"></i>
                            </span>
                        </RouterLink>
                    </div>
                </section>
            </div>
        </div>
    </main>
</template>

<script setup>
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const categories = [
    {
        key: 'training',
        items: [
            {
                key: 'specialists',
                translationKey: 'training.specialists',
                href: '/services/training/specialists',
                icon: 'bi-person-workspace',
            },
            {
                key: 'qualification',
                translationKey: 'training.qualification',
                href: '/services/training/qualification',
                icon: 'bi-award',
            },
            {
                key: 'seminars',
                translationKey: 'training.seminars',
                href: '/services/training/seminars',
                icon: 'bi-easel2',
            },
        ],
    },
    {
        key: 'metrology',
        items: [
            {
                key: 'verification',
                translationKey: 'metrology.verification',
                href: '/services/metrology/verification',
                icon: 'bi-patch-check',
            },
            {
                key: 'calibration',
                translationKey: 'metrology.calibration',
                href: '/services/metrology/calibration',
                icon: 'bi-sliders',
            },
            {
                key: 'expertise',
                translationKey: 'metrology.expertise',
                href: '/services/metrology/expertise',
                icon: 'bi-file-earmark-check',
            },
        ],
    },
    {
        key: 'diagnostics',
        items: [
            {
                key: 'technical',
                translationKey: 'technical',
                href: '/services/diagnostics/technical',
                icon: 'bi-tools',
            },
            {
                key: 'equipment',
                translationKey: 'diagnostics.equipment',
                href: '/services/diagnostics/equipment',
                icon: 'bi-cpu',
            },
            {
                key: 'expertise',
                translationKey: 'diagnostics.expertise',
                href: '/services/diagnostics/expertise',
                icon: 'bi-search',
            },
        ],
    },
]
</script>
