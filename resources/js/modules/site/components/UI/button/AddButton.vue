<template>
    <button
        type="button"
        :class="`${customClass} inline-flex font-bold cursor-pointer items-center justify-center rounded transition hover:text-emerald-300 font-bold`"
        :aria-label="label"
        @click="$emit('click')"
    >
        <i class="bi bi-plus-lg text-[14px] leading-none font-bold" aria-hidden="true"></i>
    </button>
</template>

<script setup>
defineProps({
    label: {
        type: String,
        default: 'Добавить',
    },
    customClass: {
        type: String,
        default: '',
    },
});
defineEmits(['click']);
</script>
