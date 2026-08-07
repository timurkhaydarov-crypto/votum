<template>
    <div class="flex items-center gap-4 whitespace-nowrap">
        <template v-for="social in socialMediaArray" :key="social.name">
            <a :href="social.url" target="_blank" rel="noopener noreferrer"
                class="transition hover:text-amber-300 cursor-pointer mr-2 last:mr-0">
                <i :class="`bi bi-${social.platform} text-[14px] leading-none`" aria-hidden="true"></i>
            </a>
        </template>
        <TopPanelAddButton v-if="socialMediaArray.length < 5 && canManage" customClass="mr-2" @click="$emit('add-social-media')" />
        <TopPanelEditButton v-if="canManage" @click="$emit('edit-social-media')" />
    </div>
</template>
<script setup>
import TopPanelEditButton from '../UI/button/EditButton.vue';
import TopPanelAddButton from '../UI/button/AddButton.vue';
defineProps({
    socialMediaArray: {
        type: Array,
        default: () => [],
    },
    canManage: {
        type: Boolean,
        default: false,
    },
});
</script>