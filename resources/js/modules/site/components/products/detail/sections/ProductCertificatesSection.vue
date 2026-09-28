<template>
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h3 class="text-base font-semibold text-slate-900">
                    {{ $t('certificates.title') }}
                </h3>

                <p class="mt-1 text-sm leading-6 text-slate-500">
                    {{ $t('certificates.description') }}
                </p>
            </div>

            <button
                v-if="isManager"
                type="button"
                class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800"
                @click="openPicker"
            >
                <i class="bi bi-plus-lg"></i>
                {{ $t('actions.add') }}
            </button>
        </div>

        <input
            ref="fileInput"
            type="file"
            accept="image/jpeg,image/png,image/webp,application/pdf"
            multiple
            class="hidden"
            @change="handleFiles"
        />

        <div
            v-if="certificates.length"
            class="grid gap-5 sm:grid-cols-2"
        >
            <div
                v-for="(certificate, index) in certificates"
                :key="certificate.id ?? `certificate-${index}`"
                class="overflow-hidden rounded-2xl border border-slate-200 bg-white"
            >
                <!-- Preview -->
                <div class="flex aspect-[16/10] items-center justify-center overflow-hidden bg-slate-100">
                    <img
                        v-if="isImage(certificate)"
                        :src="getFileUrl(certificate)"
                        :alt="getLocalizedName(certificate)"
                        class="h-full w-full object-contain"
                    />

                    <a
                        v-else-if="getFileUrl(certificate)"
                        :href="getFileUrl(certificate)"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex flex-col items-center gap-2 text-slate-500 transition hover:text-slate-900"
                    >
                        <i class="bi bi-file-earmark-pdf text-4xl text-red-500"></i>

                        <span class="text-sm font-medium">
                            {{ $t('actions.open') }}
                        </span>
                    </a>

                    <span
                        v-else
                        class="text-sm text-slate-400"
                    >
                        {{ $t('common.notAvailable') }}
                    </span>
                </div>

                <!-- Content -->
                <div class="space-y-4 p-4">
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            {{ $t('product.form.certificates.title') }}
                        </span>

                        <button
                            v-if="isManager"
                            type="button"
                            class="text-sm font-medium text-red-600 transition hover:text-red-700"
                            @click="removeCertificate(index)"
                        >
                            {{ $t('actions.remove') }}
                        </button>
                    </div>

                    <div
                        v-if="isManager"
                        class="grid gap-4"
                    >
                        <div class="space-y-2">
                            <label class="block text-xs font-medium text-slate-600">
                                {{ $t('common.russian') }}
                            </label>

                            <input
                                :value="certificate.name?.ru ?? ''"
                                type="text"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                                @input="updateName(index, 'ru', $event.target.value)"
                            />
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-medium text-slate-600">
                                {{ $t('common.english') }}
                            </label>

                            <input
                                :value="certificate.name?.en ?? ''"
                                type="text"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                                @input="updateName(index, 'en', $event.target.value)"
                            />
                        </div>
                    </div>

                    <div
                        v-else
                        class="text-sm font-medium text-slate-800"
                    >
                        {{ getLocalizedName(certificate) }}
                    </div>
                </div>
            </div>
        </div>

        <div
            v-else
            class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-5 py-10 text-center"
        >
            <i class="bi bi-patch-check text-2xl text-slate-300"></i>

            <p class="mt-3 text-sm text-slate-500">
                {{ $t('certificates.empty') }}
            </p>

            <button
                v-if="isManager"
                type="button"
                class="mt-4 inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800"
                @click="openPicker"
            >
                <i class="bi bi-plus-lg"></i>
                {{ $t('actions.add') }}
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';

const { locale, t } = useI18n();

const props = defineProps({
    certificates: {
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

function removeCertificate(index) {
    emit('remove', index);
}

function updateName(index, language, value) {
    const certificate =
        props.certificates[index];

    if (!certificate) {
        return;
    }

    emit('update', {
        index,

        certificate: {
            ...certificate,

            name: {
                ...(certificate.name ?? {}),
                [language]: value,
            },
        },
    });
}

function getLocalizedName(certificate) {
    const name = certificate?.name;

    if (!name) {
        return t('product.form.certificates.title');
    }

    if (typeof name === 'string') {
        return name;
    }

    return (
        name[locale.value] ??
        name.ru ??
        name.en ??
        t('product.form.certificates.title')
    );
}

function getFileUrl(certificate) {
    return (
        certificate?.image_url ??
        certificate?.file_url ??
        certificate?.url ??
        certificate?.path ??
        ''
    );
}

function isImage(certificate) {
    const url = getFileUrl(certificate).toLowerCase();

    return /\.(jpe?g|png|webp)(\?.*)?$/.test(url);
}
</script>