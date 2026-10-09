<template>
    <section class="w-full bg-white">
        <div
            class="mx-auto w-full max-w-7xl px-6 py-20 sm:px-8 sm:py-24 lg:px-10 lg:py-32"
        >
            <div
                class="grid gap-12 lg:grid-cols-[0.8fr_1.2fr] lg:gap-20"
            >
                <div>
                    <CompanySectionEyebrow
                        number="03"
                        :label="t('company.contact.eyebrow')"
                    />

                    <h2
                        class="mt-6 max-w-3xl text-3xl font-semibold leading-[1.08] tracking-[-0.03em] text-slate-900 sm:text-4xl lg:text-5xl"
                    >
                        {{ t('company.contact.title') }}
                    </h2>

                    <p
                        class="mt-7 max-w-xl text-base leading-7 text-slate-600 sm:text-lg sm:leading-8"
                    >
                        {{ t('company.contact.description') }}
                    </p>
                </div>

                <div
                    class="grid gap-px overflow-hidden rounded-2xl border border-slate-200 bg-slate-200 sm:grid-cols-2"
                >
                    <CompanyContactCard
                        :label="t('company.contact.items.address.label')"
                        :items="addressItems"
                        icon="bi-geo-alt"
                    />

                    <CompanyContactCard
                        :label="t('company.contact.items.phone.label')"
                        :items="phoneItems"
                        icon="bi-telephone"
                    />

                    <CompanyContactCard
                        :label="t('company.contact.items.email.label')"
                        :items="emailItems"
                        icon="bi-envelope"
                    />

                    <CompanyContactCard
                        :label="t('company.contact.items.hours.label')"
                        :items="hoursItems"
                        icon="bi-clock"
                    />
                </div>

                <p
                    v-if="contactLoadError"
                    class="mt-4 text-sm text-red-700"
                    role="alert"
                >
                    {{ t('company.contact.loadError') }}
                </p>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import { useI18n } from 'vue-i18n'
import { contactsApi } from '../../services/contactsApi.js'
import CompanySectionEyebrow from './shared/CompanySectionEyebrow.vue'
import CompanyContactCard from './shared/CompanyContactCard.vue'

const { t, locale } = useI18n()
const phones = ref([])
const emails = ref([])
const operatingHours = ref([])
const contactLoadError = ref(false)
const visiblePhoneNumbers = new Set([
    '74999950061',
    '74999950062',
])

const addressItems = computed(() => [
    { text: t('contacts.centralOffice.address') },
])

const getDepartmentName = (name) => {
    if (!name) {
        return ''
    }

    if (typeof name === 'string') {
        return name
    }

    return name[locale.value] ?? name.ru ?? name.en ?? ''
}

const phoneItems = computed(() =>
    phones.value.flatMap((department) =>
        (department.contacts ?? [])
            .filter(
                (contact) =>
                    visiblePhoneNumbers.has(
                        String(contact.phone).replace(/\D/g, '')
                    )
            )
            .map((contact) => ({
                id: contact.id,
                text: contact.phone,
                href: `tel:${String(contact.phone).replace(/[^\d+]/g, '')}`,
                department:
                    phones.value.length > 1
                        ? getDepartmentName(department.name)
                        : '',
            }))
    )
)

const emailItems = computed(() =>
    emails.value.flatMap((department) =>
        (department.contacts ?? []).map((contact) => ({
            id: contact.id,
            text: contact.email,
            href: `mailto:${contact.email}`,
            department:
                emails.value.length > 1
                    ? getDepartmentName(department.name)
                    : '',
        }))
    )
)

const formatDayRange = (from, to) => {
    const day = (value) => value ? t(`weekdays.${value.toLowerCase()}`) : ''

    if (from && to && from !== to) {
        return `${day(from)} — ${day(to)}`
    }

    return day(from || to)
}

const hoursItems = computed(() =>
    operatingHours.value.flatMap((department) =>
        (department.contacts ?? []).map((hours) => ({
            id: hours.id,
            text: [formatDayRange(hours.from, hours.to), hours.time]
                .filter(Boolean)
                .join(', '),
            department:
                operatingHours.value.length > 1
                    ? getDepartmentName(department.name)
                    : '',
        }))
    )
)

onMounted(async () => {
    try {
        const [phoneData, emailData, operatingHoursData] = await Promise.all([
            contactsApi.phones.index(),
            contactsApi.emails.index(),
            contactsApi.operatingHours.index(),
        ])

        phones.value = phoneData
        emails.value = emailData
        operatingHours.value = operatingHoursData
    } catch (error) {
        console.error('Failed to load company contacts:', error)
        contactLoadError.value = true
    }
})
</script>