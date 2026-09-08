<template>
    <div
        class="grid gap-10 rounded-[2rem] border border-slate-200 bg-white p-7 shadow-sm sm:p-10 lg:grid-cols-[1.2fr_0.8fr] lg:p-14"
    >
        <!-- Content -->
        <div class="flex flex-col justify-center">
            <!-- Eyebrow -->
            <div
                class="flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500"
            >
                <span class="h-px w-8 bg-slate-900"></span>

                {{ $t(eyebrow) }}
            </div>

            <!-- Title -->
            <h1
                class="mt-5 max-w-3xl text-3xl font-semibold leading-tight tracking-[-0.04em] text-slate-950 sm:text-4xl lg:text-5xl"
            >
                {{ $t(title) }}
            </h1>

            <!-- Description -->
            <p
                class="mt-6 max-w-2xl text-sm leading-6 text-slate-600 sm:text-base"
            >
                {{ $t(description) }}
            </p>

            <!-- Actions -->
            <div class="mt-8 flex flex-wrap gap-3">
                <!-- Request -->
                <RouterLink
                    v-if="request"
                    :to="requestTo"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-slate-800"
                >
                    {{ $t(request) }}

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

        <!-- Image -->
        <div
            class="relative min-h-[260px] overflow-hidden rounded-[1.5rem] sm:min-h-[320px]"
        >
            <img
                :src="image"
                :alt="imageAlt ? $t(imageAlt) : ''"
                class="absolute inset-0 h-full w-full object-cover"
                loading="lazy"
            />

            <div
                class="absolute inset-0 bg-gradient-to-t from-slate-950/30 via-transparent to-transparent"
                aria-hidden="true"
            ></div>
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

    request: {
        type: String,
        default: '',
    },

    requestTo: {
        type: String,
        default: '/contacts',
    },

    servicesLabel: {
        type: String,
        default: '',
    },

    servicesTo: {
        type: String,
        default: '',
    },

    image: {
        type: String,
        required: true,
    },

    imageAlt: {
        type: String,
        default: '',
    },
});
</script>