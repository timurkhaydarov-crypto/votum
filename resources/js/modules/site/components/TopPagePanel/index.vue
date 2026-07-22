<template>
    <div>
        <div class="fixed inset-x-0 top-0">
            <div class="h-[40px] border-b border-slate-700/60 bg-slate-900 text-slate-300">
                <div class="mx-auto flex h-full max-w-5xl items-center justify-between gap-4 px-6 text-[11px] uppercase tracking-[0.08em] sm:text-xs">
                    <div class="flex items-center gap-4 whitespace-nowrap text-right">
                    <TopPanelSocialLinks class="hidden sm:inline" :social-media-array="socialMediaArray" />
                    </div>
                    <div class="flex items-center gap-4 whitespace-nowrap text-right">
                        <TopPanelPhones
                            :phones-array="phonesArray"
                            :is-open="openMenu === 'phones'"
                            :can-manage="canManage"
                            @toggle="toggleMenu('phones')"
                            @add-phone="openDrawersHandler('phone','add')"
                            @edit-phone="openDrawersHandler('phone','edit')"
                            @delete-phone="deletePhone($event)"
                        />
                        <TopPanelEmail
                            :emails-array="emailsArray"
                            :is-open="openMenu === 'emails'"
                            @toggle="toggleMenu('emails')"
                        />
                        <TopPanelWorkTime
                            :operating-hours-array="operatingHoursArray"
                            :is-open="openMenu === 'workTime'"
                            @toggle="toggleMenu('workTime')"
                        />
                        <ChangeLanguage/>

                    </div>
                </div>
            </div>
        </div>
        <ModalWrapper :settings="ModalSetting" v-if="canManage" />
        <DrawersWrapper v-if="canManage" :settings="DrawerSetting" @close-drawers="DrawerSetting.isOpen = false" />
    </div>
</template>

<script setup>

import { computed, onMounted, onUnmounted, ref } from 'vue';
import { useCurrentUser } from '../../../auth/composables/useCurrentUser';
import { contactsApi } from '../../../auth/services/contactsApi';

import TopPanelEmail from './TopPanelEmail.vue';
import TopPanelPhones from './TopPanelPhones.vue';
import TopPanelSocialLinks from './TopPanelSocialLinks.vue';
import TopPanelWorkTime from './TopPanelWorkTime.vue';
import ChangeLanguage from '../UI/ChangeLanguage.vue';
import ModalWrapper from '../modals/ModalWrapper.vue';
import DrawersWrapper from '../modals/DrawersWrapper.vue';

const openMenu = ref(null); // 'phones' | 'emails' | 'workTime' | null
const { canManage, loadUser } = useCurrentUser();
const toggleMenu = (menu) => {
    openMenu.value = openMenu.value === menu ? null : menu;
};
const DrawerSetting = ref({
    isOpen: false,
    type: null,
    action: null,
});
const openDrawersHandler = (type, action) => {
    DrawerSetting.value = {
        isOpen: true,
        type: 'contacts.' + type,
        action: 'actions.' + action,
    };
};

const ModalSetting = ref({
    isOpen: false,
    type: null,
    action: null,
});
const openModalHandler = (type, action) => {
    ModalSetting.value = {
        isOpen: true,
        type: 'contacts.' + type,
        action,
    };
};

const phones = ref(null);
const emails = ref(null);
const operatingHours = ref(null);
const socialMedia = ref(null);

const phonesArray = computed(() => phones.value || []);
const emailsArray = computed(() => emails.value || []);
const operatingHoursArray = computed(() => operatingHours.value || []);
const socialMediaArray = computed(() => socialMedia.value || []);

const deletePhone = async (phoneId) => {
    try {
        await contactsApi.deletePhone(phoneId);
        await loadContacts();
    } catch (error) {
        console.error('Failed to delete phone:', error);
    }
};

const loadContacts = async () => {
    try {
        phones.value = await contactsApi.getPhones();
        emails.value = await contactsApi.getEmails();
        operatingHours.value = await contactsApi.getOperatingHours();
        socialMedia.value = await contactsApi.getSocialMedia();
    } catch (error) {
        console.error('Failed to load contact information:', error);
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
