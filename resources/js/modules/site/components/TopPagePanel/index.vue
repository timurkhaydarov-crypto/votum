<template>
    <div>
        <div class="fixed inset-x-0 top-0">
            <div class="h-[40px] border-b border-slate-700/60 bg-slate-900 text-slate-300">
                <div class="mx-auto flex h-full max-w-5xl items-center justify-between gap-4 px-6 text-[11px] uppercase tracking-[0.08em] sm:text-xs">
                    <div class="flex items-center gap-4 whitespace-nowrap text-right">
                        <LeftContactPanel class="hidden sm:inline" :social-media-array="contacts.socialMedia" />
                    </div>
                    <div class="flex items-center gap-4 whitespace-nowrap text-right">
                        <RightContactPanel
                            v-for="contact in rightPanelData"
                            :contactArray="contact.data"
                            :contactType="contact.type"
                            :is-open="openMenu === contact.type"
                            :can-manage="canManage"
                            @toggle="toggleMenu(contact.type)"
                            @add-contact="openDialog(DialogType.DRAWER, contact.type, ActionType.ADD)"
                            @edit-contact="openDialog(DialogType.DRAWER, contact.type, ActionType.UPDATE, $event)"
                            @delete-contact="openDialog(DialogType.MODAL, contact.type, ActionType.DELETE, $event)"
                        />
                        <ChangeLanguage/>
                    </div>
                </div>
            </div>
        </div>
        <ModalWrapper v-if="canManage"  :settings="Setting" :isOpen="ModalIsOpen"  @close="close" @submit="deleteHandler" />
        <DrawersWrapper v-if="canManage" :settings="Setting" :isOpen="DrawerIsOpen" @close="close">
            <template #header>
                <DialogTitle class="text-base first-letter:uppercase font-semibold text-gray-900">{{ $t(`actions.${Setting.action}`) }}</DialogTitle>
            </template>
            <template #body>
                <EmailPhoneForm v-if="DrawerIsOpen" ref="form" :settings="Setting" @submit="submitHandler"/>
            </template>
            <template #footer>
                <ActionButton @click="submit" :label="$t(`actions.${Setting.action}`)" :action="Setting.action" />
                <CancelButton @close="close" />
            </template>
        </DrawersWrapper>
        <Alert v-if="isVisible" :type="type" :message="message" />
    </div>
</template>

<script setup>

import { computed, onMounted, onUnmounted, ref, reactive} from 'vue';
import { useI18n } from 'vue-i18n';
import { DialogTitle } from '@headlessui/vue'
import { DialogType } from '../../constants/modal';
import { ContactType } from '../../constants/contacts';
import { ActionType } from '../../constants/actions';
import { getDefaultSetting } from '../../constants/modal';
import { useCurrentUser } from '../../../auth/composables/useCurrentUser';

import LeftContactPanel from './LeftContactPanel.vue';
import RightContactPanel from './RightContactPanel.vue';
import ChangeLanguage from '../UI/ChangeLanguage.vue';

import ModalWrapper from '../modals/ModalWrapper.vue';
import DrawersWrapper from '../modals/DrawersWrapper.vue';

import ActionButton from '../UI/button/ActionButton.vue'
import CancelButton from '../UI/button/CancelButton.vue'
import EmailPhoneForm from '../forms/EmailPhoneForm.vue';

import Alert from '../UI/Alert.vue';
import { useGlobalAlert } from '../../composables/useGlobalAlert';
import {useContacts} from '../../composables/useContacts.js';
const {isVisible,type,message,showAlert} = useGlobalAlert();
const { contacts, loadContacts, saveItem, deleteItem} = useContacts();
const { t } = useI18n();
const menuRef = ref();

const openMenu = ref(null); // 'phones' | 'emails' | 'workTime' | null
const { canManage, loadUser } = useCurrentUser();
const toggleMenu = (menu) => {
    openMenu.value = openMenu.value === menu ? null : menu;
};

const DrawerIsOpen = ref(false);
const ModalIsOpen = ref(false);

const Setting = reactive(getDefaultSetting());
const form = ref(null);

const submit = () => form.value?.submit();

const openDialog = (dialog, type, action, item = null) => {
    const dialogs = {
        [DialogType.DRAWER]: DrawerIsOpen,
        [DialogType.MODAL]: ModalIsOpen,
    };
    const dialogRef = dialogs[dialog];

    if (!dialogRef) {
        return;
    }

    dialogRef.value = true;
    Object.assign(Setting, { type, action, item });
};

const rightPanelData = computed(() => [
    { type: ContactType.PHONE, data: contacts.phones },
    { type: ContactType.EMAIL, data: contacts.emails },
    { type: ContactType.OPERATING_HOUR, data: contacts.operatingHours },
]);

const resetDialogs = () => {
    DrawerIsOpen.value = false;
    ModalIsOpen.value = false;
    Object.assign(Setting, getDefaultSetting());
};

const close = () => {
    resetDialogs();
};

const submitHandler = async (item) => {
    const response = await saveItem({
                        setting: Setting,
                        args: item,
                        t,
                    })
    if (response.type === 'success') {
        await loadContacts();
    }
    close();
    showAlert(response.type, response.text);
};

const deleteHandler = async (item) => {
    const response = await deleteItem({
        item,
        setting: Setting,
        t,
    });

    if (response.type === 'success') {
        await loadContacts();
    }

    close();

    showAlert(response.type, response.text);
};

const closeMenu = () => {
    openMenu.value = null;
};

onMounted(async () => {
    document.addEventListener('click', closeMenu);
    await Promise.all([loadContacts(), loadUser()]);
});
onUnmounted(() => {
    document.removeEventListener('click', closeMenu);
});
</script>
