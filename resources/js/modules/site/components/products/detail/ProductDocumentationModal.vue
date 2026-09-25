<template>
    <Transition name="documentation-fade">
        <div
            v-if="isOpen"
            class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-slate-950/60 p-4 backdrop-blur-sm"
            @mousedown.self="close"
        >
            <div
                class="relative my-auto w-full max-w-2xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl"
            >
                <!-- ====================================================
                     HEADER
                     ==================================================== -->
                <div
                    class="flex items-start justify-between gap-4 border-b border-slate-200 px-5 py-5 sm:px-7"
                >
                    <div class="min-w-0">
                        <div
                            class="mb-2 flex items-center gap-2 text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-400"
                        >
                            <i class="bi bi-file-earmark-text"></i>

                            {{
                                $t(
                                    'product.info.documentation.title',
                                    'Документация'
                                )
                            }}
                        </div>

                        <h2
                            class="text-xl font-semibold tracking-[-0.02em] text-slate-900"
                        >
                            {{ productName }}
                        </h2>

                        <p
                            v-if="product?.article"
                            class="mt-1 text-xs text-slate-400"
                        >
                            {{ product.article }}
                        </p>
                    </div>

                    <button
                        type="button"
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                        @click="close"
                    >
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <!-- ====================================================
                     ACCESS KEY
                     ==================================================== -->
                <div
                    v-if="!authorized"
                    class="px-5 py-7 sm:px-7 sm:py-8"
                >
                    <div class="mx-auto max-w-md">
                        <!-- ICON -->

                        <div
                            class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-700"
                        >
                            <i
                                class="bi bi-shield-lock text-2xl"
                            ></i>
                        </div>

                        <div class="mt-5 text-center">
                            <h3
                                class="text-lg font-semibold text-slate-900"
                            >
                                Введите ключ доступа
                            </h3>

                            <p
                                class="mt-2 text-sm leading-6 text-slate-500"
                            >
                                Для просмотра технической документации
                                требуется ключ доступа к этому прибору.
                            </p>
                        </div>

                        <!-- FORM -->

                        <form
                            class="mt-6"
                            @submit.prevent="submit"
                        >
                            <label
                                for="documentation-key"
                                class="mb-2 block text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-400"
                            >
                                Ключ доступа
                            </label>

                            <div class="relative">
                                <input
                                    id="documentation-key"
                                    ref="keyInput"
                                    v-model="key"
                                    type="password"
                                    autocomplete="off"
                                    spellcheck="false"
                                    :disabled="isLoading"
                                    placeholder="Введите ключ"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3.5 pr-11 text-sm text-slate-900 outline-none transition placeholder:text-slate-300 focus:border-slate-400 focus:ring-2 focus:ring-slate-900/5 disabled:bg-slate-50"
                                />

                                <i
                                    class="bi bi-key absolute right-4 top-1/2 -translate-y-1/2 text-slate-300"
                                ></i>
                            </div>

                            <!-- ERROR -->

                            <div
                                v-if="error"
                                class="mt-3 flex items-start gap-2 rounded-xl border border-red-200 bg-red-50 px-3.5 py-3 text-xs leading-5 text-red-700"
                            >
                                <i
                                    class="bi bi-exclamation-circle mt-0.5 shrink-0"
                                ></i>

                                <span>{{ error }}</span>
                            </div>

                            <!-- SUBMIT -->

                            <button
                                type="submit"
                                :disabled="
                                    isLoading ||
                                    !key.trim()
                                "
                                class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.08em] text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <span
                                    v-if="isLoading"
                                    class="h-4 w-4 animate-spin rounded-full border-2 border-white/30 border-t-white"
                                ></span>

                                <i
                                    v-else
                                    class="bi bi-unlock"
                                ></i>

                                {{
                                    isLoading
                                        ? 'Проверка...'
                                        : 'Получить документацию'
                                }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- ====================================================
                     DOCUMENTS
                     ==================================================== -->
                <div
                    v-else
                    class="px-5 py-6 sm:px-7"
                >
                    <!-- AUTHORIZED -->

                    <div
                        class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3"
                    >
                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700"
                        >
                            <i class="bi bi-check-lg"></i>
                        </div>

                        <div>
                            <div
                                class="text-xs font-semibold text-emerald-800"
                            >
                                Доступ подтверждён
                            </div>

                            <div
                                class="mt-0.5 text-[11px] text-emerald-600"
                            >
                                Доступная документация прибора
                            </div>
                        </div>
                    </div>

                    <!-- DOCUMENT LIST -->

                    <div
                        v-if="documents.length"
                        class="mt-5 space-y-3"
                    >
                        <div
                            v-for="document in documents"
                            :key="document.id"
                            class="rounded-xl border border-slate-200 bg-white p-4"
                        >
                            <!-- DOCUMENT HEADER -->

                            <div
                                class="flex items-start justify-between gap-4"
                            >
                                <div
                                    class="flex min-w-0 gap-3"
                                >
                                    <div
                                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-700"
                                    >
                                        <i
                                            class="bi bi-file-earmark-pdf text-lg"
                                        ></i>
                                    </div>

                                    <div class="min-w-0">
                                        <div
                                            class="truncate text-sm font-semibold text-slate-900"
                                        >
                                            {{
                                                documentTitle(
                                                    document
                                                )
                                            }}
                                        </div>

                                        <div
                                            v-if="
                                                documentDescription(
                                                    document
                                                )
                                            "
                                            class="mt-1 text-xs leading-5 text-slate-500"
                                        >
                                            {{
                                                documentDescription(
                                                    document
                                                )
                                            }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- CURRENT LOCALE FILE -->

                            <div
                                v-if="
                                    documentCurrentFile(
                                        document
                                    )
                                "
                                class="mt-4"
                            >
                                <div
                                    class="flex items-center justify-between gap-3 rounded-lg border border-slate-100 bg-slate-50 px-3 py-3"
                                >
                                    <div
                                        class="flex min-w-0 items-center gap-2"
                                    >
                                        <i
                                            class="bi bi-filetype-pdf shrink-0 text-red-500"
                                        ></i>

                                        <div
                                            class="min-w-0"
                                        >
                                            <div
                                                class="truncate text-xs font-medium text-slate-700"
                                            >
                                                {{
                                                    documentCurrentFile(
                                                        document
                                                    ).original_name
                                                }}
                                            </div>

                                            <div
                                                class="mt-0.5 text-[10px] text-slate-400"
                                            >
                                                {{
                                                    localeLabel(
                                                        currentLocale
                                                    )
                                                }}

                                                <span
                                                    v-if="
                                                        documentCurrentFile(
                                                            document
                                                        ).file_size
                                                    "
                                                >
                                                    ·
                                                    {{
                                                        formatFileSize(
                                                            documentCurrentFile(
                                                                document
                                                            ).file_size
                                                        )
                                                    }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- OPEN PDF -->

                                    <button
                                        type="button"
                                        class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-slate-900 px-3 py-2 text-[10px] font-semibold uppercase tracking-[0.06em] text-white transition hover:bg-slate-800"
                                        @click="
                                            openPdf(
                                                documentCurrentFile(
                                                    document
                                                )
                                            )
                                        "
                                    >
                                        <i
                                            class="bi bi-box-arrow-up-right"
                                        ></i>

                                        Открыть PDF
                                    </button>
                                </div>
                            </div>

                            <!-- NO CURRENT LOCALE FILE -->

                            <div
                                v-else
                                class="mt-4 rounded-lg border border-amber-200 bg-amber-50 px-3 py-2.5 text-xs text-amber-700"
                            >
                                Документ на текущем языке отсутствует.
                            </div>
                        </div>
                    </div>

                    <!-- EMPTY -->

                    <div
                        v-else
                        class="py-10 text-center"
                    >
                        <div
                            class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-slate-400"
                        >
                            <i
                                class="bi bi-folder2-open text-xl"
                            ></i>
                        </div>

                        <div
                            class="mt-4 text-sm font-semibold text-slate-700"
                        >
                            Документация отсутствует
                        </div>

                        <p
                            class="mt-1 text-xs text-slate-400"
                        >
                            Для этого прибора пока нет доступных документов.
                        </p>
                    </div>
                </div>

                <!-- ====================================================
                     FOOTER
                     ==================================================== -->

                <div
                    class="flex justify-end border-t border-slate-200 bg-slate-50/70 px-5 py-4 sm:px-7"
                >
                    <button
                        type="button"
                        class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-900"
                        @click="close"
                    >
                        Закрыть
                    </button>
                </div>
            </div>
        </div>
    </Transition>
</template>

<script setup>
import {
    computed,
    nextTick,
    ref,
    watch,
} from 'vue';

import { useI18n } from 'vue-i18n';

const { locale } = useI18n();

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },

    documents: {
        type: Array,
        default: () => [],
    },

    isOpen: {
        type: Boolean,
        default: false,
    },

    isLoading: {
        type: Boolean,
        default: false,
    },

    error: {
        type: String,
        default: null,
    },

    authorized: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits([
    'close',
    'submitKey',
    'openPdf',
]);

const key = ref('');
const keyInput = ref(null);

const documents = computed(() => {
    return Array.isArray(props.documents)
        ? props.documents
        : [];
});

/*
|--------------------------------------------------------------------------
| CURRENT LOCALE
|--------------------------------------------------------------------------
*/

const currentLocale = computed(() => {
    const value = String(
        locale.value || 'ru',
    ).toLowerCase();

    return value.startsWith('en')
        ? 'en'
        : 'ru';
});

/*
|--------------------------------------------------------------------------
| PRODUCT
|--------------------------------------------------------------------------
*/

const productName = computed(() => {
    const name = props.product?.name;

    if (typeof name === 'string') {
        return name;
    }

    if (name && typeof name === 'object') {
        return (
            name[currentLocale.value] ||
            name.ru ||
            name.en ||
            'NDT equipment'
        );
    }

    return 'NDT equipment';
});

/*
|--------------------------------------------------------------------------
| LOCALIZATION
|--------------------------------------------------------------------------
*/

const localizedValue = (value) => {
    if (!value) {
        return '';
    }

    if (typeof value === 'string') {
        return value;
    }

    if (typeof value === 'object') {
        return (
            value[currentLocale.value] ||
            value.ru ||
            value.en ||
            Object.values(value)[0] ||
            ''
        );
    }

    return String(value);
};

const documentTitle = (document) => {
    return (
        localizedValue(document?.title) ||
        document?.type ||
        'Документ'
    );
};

const documentDescription = (document) => {
    return localizedValue(
        document?.description,
    );
};

/*
|--------------------------------------------------------------------------
| CURRENT LOCALE FILE
|--------------------------------------------------------------------------
|
| Например:
|
| locale = ru
| → manual_ru.pdf
|
| locale = en
| → manual_en.pdf
|
*/

const documentCurrentFile = (document) => {
    if (
        !document ||
        !Array.isArray(document.files)
    ) {
        return null;
    }

    return (
        document.files.find(
            (file) =>
                String(file.locale).toLowerCase() ===
                currentLocale.value,
        ) || null
    );
};

/*
|--------------------------------------------------------------------------
| FILE
|--------------------------------------------------------------------------
*/

const localeLabel = (value) => {
    return String(value).toLowerCase() === 'ru'
        ? 'Русский'
        : 'English';
};

const formatFileSize = (bytes) => {
    const value = Number(bytes);

    if (!Number.isFinite(value) || value <= 0) {
        return '';
    }

    if (value < 1024) {
        return `${value} B`;
    }

    if (value < 1024 * 1024) {
        return `${(value / 1024).toFixed(1)} KB`;
    }

    return `${(value / (1024 * 1024)).toFixed(1)} MB`;
};

/*
|--------------------------------------------------------------------------
| ACCESS
|--------------------------------------------------------------------------
*/

const submit = () => {
    const value = key.value.trim();

    if (!value || props.isLoading) {
        return;
    }

    emit('submitKey', value);
};

/*
|--------------------------------------------------------------------------
| PDF
|--------------------------------------------------------------------------
*/

const openPdf = (file) => {
    if (!file?.id) {
        return;
    }

    emit('openPdf', {
        file,
        key: key.value,
    });
};

/*
|--------------------------------------------------------------------------
| CLOSE
|--------------------------------------------------------------------------
*/

const close = () => {
    if (props.isLoading) {
        return;
    }

    emit('close');
};

/*
|--------------------------------------------------------------------------
| WATCH
|--------------------------------------------------------------------------
*/

watch(
    () => props.isOpen,
    async (isOpen) => {
        if (!isOpen) {
            key.value = '';

            return;
        }

        await nextTick();

        keyInput.value?.focus();
    },
);
</script>

<style scoped>
.documentation-fade-enter-active,
.documentation-fade-leave-active {
    transition:
        opacity 0.2s ease,
        transform 0.2s ease;
}

.documentation-fade-enter-from,
.documentation-fade-leave-to {
    opacity: 0;
}

.documentation-fade-enter-from > div,
.documentation-fade-leave-to > div {
    transform: translateY(8px) scale(0.99);
}
</style>