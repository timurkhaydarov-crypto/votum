<template>
    <div class="mb-5">
        <div
            v-if="eyebrow"
            class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400"
        >
            {{ eyebrow }}
        </div>

        <h2
            v-if="title"
            class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"
        >
            {{ title }}
        </h2>

        <p
            v-if="description"
            class="mt-2 max-w-2xl text-sm leading-6 text-slate-500"
        >
            {{ description }}
        </p>
    </div>
</template>

<script setup>
defineProps({
    eyebrow: {
        type: String,
        default: '',
    },

    title: {
        type: String,
        default: '',
    },

    description: {
        type: String,
        default: '',
    },
});
</script>