<template>
    <section class="bg-slate-50">
        <div class="mx-auto max-w-7xl px-6 py-20 sm:px-8 lg:px-10 lg:py-28">
            <!-- Header -->
            <div class="mb-12 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <div
                        class="flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500"
                    >
                        <span class="h-px w-8 bg-slate-900"></span>

                        {{ $t('about.competence.eyebrow') }}
                    </div>

                    <h2
                        class="mt-5 text-3xl font-semibold tracking-[-0.035em] text-slate-950 sm:text-4xl lg:text-5xl"
                    >
                        {{ $t('about.competence.title') }}
                    </h2>
                </div>

                <p class="max-w-xl text-sm leading-6 text-slate-600 sm:text-base">
                    {{ $t('about.competence.description') }}
                </p>
            </div>

            <!-- Competencies -->
            <div class="grid gap-4 md:grid-cols-2">
                <article
                    v-for="item in competencies"
                    :key="item.key"
                    class="group relative overflow-hidden rounded-[1.5rem] border border-slate-200 bg-white p-7 transition duration-300 hover:-translate-y-1 hover:border-slate-300 hover:shadow-xl hover:shadow-slate-200/60 sm:p-8"
                >
                    <!-- Top -->
                    <div class="relative z-10 flex items-start justify-between">
                        <span
                            class="font-mono text-xs text-slate-400 transition-colors duration-300 group-hover:text-slate-950"
                        >
                            {{ item.number }}
                        </span>

                        <RouterLink
                            v-if="item.href"
                            :to="item.href"
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 text-slate-500 transition duration-300 hover:border-slate-950 hover:bg-slate-950 hover:text-white"
                            :aria-label="$t(`about.competence.${item.key}.link`)"
                        >
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                <path
                                    d="M5 15 15 5M7 5h8v8"
                                    stroke="currentColor"
                                    stroke-width="1.6"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </RouterLink>
                    </div>

                    <!-- Content -->
                    <div class="relative z-10 max-w-xl">
                        <h3 class="text-2xl font-semibold tracking-tight text-slate-950">
                            {{ $t(`about.competence.${item.key}.title`) }}
                        </h3>

                        <p class="mt-3 text-sm leading-6 text-slate-600">
                            {{ $t(`about.competence.${item.key}.description`) }}
                        </p>
                    </div>

                    <!-- Items -->
                    <div
                        v-if="item.items?.length"
                        class="relative z-10 mt-6 border-t border-slate-100 pt-5"
                    >
                        <div class="space-y-1">
                            <RouterLink
                                v-for="service in item.items"
                                :key="service.key"
                                :to="service.href"
                                class="group/service flex items-center justify-between rounded-xl px-3 py-3 -mx-3 transition hover:bg-slate-50"
                            >
                                <div class="min-w-0 pr-4">
                                    <div class="text-sm font-medium text-slate-900">
                                        {{
                                            $t(
                                                `about.competence.${item.key}.items.${service.key}.title`
                                            )
                                        }}
                                    </div>

                                    <p
                                        v-if="
                                            $te(
                                                `about.competence.${item.key}.items.${service.key}.description`
                                            )
                                        "
                                        class="mt-0.5 text-xs leading-5 text-slate-500"
                                    >
                                        {{
                                            $t(
                                                `about.competence.${item.key}.items.${service.key}.description`
                                            )
                                        }}
                                    </p>
                                </div>

                                <svg
                                    class="h-4 w-4 shrink-0 text-slate-400 transition-transform group-hover/service:translate-x-1 group-hover/service:text-slate-950"
                                    viewBox="0 0 20 20"
                                    fill="none"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M4 10h11M10 5l5 5-5 5"
                                        stroke="currentColor"
                                        stroke-width="1.6"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                            </RouterLink>
                        </div>
                    </div>
                    <!-- Hover background -->
                    <div
                        class="pointer-events-none absolute inset-0 z-0 bg-gradient-to-br from-transparent via-transparent to-slate-50 opacity-0 transition duration-300 group-hover:opacity-100"
                    ></div>
                </article>
            </div>
        </div>
    </section>
</template>

<script setup>
const competencies = [
    {
        key: 'production',
        number: '01',
        items: [
            {
                key: 'industrialNdt',
                href: '/products/industrial-ndt',
            },
            {
                key: 'flawDetectors',
                href: '/products/flaw-detectors',
            },
            {
                key: 'scanningDevices',
                href: '/products/scanning-devices',
            },
        ],
    },

    {
        key: 'training',
        number: '02',
        items: [
            {
                key: 'specialists',
                href: '/services/training/specialists',
            },
            {
                key: 'qualification',
                href: '/services/training/qualification',
            },
            {
                key: 'seminars',
                href: '/services/training/seminars',
            },
        ],
    },

    {
        key: 'metrology',
        number: '03',
        items: [
            {
                key: 'verification',
                href: '/services/metrology/verification',
            },
            {
                key: 'calibration',
                href: '/services/metrology/calibration',
            },
            {
                key: 'expertise',
                href: '/services/metrology/expertise',
            },
        ],
    },

    {
        key: 'diagnostics',
        number: '04',
        items: [
            {
                key: 'technical',
                href: '/services/diagnostics/technical',
            },
            {
                key: 'equipment',
                href: '/services/diagnostics/equipment',
            },
            {
                key: 'expertise',
                href: '/services/diagnostics/expertise',
            },
        ],
    },
];
</script>
