<template>
    <details
        v-if="contactArray.length > 1 || contactArray[0]?.contacts?.length > 1"
        :open="isOpen"
        class="group relative"
        @mouseenter="$emit('open')"
        @mouseleave="$emit('close')"
        @click.stop
    >
        <summary @click.prevent class="inline-flex list-none cursor-pointer items-center gap-1.5 transition hover:text-amber-300">
            <i :class="`bi ` + iconClass + ` text-[14px] leading-none`" aria-hidden="true"></i>
            <span class="hidden sm:inline lowercase first-letter:uppercase">{{ $t(`contacts.${contactType}`) }}</span>
            <i class="bi bi-chevron-down text-[12px] leading-none transition group-open:rotate-180" aria-hidden="true"></i>
        </summary>

        <div class="absolute right-0 top-full z-[80] mt-2 min-w-max whitespace-nowrap rounded-md border border-slate-700 bg-slate-900/95 p-2 normal-case tracking-normal shadow-xl">
            <template v-for="department in contactArray" :key="department.id ?? department.name">
                <span class="mb-1 border-b border-[#00979f] border-t-0 border-x-0 block px-2 text-[13px] border font-semibold text-[#00979f] text-center decoration-1">
                    {{ getDepartmentName(department.name) }}
                </span>
                <div
                    v-for="contact in department.contacts"
                    :key="contact[contactType] ?? contact.id"
                    class="flex items-center justify-between gap-2 rounded px-2 py-1.5 text-[12px] transition hover:bg-slate-800"
                >
                    <a :href="`tel:${contact[contactType]}`" class="inline-flex items-center gap-1.5 transition hover:text-amber-300">
                        <i :class="`bi ` + iconClass + ` text-[14px] leading-none`" aria-hidden="true"></i>
                        {{ props.contactType !== ContactType.OPERATING_HOUR ? contact[contactType] : `${$t(`weekdays.${contact.from}`)} - ${$t(`weekdays.${contact.to}`)} ${contact.time}` }}
                    </a>
                    <div v-if="canManage" class="flex items-center gap-0.5">
                        <TopPanelEditButton @click="$emit('edit-contact', {contact: props.contactType !== ContactType.OPERATING_HOUR ? {id: contact.id, value: contact[contactType]} : contact, department:{ id: department.id, value: department.name }})" />
                        <TopPanelDeleteButton @click="$emit('delete-contact', { id: contact.id, value: contactType !== ContactType.OPERATING_HOUR ? contact[contactType] : `${$t(`weekdays.${contact.from}`)} - ${$t(`weekdays.${contact.to}`)} ${contact.time}` })" />
                    </div>
                </div>
            </template>

            <div v-if="canManage" class="flex justify-center border-t border-slate-700/60 pt-2">
                <TopPanelAddButton customClass="w-full" @click="$emit('add-contact')" />
            </div>
        </div>
    </details>
    <span v-else class="inline-flex items-center gap-1.5">
        <i :class="`bi ` + iconClass + ` text-[14px] leading-none`" aria-hidden="true"></i>
        <span class="lowercase" v-if="contactArray.length === 1 && contactArray[0]?.contacts?.length === 1">
            {{ props.contactType !== ContactType.OPERATING_HOUR ? contact[props.contactType] : `${$t(`weekdays.${contact.from}`)} - ${$t(`weekdays.${contact.to}`)} ${contact.time}` }}
       </span>
        <div
            v-if="canManage && contactArray.length === 1 && contactArray[0]?.contacts?.length === 1"
            class="inline-flex items-center gap-0.5"
        >
            <TopPanelEditButton @click="$emit('edit-contact', {contact: contactArray[0].contacts[0], department:{ id: contactArray[0].id, value: contactArray[0].name }})" />
            <TopPanelAddButton customClass="w-full" @click="$emit('add-contact')" />
        </div>
    </span>
</template>

<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { ContactType } from '../../constants/contacts';
import { Icon } from '../../constants/icons';
import TopPanelAddButton from '../UI/button/AddButton.vue';
import TopPanelDeleteButton from '../UI/button/DeleteButton.vue';
import TopPanelEditButton from '../UI/button/EditButton.vue';

const { locale } = useI18n();

const props = defineProps({
    contactType: {
        type: String,
        default: ContactType.PHONE,
    },
    contactArray: {
        type: Array,
        default: () => [],
    },
    isOpen: {
        type: Boolean,
        default: false,
    },
    canManage: {
        type: Boolean,
        default: false,
    },
});
const iconClass = computed(() => {
    switch (props.contactType) {
        case ContactType.PHONE:
            return Icon.PHONE;
        case ContactType.EMAIL:
            return Icon.EMAIL;
        case ContactType.OPERATING_HOUR:
            return Icon.TIME;
        default:
            return '';
    }
});
const contact = computed(() => {return props.contactArray[0]?.contacts[0] || {};});

const getDepartmentName = (name) => {
    if (!name) {
        return '';
    }

    if (typeof name === 'string') {
        return name;
    }

    if (typeof name === 'object') {
        const current = locale.value;
        return name[current] ?? name.ru ?? name.en ?? Object.values(name)[0] ?? '';
    }

    return '';
};

defineEmits(['open', 'close', 'add-contact', 'edit-contact', 'delete-contact']);
</script>
