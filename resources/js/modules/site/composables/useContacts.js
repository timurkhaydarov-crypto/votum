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
    const apiByType = {
        [ContactType.PHONE]: 'phones',
        [ContactType.EMAIL]: 'emails',
        [ContactType.OPERATING_HOUR]: 'operatingHours',
        [ContactType.SOCIAL_MEDIA]: 'socialMedia',
    };

    const apiMethodByAction = {
        [ActionType.ADD]: 'store',
        [ActionType.UPDATE]: 'update',
        [ActionType.DELETE]: 'destroy',
    };

    const getApiResource = (type) => apiByType[type];
    const getApiMethod = (action) => apiMethodByAction[action];
    const errorResponse = (t) => ({
        type: 'error',
        text: t('messages.fail.default'),
    });

    const getApi = (type) => contactsApi[apiByType[type]] ?? null;

    const resetForm = (fields, department) => {
        fields.forEach((field) => {
            if (field) {
                field.value = '';
            }
        });

        if (department) {
            department.value = null;
        }
    };

    const populateForm = (props, fields) => {
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
                    fields.day.value.from = item.contact?.from ?? '';
                    fields.day.value.to = item.contact?.to ?? '';
                    fields.time.value = item.contact?.time ?? '';
                    break;
            }

            if (fields.department) {
                fields.department.value = item.department?.id ?? null;
            }
            return;
        }

        switch (type) {
            case ContactType.PHONE:
                resetForm([fields.phone], fields.department);
                break;

            case ContactType.EMAIL:
                resetForm([fields.email], fields.department);
                break;

            case ContactType.OPERATING_HOUR:
                resetForm([fields.day.from, fields.day.to, fields.time], fields.department);
                break;
        }
    };

    const loadContacts = async () => {
        const [phones, emails, operatingHours, socialMedia] = await Promise.all([
            contactsApi.phones.index(),
            contactsApi.emails.index(),
            contactsApi.operatingHours.index(),
            contactsApi.socialMedia.index(),
        ]);
        Object.assign(contacts, {
            phones,
            emails,
            operatingHours,
            socialMedia,
        });
    };

    const requestItem = async ({ setting, args, t }) => {
        const method = getApiMethod(setting.action);
        const api = getApi(setting.type);

        if (!api || !method || !api[method]) {
            return errorResponse(t);
        }

        try {
            const { message } = await api[method](args);

            return {
                type: 'success',
                text: message ? t(message) : t('messages.success.default'),
            };
        } catch (error) {
            return {
                type: 'error',
                text: t(error.message || 'messages.fail.default'),
            };
        }
    };

    const deleteItem = ({ item, setting, t }) =>
        requestItem({
            setting,
            args: item.id,
            t,
        });

    const saveItem = async ({ setting, args, t }) => {
        return requestItem({
            setting,
            args,
            t,
        });
    };

    return {
        contacts,
        loadContacts,
        saveItem,
        deleteItem,
        populateForm,
        resetForm,
    };
};
