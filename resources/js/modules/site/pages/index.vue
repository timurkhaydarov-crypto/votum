<template>
    <section class="min-h-screen bg-slate-950 text-slate-100">
        <TechnicalPanel
            v-if="user"
            :user-name="userName"
            :is-logging-out="isLoggingOut"
            @logout="logout"
        />

        <div
            class="mx-auto flex min-h-screen max-w-5xl flex-col px-6 py-10"
            :class="user ? 'pt-[58px]' : ''"
        >

            <div class="flex flex-1 flex-col items-center justify-center text-center">
                <p class="mb-4 inline-flex items-center rounded-full border border-teal-300/30 bg-teal-400/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-teal-200">
                    Vue + Laravel
                </p>
                <h1 class="text-4xl font-semibold tracking-tight sm:text-6xl">
                    Technovotum frontend is powered by Vue.
                </h1>
                <p class="mt-6 max-w-2xl text-base text-slate-300 sm:text-lg">
                    The project is now configured with Vite and Vue Single File Components.
                    Start building screens and components in resources/js/App.vue.
                </p>
                <div class="mt-10 flex flex-wrap items-center justify-center gap-3">
                    <span class="rounded-md border border-slate-700 bg-slate-900 px-3 py-1 text-sm">Laravel 13</span>
                    <span class="rounded-md border border-slate-700 bg-slate-900 px-3 py-1 text-sm">Vue 3</span>
                    <span class="rounded-md border border-slate-700 bg-slate-900 px-3 py-1 text-sm">Vite</span>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import router from '../../../router';
import { authApi } from '../../auth/services/authApi';
import TechnicalPanel from '../components/TechnicalPanel.vue';
import { useGlobalAlert } from '../composables/useGlobalAlert';

const user = ref(null);
const isLoggingOut = ref(false);
const { showAlert } = useGlobalAlert();

const userName = computed(() => user.value?.name || 'User');

const loadUser = async () => {
    try {
        user.value = await authApi.me();
    } catch (error) {
        if (error?.status === 401) {
            user.value = null;
            return;
        }

        showAlert('error', error?.message || 'Failed to load user profile.');
    }
};

const logout = async () => {
    if (isLoggingOut.value) {
        return;
    }

    isLoggingOut.value = true;
    try {
        const response = await authApi.logout();
        showAlert('success', response?.message || 'Logged out successfully.');
        router.push({ name: 'auth.login' });
    } catch (error) {
        showAlert('error', error?.message || 'Logout failed. Please try again.');
    } finally {
        isLoggingOut.value = false;
    }
};

onMounted(() => {
    loadUser();
});
</script>

