<template>
    <article
        class="bg-white p-6 transition-colors hover:bg-slate-50 sm:p-7 lg:p-8"
    >
        <div
            class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-700"
        >
            <i :class="['bi', icon, 'text-base']"></i>
        </div>

        <div class="mt-7">
            <div
                class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500"
            >
                {{ label }}
            </div>

            <div
                class="mt-2 text-base font-semibold leading-6 text-slate-900"
            >
                {{ value }}
            </div>
        </div>
    </article>
</template>

<script setup>
defineProps({
    label: {
        type: String,
        required: true,
    },

    value: {
        type: String,
        required: true,
    },

    icon: {
        type: String,
        required: true,
    },
})
</script>