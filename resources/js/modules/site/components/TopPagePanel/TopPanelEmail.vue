<template>
    <details v-if="emailsArray.length > 1 || emailsArray[0]?.emails?.length > 1" :open="isOpen" class="group relative" @click.stop>
        <summary @click.prevent="$emit('toggle')" class="inline-flex list-none cursor-pointer items-center gap-1.5 transition hover:text-amber-300">
            <i class="bi bi-envelope text-[14px] leading-none" aria-hidden="true"></i>
            <span class="hidden sm:inline">{{ $t('contacts.mail') }}</span>
            <i class="bi bi-chevron-down text-[12px] leading-none transition group-open:rotate-180" aria-hidden="true"></i>
        </summary>

        <div class="absolute right-0 top-full mt-2 min-w-max whitespace-nowrap rounded-md border border-slate-700 bg-slate-900/95 p-2 normal-case tracking-normal shadow-xl">
            <template v-for="department in emailsArray" :key="department.name">
                <span class="mb-1 block px-2 text-[13px] font-semibold text-[#00979f] text-center underline decoration-1 underline-offset-3">
                    {{ department.name }}
                </span>
                <template v-for="email in department.emails" :key="email">
                    <a :href="`mailto:${email}`" class="block whitespace-nowrap rounded px-2 py-1.5 text-[12px] transition hover:bg-slate-800 hover:text-amber-300 text-left">
                        <i class="bi bi-envelope text-[14px] leading-none" aria-hidden="true"></i> {{ email }}
                    </a>
                </template>
            </template>
        </div>
    </details>
    <span v-else class="inline-flex items-center gap-1.5">
        <i class="bi bi-envelope text-[14px] leading-none" aria-hidden="true"></i>
        <span v-if="emailsArray.length === 1 && emailsArray[0]?.emails?.length === 1">
            {{ emailsArray[0].emails[0] }}
        </span>
    </span>
</template>
<script setup>
defineProps({
    emailsArray: {
        type: Array,
        default: () => [],
    },
    isOpen: {
        type: Boolean,
        default: false,
    },
});
defineEmits(['toggle']);

</script>