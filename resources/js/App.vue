<template>
    <ServerAlert v-if="isVisible" :type="type" :message="message" />
    <router-view />
</template>

<script setup>
import ServerAlert from './modules/site/components/modals/ServerAlert.vue';
import { useGlobalAlert } from './modules/site/composables/useGlobalAlert';

const {
    isVisible,
    type,
    message,
} = useGlobalAlert();
</script>
