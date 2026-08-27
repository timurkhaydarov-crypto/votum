<template>
    <div
        v-if="methodsList.length"
        class="absolute right-4 top-4 z-20 flex items-center gap-1.5"
    >
        <div
            v-for="method in methodsList"
            :key="method.code"
            class="group/method relative flex h-8 w-8 cursor-default items-center justify-center rounded-lg border border-white/80 bg-white/85 text-slate-500 shadow-md backdrop-blur-md transition-colors duration-200 hover:border-slate-300 hover:text-slate-900"
        >
            <i
                :class="[
                    'bi',
                    method.icon,
                    'text-[13px]',
                ]"
            ></i>

            <!-- TOOLTIP -->
            <div
                class="pointer-events-none absolute right-0 top-full mt-2 w-[340px] translate-y-1 rounded-xl border border-slate-200 bg-white p-4 text-left opacity-0 shadow-xl transition-all duration-200 group-hover/method:translate-y-0 group-hover/method:opacity-100"
            >
                <!-- HEADER -->
                <div class="flex items-center gap-2">
                    <span
                        class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-600"
                    >
                        <i
                            :class="[
                                'bi',
                                method.icon,
                                'text-[13px]',
                            ]"
                        ></i>
                    </span>

                    <div>
                        <div
                            class="text-[10px] font-bold uppercase tracking-[0.08em] text-slate-900"
                        >
                            {{ method.title }}
                        </div>

                        <div
                            class="mt-0.5 text-[9px] font-semibold uppercase tracking-[0.1em] text-slate-400"
                        >
                            {{ method.code }}
                        </div>
                    </div>
                </div>

                <!-- DESCRIPTION -->
                <div
                v
                    class="mt-3 text-[11px] leading-[1.65] text-slate-500"
                >
                    {{ method.description }}
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

import { controlMethods } from '../../../constants/controlMethods.js';

const { locale } = useI18n();

const props = defineProps({
    methods: {
        type: String,
        default: '',
    },
});

const methodsList = computed(() => {
    if (!props.methods) {
        return [];
    }

    return props.methods
        .split(',')
        .map((method) => method.trim().toUpperCase())
        .filter((code) => controlMethods[code])
        .map((code) => {
            const method = controlMethods[code];

            return {
                code,
                icon: method.icon,

                title:
                    method.title[locale.value] ||
                    method.title.en,

                description:
                    method.description[locale.value] ||
                    method.description.en,
            };
        });
});
</script>