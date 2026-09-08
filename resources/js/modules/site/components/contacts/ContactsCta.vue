<template>
    <section class="bg-slate-950 text-white">
        <div
            class="mx-auto max-w-7xl px-5 py-12 sm:px-8 sm:py-16 lg:px-10"
        >
            <div
                class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between"
            >
                <div class="max-w-2xl">
                    <div
                        class="mb-4 text-xs font-semibold uppercase tracking-[0.18em] text-slate-400"
                    >
                        {{ $t('contacts.cta.eyebrow') }}
                    </div>

                    <h2
                        class="text-2xl font-semibold tracking-tight sm:text-3xl"
                    >
                        {{ $t('contacts.cta.title') }}
                    </h2>

                    <p
                        class="mt-3 max-w-xl text-sm leading-6 text-slate-400 sm:text-base"
                    >
                        {{ $t('contacts.cta.description') }}
                    </p>
                </div>

                <RouterLink
                    to="/products"
                    class="hero-btn hero-btn--secondary inline-flex shrink-0 items-center justify-center gap-3 rounded-xl bg-white px-6 py-3.5 text-sm font-semibold text-slate-950 transition hover:bg-slate-100"
                >
                    {{ $t('contacts.cta.button') }}

                    <svg
                        viewBox="0 0 16 16"
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                    >
                        <path d="M3 8h9M8 4l4 4-4 4" />
                    </svg>
                </RouterLink>
            </div>
        </div>
    </section>
</template>