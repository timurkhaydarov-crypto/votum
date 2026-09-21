<template>
    <div
        class="group relative w-full text-left"
        :class="[
            disabled && !canManage
                ? 'cursor-not-allowed'
                : 'cursor-pointer',
        ]"
    >
        <div
            :class="[
                'rounded-lg border p-2.5 transition-all duration-200',

                /* DISABLED */
                disabled && !canManage
                    ? 'cursor-not-allowed border-slate-200 bg-slate-100 opacity-60'

                    /* ACTIVE */
                    : active
                        ? 'border-slate-900 bg-slate-900 shadow-md shadow-slate-900/10'

                        /* HAS VALUE */
                        : hasValue(value)
                            ? 'border-slate-200 bg-white hover:-translate-y-0.5 hover:border-slate-300 hover:bg-slate-50 hover:shadow-sm'

                            /* NO VALUE */
                            : 'border-amber-200 bg-amber-50/50 hover:border-amber-300 hover:bg-amber-50 hover:shadow-sm',
            ]"
            @click="handleSelect"
        >
            <!-- MANAGE BUTTON -->
            <button
                v-if="canManage"
                type="button"
                class="absolute right-2 top-2 z-10 flex h-5 w-5 items-center justify-center rounded-md border transition-all duration-200"
                :class="
                    hasValue(value)
                        ? 'border-slate-200 bg-white text-slate-400 hover:border-slate-900 hover:bg-slate-900 hover:text-white'
                        : 'border-amber-200 bg-white text-amber-600 hover:border-emerald-500 hover:bg-emerald-500 hover:text-white'
                "
                :title="
                    hasValue(value)
                        ? editLabel
                        : addLabel
                "
                :aria-label="
                    hasValue(value)
                        ? editLabel
                        : addLabel
                "
                @click.stop="emit('manage')"
            >
                <i
                    class="bi text-[10px]"
                    :class="
                        hasValue(value)
                            ? 'bi-pencil'
                            : 'bi-plus-lg'
                    "
                ></i>
            </button>

            <!-- ICON + LABEL -->
            <div class="flex items-center gap-2 pr-6">
                <!-- ICON -->
                <div
                    :class="[
                        'flex h-7 w-7 shrink-0 items-center justify-center rounded-md text-xs transition-all duration-200',

                        disabled && !canManage
                            ? 'bg-slate-200 text-slate-400'

                            : active
                                ? 'bg-white/10 text-white'

                                : hasValue(value)
                                    ? 'bg-slate-100 text-slate-700 group-hover:bg-slate-200'

                                    : 'bg-amber-100 text-amber-700 group-hover:bg-amber-200',
                    ]"
                >
                    <i :class="`bi ${icon}`"></i>
                </div>

                <!-- LABEL -->
                <span
                    :class="[
                        'min-w-0 truncate text-[9px] font-semibold uppercase tracking-wide transition-colors duration-200',

                        disabled && !canManage
                            ? 'text-slate-400'

                            : active
                                ? 'text-white/60'

                                : 'text-slate-400 group-hover:text-slate-500',
                    ]"
                >
                    {{ label }}
                </span>
            </div>

            <!-- VALUE -->
            <div
                :class="[
                    'mt-1.5 truncate text-[11px] font-semibold leading-4 transition-colors duration-200',

                    disabled && !canManage
                        ? 'text-slate-400'

                        : active
                            ? 'text-white'

                            : hasValue(value)
                                ? 'text-slate-800'

                                : 'text-amber-700',
                ]"
            >
                {{
                    hasValue(value)
                        ? value
                        : noDataLabel
                }}
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    label: {
        type: String,
        default: '',
    },

    value: {
        type: [String, Number, Array],
        default: null,
    },

    icon: {
        type: String,
        default: '',
    },

    active: {
        type: Boolean,
        default: false,
    },

    disabled: {
        type: Boolean,
        default: false,
    },

    canManage: {
        type: Boolean,
        default: false,
    },

    noDataLabel: {
        type: String,
        default: 'Данные отсутствуют',
    },

    addLabel: {
        type: String,
        default: 'Добавить',
    },

    editLabel: {
        type: String,
        default: 'Редактировать',
    },
});

const emit = defineEmits([
    'select',
    'manage',
]);

const hasValue = (value) => {
    if (
        value === null ||
        value === undefined
    ) {
        return false;
    }

    if (typeof value === 'string') {
        return value.trim().length > 0;
    }

    if (Array.isArray(value)) {
        return value.length > 0;
    }

    return true;
};

const handleSelect = () => {
    if (props.disabled) {
        return;
    }

    emit('select');
};
</script>

