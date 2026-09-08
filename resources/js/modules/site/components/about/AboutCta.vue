<template>
    <section class="bg-slate-50">
        <div
            class="mx-auto max-w-7xl px-6 py-16 sm:px-8 lg:px-10 lg:py-24"
        >
            <div
                class="relative overflow-hidden rounded-[2rem] bg-white px-7 py-12 shadow-sm ring-1 ring-slate-200 sm:px-12 sm:py-16 lg:px-16"
            >
                <!-- Grid -->
                <div
                    class="pointer-events-none absolute inset-0 opacity-40"
                    aria-hidden="true"
                >
                    <div
                        class="absolute inset-0"
                        style="
                            background-image:
                                linear-gradient(#e2e8f0 1px, transparent 1px),
                                linear-gradient(90deg, #e2e8f0 1px, transparent 1px);
                            background-size: 56px 56px;
                            mask-image: linear-gradient(to right, transparent, black, transparent);
                        "
                    ></div>
                </div>

                <div
                    class="relative grid gap-10 lg:grid-cols-[1fr_auto] lg:items-end"
                >
                    <div class="max-w-3xl">
                        <div
                            class="flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500"
                        >
                            <span class="h-px w-8 bg-slate-900"></span>

                            {{ $t('about.cta.eyebrow') }}
                        </div>

                        <h2
                            class="mt-5 text-3xl font-semibold leading-tight tracking-[-0.04em] text-slate-950 sm:text-4xl lg:text-5xl"
                        >
                            {{ $t('about.cta.title') }}
                        </h2>

                        <p
                            class="mt-5 max-w-2xl text-sm leading-6 text-slate-600 sm:text-base"
                        >
                            {{ $t('about.cta.description') }}
                        </p>
                    </div>

                    <div
                        class="flex flex-col gap-3 sm:flex-row lg:flex-col"
                    >
                        <RouterLink
                            to="/products"
                            class="inline-flex items-center justify-center gap-3 rounded-xl bg-slate-950 px-6 py-3.5 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-slate-800"
                        >
                            {{ $t('about.cta.products') }}

                            <svg
                                class="h-4 w-4"
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

                        <RouterLink
                            to="/contacts"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-6 py-3.5 text-sm font-semibold text-slate-950 transition hover:-translate-y-0.5 hover:border-slate-300 hover:bg-slate-50"
                        >
                            {{ $t('about.cta.contacts') }}
                        </RouterLink>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

