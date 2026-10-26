<template>
    <button
        type="button"
        class="inline-flex cursor-pointer h-3 w-3 items-center justify-center rounded transition hover:bg-slate-800 hover:text-amber-300"
        :aria-label="label || t('actions.edit')"
        @click="$emit('click')"
    >
        <i class="bi bi-pencil text-[12px] leading-none" aria-hidden="true"></i>
    </button>
</template>

<script setup>
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

defineProps({
    label: {
        type: String,
        default: '',
    },
});

defineEmits(['click']);
</script>
