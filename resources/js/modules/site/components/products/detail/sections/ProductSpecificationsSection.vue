<template>
    <section class="space-y-5">
        <div
            class="flex items-center justify-between gap-4"
        >
            <div>
                <h3
                    class="text-base font-semibold text-slate-900"
                >
                    {{
                        $t(
                            'product.form.specifications.title',
                        )
                    }}
                </h3>
            </div>

            <button
                v-if="isManager"
                type="button"
                class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-3 py-2 text-sm font-medium text-white hover:bg-slate-800"
                @click="addSpecification"
            >
                <i class="bi bi-plus-lg"></i>

                {{
                    $t(
                        'product.form.specifications.add',
                    )
                }}
            </button>
        </div>

        <div
            v-if="modelValue?.length"
            class="space-y-4"
        >
            <div
                v-for="(
                    specification, index
                ) in modelValue"
                :key="
                    specification.id ??
                    `new-${index}`
                "
                class="rounded-xl border border-slate-200 bg-white p-5"
            >
                <div
                    class="mb-4 flex items-center justify-between"
                >
                    <span
                        class="text-sm font-semibold text-slate-700"
                    >
                        #{{ index + 1 }}
                    </span>

                    <button
                        v-if="isManager"
                        type="button"
                        class="text-red-600 hover:text-red-700"
                        @click="
                            removeSpecification(
                                index,
                            )
                        "
                    >
                        <i
                            class="bi bi-trash3"
                        ></i>
                    </button>
                </div>

                <div
                    class="grid grid-cols-1 gap-5 lg:grid-cols-2"
                >
                    <!-- NAME RU -->
                    <div>
                        <label
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            {{
                                $t(
                                    'product.form.specifications.nameRu',
                                )
                            }}
                        </label>

                        <input
                            type="text"
                            :value="
                                specification.name
                                    ?.ru ?? ''
                            "
                            :disabled="!isManager"
                            class="w-full rounded-lg border px-3 py-2 text-sm text-slate-900 outline-none transition"
                            :class="
                                hasError(
                                    index,
                                    'name_ru',
                                )
                                    ? 'border-red-500 ring-1 ring-red-200'
                                    : 'border-slate-300 focus:border-slate-500 focus:ring-1 focus:ring-slate-200'
                            "
                            @input="
                                updateSpecification(
                                    index,
                                    'name',
                                    'ru',
                                    $event.target.value,
                                )
                            "
                        />

                        <p
                            v-if="
                                hasError(
                                    index,
                                    'name_ru',
                                )
                            "
                            class="mt-1.5 text-xs text-red-600"
                        >
                            {{
                                $t(
                                    'validation.input.required',
                                )
                            }}
                        </p>
                    </div>

                    <!-- NAME EN -->
                    <div>
                        <label
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            {{
                                $t(
                                    'product.form.specifications.nameEn',
                                )
                            }}
                        </label>

                        <input
                            type="text"
                            :value="
                                specification.name
                                    ?.en ?? ''
                            "
                            :disabled="!isManager"
                            class="w-full rounded-lg border px-3 py-2 text-sm text-slate-900 outline-none transition"
                            :class="
                                hasError(
                                    index,
                                    'name_en',
                                )
                                    ? 'border-red-500 ring-1 ring-red-200'
                                    : 'border-slate-300 focus:border-slate-500 focus:ring-1 focus:ring-slate-200'
                            "
                            @input="
                                updateSpecification(
                                    index,
                                    'name',
                                    'en',
                                    $event.target.value,
                                )
                            "
                        />

                        <p
                            v-if="
                                hasError(
                                    index,
                                    'name_en',
                                )
                            "
                            class="mt-1.5 text-xs text-red-600"
                        >
                            {{
                                $t(
                                    'validation.input.required',
                                )
                            }}
                        </p>
                    </div>

                    <!-- VALUE RU -->
                    <div>
                        <label
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            {{
                                $t(
                                    'product.form.specifications.valueRu',
                                )
                            }}
                        </label>

                        <input
                            type="text"
                            :value="
                                specification.value
                                    ?.ru ?? ''
                            "
                            :disabled="!isManager"
                            class="w-full rounded-lg border px-3 py-2 text-sm text-slate-900 outline-none transition"
                            :class="
                                hasError(
                                    index,
                                    'value_ru',
                                )
                                    ? 'border-red-500 ring-1 ring-red-200'
                                    : 'border-slate-300 focus:border-slate-500 focus:ring-1 focus:ring-slate-200'
                            "
                            @input="
                                updateSpecification(
                                    index,
                                    'value',
                                    'ru',
                                    $event.target.value,
                                )
                            "
                        />

                        <p
                            v-if="
                                hasError(
                                    index,
                                    'value_ru',
                                )
                            "
                            class="mt-1.5 text-xs text-red-600"
                        >
                            {{
                                $t(
                                    'validation.input.required',
                                )
                            }}
                        </p>
                    </div>

                    <!-- VALUE EN -->
                    <div>
                        <label
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            {{
                                $t(
                                    'product.form.specifications.valueEn',
                                )
                            }}
                        </label>

                        <input
                            type="text"
                            :value="
                                specification.value
                                    ?.en ?? ''
                            "
                            :disabled="!isManager"
                            class="w-full rounded-lg border px-3 py-2 text-sm text-slate-900 outline-none transition"
                            :class="
                                hasError(
                                    index,
                                    'value_en',
                                )
                                    ? 'border-red-500 ring-1 ring-red-200'
                                    : 'border-slate-300 focus:border-slate-500 focus:ring-1 focus:ring-slate-200'
                            "
                            @input="
                                updateSpecification(
                                    index,
                                    'value',
                                    'en',
                                    $event.target.value,
                                )
                            "
                        />

                        <p
                            v-if="
                                hasError(
                                    index,
                                    'value_en',
                                )
                            "
                            class="mt-1.5 text-xs text-red-600"
                        >
                            {{
                                $t(
                                    'validation.input.required',
                                )
                            }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div
            v-else
            class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center"
        >
            <p class="text-sm text-slate-500">
                {{
                    $t(
                        'product.info.specifications.empty',
                    )
                }}
            </p>

            <button
                v-if="isManager"
                type="button"
                class="mt-4 inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800"
                @click="addSpecification"
            >
                <i class="bi bi-plus-lg"></i>

                {{
                    $t(
                        'product.form.specifications.add',
                    )
                }}
            </button>
        </div>
    </section>
</template>

<script setup>
const props = defineProps({
    modelValue: {
        type: Array,
        default: () => [],
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

function addSpecification() {
    emit('update:modelValue', [
        ...props.modelValue,
        {
            id: null,
            name: {
                ru: '',
                en: '',
            },
            value: {
                ru: '',
                en: '',
            },
        },
    ]);
}

function removeSpecification(index) {
    const specifications = [
        ...props.modelValue,
    ];

    specifications.splice(index, 1);

    emit(
        'update:modelValue',
        specifications,
    );
}

function updateSpecification(
    index,
    field,
    language,
    value,
) {
    const specifications =
        props.modelValue.map(
            (item, itemIndex) => {
                if (
                    itemIndex !== index
                ) {
                    return item;
                }

                return {
                    ...item,
                    [field]: {
                        ...(item[field] ?? {}),
                        [language]: value,
                    },
                };
            },
        );

    emit(
        'update:modelValue',
        specifications,
    );
}

function hasError(index, field) {
    return Boolean(
        props.errors?.specifications?.[
            index
        ]?.[field],
    );
}
</script>