<template>
    <section class="bg-white">
        <div
            class="mx-auto max-w-7xl px-5 pb-12 sm:px-8 sm:pb-16 lg:px-10 lg:pb-20"
        >
            <div
                class="mb-8 flex flex-col gap-4 sm:mb-10 sm:flex-row sm:items-end sm:justify-between"
            >
                <div>
                    <div
                        class="mb-4 flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500"
                    >
                        <span
                            class="h-px w-8 bg-slate-900"
                            aria-hidden="true"
                        />

                        {{ $t('contacts.dealers.eyebrow') }}
                    </div>

                    <h2
                        class="text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl"
                    >
                        {{ $t('contacts.dealers.title') }}
                    </h2>
                </div>

                <p class="max-w-md text-sm leading-6 text-slate-500">
                    {{ $t('contacts.dealers.description') }}
                </p>
            </div>

            <div
                class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
            >
                <button
                    v-for="dealer in dealers"
                    :key="dealer.id"
                    type="button"
                    class="group flex w-full items-center gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-left transition duration-300 hover:-translate-y-0.5 hover:border-slate-300 hover:bg-white hover:shadow-md focus:outline-none focus:ring-2 focus:ring-slate-950 focus:ring-offset-2"
                    @click="$emit('select', dealer)"
                >
                    <!-- Flag -->
                    <div
                        class="flex h-11 w-14 shrink-0 items-center justify-center overflow-hidden rounded-lg border border-slate-200 bg-white p-1.5"
                    >
                        <img
                            :src="dealer.flag"
                            :alt="$t(`contacts.dealers.countries.${dealer.country}`)"
                            class="max-h-full max-w-full object-contain"
                            loading="lazy"
                        />
                    </div>

                    <!-- Country -->
                    <div class="min-w-0 flex-1">
                        <h3
                            class="truncate text-sm font-semibold text-slate-950"
                        >
                            {{ $t(`contacts.dealers.countries.${dealer.country}`) }}
                        </h3>

                        <p class="mt-1 text-xs text-slate-400">
                            <template v-if="dealer.locations.length">
                                {{ dealer.locations.length }}
                                {{ locationWord(dealer.locations.length) }}
                            </template>

                            <template v-else>
                                {{ $t('contacts.dealers.noInformation') }}
                            </template>
                        </p>
                    </div>

                    <!-- Arrow -->
                    <span
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white text-slate-400 transition group-hover:bg-slate-950 group-hover:text-white"
                    >
                        <svg
                            viewBox="0 0 16 16"
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                        >
                            <path d="M4 8h8M8 4l4 4-4 4" />
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </section>
</template>

<script setup>
defineProps({
    dealers: {
        type: Array,
        default: () => [],
    },
});

defineEmits(['select']);

const locationWord = (count) => {
    return count === 1 ? 'location' : 'locations';
};
</script>