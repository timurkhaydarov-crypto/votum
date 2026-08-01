<template>
    <details v-if="contactArray.length > 1 || contactArray[0]?.phones?.length > 1" :open="isOpen" class="group relative" @click.stop>
        <summary @click.prevent="$emit('toggle')" class="inline-flex list-none cursor-pointer items-center gap-1.5 transition hover:text-amber-300">
            <i :class="`bi ` + iconClass + ` text-[14px] leading-none`" aria-hidden="true"></i>
            <span class="hidden sm:inline lowercase first-letter:uppercase">{{ $t(`contacts.${contactType}`) }}</span>
            <i class="bi bi-chevron-down text-[12px] leading-none transition group-open:rotate-180" aria-hidden="true"></i>
        </summary>

        <div class="absolute right-0 top-full mt-2 min-w-max whitespace-nowrap rounded-md border border-slate-700 bg-slate-900/95 p-2 normal-case tracking-normal shadow-xl">
            <template v-for="department in contactArray" :key="department.id ?? department.name">
                <span class="mb-1 block px-2 text-[13px] font-semibold text-[#00979f] text-center underline decoration-1 underline-offset-3">
                    {{ department.name }}
                </span>
                <div
                    v-for="contact in department.contacts"
                    :key="contact[contactType] ?? contact.id"
                    class="flex items-center justify-between gap-2 rounded px-2 py-1.5 text-[12px] transition hover:bg-slate-800"
                >
                    <a :href="`tel:${contact[contactType]}`" class="inline-flex items-center gap-1.5 transition hover:text-amber-300">
                        <i :class="`bi ` + iconClass + ` text-[14px] leading-none`" aria-hidden="true"></i>
                        {{ contact[contactType] }}
                    </a>
                    <div v-if="canManage" class="flex items-center gap-0.5">
                        <TopPanelEditButton @click="$emit('edit-contact', {contact: {id: contact.id, value: contact[contactType]}, department:{ id: department.id, value: department.name }})" />
                        <TopPanelDeleteButton @click="$emit('delete-contact', { id: contact.id, value: contactType !== 'operatingHour' ? contact[contactType] : `${$t(`weekdays.${contact.from}`)} - ${$t(`weekdays.${contact.to}`)} ${contact.time}` })" />
                    </div>
                </div>
            </template>

            <div v-if="canManage" class="flex justify-center border-t border-slate-700/60 pt-2">
                <TopPanelAddButton @click="$emit('add-contact')" />
            </div>
        </div>
    </details>
    <span v-else class="inline-flex items-center gap-1.5">
        <i :class="`bi ` + iconClass + ` text-[14px] leading-none`" aria-hidden="true"></i>
        <span class="capitalize" v-if="contactArray.length === 1 && contactArray[0]?.contacts?.length === 1">
            {{ props.contactType !== ContactType.OPERATING_HOUR ? contact[props.contactType] : `${$t(`weekdays.${contact.from}`)} - ${$t(`weekdays.${contact.to}`)} ${contact.time}` }}
       </span>
        <div
            v-if="canManage && contactArray.length === 1 && contactArray[0]?.contacts?.length === 1"
            class="inline-flex items-center gap-0.5"
        >
            <TopPanelEditButton @click="$emit('edit-contact', { department: contactArray[0], contact: contactArray[0].contacts[0] })" />
            <TopPanelDeleteButton @click="$emit('delete-contact', { id: contactArray[0].contacts[0].id, value: contactType !== ContactType.OPERATING_HOUR ? contact[contactType] : `${$t(`weekdays.${contact.from}`)} - ${$t(`weekdays.${contact.to}`)} ${contact.time}` })" />
        </div>
    </span>
</template>

<script setup>
import { computed } from 'vue';
import { ContactType } from '../../constants/contacts';
import { Icon } from '../../constants/icons';
import TopPanelAddButton from '../UI/button/AddButton.vue';
import TopPanelDeleteButton from '../UI/button/DeleteButton.vue';
import TopPanelEditButton from '../UI/button/EditButton.vue';

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
            return Icon.OPERATING_HOUR;
        default:
            return '';
    }
});
const contact = computed(() => {return props.contactArray[0]?.contacts[0] || {};});
defineEmits(['toggle', 'add-contact', 'edit-contact', 'delete-contact']);
</script>
