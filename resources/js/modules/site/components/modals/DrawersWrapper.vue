<template>
  <div>
    <button class="rounded-md bg-gray-950/5 px-2.5 py-1.5 text-sm font-semibold text-gray-900 hover:bg-gray-950/10" @click="open = true">Open drawer</button>
    <TransitionRoot as="template" :show="open">
      <Dialog class="relative z-10" @close="$emit('closeDrawers')">
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
                      <DialogTitle class="text-base first-letter:uppercase font-semibold text-gray-900">{{ $t(settings.action) }} {{ $t(settings.type) }}</DialogTitle>
                      
                    </div>
                    <div class="relative mt-6 flex-1 px-4 sm:px-6">
                      
                      <PhoneForm ref="phoneForm" :settings="settings" @submit="createPhone" >
                        <template v-slot:footer>
                          <div class="flex justify-end space-x-2">
                            <ActionButton :label="$t(settings.action)" @click="submit" />
                            <CancelButton @close="$emit('closeDrawers')" />
                          </div>
                        </template>
                      </PhoneForm>
                    </div>``
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
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import ActionButton from '../UI/button/ActionButton.vue'
import CancelButton from '../UI/button/CancelButton.vue'
import PhoneForm from '../forms/PhoneForm.vue'
import { contactsApi } from '../../../auth/services/contactsApi';
const props = defineProps({
    settings: {
        type: Object,
        default: () => ({ isOpen: false, type: null, action: null }),
    },
});
const open = ref(false);
const createPhone = (phone, department) => {
    contactsApi.addPhone({ phone, department_id: Number(department) });
};

watch(() => props.settings.isOpen, (newVal) => {
    open.value = newVal;
});
defineEmits(['closeDrawers']);
</script>