<template>
    <AuthCard title="Reset password" subtitle="We will send a password reset link to your email.">
        <form class="space-y-4" @submit.prevent="submit">
            <AuthInput
                v-model="form.email"
                name="email"
                type="email"
                autocomplete="email"
                label="Email"
                placeholder="you@company.com"
                :error="validationErrors.email?.[0]"
            />

            <p v-if="serverError" class="rounded-md border border-rose-200 bg-rose-50 px-3 py-2 text-sm text-rose-700">
                {{ serverError }}
            </p>

            <p v-if="successMessage" class="rounded-md border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700">
                {{ successMessage }}
            </p>

            <button
                type="submit"
                :disabled="isSubmitting"
                class="w-full rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:bg-emerald-400"
            >
                {{ isSubmitting ? 'Sending...' : 'Send reset link' }}
            </button>
        </form>

        <template #footer>
            <router-link class="font-medium text-emerald-700 hover:text-emerald-800" :to="{ name: 'auth.login' }">
                Back to sign in
            </router-link>
        </template>
    </AuthCard>
</template>

<script setup>
import { reactive, ref } from 'vue';

import AuthCard from '../components/AuthCard.vue';
import AuthInput from '../components/AuthInput.vue';
import { useAuthForm } from '../composables/useAuthForm';
import { authApi } from '../services/authApi';

const form = reactive({
    email: '',
});
const successMessage = ref('');

const {
    isSubmitting,
    serverError,
    validationErrors,
    runSubmit,
} = useAuthForm();

const submit = async () => {
    successMessage.value = '';

    await runSubmit(async () => {
        await authApi.forgotPassword(form);
        successMessage.value = 'If the email exists, a reset link has been sent.';
    });
};
</script>
