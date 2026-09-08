<template>
    <main class="min-h-screen bg-slate-50 text-slate-900">
        <CentralOffice />

        <DealersSection
            :dealers="dealers"
            @select="openDealer"
        />

        <ContactsCta />

        <DealerModal
            :dealer="selectedDealer"
            @close="closeDealer"
        />
    </main>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue';

import { useContacts } from '../composables/useContacts.js';
import { dealersApi } from '../services/contactsApi';

import CentralOffice from '../components/contacts/CentralOffice.vue';
import DealersSection from '../components/contacts/DealersSection.vue';
import DealerModal from '../components/contacts/DealerModal.vue';
import ContactsCta from '../components/contacts/ContactsCta.vue';

const { loadContacts } = useContacts();

const dealers = ref([]);
const selectedDealer = ref(null);

const loadDealers = async () => {
    try {
        const response = await dealersApi.index();

        dealers.value = Array.isArray(response)
            ? response
            : [];
    } catch (error) {
        console.error('Failed to load dealers:', error);
        dealers.value = [];
    }
};

const openDealer = (dealer) => {
    selectedDealer.value = dealer;
    document.body.classList.add('overflow-hidden');
};

const closeDealer = () => {
    selectedDealer.value = null;
    document.body.classList.remove('overflow-hidden');
};

const handleKeydown = (event) => {
    if (event.key === 'Escape' && selectedDealer.value) {
        closeDealer();
    }
};

onMounted(async () => {
    document.addEventListener('keydown', handleKeydown);

    await Promise.all([
        loadContacts(),
        loadDealers(),
    ]);
});

onBeforeUnmount(() => {
    document.removeEventListener('keydown', handleKeydown);
    document.body.classList.remove('overflow-hidden');
});
</script>