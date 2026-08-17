<template>
    <section>
        <div
            class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8"
        >
            <!-- HEADER -->
            <div
                class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"
            >
                <div>
                    <div
                        class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400"
                    >
                        03 / TRANSDUCERS
                    </div>

                    <div class="mt-2 flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 text-slate-700"
                        >
                            <i class="bi bi-broadcast-pin text-lg"></i>
                        </div>

                        <h2
                            class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"
                        >
                            Применяемые преобразователи
                        </h2>
                    </div>

                    <p
                        class="mt-3 max-w-2xl text-sm leading-6 text-slate-500"
                    >
                        Совместимые преобразователи и датчики для
                        выполнения различных методов неразрушающего
                        контроля.
                    </p>
                </div>

                <div
                    v-if="transducers.length"
                    class="shrink-0 rounded-lg bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-500"
                >
                    {{ transducers.length }}
                    {{
                        transducers.length === 1
                            ? 'преобразователь'
                            : 'преобразователей'
                    }}
                </div>
            </div>

            <!-- NOTICE -->
            <div
                v-if="!hasProductTransducers && transducers.length"
                class="mt-6 flex items-start gap-3 rounded-xl border border-blue-100 bg-blue-50 px-4 py-3 text-xs leading-5 text-blue-700"
            >
                <i class="bi bi-info-circle mt-0.5 shrink-0"></i>

                <span>
                    Для данного прибора индивидуальные преобразователи
                    не указаны. Показаны стандартные ультразвуковые
                    преобразователи из каталога.
                </span>
            </div>

            <!-- LOADING -->
            <div
                v-if="isLoading"
                class="mt-8 flex items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 p-10"
            >
                <div class="flex items-center gap-3 text-sm text-slate-500">
                    <div
                        class="h-5 w-5 animate-spin rounded-full border-2 border-slate-200 border-t-slate-900"
                    ></div>

                    Загрузка преобразователей...
                </div>
            </div>

            <!-- ERROR -->
            <div
                v-else-if="errorMessage && !transducers.length"
                class="mt-8 rounded-2xl border border-rose-200 bg-rose-50 p-6 text-sm text-rose-700"
            >
                Не удалось загрузить стандартные преобразователи.
            </div>

            <!-- CARDS -->
            <div
                v-else-if="transducers.length"
                class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4"
            >
                <ProductTransducerCard
                    v-for="(transducer, index) in transducers"
                    :key="
                        transducer.id ||
                        transducer.slug ||
                        index
                    "
                    :transducer="transducer"
                    :has-product-transducers="hasProductTransducers"
                />
            </div>

            <!-- EMPTY -->
            <div
                v-else
                class="mt-8 rounded-2xl border border-dashed border-amber-200 bg-amber-50/60 p-6"
            >
                <MissingContent
                    title="Преобразователи не указаны"
                    text="Для данного прибора преобразователи не указаны, а стандартные ультразвуковые преобразователи отсутствуют в каталоге."
                />
            </div>
        </div>
    </section>
</template>

<script setup>
import MissingContent from '../MissingContent.vue';
import ProductTransducerCard from './ProductTransducerCard.vue';

defineProps({
    transducers: {
        type: Array,
        default: () => [],
    },

    isLoading: {
        type: Boolean,
        default: false,
    },

    errorMessage: {
        type: String,
        default: '',
    },

    hasProductTransducers: {
        type: Boolean,
        default: false,
    },
});
</script>