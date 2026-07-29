<template>
    <Alert v-if="isVisible" :type="type" :message="message" />
    <router-view />
</template>

<script setup>
import Alert from './modules/site/components/UI/Alert.vue';
import { useGlobalAlert } from './modules/site/composables/useGlobalAlert';

const {
    isVisible,
    type,
    message,
} = useGlobalAlert();
</script>
