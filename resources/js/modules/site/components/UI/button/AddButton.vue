<template>
    <button
        type="button"
        class="inline-flex w-full font-bold cursor-pointer items-center justify-center rounded transition hover:text-emerald-300 font-bold"
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
});
defineEmits(['click']);
</script>
