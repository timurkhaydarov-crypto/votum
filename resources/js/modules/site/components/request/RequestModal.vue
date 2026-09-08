vue
<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition-opacity duration-200"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-150"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="open"
                class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/50 p-4 backdrop-blur-sm"
                @mousedown.self="handleClose"
            >
                <Transition
                    appear
                    enter-active-class="transition-all duration-200 ease-out"
                    enter-from-class="scale-95 opacity-0"
                    enter-to-class="scale-100 opacity-100"
                    leave-active-class="transition-all duration-150 ease-in"
                    leave-from-class="scale-100 opacity-100"
                    leave-to-class="scale-95 opacity-0"
                >
                    <div
                        v-if="open"
                        class="relative max-h-[90vh] w-full max-w-xl overflow-y-auto rounded-2xl bg-white shadow-2xl"
                    >
                        <!-- CLOSE -->
                        <button
                            v-if="!success"
                            type="button"
                            class="absolute right-4 top-4 z-10 flex h-9 w-9 items-center justify-center rounded-full text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                            :aria-label="t('request.modal.close')"
                            @click="handleClose"
                        >
                            <i class="bi bi-x-lg text-sm"></i>
                        </button>

                        <!-- FORM -->
                        <RequestForm
                            v-if="!success"
                            :with-products="withProducts"
                            :subject="subject"
                            :context="context"
                            @success="handleSuccess"
                        />

                        <!-- SUCCESS -->
                        <RequestSuccess
                            v-else
                            :request="request"
                            @close="handleClose"
                        />
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup>
import {
    onBeforeUnmount,
    ref,
} from 'vue';

import { useI18n } from 'vue-i18n';

import RequestForm from './RequestForm.vue';
import RequestSuccess from './RequestSuccess.vue';

const props = defineProps({
    /**
     * Whether the request is created from cart.
     *
     * true:
     * - products are taken from cart
     * - RequestItems are created
     * - cart is cleared
     *
     * false:
     * - only Request is created
     */
    withProducts: {
        type: Boolean,
        default: false,
    },

    /**
     * Request subject.
     *
     * Examples:
     * - Запрос на оборудование
     * - Связаться со специалистом
     * - Название услуги
     */
    subject: {
        type: String,
        default: null,
    },

    /**
     * Request context.
     *
     * Allowed values:
     * - cart
     * - contact
     * - service
     */
    context: {
        type: String,
        default: 'contact',
    },
});

const emit = defineEmits([
    'close',
]);

const { t } = useI18n();

/**
 * Modal state.
 */
const open = ref(true);

/**
 * Success state.
 */
const success = ref(false);

/**
 * Created request.
 */
const request = ref(null);

/**
 * Close modal.
 */
const handleClose = () => {
    if (!open.value) {
        return;
    }

    open.value = false;

    window.setTimeout(() => {
        emit('close');
    }, 150);
};

/**
 * Handle successful request.
 */
const handleSuccess = (data) => {
    request.value = data?.request ?? data;
    success.value = true;
};

/**
 * Close by Escape.
 *
 * Do not close success screen by Escape.
 * User should explicitly close the success window.
 */
const handleKeydown = (event) => {
    if (
        event.key === 'Escape'
        && open.value
        && !success.value
    ) {
        handleClose();
    }
};

window.addEventListener(
    'keydown',
    handleKeydown,
);

onBeforeUnmount(() => {
    window.removeEventListener(
        'keydown',
        handleKeydown,
    );
});
</script>

