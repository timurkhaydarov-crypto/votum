<template>
    <div class="w-full">
        <Select
            v-model="department"
            :name="'department'"
            :options="allDepartments"
            option-value="id"
            option-label="value"
            :label="$t('contacts.department')"
            :placeholder="`-- ${t('contacts.selectDepartment')} --`"
            :icon="`bi ` + Icon.DEPARTMENT"
            :required="true"
            :error="departmentError"
        />
        <Select
            v-model="day.from"
            :name="'day_from'"
            :options="weekDaysOptions"
            option-value="id"
            option-label="label"
            :label="$t('periods.from')"
            :placeholder="`-- ${t('periods.from')} --`"
            :icon="`bi ` + Icon.CALENDAR"
            :required="true"
            :error="dayError"
        />
        <Select
            v-model="day.to"
            :name="'day_to'"
            :options="weekDaysOptions"
            option-value="id"
            option-label="label"
            :label="$t('periods.to')"
            :placeholder="`-- ${t('periods.to')} --`"
            :icon="`bi ` + Icon.CALENDAR"
            :required="true"
            :error="dayError"
        />
        <Input
            v-model="time"
            :name="'time'"
            :label="$t('contacts.operating_hours')"
            :placeholder="$t('contacts.operating_hours')"
            :icon="`bi ` + Icon.TIME"
            :required="true"
            :mask="'##:##-##:##'"
            :type="'text'"
            :error="timeError"
        />        
    </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { useContacts } from '../../composables/useContacts.js'
import { useI18n } from 'vue-i18n';
import { contactsApi } from '../../services/contactsApi.js';
import { ContactType,WeekDays } from '../../constants/contacts';
import { Icon } from '../../constants/icons';
import { ActionType } from '../../constants/actions';
import Input from '../UI/form/Input.vue'
import Select from '../UI/form/Select.vue'

const { populateForm } = useContacts();
const { t } = useI18n();


const allDepartments = ref([]);
const department = ref(null);
const day = ref({from: null, to: null});
const time = ref('')

const props = defineProps({
    settings: {
        type: Object,
        default: () => ({ type: null, action: null, item: null }),
    },
});

const weekDaysOptions = computed(() =>
    WeekDays.map(day => ({
        ...day,
        label: t(`weekdays.${day.value}`),
    }))
);

const loadDepartments = async () => {
    try {
        const departments = await contactsApi.getDepartments();
        allDepartments.value = departments;
    } catch(error) {
        console.error(error);
    }
};

const emit = defineEmits(['submit']);
const timeError = ref('');
const dayError = ref('');
const departmentError = ref('');
const submit = () => {
    departmentError.value = '';
    timeError.value = '';
    dayError.value = '';
    
    if (day.value.from === null || day.value.to === null) {
        dayError.value = t('validation.select.required');
        return;
    }

    if (time.value === '') {
        timeError.value = t('validation.input.required');
        return;
    }

    if (department.value === null) {
        departmentError.value = t('validation.select.required');
        return;
    }    

    const data = {
        department_id: department.value,
        time: time.value,
        from: day.value.from,
        to: day.value.to
    };

    if (props.settings.action === ActionType.UPDATE && props.settings.item?.contact?.id)
    {
        data.id = props.settings.item.contact.id;
    }

    emit('submit', data);
};

watch(
    () => [
        props.settings.type,
        props.settings.action,
        props.settings.item
    ],
    async () => {
        await loadDepartments();
        const populatedForm = populateForm(
            props.settings,
            {
                day: day,
                time: time,
                department
            },
            t
        );
    },
    {
        immediate: true
    }
);

watch(department, () => {
    if (department.value !== null) {
        departmentError.value = '';
    }
});

defineExpose({
    submit
})
</script>
