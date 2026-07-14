<template>
    <div class="fixed inset-x-0 top-0 z-50">
        <div class="h-[40px] border-b border-slate-700/60 bg-slate-900 text-slate-300">
            <div class="mx-auto flex h-full max-w-5xl items-center justify-between gap-4 px-6 text-[11px] uppercase tracking-[0.08em] sm:text-xs">
                <TopPanelSocialLinks />
                <div class="flex items-center gap-4 whitespace-nowrap text-right">
                    <TopPanelPhones />
                    <TopPanelEmail />
                    <TopPanelWorkTime />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import TopPanelEmail from './TopPanelEmail.vue';
import TopPanelPhones from './TopPanelPhones.vue';
import TopPanelSocialLinks from './TopPanelSocialLinks.vue';
import TopPanelWorkTime from './TopPanelWorkTime.vue';
</script>