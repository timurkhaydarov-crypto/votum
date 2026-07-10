<template>
    <AuthCard title="Sign in" subtitle="Use your work account to continue.">
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
                autocomplete="current-password"
                label="Password"
                placeholder="Enter your password"
                :error="validationErrors.password?.[0]"
            />

            <p v-if="serverError" class="rounded-md border border-rose-200 bg-rose-50 px-3 py-2 text-sm text-rose-700">
                {{ serverError }}
            </p>

            <button
                type="submit"
                :disabled="isSubmitting"
                class="w-full rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:bg-emerald-400"
            >
                {{ isSubmitting ? 'Signing in...' : 'Sign in' }}
            </button>
        </form>

        <template #footer>
            <p>Admin sign-in endpoint: /admin-votum</p>
        </template>
    </AuthCard>
</template>

<script setup>
import { reactive } from 'vue';

import AuthCard from '../components/AuthCard.vue';
import AuthInput from '../components/AuthInput.vue';
import { useAuthForm } from '../composables/useAuthForm';
import { authApi } from '../services/authApi';

const form = reactive({
    email: '',
    password: '',
});

const {
    isSubmitting,
    serverError,
    validationErrors,
    runSubmit,
} = useAuthForm();

const submit = async () => {
    await runSubmit(async () => {
        await authApi.login(form);
    });
};
</script>
