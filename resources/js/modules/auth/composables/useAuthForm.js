import { ref } from 'vue';

export function useAuthForm() {
    const isSubmitting = ref(false);
    const serverError = ref('');
    const validationErrors = ref({});

    const runSubmit = async (handler) => {
        if (isSubmitting.value) {
            return;
        }

        isSubmitting.value = true;
        serverError.value = '';
        validationErrors.value = {};

        try {
            await handler();
        } catch (error) {
            if (error?.status === 422 && error?.errors) {
                validationErrors.value = error.errors;
            } else {
                serverError.value = error?.message || 'Request failed. Please try again.';
            }
            throw error;
        } finally {
            isSubmitting.value = false;
        }
    };

    return {
        isSubmitting,
        serverError,
        validationErrors,
        runSubmit,
    };
}
