<template>
    <article
        class="group grid gap-5 py-7 sm:grid-cols-[70px_1fr] sm:gap-8"
    >
        <div
            class="font-mono text-[11px] font-medium text-slate-500"
        >
            {{ number }}
        </div>

        <div>
            <div class="flex items-center gap-3">
                <span
                    class="h-1.5 w-1.5 rounded-full bg-slate-300 transition-colors group-hover:bg-slate-900"
                ></span>

                <h3
                    class="text-lg font-semibold tracking-[-0.02em] text-slate-900"
                >
                    {{ title }}
                </h3>
            </div>

            <p
                class="mt-3 max-w-2xl text-sm leading-6 text-slate-600"
            >
                {{ description }}
            </p>
        </div>
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