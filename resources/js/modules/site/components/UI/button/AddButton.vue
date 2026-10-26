<template>
    <button
        type="button"
        :class="`${customClass} inline-flex font-bold cursor-pointer items-center justify-center rounded transition hover:text-emerald-300 font-bold`"
        :aria-label="label || t('actions.add')"
        @click="$emit('click')"
    >
        <i class="bi bi-plus-lg text-[14px] leading-none font-bold" aria-hidden="true"></i>
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
    customClass: {
        type: String,
        default: '',
    },
});
defineEmits(['click']);
</script>
