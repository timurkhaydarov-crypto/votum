import { reactive } from 'vue';
import { contactsApi } from '../services/contactsApi.js';
import { ContactType } from '../constants/contacts';
import { ActionType } from '../constants/actions';
export const useContacts = () => {
const contacts = reactive({
    phones: [],
    emails: [],
    operatingHours: [],
    socialMedia: [],
});
const getApiMethod = (action, type) => `${action}${type.charAt(0).toUpperCase()}${type.slice(1)}`;
const resetForm = (fields, department, t) => {
    fields.forEach(field => {
        if (field) {
            field.value = '';
        }
    });
    if (department) {
        department.value = null;
    }
};

const populateForm = (props, fields,t) => {
    const { type, action, item } = props;
    if (action === ActionType.UPDATE && item) {
        switch (type) {
            case ContactType.PHONE:
                fields.phone.value = item.contact?.value ?? '';
                break;

            case ContactType.EMAIL:
                fields.email.value = item.contact?.value ?? '';
                break;

            case ContactType.OPERATING_HOUR:
                fields.day_from.value = item.day_from ?? '';
                fields.day_to.value = item.day_to ?? '';
                fields.time_from.value = item.time_from ?? '';
                fields.time_to.value = item.time_to ?? '';
                break;
        }

        if (fields.department) {
            fields.department.value = item.department.id ?? null;
        }

        return;
    }

    switch (type) {
        case ContactType.PHONE:
            resetForm([fields.phone], fields.department, t);
            break;

        case ContactType.EMAIL:
            resetForm([fields.email], fields.department, t);
            break;

        case ContactType.OPERATING_HOUR:
            resetForm(
                [
                    fields.day_from,
                    fields.day_to,
                    fields.time_from,
                    fields.time_to,
                ],
                fields.department,
                t
            );
            break;
    }
};

const loadContacts = async () => {
            const [
                phones,
                emails,
                operatingHours,
                socialMedia
            ] = await Promise.all([
                contactsApi.getPhones(),
                contactsApi.getEmails(),
                contactsApi.getOperatingHours(),
                contactsApi.getSocialMedia(),
            ]);
            Object.assign(contacts, {
                phones,
                emails,
                operatingHours,
                socialMedia,
            });
       
};


const deleteItem = async ({item,setting,t}) => {
    const method = getApiMethod(
        setting.action,
        setting.type
    );
    try {
        const { message } = await contactsApi[method](item.id);
        return {
            type: 'success',
            text: message
                ? t(message)
                : t('messages.success.default')
        };
    } catch(error){
        const message = error.response?.data?.message;
        return {
            type: 'error',
            text: message
                ? t(message)
                : t('messages.fail.default'),
        };
    }
};

const saveItem = async ({ setting, args, t }) => {
    const method = getApiMethod(
        setting.action,
        setting.type
    );
    try {
        const { message } = await contactsApi[method](args);

        return {
            type: 'success',
            text: message
                ? t(message)
                : t('messages.success.default')
        };

    } catch(error) {
        const message = error.response?.data?.message;
        return {
            type: 'error',
            text: message
                ? t(message)
                : t('messages.fail.default'),
        };
    }
};
return {
    contacts,
    loadContacts,
    saveItem,
    deleteItem,
    populateForm,
    resetForm,
    getApiMethod
};
};