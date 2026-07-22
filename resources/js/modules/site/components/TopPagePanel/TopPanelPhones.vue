<template>
    <details v-if="phonesArray.length > 1 || phonesArray[0]?.phones?.length > 1" :open="isOpen" class="group relative" @click.stop>
        <summary @click.prevent="$emit('toggle')" class="inline-flex list-none cursor-pointer items-center gap-1.5 transition hover:text-amber-300">
            <i class="bi bi-telephone text-[14px] leading-none" aria-hidden="true"></i>
            <span class="hidden sm:inline">{{ $t('contacts.phone') }}</span>
            <i class="bi bi-chevron-down text-[12px] leading-none transition group-open:rotate-180" aria-hidden="true"></i>
        </summary>

        <div class="absolute right-0 top-full mt-2 min-w-max whitespace-nowrap rounded-md border border-slate-700 bg-slate-900/95 p-2 normal-case tracking-normal shadow-xl">
            <template v-for="department in phonesArray" :key="department.id ?? department.name">
                <span class="mb-1 block px-2 text-[13px] font-semibold text-[#00979f] text-center underline decoration-1 underline-offset-3">
                    {{ department.name }}
                </span>
                <div
                    v-for="phone in department.phones"
                    :key="phone.id ?? phone.phone"
                    class="flex items-center justify-between gap-2 rounded px-2 py-1.5 text-[12px] transition hover:bg-slate-800"
                >
                    <a :href="`tel:${phone.phone}`" class="inline-flex items-center gap-1.5 transition hover:text-amber-300">
                        <i class="bi bi-telephone text-[14px] leading-none" aria-hidden="true"></i>
                        {{ phone.phone }}
                    </a>
                    <div v-if="canManage" class="flex items-center gap-0.5">
                        <TopPanelEditButton @click="$emit('edit-phone', { department, phone })" />
                        <TopPanelDeleteButton @click="$emit('delete-phone', phone.id)" />
                    </div>
                </div>
            </template>

            <div v-if="canManage" class="flex justify-center border-t border-slate-700/60 pt-2">
                <TopPanelAddButton @click="$emit('add-phone')" />
            </div>
        </div>
    </details>
    <span v-else class="inline-flex items-center gap-1.5">
        <i class="bi bi-telephone text-[14px] leading-none" aria-hidden="true"></i>
        <span v-if="phonesArray.length === 1 && phonesArray[0]?.phones?.length === 1">
            {{ phonesArray[0].phones[0].phone }}
        </span>
        <div
            v-if="canManage && phonesArray.length === 1 && phonesArray[0]?.phones?.length === 1"
            class="inline-flex items-center gap-0.5"
        >
            <TopPanelEditButton @click="$emit('edit-phone', { department: phonesArray[0], phone: phonesArray[0].phones[0] })" />
            <TopPanelDeleteButton @click="$emit('delete-phone', phonesArray[0].phones[0].id)" />
        </div>
    </span>
</template>

<script setup>
import TopPanelAddButton from '../UI/button/AddButton.vue';
import TopPanelDeleteButton from '../UI/button/DeleteButton.vue';
import TopPanelEditButton from '../UI/button/EditButton.vue';

defineProps({
    phonesArray: {
        type: Array,
        default: () => [],
    },
    isOpen: {
        type: Boolean,
        default: false,
    },
    canManage: {
        type: Boolean,
        default: false,
    },
});

defineEmits(['toggle', 'add-phone', 'edit-phone', 'delete-phone']);
</script>
