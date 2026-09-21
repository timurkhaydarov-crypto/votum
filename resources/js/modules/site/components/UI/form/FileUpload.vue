<template>
    <div>
        <label
            v-if="label"
            :for="id"
            class="mb-2 block text-sm font-medium text-gray-900"
        >
            {{ label }}
        </label>

        <div
            :class="[
                'rounded-xl border bg-white transition',
                error
                    ? 'border-red-300'
                    : 'border-slate-200 hover:border-slate-300',
            ]"
        >
            <input
                ref="fileInput"
                :id="id"
                :name="name"
                :accept="accept"
                :multiple="multiple"
                type="file"
                class="sr-only"
                @change="handleChange"
            />

            <div class="p-4">
                <!-- ============================================== -->
                <!-- SELECTED / CURRENT FILE -->
                <!-- ============================================== -->

                <div
                    v-if="hasFile"
                    class="flex items-center gap-4"
                >
                    <!-- IMAGE PREVIEW -->

                    <div
                        v-if="displayImagePreviewUrl"
                        class="h-16 w-16 shrink-0 overflow-hidden rounded-lg border border-slate-200 bg-slate-50"
                    >
                        <img
                            :src="displayImagePreviewUrl"
                            :alt="fileName"
                            class="h-full w-full object-cover"
                        />
                    </div>

                    <!-- VIDEO PREVIEW -->

                    <div
                        v-else-if="displayVideoPreviewUrl"
                        class="relative h-16 w-16 shrink-0 overflow-hidden rounded-lg border border-slate-200 bg-slate-900"
                    >
                        <video
                            ref="videoPreview"
                            :src="displayVideoPreviewUrl"
                            class="h-full w-full object-cover"
                            muted
                            playsinline
                            preload="metadata"
                            @ended="handleVideoEnded"
                        ></video>

                        <!-- PLAY BUTTON -->

                        <button
                            v-if="!isVideoPlaying"
                            type="button"
                            class="absolute inset-0 flex items-center justify-center bg-slate-900/20 transition hover:bg-slate-900/30"
                            @click.stop="toggleVideoPreview"
                        >
                            <span
                                class="flex h-8 w-8 items-center justify-center rounded-full bg-white/90 text-slate-900 shadow-md transition hover:scale-105"
                            >
                                <i
                                    class="bi bi-play-fill text-base"
                                    aria-hidden="true"
                                ></i>
                            </span>
                        </button>
                    </div>

                    <!-- DEFAULT FILE ICON -->

                    <div
                        v-else
                        class="flex h-16 w-16 shrink-0 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 text-slate-400"
                    >
                        <i
                            :class="fileIcon"
                            class="text-2xl"
                            aria-hidden="true"
                        ></i>
                    </div>

                    <!-- FILE INFO -->

                    <div class="min-w-0 flex-1">
                        <p
                            class="truncate text-sm font-medium text-slate-800"
                            :title="fileName"
                        >
                            {{ fileName }}
                        </p>

                        <p
                            v-if="fileSize"
                            class="mt-1 text-xs text-slate-500"
                        >
                            {{ fileSize }}
                        </p>

                        <p
                            v-else-if="isCurrentFile"
                            class="mt-1 text-xs text-slate-500"
                        >
                            {{ currentFileLabel }}
                        </p>
                    </div>

                    <!-- ACTIONS -->

                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100 hover:text-slate-900"
                            title="Replace file"
                            @click="openPicker"
                        >
                            <i
                                class="bi bi-arrow-repeat"
                                aria-hidden="true"
                            ></i>
                        </button>

                        <button
                            type="button"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-red-500 transition hover:bg-red-50 hover:text-red-600"
                            title="Remove file"
                            @click="clearFile"
                        >
                            <i
                                class="bi bi-trash"
                                aria-hidden="true"
                            ></i>
                        </button>
                    </div>
                </div>

                <!-- ============================================== -->
                <!-- EMPTY STATE -->
                <!-- ============================================== -->

                <button
                    v-else
                    type="button"
                    class="flex w-full items-center gap-4 text-left"
                    @click="openPicker"
                >
                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500"
                    >
                        <i
                            :class="fileIcon"
                            class="text-xl"
                            aria-hidden="true"
                        ></i>
                    </div>

                    <div class="min-w-0 flex-1">
                        <p
                            class="text-sm font-medium text-slate-800"
                        >
                            {{ placeholder }}
                        </p>

                        <p
                            v-if="hint"
                            class="mt-1 text-xs text-slate-500"
                        >
                            {{ hint }}
                        </p>
                    </div>

                    <span
                        class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-slate-900 px-3 py-2 text-sm font-medium text-white transition hover:bg-slate-800"
                    >
                        <i
                            class="bi bi-folder2-open"
                            aria-hidden="true"
                        ></i>

                        {{ buttonText }}
                    </span>
                </button>
            </div>
        </div>

        <!-- ERROR -->

        <p
            v-if="error"
            :id="`${id}-error`"
            role="alert"
            class="mt-1.5 text-sm text-red-500"
        >
            {{ error }}
        </p>
    </div>
