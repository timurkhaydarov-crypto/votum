<template>
    <div class="mb-6">
        <!-- EYEBROW -->
        <div
            v-if="eyebrow"
            class="mb-1 text-[9px] font-semibold uppercase tracking-[0.14em] text-slate-400"
        >
            {{ eyebrow }}
        </div>

        <!-- TITLE ROW -->
        <div class="flex items-center justify-between gap-4">
            <!-- TITLE + ACTIONS -->
            <div class="flex min-w-0 items-center gap-2">
                <h2
                    class="text-lg font-bold tracking-tight text-slate-900"
                >
                    {{ title }}
                </h2>

                <!-- ACTIONS -->
                <div
                    v-if="$slots.actions"
                    class="flex shrink-0 items-center"
                >
                    <slot name="actions" />
                </div>
            </div>

            <!-- META -->
            <div
                v-if="$slots.meta"
                class="shrink-0 text-[10px] font-medium uppercase tracking-[0.08em] text-slate-400"
            >
                <slot name="meta" />
            </div>
        </div>

        <!-- DESCRIPTION -->
        <p
            v-if="description"
            class="mt-1 text-xs leading-relaxed text-slate-500"
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