<template>
    <section class="min-h-screen bg-white text-slate-100">
        <TopPagePanel class="hidden sm:inline" />
        <MainMenu class="hidden sm:inline" />
    </section>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import router from '../../../router';
import { authApi } from '../../auth/services/authApi';
import TopPagePanel from '../components/TopPagePanel/index.vue';
import MainMenu from '../components/menu/MainMenu.vue';
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

