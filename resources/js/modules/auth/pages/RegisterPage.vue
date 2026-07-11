<template>
    <VotumCard title="Create account" subtitle="Set up access for your team workspace.">
        <form class="space-y-4" @submit.prevent="submit">
            <VotumInput
                v-model="form.name"
                name="name"
                autocomplete="name"
                label="Full name"
                placeholder="John Smith"
                :error="validationErrors.name?.[0]"
            />

            <VotumInput
                v-model="form.email"
                name="email"
                type="email"
                autocomplete="email"
                label="Email"
                placeholder="you@company.com"
                :error="validationErrors.email?.[0]"
            />

            <VotumSelect
                v-model="form.role"
                name="role"
                label="Role"
                :options="roleOptions"
                :error="validationErrors.role?.[0]"
            />

            <VotumInput
                v-model="form.password"
                name="password"
                type="password"
                autocomplete="new-password"
                label="Password"
                placeholder="Create password"
                :error="validationErrors.password?.[0]"
            />

            <VotumInput
                v-model="form.password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                label="Confirm password"
                placeholder="Repeat password"
                :error="validationErrors.password_confirmation?.[0]"
            />

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
    </VotumCard>
</template>

<script setup>
import { reactive } from 'vue';
import router from '../../../router/index.js';

import VotumCard from '../components/VotumCard.vue';
import VotumInput from '../components/VotumInput.vue';
import VotumSelect from '../components/VotumSelect.vue';
import { useAuthForm } from '../composables/useAuthForm';
import { authApi } from '../services/authApi';
import { useGlobalAlert } from '../../site/composables/useGlobalAlert';

const roleOptions = [
    { value: 'user', label: 'User' },
    { value: 'manager', label: 'Manager' },
    { value: 'admin', label: 'Admin' },
];

const form = reactive({
    name: '',
    email: '',
    role: 'user',
    password: '',
    password_confirmation: '',
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
            const response = await authApi.register(form);
            showServerAlert('success', response?.message || 'Account created successfully');
            setTimeout(() => {
                 router.push({ name: 'site.index' });
            }, 1000);
        });
    } catch (error) {
        if (error?.status === 422) {
            showServerAlert('warning', 'Please check the form fields.');
            return;
        }

        showServerAlert('error', error?.message || 'Registration failed. Please try again.');
    }
};
</script>
