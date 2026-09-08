<template>
    <section class="bg-white">
        <div
            class="mx-auto max-w-7xl px-6 py-16 sm:px-8 lg:px-10 lg:py-20"
        >
            <!-- Header -->
            <div class="mb-10">
                <div
                    class="flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500"
                >
                    <span class="h-px w-8 bg-slate-900"></span>

                    {{ $t('about.values.eyebrow') }}
                </div>

                <div
                    class="mt-4 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between"
                >
                    <h2
                        class="max-w-xl text-3xl font-semibold tracking-[-0.035em] text-slate-950 sm:text-4xl"
                    >
                        {{ $t('about.values.title') }}
                    </h2>

                    <p
                        class="max-w-xl text-sm leading-6 text-slate-600 sm:text-base"
                    >
                        {{ $t('about.values.description') }}
                    </p>
                </div>
            </div>

            <!-- Values -->
            <div
                class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4"
            >
                <article
                    v-for="item in values"
                    :key="item.key"
                    class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 p-6 transition duration-300 hover:-translate-y-1 hover:border-slate-300 hover:bg-white hover:shadow-lg hover:shadow-slate-200/50"
                >
                    <!-- Number -->
                    <div
                        class="flex items-center justify-between"
                    >
                        <span
                            class="font-mono text-xs text-slate-400 transition-colors duration-300 group-hover:text-slate-950"
                        >
                            {{ item.number }}
                        </span>

                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-400 transition duration-300 group-hover:border-slate-950 group-hover:bg-slate-950 group-hover:text-white"
                        >
                            <svg
                                class="h-3.5 w-3.5"
                                viewBox="0 0 20 20"
                                fill="none"
                                aria-hidden="true"
                            >
                                <path
                                    d="M5 15 15 5M7 5h8v8"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </span>
                    </div>

                    <!-- Content -->
                    <div class="mt-8">
                        <h3
                            class="text-lg font-semibold tracking-tight text-slate-950"
                        >
                            {{ $t(`about.values.${item.key}.title`) }}
                        </h3>

                        <p
                            class="mt-2 text-sm leading-6 text-slate-600"
                        >
                            {{
                                $t(
                                    `about.values.${item.key}.description`,
                                )
                            }}
                        </p>
                    </div>

                    <!-- Bottom accent -->
                    <div
                        class="absolute bottom-0 left-0 h-0.5 w-0 bg-slate-950 transition-all duration-300 group-hover:w-full"
                    ></div>
                </article>
            </div>
        </div>
    </section>
</template>

<script setup>
const values = [
    {
        key: 'quality',
        number: '01',
    },
    {
        key: 'innovation',
        number: '02',
    },
    {
        key: 'reliability',
        number: '03',
    },
    {
        key: 'partnership',
        number: '04',
    },
];
</script>
