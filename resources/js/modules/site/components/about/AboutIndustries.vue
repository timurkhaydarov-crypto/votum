<template>
    <section class="bg-slate-50">
        <div
            class="mx-auto max-w-7xl px-6 py-16 sm:px-8 lg:px-10 lg:py-20"
        >
            <!-- Header -->
            <div
                class="mb-10 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between"
            >
                <div>
                    <div
                        class="flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500"
                    >
                        <span class="h-px w-8 bg-slate-900"></span>

                        {{ $t('about.industries.eyebrow') }}
                    </div>

                    <h2
                        class="mt-4 max-w-xl text-3xl font-semibold tracking-[-0.035em] text-slate-950 sm:text-4xl"
                    >
                        {{ $t('about.industries.title') }}
                    </h2>
                </div>

                <p
                    class="max-w-xl text-sm leading-6 text-slate-600 sm:text-base"
                >
                    {{ $t('about.industries.description') }}
                </p>
            </div>

            <!-- Industries -->
            <div
                class="grid overflow-hidden rounded-2xl border border-slate-200 bg-white sm:grid-cols-2 lg:grid-cols-4"
            >
                <article
                    v-for="item in industries"
                    :key="item.key"
                    class="group relative min-h-[180px] border-b border-slate-200 bg-white p-6 transition duration-300 hover:bg-slate-50 sm:min-h-[190px] sm:border-r last:border-r-0 sm:[&:nth-child(2)]:border-r-0 lg:border-b-0 lg:border-r lg:[&:nth-child(2)]:border-r lg:[&:nth-child(3)]:border-r lg:[&:nth-child(4)]:border-r-0"
                >
                    <!-- Top -->
                    <div class="flex items-center justify-between">
                        <span
                            class="font-mono text-xs text-slate-400 transition-colors duration-300 group-hover:text-slate-900"
                        >
                            {{ item.number }}
                        </span>

                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-full border border-slate-200 text-slate-400 transition duration-300 group-hover:border-slate-950 group-hover:bg-slate-950 group-hover:text-white"
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
                    <div class="absolute bottom-6 left-6 right-6">
                        <h3
                            class="text-lg font-semibold tracking-tight text-slate-950 sm:text-xl"
                        >
                            {{ $t(`about.industries.${item.key}`) }}
                        </h3>

                        <div
                            class="mt-4 h-px w-8 bg-slate-300 transition-all duration-300 group-hover:w-full group-hover:bg-slate-950"
                        ></div>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>

<script setup>
const industries = [
    {
        key: 'aviation',
        number: '01',
    },
    {
        key: 'railway',
        number: '02',
    },
    {
        key: 'industry',
        number: '03',
    },
    {
        key: 'energy',
        number: '04',
    },
];
</script>

