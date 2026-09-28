<template>
    <section class="space-y-6">
        <div>
            <h3 class="text-base font-semibold text-slate-900">
                {{ $t('product.info.details.title') }}
            </h3>
        </div>

        <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
            <!-- RU -->
            <div>
                <label
                    class="mb-2 block text-sm font-medium text-slate-700"
                >
                    Русский
                </label>

                <textarea
                    :value="modelValue?.ru ?? ''"
                    rows="8"
                    :disabled="!isManager"
                    class="w-full rounded-xl border px-4 py-3 text-sm text-slate-900 outline-none transition"
                    :class="
                        errors?.full_description_ru
                            ? 'border-red-500 ring-1 ring-red-200'
                            : 'border-slate-300 focus:border-slate-500 focus:ring-1 focus:ring-slate-200'
                    "
                    @input="
                        updateValue(
                            'ru',
                            $event.target.value,
                        )
                    "
                />

                <p
                    v-if="errors?.full_description_ru"
                    class="mt-1.5 text-xs text-red-600"
                >
                    {{ $t('validation.input.required') }}
                </p>
            </div>

            <!-- EN -->
            <div>
                <label
                    class="mb-2 block text-sm font-medium text-slate-700"
                >
                    English
                </label>

                <textarea
                    :value="modelValue?.en ?? ''"
                    rows="8"
                    :disabled="!isManager"
                    class="w-full rounded-xl border px-4 py-3 text-sm text-slate-900 outline-none transition"
                    :class="
                        errors?.full_description_en
                            ? 'border-red-500 ring-1 ring-red-200'
                            : 'border-slate-300 focus:border-slate-500 focus:ring-1 focus:ring-slate-200'
                    "
                    @input="
                        updateValue(
                            'en',
                            $event.target.value,
                        )
                    "
                />

                <p
                    v-if="errors?.full_description_en"
                    class="mt-1.5 text-xs text-red-600"
                >
                    {{ $t('validation.input.required') }}
                </p>
            </div>
        </div>
    </section>
</template>

<script setup>
const props = defineProps({
    modelValue: {
        type: Object,
        default: () => ({
            ru: '',
            en: '',
        }),
    },

    isManager: {
        type: Boolean,
        default: false,
    },

    errors: {
        type: Object,
        default: () => ({}),
    },
});

const emit = defineEmits([
    'update:modelValue',
]);

function updateValue(language, value) {
    emit('update:modelValue', {
        ...props.modelValue,
        [language]: value,
    });
}
</script>