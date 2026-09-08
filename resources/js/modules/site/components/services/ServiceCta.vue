<template>
    <div
        class="relative mt-20 overflow-hidden rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-slate-200 sm:p-12 lg:p-14"
    >
        <!-- Grid -->
        <div
            class="pointer-events-none absolute inset-0 opacity-40"
            aria-hidden="true"
        >
            <div
                class="absolute inset-0"
                style="
                    background-image:
                        linear-gradient(#e2e8f0 1px, transparent 1px),
                        linear-gradient(90deg, #e2e8f0 1px, transparent 1px);
                    background-size: 56px 56px;
                    mask-image: linear-gradient(
                        to right,
                        transparent,
                        black,
                        transparent
                    );
                "
            ></div>
        </div>

        <!-- Content -->
        <div
            class="relative grid gap-8 lg:grid-cols-[1fr_auto] lg:items-end"
        >
            <div class="max-w-3xl">
                <div
                    class="flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500"
                >
                    <span class="h-px w-8 bg-slate-900"></span>

                    {{ $t(eyebrow) }}
                </div>

                <h2
                    class="mt-5 text-3xl font-semibold leading-tight tracking-[-0.04em] text-slate-950 sm:text-4xl"
                >
                    {{ $t(title) }}
                </h2>

                <p
                    class="mt-4 max-w-2xl text-sm leading-6 text-slate-600 sm:text-base"
                >
                    {{ $t(description) }}
                </p>
            </div>

            <RouterLink
                :to="to"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-950 px-6 py-3.5 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-slate-800"
            >
                {{ $t(button) }}

                <svg
                    class="h-4 w-4"
                    viewBox="0 0 20 20"
                    fill="none"
                    aria-hidden="true"
                >
                    <path
                        d="M4 10h11M10 5l5 5-5 5"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </RouterLink>
        </div>
    </div>
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

    button: {
        type: String,
        required: true,
    },

    to: {
        type: String,
        default: '/contacts',
    },
});
</script>