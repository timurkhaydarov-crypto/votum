<template>
    <Alert v-if="isVisible" :type="type" :message="message" />
    <router-view />
</template>

<script setup>
import Alert from './modules/site/components/UI/Alert.vue';
import { useGlobalAlert } from './modules/site/composables/useGlobalAlert';
import { watch, onMounted } from 'vue';
import { useI18n } from 'vue-i18n';

const {
    isVisible,
    type,
    message,
} = useGlobalAlert();

const { t, locale } = useI18n();

const updateDocumentTitle = () => {
    document.title = t('logo.Title') || 'TECHNOVOTUM';
};

onMounted(updateDocumentTitle);
watch(locale, updateDocumentTitle, { immediate: true });
</script>