</template>

<script setup>
import {
    computed,
    onBeforeUnmount,
    ref,
} from 'vue';

import { useId } from 'vue';

const id = useId();

const model = defineModel({
    default: null,
});

const props = defineProps({
    label: {
        type: String,
        default: '',
    },

    name: {
        type: String,
        default: '',
    },

    accept: {
        type: String,
        default: '',
    },

    multiple: {
        type: Boolean,
        default: false,
    },

    placeholder: {
        type: String,
        default: 'Select a file',
    },

    buttonText: {
        type: String,
        default: 'Choose file',
    },

    hint: {
        type: String,
        default: '',
    },

    error: {
        type: String,
        default: '',
    },

    preview: {
        type: Boolean,
        default: true,
    },

    icon: {
        type: String,
        default: '',
    },

    currentFileUrl: {
        type: String,
        default: '',
    },

    currentFileLabel: {
        type: String,
        default: 'Current file',
    },
});

const emit = defineEmits([
    'update:modelValue',
    'remove-current',
]);

const fileInput = ref(null);

const previewUrl = ref(null);
const videoPreviewUrl = ref(null);

const videoPreview = ref(null);
const isVideoPlaying = ref(false);

/*
|--------------------------------------------------------------------------
| FILE STATE
|--------------------------------------------------------------------------
*/

const hasSelectedFile = computed(() => {
    if (props.multiple) {
        return (
            Array.isArray(model.value) &&
            model.value.length > 0
        );
    }

    return (
        typeof File !== 'undefined' &&
        model.value instanceof File
    );
});

const selectedFile = computed(() => {
    if (props.multiple) {
        return Array.isArray(model.value)
            ? model.value[0] ?? null
            : null;
    }

    if (
        typeof File !== 'undefined' &&
        model.value instanceof File
    ) {
        return model.value;
    }

    return null;
});

const hasCurrentFile = computed(() => {
    return Boolean(
        props.currentFileUrl
    );
});

const isCurrentFile = computed(() => {
    return (
        !hasSelectedFile.value &&
        hasCurrentFile.value
    );
});

const hasFile = computed(() => {
    return (
        hasSelectedFile.value ||
        hasCurrentFile.value
    );
});

/*
|--------------------------------------------------------------------------
| FILE NAME
|--------------------------------------------------------------------------
*/

const currentFileName = computed(() => {
    if (!props.currentFileUrl) {
        return '';
    }

    try {
        const pathname =
            new URL(
                props.currentFileUrl,
                window.location.origin
            ).pathname;

        const filename =
            pathname
                .split('/')
                .filter(Boolean)
                .pop() || '';

        return decodeURIComponent(
            filename
        );
    } catch {
        return (
            props.currentFileUrl
                .split('/')
                .filter(Boolean)
                .pop() ||
            props.currentFileUrl
        );
    }
});

const fileName = computed(() => {
    if (props.multiple) {
        const files = Array.isArray(model.value)
            ? model.value
            : [];

        if (files.length === 0) {
            return currentFileName.value;
        }

        if (files.length === 1) {
            return files[0].name;
        }

        return `${files.length} files selected`;
    }

    if (selectedFile.value) {
        return selectedFile.value.name;
    }

    return currentFileName.value;
});

const fileSize = computed(() => {
    if (!selectedFile.value) {
        return '';
    }

    return formatFileSize(
        selectedFile.value.size
    );
});

/*
|--------------------------------------------------------------------------
| FILE TYPE
|--------------------------------------------------------------------------
*/

const isSelectedImage = computed(() => {
    return Boolean(
        selectedFile.value &&
        selectedFile.value.type?.startsWith(
            'image/'
        )
    );
});

const isSelectedVideo = computed(() => {
    return Boolean(
        selectedFile.value &&
        selectedFile.value.type?.startsWith(
            'video/'
        )
    );
});

const isCurrentImage = computed(() => {
    return (
        !hasSelectedFile.value &&
        hasCurrentFile.value &&
        props.accept.includes('image')
    );
});

const isCurrentVideo = computed(() => {
    return (
        !hasSelectedFile.value &&
        hasCurrentFile.value &&
        props.accept.includes('video')
    );
});

/*
|--------------------------------------------------------------------------
| PREVIEW URLS
|--------------------------------------------------------------------------
*/

