<template>
    <VotumCard title="Sign in" subtitle="Use your work account to continue.">
        <form class="space-y-4" @submit.prevent="submit">
            <VotumInput
                v-model="form.email"
                name="email"
                type="email"
                autocomplete="email"
                label="Email"
                placeholder="you@company.com"
                :error="validationErrors.email?.[0]"
            />

            <VotumInput
                v-model="form.password"
                name="password"
                type="password"
                autocomplete="current-password"
                label="Password"
                placeholder="Enter your password"
                :error="validationErrors.password?.[0]"
            />

            <button
                type="submit"
                :disabled="isSubmitting"
                class="w-full rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:bg-emerald-400"
            >
                {{ isSubmitting ? 'Signing in...' : 'Sign in' }}
            </button>
        </form>

        <template #footer>
            <p>Admin sign-in endpoint: /auth/login</p>
        </template>
    </VotumCard>
</template>

<script setup>
import { reactive } from 'vue';

import VotumCard from '../components/VotumCard.vue';
import VotumInput from '../components/VotumInput.vue';
import { useAuthForm } from '../composables/useAuthForm';
import { authApi } from '../services/authApi';
import { useGlobalAlert } from '../../site/composables/useGlobalAlert';
import router from '../../../router/index.js';

const form = reactive({
    email: '',
    password: '',
});

const {
    isSubmitting,
    validationErrors,
    runSubmit,
} = useAuthForm();

const { showAlert } = useGlobalAlert();

const showServerAlert = (type, message) => {
    showAlert(type, message);
};

const submit = async () => {
    try {
        await runSubmit(async () => {
            const response = await authApi.login(form);
            showServerAlert('success', response?.message || 'Login successful');
        });

        setTimeout(() => {
            router.push({ name: 'site.index' });
        }, 800);
    } catch (error) {
        if (error?.status === 401 || error?.status === 403) {
            showServerAlert('warning', error?.message || 'Access is restricted.');
            return;
        }

        showServerAlert('error', error?.message || 'Request failed. Please try again.');
    }
};
</script>
