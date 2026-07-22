<template>
    <button
        type="button"
        class="inline-flex w-full font-bold bg-emerald-600 cursor-pointer h-7 w-7 items-center justify-center rounded transition hover:bg-emerald-500 hover:text-white"
        :aria-label="label"
        @click="$emit('click')"
    >
        <i class="bi bi-plus-lg text-[14px] leading-none" aria-hidden="true"></i>
    </button>
</template>

<script setup>
defineProps({
    label: {
        type: String,
        default: 'Добавить',
    },
});
defineEmits(['click']);
</script>
