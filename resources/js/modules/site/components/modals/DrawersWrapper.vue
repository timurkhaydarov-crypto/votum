<template>
  <div>
    <TransitionRoot as="template" :show="open">
      <Dialog class="relative z-10" @close="$emit('close')">
        <TransitionChild as="template" enter="ease-in-out duration-500" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-500" leave-from="opacity-100" leave-to="opacity-0">
          <div class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>
        </TransitionChild>
        <div class="fixed inset-0 overflow-hidden">
          <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16">
              <TransitionChild as="template" enter="transform transition ease-in-out duration-500 sm:duration-700" enter-from="translate-x-full" enter-to="translate-x-0" leave="transform transition ease-in-out duration-500 sm:duration-700" leave-from="translate-x-0" leave-to="translate-x-full">
                <DialogPanel class="pointer-events-auto relative w-screen max-w-md">
                  <div class="relative flex h-full flex-col overflow-y-auto bg-white py-6 shadow-xl">
                    <div class="px-4 sm:px-6">
                      <DialogTitle class="text-base first-letter:uppercase font-semibold text-gray-900">{{ $t(`actions.${settings.action}`) }}</DialogTitle>
                    </div>
                    <div class="relative mt-6 flex-1 px-4 sm:px-6">
                   
                      <EmailPhoneForm v-if="open" ref="phoneForm" :settings="settings" @submit="submitHandler">
                        <template #footer>
                          <div class="flex justify-end space-x-2">
                            <ActionButton type="submit" :label="$t(`actions.${settings.action}`)" :action="settings.action" />
                            <CancelButton @close="$emit('close')" />
                          </div>
                        </template>
                      </EmailPhoneForm>
                    </div>
                  </div>
                </DialogPanel>
              </TransitionChild>
            </div>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
  </div>
</template>

<script setup>
import { ref, watch} from 'vue'

import { useI18n } from 'vue-i18n';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import ActionButton from '../UI/button/ActionButton.vue'
import CancelButton from '../UI/button/CancelButton.vue'
import EmailPhoneForm from '../forms/EmailPhoneForm.vue'
import Alert from '../UI/Alert.vue'
import { contactsApi } from '../../services/contactsApi.js';
const props = defineProps({
    settings: {
        type: Object,
        default: () => ({type: null, action: null }),
    },
    isOpen: {
        type: Boolean,
        default: false,
    },
});
const open = ref(false);
const { t } = useI18n();
const emit = defineEmits(['close']);

const submitHandler = (item) => {
  if (props.settings.action === 'add') {
    const addApi =  props.settings.action + props.settings.type.charAt(0).toUpperCase() + props.settings.type.slice(1);
    createItem(item, addApi);
  } else if (props.settings.action === 'update') {
    const updateApi =  props.settings.action + props.settings.type.charAt(0).toUpperCase() + props.settings.type.slice(1);
    updateItem(item, updateApi);
  }
};
const createItem =  async (item, addApi) => {
  try {
    const { message } = await contactsApi[addApi](item);
    emit('close', {
      text: t(message) ?? 'Phone number added successfully',
      type: 'success',
    });
  } catch (error) {
    emit('close', {
      text: error.response?.data?.message ?? 'Failed to add phone number',
      type: 'error',
    });
  } finally {
    open.value = false;
  }
};
const updateItem = async (item, updateApi) => {
  try {
    const { message } = await contactsApi[updateApi](item.id, item);
    emit('close', {
      text: t(message) ?? 'Phone number updated successfully',
      type: 'success',
    });
  } catch (error) {
    emit('close', {
      text: error.response?.data?.message ?? 'Failed to update phone number',
      type: 'error',
    });
  } finally {
    open.value = false;
  }
};

watch(() => props.isOpen, (newVal) => {
  open.value = newVal;
});


</script>