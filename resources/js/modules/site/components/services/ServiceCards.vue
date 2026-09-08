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

        <div
            class="grid gap-4"
            :class="gridClass"
        >
            <article
                v-for="(item, index) in items"
                :key="item.key"
                class="rounded-[1.5rem] border border-slate-200 bg-white p-7 transition duration-300 hover:-translate-y-1 hover:border-slate-300 hover:shadow-lg hover:shadow-slate-200/50"
            >
                <div class="font-mono text-xs text-slate-400">
                    {{ String(index + 1).padStart(2, '0') }}
                </div>

                <h3
                    class="mt-8 text-xl font-semibold tracking-tight text-slate-950"
                >
                    {{ $t(`${translationPrefix}.${item.key}.title`) }}
                </h3>

                <p
                    v-if="
                        $te(
                            `${translationPrefix}.${item.key}.description`
                        )
                    "
                    class="mt-3 text-sm leading-6 text-slate-600"
                >
                    {{ $t(`${translationPrefix}.${item.key}.description`) }}
                </p>
            </article>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
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

    columns: {
        type: Number,
        default: 3,
    },
});

const gridClass = computed(() => {
    const classes = {
        2: 'md:grid-cols-2',
        3: 'md:grid-cols-3',
        4: 'sm:grid-cols-2 lg:grid-cols-4',
    };

    return classes[props.columns] ?? classes[3];
});
</script>