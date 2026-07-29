<template>
    <div class="w-full">
        <form class="space-y-4" @submit.prevent="handleSubmit">
            <Input
                :label="$t(`contacts.${props.settings.type}`)"
                :placeholder="$t(`contacts.${props.settings.type}`)"
                :icon="props.settings.type === 'phone' ? 'bi bi-telephone' : 'bi bi-envelope'"
                :required="true"
                :type="props.settings.type === 'phone' ? 'tel' : 'email'"
                :pattern="props.settings.type === 'phone' ? '[0-9]{3}-[0-9]{3}-[0-9]{4}' : `[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$`"
                :value="props.settings.type === 'phone' ? phone_number : email"
                @input="props.settings.type === 'phone' ? phone_number = $event : email = $event"
            />
            <Select
                v-model="department"
                :label="$t('contacts.department')"
                :placeholder="$t('contacts.department')"
                :icon="'bi bi-buildings'"
                :required="true"
                :options="allDepartments"
                :option-value="'id'"
                @change="department = $event"
            />
            <div class="flex justify-end space-x-2">
            <slot name="footer" :submit="handleSubmit"></slot>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useI18n } from 'vue-i18n';
import { getDefaultDepartment } from '../../constants/form';
import { contactsApi } from '../../services/contactsApi.js';
import Input from '../UI/form/Input.vue'
import Select from '../UI/form/Select.vue'

const { t } = useI18n();
const phone_number = ref('')
const email = ref('')
const department = ref(getDefaultDepartment(t));
const allDepartments = ref([]);

const loadDepartments = async () => {
    try {
        const currentDepartment = props.settings.item?.department || department.value;
        const response = await contactsApi.getDepartments();
        allDepartments.value = [currentDepartment, ...response.filter(dept => dept.id !== currentDepartment.id)];
    } catch (error) {
        console.error('Failed to load departments:', error);
    }
};

const props = defineProps({
    settings: {
        type: Object,
        default: () => ({ type: null, action: null, item: null }),
    },
});

const emit = defineEmits(['submit'])

const handleSubmit = () => {
  emit('submit', { id: props.settings.item?.contact?.id || null, [props.settings.type]: props.settings.type === 'phone' ? phone_number.value : email.value, department_id: department.value.id });
  resetForm();
}

const resetForm = () => {
    phone_number.value = ''
    email.value = ''
    department.value = getDefaultDepartment(t);
}

const populateForm = () => {
    if (props.settings.action === 'update' && props.settings.item) {
        switch (props.settings.type) {
            case 'phone':
                phone_number.value = props.settings.item.contact.value || ''
                break;
            case 'email':
                email.value = props.settings.item.contact.value || ''
                break;
            default:
                phone_number.value = ''
                email.value = '';
        }
        department.value = props.settings.item.department || getDefaultDepartment(t);
    } else {
        resetForm()
    }
}

onMounted(async () => {
    populateForm()
    await Promise.all([loadDepartments()]);
});

</script>
