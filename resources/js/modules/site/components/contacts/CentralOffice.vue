<template>
    <section class="relative overflow-hidden bg-white">
        <div
            class="relative mx-auto max-w-7xl px-5 pb-12 pt-24 sm:px-8 sm:pb-16 sm:pt-28 lg:px-10 lg:pb-20 lg:pt-32"
        >
            <div
                class="grid w-full overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm lg:grid-cols-[0.8fr_1.2fr]"
            >
                <!-- Office photo -->
                <div
                    class="relative min-h-[240px] overflow-hidden sm:min-h-[280px] lg:min-h-[320px]"
                >
                    <img
                        :src="'/image/contacts/central_office.webp'"
                        :alt="$t('contacts.centralOffice.imageAlt')"
                        class="absolute inset-0 h-full w-full object-cover"
                        loading="lazy"
                    />

                    <div
                        class="absolute inset-0 bg-gradient-to-t from-slate-950/50 via-slate-950/5 to-transparent"
                    />

                    <div class="absolute bottom-5 left-5 sm:bottom-6 sm:left-6">
                        <div
                            class="inline-flex items-center gap-2 rounded-full bg-white/90 px-4 py-2 text-xs font-medium text-slate-800 shadow-lg backdrop-blur"
                        >
                            <span
                                class="h-2 w-2 rounded-full bg-emerald-500"
                            />

                            {{ $t('contacts.centralOffice.caption') }}
                        </div>
                    </div>
                </div>

                <!-- Information -->
                <div class="flex flex-col justify-center p-6 sm:p-8 lg:p-10">
                    <!-- Header -->
                    <div
                        class="mb-5 flex flex-wrap items-center gap-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500"
                    >
                        <span
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-950 text-white"
                        >
                            <svg
                                viewBox="0 0 24 24"
                                class="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    d="M3 21h18M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16M9 7h2M13 7h2M9 11h2M13 11h2M9 15h2M13 15h2"
                                />
                            </svg>
                        </span>

                        <span>
                            {{ $t('contacts.centralOffice.label') }}
                        </span>

                        <a
                            :href="mapLink"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="ml-1 inline-flex items-center gap-2 rounded-lg bg-slate-950 px-3 py-2 text-[11px] font-semibold uppercase tracking-normal text-white transition hover:bg-slate-800"
                        >
                            {{ $t('contacts.centralOffice.openMap') }}

                            <svg
                                viewBox="0 0 16 16"
                                class="h-3.5 w-3.5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.7"
                            >
                                <path d="M3 8h9M8 4l4 4-4 4" />
                            </svg>
                        </a>
                    </div>

                    <h1
                        class="text-2xl font-semibold tracking-tight text-slate-950 sm:text-3xl"
                    >
                        {{ $t('contacts.centralOffice.title') }}
                    </h1>

                    <div class="mt-6 grid gap-5 sm:grid-cols-2">
                        <!-- Address -->
                        <div class="flex gap-3">
                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-700"
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
                                    <circle cx="12" cy="10" r="2.5" />
                                </svg>
                            </div>

                            <div>
                                <div
                                    class="text-[11px] font-semibold uppercase tracking-wider text-slate-400"
                                >
                                    {{ $t('contacts.centralOffice.addressLabel') }}
                                </div>

                                <address
                                    class="mt-1 not-italic text-sm leading-5 text-slate-700"
                                >
                                    {{ $t('contacts.centralOffice.address') }}
                                </address>
                            </div>
                        </div>

                        <!-- Phones -->
                        <div class="flex gap-3">
                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-700"
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
                            </div>

                            <div class="min-w-0 flex-1">
                                <div
                                    class="text-[11px] font-semibold uppercase tracking-wider text-slate-400"
                                >
                                    {{ $t('contacts.centralOffice.phoneLabel') }}
                                </div>

                                <div class=" space-y-4">
                                    <div
                                        v-for="department in contacts.phones"
                                        :key="department.id"
                                    >
                                    
                                        <div
                                            v-if="department.name && contacts.phones.length > 1"
                                            class="mb-1 text-xs font-semibold text-slate-500"
                                        >
                                            {{ getLocalizedValue(department.name) }}
                                        </div>

                                        <div class="space-y-0.5">
                                            <a
                                                v-for="phone in department.contacts"
                                                :key="phone.id"
                                                :href="phoneHref(phone.phone)"
                                                class="block text-sm font-medium text-slate-800 transition hover:text-slate-500"
                                            >
                                                {{ phone.phone }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex gap-3">
                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-700"
                            >
                                <svg
                                    viewBox="0 0 24 24"
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                >
                                    <rect
                                        x="3"
                                        y="5"
                                        width="18"
                                        height="14"
                                        rx="2"
                                    />
                                    <path d="m4 7 8 6 8-6" />
                                </svg>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div
                                    class="text-[11px] font-semibold uppercase tracking-wider text-slate-400"
                                >
                                    {{ $t('contacts.centralOffice.emailLabel') }}
                                </div>

                                <div class=" space-y-4">
                                    <div
                                        v-for="department in contacts.emails"
                                        :key="department.id"
                                    >
                                        <div
                                            v-if="department.name && contacts.emails.length>1"
                                            class="mb-1 text-xs font-semibold text-slate-500"
                                        >
                                            {{ getLocalizedValue(department.name) }}
                                        </div>

                                        <div class="space-y-0.5">
                                            <a
                                                v-for="email in department.contacts"
                                                :key="email.id"
                                                :href="`mailto:${email.email}`"
                                                class="block break-all text-sm font-medium text-slate-800 transition hover:text-slate-500"
                                            >
                                                {{ email.email }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Operating hours -->
                        <div class="flex gap-3">
                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-700"
                            >
                                <svg
                                    viewBox="0 0 24 24"
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                >
                                    <circle cx="12" cy="12" r="9" />
                                    <path d="M12 7v5l3 2" />
                                </svg>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div
                                    class="text-[11px] font-semibold uppercase tracking-wider text-slate-400"
                                >
                                    {{ $t('contacts.centralOffice.hoursLabel') }}
                                </div>

                                <div class="capitalize  space-y-2">
                                    <div
                                        v-for="item in contacts.operatingHours"
                                        :key="item.id"
                                        class="text-sm text-slate-700"
                                    >
                                        <div
                                            v-for="schedule in item.contacts"
                                            :key="schedule.id"
                                            class="flex flex-wrap gap-x-2 gap-y-1"
                                        >
                                            <span>
                                                {{ formatDayRange(schedule.from, schedule.to) }}
                                            </span>

                                            <span
                                                v-if="schedule.time"
                                                class="font-medium text-slate-800"
                                            >
                                                {{ schedule.time }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { useI18n } from 'vue-i18n';
import { useContacts } from '../../composables/useContacts.js';

const { t } = useI18n();
const { contacts, loadContacts } = useContacts();

loadContacts();

const mapLink =
    'https://yandex.ru/maps/?ll=37.250553%2C55.977376&z=16&pt=37.250553%2C55.977376%2Cpm2rdm';

const getLocalizedValue = (value) => {
    if (!value) {
        return '';
    }

    if (typeof value === 'string') {
        return value;
    }

    return value[t.value] ?? value.ru ?? value.en ?? '';
};

const phoneHref = (phone) => {
    if (!phone) {
        return '#';
    }

    return `tel:${String(phone).replace(/[^\d+]/g, '')}`;
};

const formatDayRange = (from, to) => {
    if (!from && !to) {
        return '';
    }

    const localizeDay = (day) => {
        if (!day) {
            return '';
        }

        return t(`weekdays.${String(day).toLowerCase()}`);
    };

    if (from && to && from === to) {
        return localizeDay(from);
    }

    if (from && to) {
        return `${localizeDay(from)} — ${localizeDay(to)}`;
    }

    return localizeDay(from || to);
};
</script>