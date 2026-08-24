<template>
    <div
        class="flex flex-col items-center justify-center py-12 text-center"
    >
        <div
            class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-slate-400"
        >
            <i class="bi bi-info-circle text-xl"></i>
        </div>

        <p class="text-sm font-medium text-slate-700">
            {{ title }}
        </p>

        <p
            v-if="description"
            class="mt-1 max-w-sm text-xs leading-5 text-slate-400"
        >
            {{ description }}
        </p>
    </div>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        default: 'Информация отсутствует',
    },

    description: {
        type: String,
        default: '',
    },
});
</script>