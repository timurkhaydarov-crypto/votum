<template>
    <div
        :class="[
            'rounded-lg border p-2.5',
            hasValue(value)
                ? 'border-slate-200 bg-white'
                : 'border-amber-200 bg-amber-50/50',
        ]"
    >
        <div class="flex items-center gap-2">
            <div
                :class="[
                    'flex h-7 w-7 shrink-0 items-center justify-center rounded-md text-xs',
                    hasValue(value)
                        ? 'bg-slate-100 text-slate-700'
                        : 'bg-amber-100 text-amber-700',
                ]"
            >
                <i :class="`bi ${icon}`"></i>
            </div>

            <span
                class="min-w-0 truncate text-[9px] font-semibold uppercase tracking-wide text-slate-400"
            >
                {{ label }}
            </span>
        </div>

        <div
            :class="[
                'mt-1.5 truncate text-[11px] font-semibold leading-4',
                hasValue(value)
                    ? 'text-slate-800'
                    : 'text-amber-700',
            ]"
        >
            {{ hasValue(value) ? value : 'Данные отсутствуют' }}
        </div>
    </div>
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
});

const hasValue = (value) => {
    if (value === null || value === undefined) {
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
</script>