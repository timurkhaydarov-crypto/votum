<template>
    <div
        v-if="itemsCount > initialCount"
        class="mt-6 flex justify-center"
    >
        <button
            type="button"
            class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-xs font-semibold text-slate-700 shadow-sm transition-all duration-200 hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900 hover:shadow-md active:scale-[0.98]"
            @click="handleClick"
        >
            <span>
                {{
                    expanded
                        ? $t('common.collapse')
                        : $t('common.showMore')
                }}
            </span>

            <svg
                class="h-4 w-4 transition-transform duration-200"
                :class="expanded ? 'rotate-180' : ''"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 9l6 6 6-6"
                />
            </svg>
        </button>
    </div>
</template>

<script setup>
const props = defineProps({
    itemsCount: {
        type: Number,
        required: true,
    },

    visibleCount: {
        type: Number,
        required: true,
    },

    initialCount: {
        type: Number,
        default: 4,
    },

    expanded: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits([
    'show-more',
    'collapse',
]);

/*
|--------------------------------------------------------------------------
| Click
|--------------------------------------------------------------------------
*/

const handleClick = () => {
    if (props.expanded) {
        emit('collapse');

        return;
    }

    emit('show-more');
};
</script>