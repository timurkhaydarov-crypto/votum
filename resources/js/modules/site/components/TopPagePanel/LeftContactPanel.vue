<template>
    <div class="flex items-center gap-4 whitespace-nowrap">
        <template v-for="social in socialMediaArray" :key="social.name">
            <a :href="social.link" target="_blank" rel="noopener noreferrer" class="transition hover:text-amber-300 cursor-pointer mr-2 last:mr-0">
                <i :class="`bi bi-${social.platform} text-[14px] leading-none`" aria-hidden="true"></i>
            </a>
        </template>
    </div>
</template>
<script setup>
defineProps({
    socialMediaArray: {
        type: Array,
        default: () => [],
    },
});
</script>