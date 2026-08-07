<template>
    <div class="w-full">
        <Input v-model="input" :name="props.settings.type" :label="$t(`contacts.${props.settings.type}`)"
            :placeholder="$t(`contacts.${props.settings.type}`)" :icon="inputConfig.icon" :required="true"
            :mask="inputConfig.mask" :type="inputConfig.type"
            :pattern="isPhone ? `^\\+7\\(\\d{3}\\)\\d{3}-\\d{2}-\\d{2}$` : undefined" :error="inputError" />
        <Select v-model="department" :name="'department'" :options="allDepartments" option-value="id"
            option-label="value" :label="$t('contacts.department')"
            :placeholder="`-- ${t('contacts.selectDepartment')} --`" :icon="'bi bi-buildings'" :required="true"
            :error="departmentError" />
    </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { useContacts } from '../../composables/useContacts.js'
import { useI18n } from 'vue-i18n';
import { contactsApi } from '../../services/contactsApi.js';
import { ContactType } from '../../constants/contacts';
import { ActionType } from '../../constants/actions';
import Input from '../UI/form/Input.vue'
import Select from '../UI/form/Select.vue'

const { populateForm } = useContacts();
const { t } = useI18n();

const input = ref('')
const department = ref(null);
const allDepartments = ref([]);
const props = defineProps({
    settings: {
        type: Object,
        default: () => ({ type: null, action: null, item: null }),
    },
});

const loadDepartments = async () => {
    try {
        const departments = await contactsApi.getDepartments();
        allDepartments.value = departments;
    } catch (error) {
        console.error(error);
    }
};

const isPhone = computed(() =>
    props.settings.type === ContactType.PHONE
);

const inputConfig = computed(() => ({
    icon: isPhone.value
        ? 'bi bi-telephone'
        : 'bi bi-envelope',

    mask: isPhone.value
        ? '+7(###)###-##-##'
        : undefined,

    type: isPhone.value
        ? 'tel'
        : 'email'
}));

const emit = defineEmits(['submit']);
const inputError = ref('');
const departmentError = ref('');
const submit = () => {
    departmentError.value = '';
    inputError.value = '';

    if (input.value === '') {
        inputError.value = t('validation.input.required');
        return;
    }

    if (department.value === null) {
        departmentError.value = t('validation.select.required');
        return;
    }

    const field = props.settings.type;

    const data = {
        [field]: input.value,
        department_id: department.value,
    };

    if (props.settings.action === ActionType.UPDATE && props.settings.item?.contact?.id) {
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
        populateForm(
            props.settings,
            {
                phone: input,
                email: input,
                department
            }
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
