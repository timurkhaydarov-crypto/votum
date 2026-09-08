<template>
    <section class="relative mt-20">
        <div
            class="grid gap-10 lg:grid-cols-[0.8fr_1.2fr] lg:gap-24"
        >
            <!-- Left -->
            <div>
                <div class="flex items-center gap-4">

                    <span class="h-px w-10 bg-slate-900"></span>

                    <span
                        class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500"
                    >
                        {{ $t(eyebrow) }}
                    </span>
                </div>

                <h2
                    class="mt-7 max-w-xl text-3xl font-semibold leading-[1.08] tracking-[-0.045em] text-slate-950 sm:text-4xl lg:text-5xl"
                >
                    {{ $t(title) }}
                </h2>
            </div>

            <!-- Right -->
            <div class="flex items-center lg:pt-8">
                <div
                    class="relative border-l-2 border-slate-950 pl-7 sm:pl-9"
                >
                    <p
                        class="max-w-2xl text-base leading-7 text-slate-600 sm:text-lg sm:leading-8"
                    >
                        {{ $t(description) }}
                    </p>

                    <!-- Technical marker -->
                    <div
                        class="mt-8 flex items-center gap-3"
                        aria-hidden="true"
                    >
                        <span class="h-px w-12 bg-slate-300"></span>

                        <span
                            class="font-mono text-[10px] uppercase tracking-[0.2em] text-slate-400"
                        >
                            TECH
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
defineProps({
    eyebrow: {
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
});
</script>

