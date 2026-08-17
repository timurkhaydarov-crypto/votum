<template>
    <div>
        <div class="flex flex-wrap items-center gap-2">
            <span
                class="text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-400"
            >
                {{ product.article || 'ARTICLE N/A' }}
            </span>

            <span class="h-0.5 w-0.5 rounded-full bg-slate-300"></span>

            <span
                :class="[
                    'inline-flex items-center gap-1.5 text-[10px] font-semibold',
                    isInStock
                        ? 'text-emerald-600'
                        : 'text-slate-400',
                ]"
            >
                <span
                    :class="[
                        'h-1.5 w-1.5 rounded-full',
                        isInStock
                            ? 'bg-emerald-500'
                            : 'bg-slate-300',
                    ]"
                ></span>

                {{
                    isInStock
                        ? 'В наличии'
                        : 'Нет в наличии'
                }}
            </span>
        </div>

        <h1
            class="mt-3 max-w-2xl text-2xl font-bold leading-tight tracking-[-0.025em] text-slate-900 sm:text-[1.75rem]"
        >
            {{ product.name || 'Без названия' }}
        </h1>

        <p class="mt-3 max-w-xl text-sm leading-6 text-slate-500">
            {{
                product.shortDescription ||
                'Профессиональное оборудование для неразрушающего контроля.'
            }}
        </p>

        <div class="my-5 h-px bg-slate-200"></div>

        <div class="grid grid-cols-2 gap-2.5">
            <InfoItem
                label="Метод контроля"
                :value="product.method"
                icon="bi-broadcast"
            />

            <InfoItem
                label="Область применения"
                :value="product.application || product.categoryTitle"
                icon="bi-buildings"
            />

            <InfoItem
                label="Диапазон частот"
                :value="product.frequency"
                icon="bi-activity"
            />

            <InfoItem
                label="Дисплей"
                :value="product.display"
                icon="bi-display"
            />
        </div>
    </div>
</template>

<script setup>
import InfoItem from './InfoItem.vue';

defineProps({
    product: {
        type: Object,
        required: true,
    },

    isInStock: {
        type: Boolean,
        default: false,
    },
});
</script>