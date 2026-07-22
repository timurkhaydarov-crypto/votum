<template>
    <div
        class="fixed left-1/2 top-4 z-50 w-[calc(100%-2rem)] max-w-md -translate-x-1/2 rounded-lg border px-4 py-3 text-sm shadow-lg"
        :class="variantClass"
        role="alert"
    >
        {{ message }}
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    type: {
        type: String,
        default: 'success',
        validator: (value) => ['success', 'warning', 'error'].includes(value),
    },
    message: {
        type: String,
        default: '',
    },
});

const variantClass = computed(() => {
    if (props.type === 'warning') {
        return 'border-amber-200 bg-amber-50 text-amber-800';
    }

    if (props.type === 'error') {
        return 'border-rose-200 bg-rose-50 text-rose-800';
    }

    return 'border-emerald-200 bg-emerald-50 text-emerald-800';
});
</script>
