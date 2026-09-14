<template>
    <article
        class="group bg-white p-6 transition-colors duration-300 hover:bg-slate-900 sm:p-7 lg:p-8"
    >
        <div class="flex items-center justify-between">
            <span
                class="font-mono text-[10px] font-medium text-slate-500 transition-colors duration-300 group-hover:text-white/60"
            >
                {{ number }}
            </span>

            <span
                class="h-1.5 w-1.5 rounded-full bg-slate-300 transition-all duration-300 group-hover:scale-125 group-hover:bg-white/70"
            ></span>
        </div>

        <h3
            class="mt-12 text-lg font-semibold tracking-[-0.02em] text-slate-900 transition-colors duration-300 group-hover:text-white"
        >
            {{ title }}
        </h3>

        <p
            class="mt-4 text-sm leading-6 text-slate-600 transition-colors duration-300 group-hover:text-white/70"
        >
            {{ description }}
        </p>
    </article>
</template>

<script setup>
defineProps({
    number: {
        type: String,
        required: true,
    },

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