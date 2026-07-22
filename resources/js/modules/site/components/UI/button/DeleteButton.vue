<template>
    <button
        type="button"
        class="inline-flex cursor-pointer h-3 w-3 items-center justify-center rounded transition hover:bg-slate-800 hover:text-red-400"
        :aria-label="label"
        @click="$emit('click')"
    >
        <i class="bi bi-trash text-[12px] leading-none" aria-hidden="true"></i>
    </button>
</template>

<script setup>
defineProps({
    label: {
        type: String,
        default: 'Удалить',
    },
});

defineEmits(['click']);
</script>
