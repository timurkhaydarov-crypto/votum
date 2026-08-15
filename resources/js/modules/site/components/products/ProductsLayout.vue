<template>
    <section class="min-h-screen bg-slate-100 px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto w-full max-w-6xl">
            <header class="mb-6">
                <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">
                    {{ title }}
                </h1>

                <p
                    v-if="subtitle"
                    class="mt-2 text-sm text-slate-600"
                >
                    {{ subtitle }}
                </p>
            </header>

            <slot />
        </div>
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
