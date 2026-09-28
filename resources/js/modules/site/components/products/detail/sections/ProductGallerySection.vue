<template>
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h3 class="text-base font-semibold text-slate-900">
                    {{ $t('gallery.title') }}
                </h3>

                <p class="mt-1 text-sm leading-6 text-slate-500">
                    {{ $t('gallery.description') }}
                </p>
            </div>

            <button
                v-if="isManager"
                type="button"
                class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800"
                @click="openPicker"
            >
                <i class="bi bi-plus-lg"></i>
                {{ $t('product.form.gallery.add') }}
            </button>
        </div>

        <input
            ref="fileInput"
            type="file"
            accept="image/jpeg,image/png,image/webp"
            multiple
            class="hidden"
            @change="handleFiles"
        />

        <div
            v-if="gallery.length"
            class="grid gap-5 sm:grid-cols-2"
        >
            <div
                v-for="(item, index) in gallery"
                :key="item.id ?? `gallery-${index}`"
                class="overflow-hidden rounded-2xl border border-slate-200 bg-white"
            >
                <!-- Image -->
                <div class="aspect-[16/10] overflow-hidden bg-slate-100">
                    <img
                        v-if="getImageUrl(item)"
                        :src="getImageUrl(item)"
                        :alt="getLocalizedTitle(item)"
                        class="h-full w-full object-cover"
                    />

                    <div
                        v-else
                        class="flex h-full items-center justify-center text-sm text-slate-400"
                    >
                        {{ $t('common.notAvailable') }}
                    </div>
                </div>

                <!-- Content -->
                <div class="space-y-5 p-4">
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            {{ $t('gallery.image') }}
                        </span>

                        <button
                            v-if="isManager"
                            type="button"
                            class="text-sm font-medium text-red-600 transition hover:text-red-700"
                            @click="removeItem(index)"
                        >
                            {{ $t('actions.remove') }}
                        </button>
                    </div>

                    <template v-if="isManager">
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="space-y-2">
                                <label class="block text-xs font-medium text-slate-600">
                                    {{ $t('product.form.gallery.titleRu') }}
                                </label>

                                <input
                                    :value="item.title?.ru ?? ''"
                                    type="text"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                                    @input="updateField(index, 'title', 'ru', $event.target.value)"
                                />
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-medium text-slate-600">
                                    {{ $t('product.form.gallery.titleEn') }}
                                </label>

                                <input
                                    :value="item.title?.en ?? ''"
                                    type="text"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                                    @input="updateField(index, 'title', 'en', $event.target.value)"
                                />
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="space-y-2">
                                <label class="block text-xs font-medium text-slate-600">
                                    {{ $t('product.form.gallery.descriptionRu') }}
                                </label>

                                <textarea
                                    :value="item.description?.ru ?? ''"
                                    rows="4"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                                    @input="updateField(index, 'description', 'ru', $event.target.value)"
                                ></textarea>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-medium text-slate-600">
                                    {{ $t('product.form.gallery.descriptionEn') }}
                                </label>

                                <textarea
                                    :value="item.description?.en ?? ''"
                                    rows="4"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                                    @input="updateField(index, 'description', 'en', $event.target.value)"
                                ></textarea>
                            </div>
                        </div>
                    </template>

                    <div
                        v-else
                        class="space-y-2"
                    >
                        <div class="text-sm font-medium text-slate-800">
                            {{ getLocalizedTitle(item) }}
                        </div>

                        <p
                            v-if="getLocalizedDescription(item)"
                            class="text-sm leading-6 text-slate-500"
                        >
                            {{ getLocalizedDescription(item) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div
            v-else
            class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-5 py-10 text-center"
        >
            <i class="bi bi-images text-2xl text-slate-300"></i>

            <p class="mt-3 text-sm text-slate-500">
                {{ $t('gallery.empty') }}
            </p>

            <button
                v-if="isManager"
                type="button"
                class="mt-4 inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800"
                @click="openPicker"
            >
                <i class="bi bi-plus-lg"></i>
                {{ $t('product.form.gallery.add') }}
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';

const { locale, t } = useI18n();

const props = defineProps({
    gallery: {
        type: Array,
        default: () => [],
    },

    isManager: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits([
    'files',
    'remove',
    'update',
]);

const fileInput = ref(null);

function openPicker() {
    fileInput.value?.click();
}

function handleFiles(event) {
    const files = Array.from(
        event.target.files ?? [],
    );

    if (files.length) {
        emit('files', files);
    }

    event.target.value = '';
}

function removeItem(index) {
    emit('remove', index);
}

function updateField(
    index,
    field,
    language,
    value,
) {
    const item = props.gallery[index];

    if (!item) {
        return;
    }

    emit('update', {
        index,

        changes: {
            [field]: {
                ...(item[field] ?? {}),
                [language]: value,
            },
        },
    });
}

function getImageUrl(item) {
    return (
        item?.preview_url ??
        item?.image_url ??
        ''
    );
}

function getLocalizedTitle(item) {
    const title = item?.title;

    if (!title) {
        return t('gallery.image');
    }

    if (typeof title === 'string') {
        return title;
    }

    return (
        title[locale.value] ??
        title.ru ??
        title.en ??
        t('gallery.image')
    );
}

function getLocalizedDescription(item) {
    const description = item?.description;

    if (!description) {
        return '';
    }

    if (typeof description === 'string') {
        return description;
    }

    return (
        description[locale.value] ??
        description.ru ??
        description.en ??
        ''
    );
}
</script>