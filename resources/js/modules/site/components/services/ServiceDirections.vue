<template>
    <section class="mt-20">
        <!-- Header -->
        <div class="mb-10">
            <div class="flex items-center gap-4">
                <span
                    class="font-mono text-xs font-medium tracking-[0.2em] text-slate-400"
                >
                    02
                </span>

                <span class="h-px w-10 bg-slate-900"></span>

                <span
                    class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500"
                >
                    {{ $t(eyebrow) }}
                </span>
            </div>

            <h2
                class="mt-6 max-w-3xl text-3xl font-semibold leading-tight tracking-[-0.045em] text-slate-950 sm:text-4xl lg:text-5xl"
            >
                {{ $t(title) }}
            </h2>
        </div>

        <!-- Directions -->
        <div
            class="grid gap-px overflow-hidden rounded-[2rem] border border-slate-200 bg-slate-200 md:grid-cols-3"
        >
            <article
                v-for="(item, index) in items"
                :key="item.key"
                class="group relative bg-white p-7 sm:p-9 lg:p-10"
            >
                <!-- Number -->
                <div
                    class="flex items-center justify-between"
                >
                    <span
                        class="font-mono text-sm tracking-[0.15em] text-slate-400"
                    >
                        {{ String(index + 1).padStart(2, '0') }}
                    </span>

                    <span
                        class="h-1.5 w-1.5 rounded-full bg-slate-300 transition-colors duration-300 group-hover:bg-slate-950"
                        aria-hidden="true"
                    ></span>
                </div>

                <!-- Content -->
                <div class="mt-12">
                    <h3
                        class="text-xl font-semibold leading-snug tracking-[-0.025em] text-slate-950 sm:text-2xl"
                    >
                        {{ $t(`${translationPrefix}.${item.key}.title`) }}
                    </h3>

                    <p
                        v-if="
                            $te(
                                `${translationPrefix}.${item.key}.description`
                            )
                        "
                        class="mt-4 text-sm leading-6 text-slate-600 sm:text-base sm:leading-7"
                    >
                        {{
                            $t(
                                `${translationPrefix}.${item.key}.description`
                            )
                        }}
                    </p>
                </div>

                <!-- Technical marker -->
                <div
                    class="mt-10 flex items-center gap-3"
                    aria-hidden="true"
                >
                    <span class="h-px w-8 bg-slate-300"></span>

                    <span
                        class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-400"
                    >
                        NDT
                    </span>
                </div>
            </article>
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

    items: {
        type: Array,
        default: () => [],
    },

    translationPrefix: {
        type: String,
        required: true,
    },
});
</script>

