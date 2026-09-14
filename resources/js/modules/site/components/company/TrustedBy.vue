<template>
    <section
        class="w-full border-y border-slate-200 bg-white"
    >
        <div
            class="mx-auto flex w-full max-w-7xl flex-col items-center px-6 py-8 sm:px-8 lg:px-10"
        >
            <!-- LABEL -->

            <div
                class="mb-6 flex items-center gap-3"
            >
                <span
                    class="h-px w-8 bg-slate-300"
                ></span>

                <p
                    class="text-center text-[10px] font-semibold uppercase tracking-[0.22em] text-slate-400"
                >
                    {{ t('trustedBy.eyebrow') }}
                </p>

                <span
                    class="h-px w-8 bg-slate-300"
                ></span>
            </div>

            <!-- TITLE -->

            <h2
                class="text-center text-[15px] font-medium tracking-[-0.01em] text-slate-700 sm:text-base"
            >
                {{ t('trustedBy.title') }}
            </h2>

            <!-- INDUSTRIES -->

            <div
                class="mt-7 flex w-full flex-wrap items-center justify-center gap-x-8 gap-y-4 sm:gap-x-10 lg:gap-x-14"
            >
                <div
                    v-for="industry in industries"
                    :key="industry.key"
                    class="group flex items-center gap-2"
                >
                    <!-- DOT -->

                    <span
                        class="h-1.5 w-1.5 shrink-0 rounded-full bg-slate-300 transition-all duration-300 group-hover:bg-slate-700 group-hover:scale-125"
                    ></span>

                    <!-- NAME -->

                    <span
                        class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-400 transition-colors duration-300 group-hover:text-slate-800 sm:text-[11px]"
                    >
                        {{ t(`trustedBy.industries.${industry.key}`) }}
                    </span>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const industries = [
    {
        key: 'aerospace',
    },
    {
        key: 'railway',
    },
    {
        key: 'composites',
    },
    {
        key: 'oilGas',
    },
];
</script>