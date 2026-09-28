<template>
    <section class="space-y-8">
        <!-- FEATURES -->
        <div class="space-y-5">
            <div>
                <h3
                    class="text-base font-semibold text-slate-900"
                >
                    {{ $t('product.info.features.title') }}
                </h3>
            </div>

            <div
                class="grid grid-cols-1 gap-5 lg:grid-cols-2"
            >
                <!-- RU -->
                <div>
                    <label
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        {{ $t('product.form.features.ru') }}
                    </label>

                    <textarea
                        :value="modelValue?.ru ?? ''"
                        rows="8"
                        :disabled="!isManager"
                        class="w-full rounded-xl border px-4 py-3 text-sm text-slate-900 outline-none transition"
                        :class="
                            errors?.features_ru
                                ? 'border-red-500 ring-1 ring-red-200'
                                : 'border-slate-300 focus:border-slate-500 focus:ring-1 focus:ring-slate-200'
                        "
                        @input="
                            updateFeature(
                                'ru',
                                $event.target.value,
                            )
                        "
                    />

                    <p
                        v-if="errors?.features_ru"
                        class="mt-1.5 text-xs text-red-600"
                    >
                        {{
                            $t(
                                'validation.input.required',
                            )
                        }}
                    </p>
                </div>

                <!-- EN -->
                <div>
                    <label
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        {{ $t('product.form.features.en') }}
                    </label>

                    <textarea
                        :value="modelValue?.en ?? ''"
                        rows="8"
                        :disabled="!isManager"
                        class="w-full rounded-xl border px-4 py-3 text-sm text-slate-900 outline-none transition"
                        :class="
                            errors?.features_en
                                ? 'border-red-500 ring-1 ring-red-200'
                                : 'border-slate-300 focus:border-slate-500 focus:ring-1 focus:ring-slate-200'
                        "
                        @input="
                            updateFeature(
                                'en',
                                $event.target.value,
                            )
                        "
                    />

                    <p
                        v-if="errors?.features_en"
                        class="mt-1.5 text-xs text-red-600"
                    >
                        {{
                            $t(
                                'validation.input.required',
                            )
                        }}
                    </p>
                </div>
            </div>
        </div>

        <!-- FEATURES GALLERY -->
        <div class="space-y-5">
            <div
                class="flex items-center justify-between gap-4"
            >
                <div>
                    <h3
                        class="text-base font-semibold text-slate-900"
                    >
                        {{
                            $t(
                                'product.form.featuresGallery.title',
                            )
                        }}
                    </h3>
                </div>

                <button
                    v-if="isManager"
                    type="button"
                    :disabled="
                        gallery.length >= maxGalleryItems
                    "
                    class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-3 py-2 text-sm font-medium text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
                    @click="openFilePicker"
                >
                    <i class="bi bi-plus-lg"></i>

                    {{
                        $t(
                            'product.form.featuresGallery.add',
                        )
                    }}
                </button>

                <input
                    ref="fileInput"
                    type="file"
                    class="hidden"
                    accept="image/jpeg,image/png,image/webp"
                    multiple
                    @change="handleFiles"
                />
            </div>

            <div
                v-if="gallery.length"
                class="grid grid-cols-1 gap-5 md:grid-cols-2"
            >
                <div
                    v-for="(item, index) in gallery"
                    :key="item.id ?? `new-${index}`"
                    class="overflow-hidden rounded-xl border border-slate-200 bg-white"
                >
                    <!-- IMAGE -->
                    <div
                        class="flex aspect-video items-center justify-center bg-slate-50"
                    >
                        <img
                            v-if="item.preview_url"
                            :src="item.preview_url"
                            :alt="
                                getTitle(item)
                            "
                            class="h-full w-full object-contain"
                        />

                        <div
                            v-else
                            class="text-sm text-slate-400"
                        >
                            {{
                                $t(
                                    'product.form.featuresGallery.image',
                                )
                            }}
                        </div>
                    </div>

                    <div class="space-y-4 p-4">
                        <!-- RU -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                {{
                                    $t(
                                        'product.form.featuresGallery.titleRu',
                                    )
                                }}
                            </label>

                            <input
                                type="text"
                                :value="
                                    item.title?.ru ??
                                    ''
                                "
                                :disabled="!isManager"
                                class="w-full rounded-lg border px-3 py-2 text-sm text-slate-900 outline-none transition"
                                :class="
                                    hasGalleryError(
                                        index,
                                        'title_ru',
                                    )
                                        ? 'border-red-500 ring-1 ring-red-200'
                                        : 'border-slate-300 focus:border-slate-500 focus:ring-1 focus:ring-slate-200'
                                "
                                @input="
                                    updateGalleryTitle(
                                        index,
                                        'ru',
                                        $event.target.value,
                                    )
                                "
                            />

                            <p
                                v-if="
                                    hasGalleryError(
                                        index,
                                        'title_ru',
                                    )
                                "
                                class="mt-1.5 text-xs text-red-600"
                            >
                                {{
                                    $t(
                                        'validation.input.required',
                                    )
                                }}
                            </p>
                        </div>

                        <!-- EN -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                {{
                                    $t(
                                        'product.form.featuresGallery.titleEn',
                                    )
                                }}
                            </label>

                            <input
                                type="text"
                                :value="
                                    item.title?.en ??
                                    ''
                                "
                                :disabled="!isManager"
                                class="w-full rounded-lg border px-3 py-2 text-sm text-slate-900 outline-none transition"
                                :class="
                                    hasGalleryError(
                                        index,
                                        'title_en',
                                    )
                                        ? 'border-red-500 ring-1 ring-red-200'
                                        : 'border-slate-300 focus:border-slate-500 focus:ring-1 focus:ring-slate-200'
                                "
                                @input="
                                    updateGalleryTitle(
                                        index,
                                        'en',
                                        $event.target.value,
                                    )
                                "
                            />

                            <p
                                v-if="
                                    hasGalleryError(
                                        index,
                                        'title_en',
                                    )
                                "
                                class="mt-1.5 text-xs text-red-600"
                            >
                                {{
                                    $t(
                                        'validation.input.required',
                                    )
                                }}
                            </p>
                        </div>

                        <button
                            v-if="isManager"
                            type="button"
                            class="inline-flex items-center gap-2 text-sm font-medium text-red-600 hover:text-red-700"
                            @click="
                                removeGalleryItem(index)
                            "
                        >
                            <i class="bi bi-trash3"></i>

                            {{
                                $t(
                                    'actions.remove',
                                )
                            }}
                        </button>
                    </div>
                </div>
            </div>

            <div
                v-else
                class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center"
            >
                <div
                    class="mx-auto mb-3 flex h-11 w-11 items-center justify-center rounded-full bg-white text-slate-400 shadow-sm"
                >
                    <i
                        class="bi bi-images text-xl"
                    ></i>
                </div>

                <p class="text-sm text-slate-500">
                    {{
                        $t(
                            'gallery.empty',
                        )
                    }}
                </p>

                <button
                    v-if="isManager"
                    type="button"
                    class="mt-4 inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800"
                    @click="openFilePicker"
                >
                    <i class="bi bi-plus-lg"></i>

                    {{
                        $t(
                            'product.form.featuresGallery.add',
                        )
                    }}
                </button>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
    modelValue: {
        type: Object,
        default: () => ({
            ru: '',
            en: '',
        }),
    },

    errors: {
        type: Object,
        default: () => ({}),
    },

    gallery: {
        type: Array,
        default: () => [],
    },

    isManager: {
        type: Boolean,
        default: false,
    },

    maxGalleryItems: {
        type: Number,
        default: 4,
    },
});