const displayImagePreviewUrl = computed(() => {
    if (!props.preview) {
        return '';
    }

    if (
        isSelectedImage.value &&
        previewUrl.value
    ) {
        return previewUrl.value;
    }

    if (isCurrentImage.value) {
        return props.currentFileUrl;
    }

    return '';
});

const displayVideoPreviewUrl = computed(() => {
    if (!props.preview) {
        return '';
    }

    if (
        isSelectedVideo.value &&
        videoPreviewUrl.value
    ) {
        return videoPreviewUrl.value;
    }

    if (isCurrentVideo.value) {
        return props.currentFileUrl;
    }

    return '';
});

/*
|--------------------------------------------------------------------------
| ICON
|--------------------------------------------------------------------------
*/

const fileIcon = computed(() => {
    if (props.icon) {
        return props.icon;
    }

    if (props.accept.includes('image')) {
        return 'bi bi-image';
    }

    if (props.accept.includes('video')) {
        return 'bi bi-play-btn';
    }

    return 'bi bi-file-earmark';
});

/*
|--------------------------------------------------------------------------
| HELPERS
|--------------------------------------------------------------------------
*/

const formatFileSize = (size) => {
    if (size < 1024) {
        return `${size} B`;
    }

    if (size < 1024 * 1024) {
        return `${(
            size / 1024
        ).toFixed(1)} KB`;
    }

    if (size < 1024 * 1024 * 1024) {
        return `${(
            size /
            (1024 * 1024)
        ).toFixed(1)} MB`;
    }

    return `${(
        size /
        (1024 * 1024 * 1024)
    ).toFixed(1)} GB`;
};

/*
|--------------------------------------------------------------------------
| IMAGE PREVIEW
|--------------------------------------------------------------------------
*/

const createImagePreview = (file) => {
    revokeImagePreview();

    if (
        !props.preview ||
        !file ||
        !file.type.startsWith('image/')
    ) {
        return;
    }

    previewUrl.value =
        URL.createObjectURL(file);
};

const revokeImagePreview = () => {
    if (previewUrl.value) {
        URL.revokeObjectURL(
            previewUrl.value
        );

        previewUrl.value = null;
    }
};

/*
|--------------------------------------------------------------------------
| VIDEO PREVIEW
|--------------------------------------------------------------------------
*/

const createVideoPreview = (file) => {
    revokeVideoPreview();

    if (
        !props.preview ||
        !file ||
        !file.type.startsWith('video/')
    ) {
        return;
    }

    videoPreviewUrl.value =
        URL.createObjectURL(file);
};

const revokeVideoPreview = () => {
    if (videoPreview.value) {
        videoPreview.value.pause();
        videoPreview.value.currentTime = 0;
    }

    if (videoPreviewUrl.value) {
        URL.revokeObjectURL(
            videoPreviewUrl.value
        );

        videoPreviewUrl.value = null;
    }

    isVideoPlaying.value = false;
};

const revokePreviews = () => {
    revokeImagePreview();
    revokeVideoPreview();
};

/*
|--------------------------------------------------------------------------
| PICKER
|--------------------------------------------------------------------------
*/

const openPicker = () => {
    fileInput.value?.click();
};

/*
|--------------------------------------------------------------------------
| VIDEO PLAYBACK
|--------------------------------------------------------------------------
*/

const toggleVideoPreview = async () => {
    if (!videoPreview.value) {
        return;
    }

    try {
        await videoPreview.value.play();

        isVideoPlaying.value = true;
    } catch (error) {
        console.error(
            'Unable to play video preview:',
            error
        );

        isVideoPlaying.value = false;
    }
};

const handleVideoEnded = () => {
    isVideoPlaying.value = false;
};

/*
|--------------------------------------------------------------------------
| FILE CHANGE
|--------------------------------------------------------------------------
*/

const handleChange = (event) => {
    const files = Array.from(
        event.target.files ?? []
    );

    revokePreviews();

    if (props.multiple) {
        model.value = files;

        const firstFile =
            files[0] ?? null;

        if (firstFile) {
            createImagePreview(firstFile);
            createVideoPreview(firstFile);
        }
    } else {
        const file =
            files[0] ?? null;

        model.value = file;

        if (file) {
            createImagePreview(file);
            createVideoPreview(file);
        }
    }

    event.target.value = '';
};

/*
|--------------------------------------------------------------------------
| REMOVE
|--------------------------------------------------------------------------
*/

const clearFile = () => {
    revokePreviews();

    if (hasSelectedFile.value) {
        model.value = props.multiple
            ? []
            : null;

        return;
    }

    if (hasCurrentFile.value) {
        emit('remove-current');

        return;
    }

    model.value = props.multiple
        ? []
        : null;
};

/*
|--------------------------------------------------------------------------
| CLEANUP
|--------------------------------------------------------------------------
*/

onBeforeUnmount(() => {
    revokePreviews();
});
</script>
