<template>
    <div class="w-full">
        <form class="space-y-4" @submit.prevent="submit">
            <Input
                v-model="phone_number"
                :label="$t('contacts.phone')"
                :placeholder="$t('contacts.phone')"
                :icon="'bi bi-telephone'"
                :required="true"
                @input="phone_number = $event"
            />
            <Select
                v-model="department"
                :label="$t('contacts.department')"
                :placeholder="$t('contacts.department')"
                :icon="'bi bi-buildings'"
                :required="true"
                :options="allDepartments"
                :option-value="'id'"
                @change="department = $event.target.value"
            />
            <div class="flex justify-end space-x-2">
            <slot name="footer" :submit="submit"></slot>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { contactsApi } from '../../../auth/services/contactsApi';
import Input from '../UI/form/Input.vue'
import Select from '../UI/form/Select.vue'


const phone_number = ref('')
const email = ref('')
const department = ref('')
const allDepartments = ref([])

const loadDepartments = async () => {
    try {
        allDepartments.value = await contactsApi.getDepartments();
    } catch (error) {
        console.error('Failed to load departments:', error);
    }
};

const props = defineProps({
    settings: {
        type: Object,
        default: () => ({ isOpen: false, type: null, action: null }),
    },
});
const emit = defineEmits(['submit'])
const submit = () => {
  emit('submit', phone_number.value, department.value)
}
onMounted(async () => {
    await Promise.all([loadDepartments()]);
});

</script>
