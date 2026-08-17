<template>
    <div
        class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-md"
    >
        <div
            class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100 text-slate-700 transition group-hover:bg-slate-900 group-hover:text-white"
        >
            <i class="bi bi-check2"></i>
        </div>

        <div
            class="mt-4 text-sm font-semibold leading-6 text-slate-800"
        >
            {{ feature }}
        </div>
    </div>
</template>

<script setup>
defineProps({
    feature: {
        type: String,
        default: '',
    },
});
</script>