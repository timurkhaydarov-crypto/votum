import { ref } from 'vue';

const isVisible = ref(false);
const message = ref('');
const type = ref('success');
let hideTimerId;

export function useGlobalAlert() {
    const showAlert = (alertType, alertMessage, duration = 3000) => {
        type.value = alertType;
        message.value = alertMessage;
        isVisible.value = true;

        clearTimeout(hideTimerId);
        hideTimerId = setTimeout(() => {
            isVisible.value = false;
        }, duration);
    };

    const hideAlert = () => {
        clearTimeout(hideTimerId);
        isVisible.value = false;
    };

    return {
        isVisible,
        message,
        type,
        showAlert,
        hideAlert,
    };
}
