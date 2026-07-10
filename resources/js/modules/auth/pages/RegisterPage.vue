<template>
    <AuthCard title="Create account" subtitle="Set up access for your team workspace.">
        <form class="space-y-4" @submit.prevent="submit">
            <AuthInput
                v-model="form.name"
                name="name"
                autocomplete="name"
                label="Full name"
                placeholder="John Smith"
                :error="validationErrors.name?.[0]"
            />

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
                label="Password"
                placeholder="Create password"
                :error="validationErrors.password?.[0]"
            />

            <AuthInput
                v-model="form.password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                label="Confirm password"
                placeholder="Repeat password"
                :error="validationErrors.password_confirmation?.[0]"
            />

            <p v-if="serverError" class="rounded-md border border-rose-200 bg-rose-50 px-3 py-2 text-sm text-rose-700">
                {{ serverError }}
            </p>

            <button
                type="submit"
                :disabled="isSubmitting"
                class="w-full rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:bg-emerald-400"
            >
                {{ isSubmitting ? 'Creating account...' : 'Create account' }}
            </button>
        </form>

        <template #footer>
            <router-link class="font-medium text-emerald-700 hover:text-emerald-800" :to="{ name: 'auth.login' }">
                Already have an account?
            </router-link>
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
    name: '',
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
    await runSubmit(async () => {
        await authApi.register(form);
    });
};
</script>
