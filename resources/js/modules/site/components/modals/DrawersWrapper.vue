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
                      <slot name="header"></slot>
                    </div>
                    <div class="relative mt-6 flex-1 px-4 sm:px-6">
                      <form class="space-y-4" @submit.prevent="$emit('submit')">
                        <slot name="body"></slot>
                          <div class="flex justify-end space-x-2">
                            <div class="flex justify-end space-x-2">
                              <slot name="footer"></slot>
                            </div>
                          </div>
                      </form>
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

const props = defineProps({
    isOpen: {
        type: Boolean,
        default: false,
    },
});

const { t } = useI18n();

const open = ref(false);
const emit = defineEmits(['close', 'submit']);

watch(() => props.isOpen, (newVal) => {
  open.value = newVal;
});


</script>
