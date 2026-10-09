<template>
    <div class="flex items-center gap-3">
        <span
            :class="[
                'font-mono text-[10px] font-medium',
                dark ? 'text-white/65' : 'text-slate-500',
            ]"
        >
            <!-- {{ number }} -->
        </span>

        <span
            :class="[
                'h-px w-8',
                dark ? 'bg-white/30' : 'bg-slate-300',
            ]"
        ></span>

        <span
            :class="[
                'text-[10px] font-semibold uppercase tracking-[0.2em]',
                dark ? 'text-white/75' : 'text-slate-600',
            ]"
        >
            {{ label }}
        </span>
    </div>
</template>

<script setup>
defineProps({
    number: {
        type: String,
        required: true,
    },

    label: {
        type: String,
        required: true,
    },

    dark: {
        type: Boolean,
        default: false,
    },
})
</script>