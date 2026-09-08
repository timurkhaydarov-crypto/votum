<template>
    <section class="p-6 text-center sm:p-8">
        <!-- ICON -->
        <div
            class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-50 text-emerald-600"
        >
            <i class="bi bi-check-lg text-3xl"></i>
        </div>

    <!-- TITLE -->
    <h2
        class="mt-5 text-xl font-semibold tracking-tight text-slate-900"
    >
        {{ t('request.success.title') }}
    </h2>

    <p
        class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500"
    >
        {{ t('request.success.description') }}
    </p>

    <!-- REQUEST NUMBER -->
    <div
        v-if="request?.number"
        class="mt-6 rounded-xl border border-slate-200 bg-slate-50 px-5 py-4"
    >
        <div
            class="text-[9px] font-semibold uppercase tracking-[0.15em] text-slate-400"
        >
            {{ t('request.success.numberLabel') }}
        </div>

        <div
            class="mt-1 text-lg font-bold tracking-tight text-slate-900"
        >
            {{ request.number }}
        </div>
    </div>

    <!-- CLOSE -->
    <button
        type="button"
        class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-slate-900 px-4 py-3 text-xs font-semibold text-white shadow-sm transition-all duration-200 hover:bg-slate-800 hover:shadow-md active:scale-[0.98]"
        @click="emit('close')"
    >
        {{ t('request.success.close') }}

        <i class="bi bi-arrow-right text-sm"></i>
    </button>
</section>

</template>

<script setup>
import { useI18n } from 'vue-i18n';

defineProps({
    request: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits([
    'close',
]);

const { t } = useI18n();
</script>
