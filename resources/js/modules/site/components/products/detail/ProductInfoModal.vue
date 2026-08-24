<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="infoKey"
                class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6"
                @click.self="emit('close')"
            >
                <!-- BACKDROP -->
                <div
                    class="absolute inset-0 bg-slate-950/50 backdrop-blur-sm"
                    @click="emit('close')"
                ></div>

                <!-- MODAL -->
                <div
                    class="relative z-10 flex max-h-[90vh] w-full max-w-[1400px] flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl"
                >
                    <!-- HEADER -->
                    <div
                        class="flex shrink-0 items-start justify-between gap-4 border-b border-slate-200 px-6 py-5 sm:px-8"
                    >
                        <div class="min-w-0">
                            <!-- ARTICLE -->
                            <div
                                class="mb-1 text-[9px] font-semibold uppercase tracking-[0.15em] text-slate-400"
                            >
                                {{ product.article }}
                            </div>

                            <!-- TITLE -->
                            <h2
                                class="text-xl font-bold tracking-tight text-slate-900 sm:text-2xl"
                            >
                                {{ modalTitle }}
                            </h2>
                        </div>

                        <!-- CLOSE -->
                        <button
                            type="button"
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-900"
                            @click="emit('close')"
                        >
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <!-- CONTENT -->
                    <div
                        class="min-h-0 overflow-y-auto px-6 py-6 sm:px-8 sm:py-8"
                    >
                        <!-- LOADING -->
                        <div
                            v-if="isLoading"
                            class="flex min-h-[220px] items-center justify-center"
                        >
                            <div
                                class="flex items-center gap-3 text-sm text-slate-500"
                            >
                                <span
                                    class="h-5 w-5 animate-spin rounded-full border-2 border-slate-200 border-t-slate-900"
                                ></span>

                                {{ $t('common.loading') }}
                            </div>
                        </div>

                        <!-- ERROR -->
                        <div
                            v-else-if="error"
                            class="rounded-xl border border-red-200 bg-red-50 p-5 text-sm text-red-700"
                        >
                            <div class="flex items-start gap-3">
                                <i
                                    class="bi bi-exclamation-triangle"
                                ></i>

                                <span>{{ error }}</span>
                            </div>
                        </div>

                        <!-- FEATURES -->
                        <div
                            v-else-if="
                                infoKey === 'features' &&
                                infoData
                            "
                            class="space-y-6"
                        >
                            <div
                                class="prose prose-slate max-w-none text-sm leading-7"
                                v-html="featuresText"
                            ></div>
                        </div>

                        <!-- EMPTY -->
                        <EmptyInfo
                            v-else
                            :title="$t('product.info.notAvailable')"
                        />
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

import EmptyInfo from '@/modules/site/components/shared/EmptyInfo.vue';

const { locale } = useI18n();

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },

    infoKey: {
        type: String,
        default: null,
    },

    infoData: {
        type: [Object, Array, String],
        default: null,
    },

    isLoading: {
        type: Boolean,
        default: false,
    },

    error: {
        type: String,
        default: null,
    },
});

const emit = defineEmits([
    'close',
]);

/*
|--------------------------------------------------------------------------
| Modal title
|--------------------------------------------------------------------------
*/

const modalTitle = computed(() => {
    switch (props.infoKey) {
        case 'features':
            return locale.value === 'en'
                ? 'Functional Features'
                : 'Функциональные особенности';

        case 'technical':
            return locale.value === 'en'
                ? 'Technical Specifications'
                : 'Технические характеристики';

        case 'documentation':
            return locale.value === 'en'
                ? 'Documentation'
                : 'Документация';

        case 'details':
            return locale.value === 'en'
                ? 'Details'
                : 'Подробнее';

        default:
            return (
                props.product.name ||
                (
                    locale.value === 'en'
                        ? 'Product Information'
                        : 'Информация о продукте'
                )
            );
    }
});

/*
|--------------------------------------------------------------------------
| Features
|--------------------------------------------------------------------------
*/

const featuresText = computed(() => {
    if (!props.infoData) {
        return '';
    }

    /*
     * API:
     *
     * {
     *     ru: "<div>...</div>",
     *     en: "<div>...</div>"
     * }
     */

    if (
        typeof props.infoData === 'object' &&
        !Array.isArray(props.infoData)
    ) {
        return (
            props.infoData[locale.value] ||
            props.infoData.ru ||
            props.infoData.en ||
            ''
        );
    }

    if (typeof props.infoData === 'string') {
        return props.infoData;
    }

    return '';
});
</script>