<template>
    <section>
        <SectionHeader
            eyebrow="01 / TECHNICAL DATA"
            title="Технические характеристики"
            description="Основные параметры и технические возможности оборудования."
        />

        <div
            class="overflow-hidden rounded-[1.5rem] border border-slate-200 bg-white shadow-sm"
        >
            <div
                v-for="(item, index) in visibleCharacteristics"
                :key="item.key"
                :class="[
                    'grid gap-2 px-5 py-4 sm:grid-cols-[minmax(180px,0.7fr)_1.3fr] sm:px-6',
                    index !== visibleCharacteristics.length - 1
                        ? 'border-b border-slate-100'
                        : '',
                    !item.available
                        ? 'bg-amber-50/40'
                        : 'bg-white',
                ]"
            >
                <div
                    class="text-xs font-medium uppercase tracking-wider text-slate-400"
                >
                    {{ item.label }}
                </div>

                <div
                    v-if="item.available"
                    class="text-sm font-semibold text-slate-800"
                >
                    {{ item.value }}
                </div>

                <div
                    v-else
                    class="flex items-center gap-2 text-sm text-amber-700"
                >
                    <i class="bi bi-info-circle"></i>

                    <span>
                        Данные отсутствуют
                    </span>
                </div>
            </div>

            <button
                v-if="characteristics.length > 6"
                type="button"
                class="flex w-full items-center justify-center gap-2 border-t border-slate-100 bg-slate-50/60 px-5 py-3.5 text-xs font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900"
                @click="showAll = !showAll"
            >
                <span>
                    {{
                        showAll
                            ? 'Скрыть характеристики'
                            : 'Показать все характеристики'
                    }}
                </span>

                <i
                    :class="[
                        'bi text-sm transition-transform duration-200',
                        showAll
                            ? 'bi-chevron-up'
                            : 'bi-chevron-down',
                    ]"
                ></i>
            </button>
        </div>
    </section>
</template>

<script setup>
import { computed, ref } from 'vue';
import SectionHeader from '../SectionHeader.vue';

const props = defineProps({
    characteristics: {
        type: Array,
        default: () => [],
    },
});

const showAll = ref(false);

const visibleCharacteristics = computed(() => {
    if (showAll.value) {
        return props.characteristics;
    }

    return props.characteristics.slice(0, 6);
});
</script>