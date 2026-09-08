<template>
    <Transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition duration-150 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div
            v-if="dealer"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/60 p-4 backdrop-blur-sm sm:p-6"
            @click.self="$emit('close')"
        >
            <Transition
                appear
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="scale-95 opacity-0"
                enter-to-class="scale-100 opacity-100"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="scale-100 opacity-100"
                leave-to-class="scale-95 opacity-0"
            >
                <div
                    v-if="dealer"
                    class="relative flex max-h-[90vh] w-full max-w-2xl flex-col overflow-hidden rounded-[2rem] bg-white shadow-2xl"
                >
                    <!-- Header -->
                    <div
                        class="flex shrink-0 items-center justify-between gap-4 border-b border-slate-200 p-5 sm:p-6"
                    >
                        <div class="flex min-w-0 items-center gap-4">
                            <div
                                class="flex h-12 w-16 shrink-0 items-center justify-center overflow-hidden rounded-xl border border-slate-200 bg-slate-50 p-2"
                            >
                                <img
                                    :src="dealer.flag"
                                    :alt="$t(`contacts.dealers.countries.${dealer.country}`)"
                                    class="max-h-full max-w-full object-contain"
                                />
                            </div>

                            <div class="min-w-0">
                                <div
                                    class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-400"
                                >
                                    Техновотум
                                </div>

                                <h2
                                    class="mt-1 truncate text-xl font-semibold tracking-tight text-slate-950 sm:text-2xl"
                                >
                                    {{ $t(`contacts.dealers.countries.${dealer.country}`) }}
                                </h2>
                            </div>
                        </div>

                        <button
                            type="button"
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500 transition hover:bg-slate-950 hover:text-white"
                            :aria-label="$t('contacts.dealers.close')"
                            @click="$emit('close')"
                        >
                            <svg
                                viewBox="0 0 24 24"
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path d="M6 6l12 12M18 6 6 18" />
                            </svg>
                        </button>
                    </div>

                    <!-- Content -->
                    <div class="overflow-y-auto p-5 sm:p-6">
                        <!-- No information -->
                        <div
                            v-if="!dealer.locations.length"
                            class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-5 py-10 text-center"
                        >
                            <div
                                class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-white text-slate-400"
                            >
                                <svg
                                    viewBox="0 0 24 24"
                                    class="h-6 w-6"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                >
                                    <circle cx="12" cy="12" r="9" />
                                    <path d="M12 10v6M12 7.5v.5" />
                                </svg>
                            </div>

                            <p class="mt-4 text-sm leading-6 text-slate-500">
                                {{ $t('contacts.dealers.informationComingSoon') }}
                            </p>
                        </div>

                        <!-- Locations -->
                        <div v-else class="space-y-5">
                            <article
                                v-for="location in dealer.locations"
                                :key="location.id"
                                class="rounded-2xl border border-slate-200 bg-slate-50 p-5"
                            >
                                <!-- Address -->
                                <div class="mb-4 flex items-start gap-3">
                                    <div
                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-slate-500"
                                    >
                                        <svg
                                            viewBox="0 0 24 24"
                                            class="h-4 w-4"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.7"
                                        >
                                            <path
                                                d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"
                                            />
                                            <circle
                                                cx="12"
                                                cy="10"
                                                r="2.5"
                                            />
                                        </svg>
                                    </div>

                                    <div>
                                        <div
                                            class="text-[11px] font-semibold uppercase tracking-wider text-slate-400"
                                        >
                                            {{ $t('contacts.dealers.addressLabel') }}
                                        </div>

                                        <p
                                            class="mt-1 text-sm leading-6 text-slate-700"
                                        >
                                            {{ location.address }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Website -->
                                <a
                                    v-if="location.website"
                                    :href="location.website"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="mb-4 flex items-center gap-3 rounded-xl bg-white px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:text-slate-950"
                                >
                                    <span
                                        class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500"
                                    >
                                        <svg
                                            viewBox="0 0 24 24"
                                            class="h-4 w-4"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.7"
                                        >
                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="9"
                                            />
                                            <path
                                                d="M3 12h18M12 3c2.2 2.4 3.3 5.4 3.3 9s-1.1 6.6-3.3 9c-2.2-2.4-3.3-5.4-3.3-9S9.8 5.4 12 3Z"
                                            />
                                        </svg>
                                    </span>

                                    <span class="truncate">
                                        {{ displayWebsite(location.website) }}
                                    </span>

                                    <svg
                                        viewBox="0 0 16 16"
                                        class="ml-auto h-3.5 w-3.5 shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    >
                                        <path d="M5 11 11 5M6 5h5v5" />
                                    </svg>
                                </a>

                                <!-- Phones -->
                                <div
                                    v-if="location.phones?.length"
                                    class="space-y-2"
                                >
                                    <a
                                        v-for="phone in location.phones"
                                        :key="phone.id"
                                        :href="phoneHref(phone.phone)"
                                        class="flex items-center gap-3 rounded-xl bg-white px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:text-slate-950"
                                    >
                                        <span
                                            class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500"
                                        >
                                            <svg
                                                viewBox="0 0 24 24"
                                                class="h-4 w-4"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.7"
                                            >
                                                <path
                                                    d="M6.6 3h3l1.5 4-2 1.5a14 14 0 0 0 6.4 6.4l1.5-2 4 1.5v3c0 1.1-.9 2-2 2C10.2 19.4 4.6 13.8 4.6 7c0-1.1.9-2 2-2Z"
                                                />
                                            </svg>
                                        </span>

                                        {{ phone.phone }}
                                    </a>
                                </div>
                            </article>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div
                        class="flex shrink-0 justify-end border-t border-slate-200 bg-slate-50 p-4 sm:p-5"
                    >
                        <button
                            type="button"
                            class="inline-flex items-center justify-center rounded-xl bg-slate-950 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800"
                            @click="$emit('close')"
                        >
                            {{ $t('contacts.dealers.close') }}
                        </button>
                    </div>
                </div>
            </Transition>
        </div>
    </Transition>
</template>

<script setup>
defineProps({
    dealer: {
        type: Object,
        default: null,
    },
});

defineEmits(['close']);

const phoneHref = (phone) => {
    if (!phone) {
        return '#';
    }

    return `tel:${String(phone).replace(/[^\d+]/g, '')}`;
};

const displayWebsite = (website) => {
    if (!website) {
        return '';
    }

    return String(website)
        .replace(/^https?:\/\//i, '')
        .replace(/\/$/, '');
};
</script>