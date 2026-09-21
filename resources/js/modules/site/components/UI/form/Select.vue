<template>
    <div>
        <label
            v-if="label !== ''"
            :for="id"
            class="mb-2 block first-letter:uppercase text-sm/6 font-medium text-gray-900"
        >
            {{ label }}
        </label>

        <div>
            <div
                :class="[
                    'flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 focus-within:outline-2 focus-within:-outline-offset-2',
                    height,
                    error
                        ? 'outline-red-500 focus-within:outline-red-500'
                        : 'outline-gray-300 focus-within:outline-emerald-500',
                ]"
            >
                <div
                    v-if="icon !== ''"
                    class="flex w-5 items-center justify-center text-gray-500"
                >
                    <i
                        :class="icon"
                        aria-hidden="true"
                    ></i>
                </div>

                <select
                    v-model="model"
                    :aria-invalid="!!error"
                    :aria-describedby="
                        error
                            ? `${id}-error`
                            : undefined
                    "
                    :name="name"
                    :id="id"
                    :required="required"
                    :aria-required="required"
                    class="block h-full min-w-0 grow bg-transparent pr-8 pl-2 text-sm text-gray-900 focus:outline-none"
                >
                    <option
                        disabled
                        :value="null"
                    >
                        {{ placeholder }}
                    </option>

                    <option
                        v-for="option in options"
                        :key="option[optionValue]"
                        :value="option[optionValue]"
                    >
                        {{ getOptionLabel(option) }}
                    </option>
                </select>
            </div>

            <p
                v-if="error"
                :id="`${id}-error`"
                role="alert"
                class="mt-1 text-sm text-red-500"
            >
                {{ error }}
            </p>
        </div>
    </div>
</template>

<script setup>
import { useId } from 'vue';
import { useI18n } from 'vue-i18n';

const { locale } = useI18n();

const id = useId();

const model = defineModel({
    default: null,
});

const props = defineProps({
    height: {
        type: String,
        default: 'h-11',
    },

    label: {
        type: String,
        default: '',
    },

    name: {
        type: String,
        default: '',
    },

    icon: {
        type: String,
        default: '',
    },

    required: {
        type: Boolean,
        default: false,
    },

    options: {
        type: Array,
        default: () => [],
    },

    optionValue: {
        type: String,
        default: 'id',
    },

    optionLabel: {
        type: String,
        default: '',
    },

    placeholder: {
        type: String,
        default: '',
    },

    error: {
        type: String,
        default: '',
    },
});

const getOptionLabel = (option) => {
    const value = option?.[props.optionLabel];

    if (
        value &&
        typeof value === 'object'
    ) {
        return (
            value[locale.value] ??
            value.ru ??
            value.en ??
            ''
        );
    }

    return value ?? '';
};
</script>