const emit = defineEmits([
    'update:modelValue',
    'update:gallery',
    'files',
    'remove-gallery-item',
]);

const fileInput = ref(null);

function updateFeature(
    language,
    value,
) {
    emit('update:modelValue', {
        ...props.modelValue,
        [language]: value,
    });
}

function openFilePicker() {
    if (!props.isManager) {
        return;
    }

    fileInput.value?.click();
}

function handleFiles(event) {
    const files =
        event.target?.files;

    if (!files?.length) {
        return;
    }

    emit('files', files);

    event.target.value = '';
}

function updateGalleryTitle(
    index,
    language,
    value,
) {
    const updated =
        props.gallery.map(
            (item, itemIndex) => {
                if (
                    itemIndex !== index
                ) {
                    return item;
                }

                return {
                    ...item,
                    title: {
                        ...(item.title ?? {}),
                        [language]: value,
                    },
                };
            },
        );

    emit(
        'update:gallery',
        updated,
    );
}

function removeGalleryItem(index) {
    emit(
        'remove-gallery-item',
        index,
    );
}

function hasGalleryError(
    index,
    field,
) {
    return Boolean(
        props.errors?.gallery?.[index]?.[
            field
        ],
    );
}

function getTitle(item) {
    return (
        item?.title?.ru ??
        item?.title?.en ??
        ''
    );
}
</script>