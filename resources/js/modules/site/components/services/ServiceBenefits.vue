<template>
    <div class="mt-20">
        <div class="mb-8">
            <div
                class="flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500"
            >
                <span class="h-px w-8 bg-slate-900"></span>

                {{ $t(eyebrow) }}
            </div>

            <h2
                class="mt-5 text-3xl font-semibold tracking-[-0.035em] text-slate-950 sm:text-4xl"
            >
                {{ $t(title) }}
            </h2>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <article
                v-for="(item, index) in items"
                :key="item.key"
                class="rounded-[1.5rem] border border-slate-200 bg-white p-6"
            >
                <div class="font-mono text-xs text-slate-400">
                    {{ String(index + 1).padStart(2, '0') }}
                </div>

                <h3
                    class="mt-7 text-lg font-semibold tracking-tight text-slate-950"
                >
                    {{ $t(`${translationPrefix}.${item.key}.title`) }}
                </h3>

                <p
                    v-if="
                        $te(
                            `${translationPrefix}.${item.key}.description`
                        )
                    "
                    class="mt-2 text-sm leading-6 text-slate-600"
                >
                    {{ $t(`${translationPrefix}.${item.key}.description`) }}
                </p>
            </article>
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