<template>
    <section class="min-h-screen bg-gray-300 text-slate-100 sm:pt-[100px]">
        <TopPagePanel class="hidden sm:block" />
        <MainMenu class="hidden bg-white sm:!fixed sm:inset-x-0 sm:top-[40px] sm:z-[60] sm:block" />
        <HomeHeroSection />

        <!-- <TrustedBy /> -->
        <!-- <CompanyAbout /> -->
        <!-- <CompanyManufacturing /> -->
        <!-- <CompanyQuality /> -->
        <CompanyCertifications />
        <CompanyContact />
        <!-- <CompanyGetStarted /> -->
    </section>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import router from '../../../router';
import { authApi } from '../../auth/services/authApi';
import TopPagePanel from '../components/TopPagePanel/index.vue';
import MainMenu from '../components/navigation/MainHeader.vue';
import HomeHeroSection from '../components/HomeHeroSection.vue';
// import TrustedBy from '../components/company/TrustedBy.vue'
import CompanyAbout from '../components/company/CompanyAbout.vue'
// import CompanyManufacturing from '../components/company/CompanyManufacturing.vue'
// import CompanyQuality from '../components/company/CompanyQuality.vue'
import CompanyCertifications from '../components/company/CompanyCertifications.vue'
import CompanyGetStarted from '../components/company/CompanyGetStarted.vue'
import CompanyContact from '../components/company/CompanyContact.vue'
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

