<template>
    <component
        :is="href ? 'a' : 'div'"
        v-bind="href
            ? {
                href,
                target: '_blank',
                rel: 'noopener noreferrer',
            }
            : {}"
        :class="[
            'group rounded-2xl border p-5 transition',
            available
                ? 'border-slate-200 bg-white shadow-sm hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-md'
                : 'border-amber-200 bg-amber-50/40',
        ]"
    >
        <div class="flex items-start justify-between gap-4">
            <div
                :class="[
                    'flex h-10 w-10 items-center justify-center rounded-xl',
                    available
                        ? 'bg-slate-100 text-slate-700 group-hover:bg-slate-900 group-hover:text-white'
                        : 'bg-amber-100 text-amber-700',
                ]"
            >
                <i :class="`bi ${icon}`"></i>
            </div>

            <i
                :class="[
                    'bi bi-arrow-up-right text-sm',
                    available
                        ? 'text-slate-400'
                        : 'text-amber-500',
                ]"
            ></i>
        </div>

        <h3 class="mt-5 text-sm font-bold text-slate-900">
            {{ title }}
        </h3>

        <p class="mt-1.5 text-xs leading-5 text-slate-500">
            {{ description }}
        </p>

        <div
            v-if="!available"
            class="mt-4 text-[10px] font-semibold uppercase tracking-wider text-amber-700"
        >
            Ссылка отсутствует
        </div>
    </component>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    title: {
        type: String,
        default: '',
    },

    description: {
        type: String,
        default: '',
    },

    icon: {
        type: String,
        default: '',
    },

    href: {
        type: String,
        default: '',
    },
});

const available = computed(() => {
    return Boolean(props.href);
});
</script>