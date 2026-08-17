<template>
    <div
        class="flex items-start gap-4"
    >
        <div
            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-700"
        >
            <i class="bi bi-exclamation-circle"></i>
        </div>

        <div class="min-w-0">
            <div
                class="text-sm font-semibold text-slate-800"
            >
                {{ title }}
            </div>

            <p
                v-if="text"
                class="mt-1 text-xs leading-5 text-slate-500"
            >
                {{ text }}
            </p>
        </div>
    </div>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        default: 'Информация отсутствует',
    },

    text: {
        type: String,
        default: '',
    },
});
</script>