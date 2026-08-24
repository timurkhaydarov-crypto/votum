<template>
    <button
        type="button"
        class="group w-full text-left"
        @click="emit('select')"
    >
        <div
            :class="[
                'rounded-lg border p-2.5 transition-all duration-200',
                active
                    ? 'border-slate-900 bg-slate-900 shadow-md shadow-slate-900/10'
                    : hasValue(value)
                        ? 'border-slate-200 bg-white hover:-translate-y-0.5 hover:border-slate-300 hover:bg-slate-50 hover:shadow-sm active:translate-y-0 active:scale-[0.98]'
                        : 'border-amber-200 bg-amber-50/50 hover:-translate-y-0.5 hover:border-amber-300 hover:bg-amber-50 hover:shadow-sm active:translate-y-0 active:scale-[0.98]',
            ]"
        >
            <div class="flex items-center gap-2">
                <div
                    :class="[
                        'flex h-7 w-7 shrink-0 items-center justify-center rounded-md text-xs transition-all duration-200',
                        active
                            ? 'bg-white/10 text-white'
                            : hasValue(value)
                                ? 'bg-slate-100 text-slate-700 group-hover:bg-slate-200'
                                : 'bg-amber-100 text-amber-700 group-hover:bg-amber-200',
                    ]"
                >
                    <i :class="`bi ${icon}`"></i>
                </div>

                <span
                    :class="[
                        'min-w-0 truncate text-[9px] font-semibold uppercase tracking-wide transition-colors duration-200',
                        active
                            ? 'text-white/60'
                            : 'text-slate-400 group-hover:text-slate-500',
                    ]"
                >
                    {{ label }}
                </span>
            </div>

            <div
                :class="[
                    'mt-1.5 truncate text-[11px] font-semibold leading-4 transition-colors duration-200',
                    active
                        ? 'text-white'
                        : hasValue(value)
                            ? 'text-slate-800'
                            : 'text-amber-700',
                ]"
            >
                {{ hasValue(value) ? value : 'Данные отсутствуют' }}
            </div>
        </div>
    </button>
</template>

<script setup>
defineProps({
    label: {
        type: String,
        default: '',
    },

    value: {
        type: [String, Number],
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
})

const emit = defineEmits(['select']);

const hasValue = (value) => {
    if (value === null || value === undefined) {
        return false
    }

    if (typeof value === 'string') {
        return value.trim().length > 0
    }

    if (Array.isArray(value)) {
        return value.length > 0
    }

    return true
}
</script>