<template>
    <div class="w-full">
        <form class="space-y-4" @submit.prevent="handleSubmit">
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
            <Select
                v-model="day_from"
                :label="$t('periods.from')"
                :placeholder="$t('periods.from')"
                :icon="'bi bi-calendar'"
                :required="true"
                :options="weekDays"
                :option-value="'id'"
                @change="day_from = $event"
            />
            <Select
                v-model="day_to"
                :label="$t('periods.to')"
                :placeholder="$t('periods.to')"
                :icon="'bi bi-calendar'"
                :required="true"
                :options="weekDays"
                :option-value="'id'"
                @change="day_to = $event"
            />
            <Input
                :label="$t('periods.from')"
                :placeholder="$t('contacts.time_mask')"
                :icon="'bi bi-clock'"
                :required="true"
                :type="'text'"
                :pattern="'^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$'"
                :value="time_from"
                @input="time_from = $event"
            />
            <Input
                :label="$t('periods.to')"
                :placeholder="$t('contacts.time_mask')"
                :icon="'bi bi-clock'"
                :required="true"
                :pattern="'^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$'"
                :value="time_to"
                @input="time_to = $event"
            />
            <div class="flex justify-end space-x-2">
                <slot name="footer" :submit="handleSubmit"></slot>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { ContactType } from '../../constants/contacts';
import { useContacts } from '../../composables/useContacts.js'
import { useI18n } from 'vue-i18n';
import { weekDays } from '../../constants/form';
import { contactsApi } from '../../services/contactsApi.js';
import Input from '../UI/form/Input.vue'
import Select from '../UI/form/Select.vue'
const { populateForm, resetForm } = useContacts();
const { t } = useI18n();
const day_from = ref('')
const day_to = ref('')
const time_from = ref('')
const time_to = ref('')
const department = ref(-1);
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
  emit('submit', { id: props.settings.item?.contact?.id || null, [props.settings.type]: props.settings.type === ContactType.PHONE ? phone_number.value : email.value, department_id: department.value.id });
  resetForm([day_from, day_to, time_from, time_to], department, t);
}


onMounted(async () => {
    populateForm(props,{ day_from, day_to, time_from, time_to, department }, t);
    await Promise.all([loadDepartments()]);
});

</script>
