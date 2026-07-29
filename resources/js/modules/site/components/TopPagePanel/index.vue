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
                            @add-contact="openDrawersHandler(contact.type,'add')"
                            @edit-contact="openDrawersHandler(contact.type,'update', $event)"
                            @delete-contact="openModalHandler(contact.type,'delete', $event)"
                        />
                        <ChangeLanguage/>
                    </div>
                </div>
            </div>
        </div>
        <ModalWrapper v-if="canManage"  :settings="Setting" :isOpen="ModalIsOpen"  @close="close" @submit="deleteHandler" />
        <DrawersWrapper v-if="canManage" :settings="Setting" :isOpen="DrawerIsOpen" @close="close" />
        <Alert v-if="isVisible" :type="type" :message="message" />
    </div>
</template>

<script setup>

import { computed, onMounted, onUnmounted, ref, reactive } from 'vue';
import { useI18n } from 'vue-i18n';
import { getDefaultDepartment } from '../../constants/form'; 
import { getDefaultSetting } from '../../constants/modal';
import { useCurrentUser } from '../../../auth/composables/useCurrentUser';
import { contactsApi } from '../../services/contactsApi.js';


import LeftContactPanel from './LeftContactPanel.vue';
import RightContactPanel from './RightContactPanel.vue';
import ChangeLanguage from '../UI/ChangeLanguage.vue';

import ModalWrapper from '../modals/ModalWrapper.vue';
import DrawersWrapper from '../modals/DrawersWrapper.vue';
import Alert from '../UI/Alert.vue';
import { useGlobalAlert } from '../../composables/useGlobalAlert';
const { isVisible, type, message } = useGlobalAlert();
const { showAlert } = useGlobalAlert();
const { t } = useI18n();

const openMenu = ref(null); // 'phones' | 'emails' | 'workTime' | null
const { canManage, loadUser } = useCurrentUser();
const toggleMenu = (menu) => {
    openMenu.value = openMenu.value === menu ? null : menu;
};
const DrawerIsOpen = ref(false);
const ModalIsOpen = ref(false);

const Setting = ref(getDefaultSetting());
const openDrawersHandler = (type, action, item = null) => {
    DrawerIsOpen.value = true;
    Setting.value = {
        type: type,
        action: action,
        item: item,
    };
};


const openModalHandler = (type, action, item) => {
    ModalIsOpen.value = true;
    Setting.value = {
        type: type,
        action: action,
        item: item,
    };
};

const contacts = reactive({
    phones: [],
    emails: [],
    operatingHours: [],
    socialMedia: [],
});


const rightPanelData = computed(() => ([
    { type: 'phone', data: contacts.phones },
    { type: 'email', data: contacts.emails },
    { type: 'operatingHour', data: contacts.operatingHours },
]));
const close = (message) => {
    loadContacts();
    DrawerIsOpen.value = ModalIsOpen.value = false;
    Setting.value = getDefaultSetting();
    showAlert(message.type, message.text);
};
const deleteHandler = async (item) => {
    const deleteItem =  Setting.value.action + Setting.value.type.charAt(0).toUpperCase() + Setting.value.type.slice(1);
    try {
        const { message } = await contactsApi[deleteItem](item.id);
        close({ type: 'success', text: t(message) ?? 'Phone number deleted successfully' });
    } catch (error) {
        close({ type: 'error', text: t(error.message) ?? 'Failed to delete phone number' });
    } finally {
        await loadContacts();
        Setting.value = getDefaultSetting();
    }
};

const loadContacts = async () => {
    try {
        const [phones, emails, operatingHours, socialMedia] = await Promise.all([
            contactsApi.getPhones(),
            contactsApi.getEmails(),
            contactsApi.getOperatingHours(),
            contactsApi.getSocialMedia(),
        ]);

        Object.assign(contacts, {
            phones,
            emails,
            operatingHours,
            socialMedia,
        });
    } catch (error) {
        console.error("Failed to load contact information:", error);
    }
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
