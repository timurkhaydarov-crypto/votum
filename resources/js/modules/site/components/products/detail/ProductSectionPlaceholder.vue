<template>
    <section
        class="overflow-hidden rounded-2xl border border-dashed border-slate-300 bg-slate-50/70"
    >
        <div class="flex flex-col items-center justify-center px-6 py-10 text-center sm:py-12">
            <!-- ICON -->
            <div
                class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-slate-400 shadow-sm ring-1 ring-slate-200"
            >
                <i :class="['bi', icon, 'text-2xl']"></i>
            </div>

            <!-- TITLE -->
            <h2 class="mt-4 text-sm font-semibold text-slate-800">
                {{ title }}
            </h2>

            <!-- DESCRIPTION -->
            <p
                v-if="description"
                class="mt-1.5 max-w-md text-xs leading-5 text-slate-500"
            >
                {{ description }}
            </p>

            <!-- ACTION -->
            <button
                type="button"
                class="mt-5 inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2.5 text-[10px] font-semibold uppercase tracking-[0.08em] text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-slate-800 hover:shadow-md active:translate-y-0"
                @click="$emit('click')"
            >
                <i :class="['bi', buttonIcon]"></i>
                {{ t('actions.add') }}
            </button>
        </div>
    </section>
</template>

<script setup>
import { useI18n } from 'vue-i18n';

defineProps({
    icon: {
        type: String,
        default: 'bi-plus-circle',
    },

    title: {
        type: String,
        required: true,
    },

    description: {
        type: String,
        default: '',
    },

    buttonIcon: {
        type: String,
        default: 'bi-plus-lg',
    },
});

defineEmits(['click']);

const { t } = useI18n();
</script>