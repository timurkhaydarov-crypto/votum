<template>
    <div class="flex flex-col justify-center py-7 first:pt-7 lg:py-8">
        <div
            class="text-4xl font-semibold leading-none tracking-[-0.04em] text-slate-900 sm:text-5xl"
        >
            {{ value }}
        </div>

        <div
            class="mt-3 text-xs font-medium uppercase tracking-[0.12em] text-slate-500"
        >
            {{ label }}
        </div>
    </div>
</template>

<script setup>
defineProps({
    value: {
        type: String,
        required: true,
    },

    label: {
        type: String,
        required: true,
    },
})
</script>