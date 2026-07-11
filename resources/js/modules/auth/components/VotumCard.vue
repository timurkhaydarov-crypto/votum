<template>
    <section class="w-full max-w-md rounded-2xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/70 sm:p-8">
        <header>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-900">
                {{ title }}
            </h2>
            <p v-if="subtitle" class="mt-2 text-sm leading-relaxed text-slate-600">
                {{ subtitle }}
            </p>
        </header>

        <div class="mt-6">
            <slot />
        </div>

        <footer v-if="$slots.footer" class="mt-6 border-t border-slate-100 pt-4 text-sm text-slate-600">
            <slot name="footer" />
        </footer>
    </section>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    subtitle: {
        type: String,
        default: '',
    },
});
</script>
