<template>
    <AuthCard title="Set a new password" subtitle="Enter your new credentials to complete the reset.">
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

            <AuthInput
                v-model="form.password"
                name="password"
                type="password"
                autocomplete="new-password"
                label="New password"
                placeholder="Create password"
                :error="validationErrors.password?.[0]"
            />

            <AuthInput
                v-model="form.password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                label="Confirm new password"
                placeholder="Repeat password"
                :error="validationErrors.password_confirmation?.[0]"
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
                {{ isSubmitting ? 'Updating...' : 'Update password' }}
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
import { useRoute } from 'vue-router';

import AuthCard from '../components/AuthCard.vue';
import AuthInput from '../components/AuthInput.vue';
import { useAuthForm } from '../composables/useAuthForm';
import { authApi } from '../services/authApi';

const route = useRoute();
const successMessage = ref('');

const form = reactive({
    token: route.params.token || '',
    email: '',
    password: '',
    password_confirmation: '',
});

const {
    isSubmitting,
    serverError,
    validationErrors,
    runSubmit,
} = useAuthForm();

const submit = async () => {
    successMessage.value = '';

    await runSubmit(async () => {
        await authApi.resetPassword(form);
        successMessage.value = 'Password changed successfully. You can sign in now.';
    });
};
</script>
