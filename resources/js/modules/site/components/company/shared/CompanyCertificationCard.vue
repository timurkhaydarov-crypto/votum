<template>
    <article
        class="group rounded-xl border border-white/25 p-5 transition-all duration-300 hover:border-white/60 hover:bg-white/10"
    >
        <div
            class="flex h-9 w-9 items-center justify-center rounded-lg border border-white/20 text-white/75 transition-colors group-hover:border-white/40 group-hover:text-white"
        >
            <i class="bi bi-check2 text-base"></i>
        </div>

        <h3
            class="mt-7 text-base font-semibold tracking-[-0.01em] text-white"
        >
            {{ title }}
        </h3>

        <p
            class="mt-3 text-sm leading-6 text-white/70"
        >
            {{ description }}
        </p>
    </article>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },

    description: {
        type: String,
        required: true,
    },
})
</script>