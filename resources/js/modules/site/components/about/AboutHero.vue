<template>
    <section
        class="relative overflow-hidden border-b border-slate-200 bg-white"
    >
        <div
            class="mx-auto grid max-w-7xl gap-12 px-6 py-20 sm:px-8 lg:grid-cols-[1.05fr_0.95fr] lg:items-center lg:px-10 lg:py-28"
        >
            <div>
                <p
                    class="mb-5 text-sm font-semibold uppercase tracking-[0.2em] text-slate-500"
                >
                    {{ t('about.hero.eyebrow') }}
                </p>

                <h1
                    class="max-w-3xl text-4xl font-semibold tracking-tight text-slate-950 sm:text-5xl lg:text-6xl"
                >
                    {{ t('about.hero.title') }}
                </h1>

                <p
                    class="mt-6 max-w-2xl text-base leading-7 text-slate-600 sm:text-lg"
                >
                    {{ t('about.hero.description') }}
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <RouterLink
                        to="/products"
                        class="inline-flex items-center justify-center rounded-xl bg-slate-950 px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-slate-800"
                    >
                        {{ t('about.hero.primaryButton') }}
                    </RouterLink>

                    <RouterLink
                        to="/contacts"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-6 py-3.5 text-sm font-semibold text-slate-900 transition hover:bg-slate-50"
                    >
                        {{ t('about.hero.secondaryButton') }}
                    </RouterLink>
                </div>

                <div
                    class="mt-12 grid max-w-2xl grid-cols-2 gap-x-8 gap-y-6 border-t border-slate-200 pt-8 sm:grid-cols-4"
                >
                    <div>
                        <div class="text-xl font-semibold text-slate-950">
                            {{ t('about.hero.stats.production.value') }}
                        </div>

                        <div class="mt-1 text-xs text-slate-500">
                            {{ t('about.hero.stats.production.label') }}
                        </div>
                    </div>

                    <div>
                        <div class="text-xl font-semibold text-slate-950">
                            {{ t('about.hero.stats.development.value') }}
                        </div>

                        <div class="mt-1 text-xs text-slate-500">
                            {{ t('about.hero.stats.development.label') }}
                        </div>
                    </div>

                    <div>
                        <div class="text-xl font-semibold text-slate-950">
                            {{ t('about.hero.stats.experience.value') }}
                        </div>

                        <div class="mt-1 text-xs text-slate-500">
                            {{ t('about.hero.stats.experience.label') }}
                        </div>
                    </div>

                    <div>
                        <div class="text-xl font-semibold text-slate-950">
                            {{ t('about.hero.stats.geography.value') }}
                        </div>

                        <div class="mt-1 text-xs text-slate-500">
                            {{ t('about.hero.stats.geography.label') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div
                    class="overflow-hidden rounded-[2rem] border border-slate-200 bg-slate-100"
                >
                    <img
                        :src="'/image/about/hero-about.webp'"
                        :alt="t('about.hero.imageAlt')"
                        class="aspect-[4/3] w-full object-cover"
                    />
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
</script>

