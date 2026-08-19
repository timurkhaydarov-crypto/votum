<template>
    <div>
        <div class="flex flex-wrap items-center gap-2">
            <span class="text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-400">
                {{ props.product.article || 'ARTICLE N/A' }}
            </span>

            <span class="h-0.5 w-0.5 rounded-full bg-slate-300"></span>

            <span :class="[
                'inline-flex items-center gap-1.5 text-[10px] font-semibold',
                isInStock
                    ? 'text-emerald-600'
                    : 'text-slate-400',
            ]">
                <span :class="[
                    'h-1.5 w-1.5 rounded-full',
                    isInStock
                        ? 'bg-emerald-500'
                        : 'bg-slate-300',
                ]"></span>

                {{ isInStock ? 'В наличии' : 'Нет в наличии' }}
            </span>
        </div>

        <h1
            class="mt-3 max-w-2xl text-2xl font-bold leading-tight tracking-[-0.025em] text-slate-900 sm:text-[1.75rem]">
            {{ props.product.name || 'Без названия' }}
        </h1>

        <p class="mt-3 max-w-xl text-sm leading-6 text-slate-500">
            {{
                props.product.shortDescription ||
                'Профессиональное оборудование для неразрушающего контроля.'
            }}
        </p>

        <div class="my-5 h-px bg-slate-200"></div>

        <!-- Navigation -->
        <div class="grid grid-cols-2 gap-2.5">
            <InfoItem v-for="item in infoItems" :key="item.key" :label="item.label" :value="item.value()"
                :icon="item.icon" :active="activeInfo === item.key" @select="emit('changeInfo', item.key)" />
        </div>
    </div>
</template>

<script setup>
import InfoItem from './InfoItem.vue'

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },

    isInStock: {
        type: Boolean,
        default: false,
    },

    activeInfo: {
        type: String,
        default: 'method',
    },
})

const emit = defineEmits(['changeInfo'])

const infoItems = [
    {
        key: 'method',
        label: 'Метод контроля',
        icon: 'bi-broadcast',
        value: () => props.product.method,
    },
    {
        key: 'features',
        label: 'Функциональные особенности',
        icon: 'bi-stars',
        value: () =>
            props.product.application ||
            props.product.categoryTitle,
    },
    {
        key: 'technical',
        label: 'Технические характеристики',
        icon: 'bi-sliders',
        value: () =>
            props.product.application ||
            props.product.categoryTitle,
    },
    {
        key: 'documentation',
        label: 'Документация',
        icon: 'bi-file-earmark-text',
        value: () =>
            props.product.application ||
            props.product.categoryTitle,
    },
]
</script>