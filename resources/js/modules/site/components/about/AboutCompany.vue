<template>
    <section class="bg-white">
        <div
            class="mx-auto grid max-w-7xl gap-12 px-6 py-20 sm:px-8 lg:grid-cols-2 lg:items-center lg:px-10 lg:py-28"
        >
            <div class="overflow-hidden rounded-[2rem] bg-slate-100">
                <img
                    :src="'/image/about/about_development.webp'"
                    :alt="t('about.company.imageAlt')"
                    class="aspect-[4/3] w-full object-cover"
                />
            </div>

            <div>
                <p
                    class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500"
                >
                    {{ t('about.company.eyebrow') }}
                </p>

                <h2
                    class="mt-4 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl"
                >
                    {{ t('about.company.title') }}
                </h2>

                <p
                    class="mt-6 text-lg leading-8 text-slate-700"
                >
                    {{ t('about.company.description') }}
                </p>

                <p
                    class="mt-5 leading-7 text-slate-600"
                >
                    {{ t('about.company.text') }}
                </p>

                <p
                    class="mt-5 leading-7 text-slate-600"
                >
                    {{ t('about.company.additionalText') }}
                </p>

                <div class="mt-10 grid gap-6 sm:grid-cols-3">
                    <div>
                        <h3 class="font-semibold text-slate-950">
                            {{ t('about.company.highlights.development.title') }}
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            {{ t('about.company.highlights.development.description') }}
                        </p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-slate-950">
                            {{ t('about.company.highlights.production.title') }}
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            {{ t('about.company.highlights.production.description') }}
                        </p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-slate-950">
                            {{ t('about.company.highlights.expertise.title') }}
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            {{ t('about.company.highlights.expertise.description') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
</script>

