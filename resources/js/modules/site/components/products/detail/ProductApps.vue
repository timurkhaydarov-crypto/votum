<template>
    <section v-if="apps.length" class="space-y-5">
        <div>
            <h2 class="text-lg font-bold tracking-tight text-slate-900">
                {{ t('productApps.title') }}
            </h2>
        </div>

        <Transition
            name="product-app-view"
            mode="out-in"
            @after-enter="restoreListScroll"
        >
            <div v-if="selectedApp" key="details">
                <button
                    type="button"
                    class="mb-5 inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50"
                    @click="backToList"
                >
                    <i class="bi bi-arrow-left" aria-hidden="true"></i>
                    {{ t('productApps.backToList') }}
                </button>

                <article
                    class="overflow-hidden rounded-2xl border border-slate-200 bg-white"
                >
                    <div class="p-5 sm:p-7">
                        <div
                            class="flex flex-wrap items-center gap-2 text-xs text-slate-500"
                        >
                            <span
                                v-if="selectedApp.version"
                                class="rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 font-medium"
                            >
                                {{ t('productApps.version') }} {{ selectedApp.version }}
                            </span>
                            <span
                                v-if="selectedApp.purpose"
                                class="rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 font-medium"
                            >
                                {{ purposeLabel(selectedApp.purpose) }}
                            </span>
                        </div>

                        <h3
                            class="mt-3 text-xl font-bold tracking-tight text-slate-900 sm:text-2xl"
                        >
                            {{ localized(selectedApp.name) || t('productApps.untitled') }}
                        </h3>

                        <div
                            v-if="localized(selectedApp.full_description)"
                            class="product-app-description mt-5 max-w-none text-sm leading-7 text-slate-700"
                            v-html="descriptionWithoutDuplicateTitle(selectedApp)"
                        ></div>
                        <p v-else class="mt-5 text-sm text-slate-500">
                            {{ t('productApps.noDescription') }}
                        </p>

                        <button
                            type="button"
                            class="mt-4 inline-flex items-center gap-1.5 rounded-md border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-medium text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900"
                            @click="backToList"
                        >
                            <i class="bi bi-arrow-left" aria-hidden="true"></i>
                            {{ t('productApps.backToList') }}
                        </button>
                    </div>

                    <div
                        v-if="selectedGallery.length"
                        class="border-t border-slate-200 bg-slate-50 p-5 sm:p-7"
                    >
                        <h4 class="mb-4 text-sm font-semibold text-slate-800">
                            {{ t('productApps.gallery') }}
                        </h4>

                        <div
                            class="overflow-hidden rounded-xl border border-slate-200 bg-white"
                        >
                            <div
                                class="flex min-h-28 items-center justify-center p-4 sm:min-h-40"
                            >
                                <img
                                    v-if="!failedImages.has(galleryKey(selectedApp, activeImageIndex))"
                                    :src="selectedGallery[activeImageIndex].src"
                                    :alt="`${localized(selectedApp.name)} ${activeImageIndex + 1}`"
                                    class="max-h-[32vh] max-w-[50%] object-contain"
                                    loading="lazy"
                                    @error="markImageFailed(galleryKey(selectedApp, activeImageIndex))"
                                />
                                <div
                                    v-else
                                    class="flex h-28 items-center justify-center text-slate-300 sm:h-40"
                                >
                                    <i class="bi bi-image text-5xl" aria-hidden="true"></i>
                                </div>
                            </div>

                            <div
                                v-if="selectedGallery.length > 1"
                                class="flex items-center justify-between border-t border-slate-100 px-3 py-2"
                            >
                                <button
                                    type="button"
                                    class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100 hover:text-slate-900"
                                    :aria-label="t('productApps.previousImage')"
                                    @click="moveImage(-1)"
                                >
                                    <i class="bi bi-chevron-left" aria-hidden="true"></i>
                                </button>
                                <span class="text-xs font-medium text-slate-500">
                                    {{ activeImageIndex + 1 }} / {{ selectedGallery.length }}
                                </span>
                                <button
                                    type="button"
                                    class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100 hover:text-slate-900"
                                    :aria-label="t('productApps.nextImage')"
                                    @click="moveImage(1)"
                                >
                                    <i class="bi bi-chevron-right" aria-hidden="true"></i>
                                </button>
                            </div>

                            <div
                                v-if="selectedGallery.length > 1"
                                class="flex gap-2 overflow-x-auto border-t border-slate-100 p-3"
                            >
                                <button
                                    v-for="(image, index) in selectedGallery"
                                    :key="image.key"
                                    type="button"
                                    class="h-16 w-20 shrink-0 overflow-hidden rounded-lg border-2 bg-white transition"
                                    :class="
                                        activeImageIndex === index
                                            ? 'border-slate-800'
                                            : 'border-transparent hover:border-slate-300'
                                    "
                                    :aria-label="`${t('productApps.image')} ${index + 1}`"
                                    :aria-pressed="activeImageIndex === index"
                                    @click="activeImageIndex = index"
                                >
                                    <img
                                        v-if="!failedImages.has(galleryKey(selectedApp, index))"
                                        :src="image.src"
                                        :alt="`${localized(selectedApp.name)} ${index + 1}`"
                                        class="h-full w-full object-cover"
                                        loading="lazy"
                                        @error="markImageFailed(galleryKey(selectedApp, index))"
                                    />
                                    <span
                                        v-else
                                        class="flex h-full items-center justify-center text-slate-300"
                                    >
                                        <i class="bi bi-image" aria-hidden="true"></i>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div
                        v-else
                        class="border-t border-slate-200 bg-slate-50 px-5 py-6 text-sm text-slate-500 sm:px-7"
                    >
                        {{ t('productApps.noImages') }}
                    </div>
                </article>
            </div>

            <div v-else key="list">
                <div
                    v-if="purposeOptions.length"
                    class="mb-5"
                >
                    <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-500">
                        {{ t('productApps.filterLabel') }}
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <button
                            v-for="option in purposeOptions"
                            :key="option.value || 'all'"
                            type="button"
                            class="rounded-full border px-3.5 py-2 text-xs font-semibold transition"
                            :class="
                                selectedPurpose === option.value
                                    ? 'border-slate-800 bg-slate-800 text-white'
                                    : 'border-slate-200 bg-white text-slate-600 hover:border-slate-300 hover:text-slate-900'
                            "
                            :aria-pressed="selectedPurpose === option.value"
                            @click="selectedPurpose = option.value"
                        >
                            {{ option.label }}
                        </button>
                    </div>
                </div>

                <div
                    v-if="filteredApps.length"
                    class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4"
                >
                    <article
                        v-for="app in filteredApps"
                        :key="app.id || app.version"
                        class="flex h-full flex-col overflow-hidden rounded-xl border border-slate-200 bg-white transition hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-md"
                    >
                        <div
                            class="flex h-28 items-center justify-center bg-slate-50 p-3 sm:h-36"
                        >
                            <img
                                v-if="cardImage(app) && !failedImages.has(cardKey(app))"
                                :src="cardImage(app)"
                                :alt="localized(app.name) || t('productApps.untitled')"
                                class="h-full w-full object-contain"
                                loading="lazy"
                                @error="markImageFailed(cardKey(app))"
                            />
                            <div
                                v-else
                                class="flex h-14 w-14 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-300"
                                aria-hidden="true"
                            >
                                <i class="bi bi-box-seam text-2xl"></i>
                            </div>
                        </div>

                        <div class="flex flex-1 flex-col p-3 sm:p-4">
                            <div
                                class="flex flex-wrap items-center gap-x-1.5 gap-y-1 text-[10px] font-medium text-slate-500 sm:text-[11px]"
                            >
                                <span v-if="app.version">
                                    {{ t('productApps.version') }} {{ app.version }}
                                </span>
                                <span v-if="app.purpose" aria-hidden="true">·</span>
                                <span v-if="app.purpose">
                                    {{ purposeLabel(app.purpose) }}
                                </span>
                            </div>

                            <h3 class="mt-2 text-sm font-bold leading-snug text-slate-900 sm:text-base">
                                {{ localized(app.name) || t('productApps.untitled') }}
                            </h3>
                            <p class="mt-2 line-clamp-3 text-xs leading-5 text-slate-600 sm:text-sm">
                                {{ localized(app.short_description) || t('productApps.noDescription') }}
                            </p>

                            <button
                                type="button"
                                class="mt-3 inline-flex w-fit items-center gap-1 rounded-md bg-slate-900 px-2.5 py-1.5 text-[11px] font-semibold text-white transition hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2"
                                @click="openApp(app)"
                            >
                                {{ t('productApps.details') }}
                                <i class="bi bi-arrow-right" aria-hidden="true"></i>
                            </button>
                        </div>
                    </article>
                </div>

                <div
                    v-else
                    class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-6 py-10 text-center text-sm text-slate-500"
                >
                    {{ apps.length ? t('productApps.noFilteredApps') : t('productApps.noApps') }}
                </div>
            </div>
        </Transition>
    </section>
</template>

<script setup>
import { computed, nextTick, ref } from 'vue';
import { useI18n } from 'vue-i18n';

const props = defineProps({
    apps: {
        type: Array,
        default: () => [],
    },
});

const { t, locale } = useI18n();

const selectedPurpose = ref('general');
const selectedAppId = ref(null);
const activeImageIndex = ref(0);
const listScrollPosition = ref(0);
const restoreScrollOnEnter = ref(false);
const failedImages = ref(new Set());

const localized = (value) => {
    if (typeof value === 'string') {
        return value;
    }

    if (!value || typeof value !== 'object') {
        return '';
    }

    return value[locale.value] || value.ru || value.en || '';
};

const normalizeHeading = (value) => {
    return value
        .replace(/<[^>]*>/g, '')
        .replace(/&nbsp;/gi, ' ')
        .replace(/&mdash;/gi, '—')
        .replace(/&ndash;/gi, '–')
        .replace(/&amp;/gi, '&')
        .replace(/[–—]/g, '-')
        .replace(/\s+/g, ' ')
        .trim()
        .toLocaleLowerCase();
};

const descriptionWithoutDuplicateTitle = (app) => {
    const description = localized(app.full_description);
    const title = localized(app.name);
    const headingMatch = description.match(
        /^\s*<h([1-6])\b[^>]*>([\s\S]*?)<\/h\1>\s*/i,
    );

    if (
        !headingMatch ||
        normalizeHeading(headingMatch[2]) !== normalizeHeading(title)
    ) {
        return description;
    }

    return description.slice(headingMatch[0].length);
};

const purposeValues = computed(() => {
    return [
        ...new Set(
            props.apps
                .map((app) => String(app?.purpose || '').trim())
                .filter(Boolean),
        ),
    ];
});

const purposeOptions = computed(() => [
    ...['general', 'railway', 'avia', 'eddy-current', 'service']
        .filter(
            (value) =>
                value === 'general' || purposeValues.value.includes(value),
        )
        .map((value) => ({
            value,
            label: purposeLabel(value),
        })),
    ...purposeValues.value
        .filter(
            (value) =>
                !['general', 'railway', 'avia', 'eddy-current', 'service'].includes(
                    value,
                ),
        )
        .map((value) => ({
            value,
            label: purposeLabel(value),
        })),
]);

const purposeLabel = (purpose) => {
    if (!purpose) {
        return '';
    }

    const key = `productApps.purposes.${purpose}`;

    return t(key) === key ? purpose : t(key);
};

const filteredApps = computed(() => {
    if (!selectedPurpose.value) {
        return props.apps;
    }

    return props.apps.filter(
        (app) => String(app?.purpose || '').trim() === selectedPurpose.value,
    );
});

const selectedApp = computed(() => {
    return props.apps.find((app) => app.id === selectedAppId.value) || null;
});

const selectedGallery = computed(() => {
    if (!selectedApp.value) {
        return [];
    }

    const images = Array.isArray(selectedApp.value.images)
        ? selectedApp.value.images
            .map((image, index) => ({
                key: image.id || `${selectedApp.value.id || selectedApp.value.version}-${index}`,
                src: image.image_url || image.src || image.url || '',
            }))
            .filter((image) => image.src)
        : [];

    if (images.length) {
        return images;
    }

    const image = selectedApp.value.image;

    return image ? [{ key: `${selectedApp.value.id || selectedApp.value.version}-main`, src: image }] : [];
});

const resolveImage = (image) => {
    if (!image || typeof image !== 'string') {
        return '';
    }

    if (/^(https?:)?\/\//.test(image) || image.startsWith('/')) {
        return image;
    }

    return `/image/${image}`;
};

const cardImage = (app) => {
    const image = app?.image || app?.images?.[0]?.image_url || app?.images?.[0]?.src;

    return resolveImage(image);
};

const cardKey = (app) => `card-${app.id || app.version}`;
const galleryKey = (app, index) => `gallery-${app.id || app.version}-${index}`;

const markImageFailed = (key) => {
    failedImages.value = new Set([...failedImages.value, key]);
};

const openApp = async (app) => {
    listScrollPosition.value = window.scrollY;
    selectedAppId.value = app.id;
    activeImageIndex.value = 0;
    await nextTick();
    window.scrollTo({ top: listScrollPosition.value, behavior: 'auto' });
};

const backToList = async () => {
    restoreScrollOnEnter.value = true;
    selectedAppId.value = null;
};

const restoreListScroll = () => {
    if (!restoreScrollOnEnter.value) {
        return;
    }

    restoreScrollOnEnter.value = false;
    window.scrollTo({ top: listScrollPosition.value, behavior: 'auto' });
};

const moveImage = (direction) => {
    const count = selectedGallery.value.length;

    if (count < 2) {
        return;
    }

    activeImageIndex.value = (activeImageIndex.value + direction + count) % count;
};
</script>

<style scoped>
.product-app-view-enter-active,
.product-app-view-leave-active {
    transition: opacity 160ms ease, transform 160ms ease;
}

.product-app-view-enter-from,
.product-app-view-leave-to {
    opacity: 0;
    transform: translateY(4px);
}

.product-app-description :deep(h1),
.product-app-description :deep(h2),
.product-app-description :deep(h3) {
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    color: #0f172a;
    font-weight: 700;
    line-height: 1.3;
}

.product-app-description :deep(h1) {
    font-size: 1.5rem;
}

.product-app-description :deep(h2) {
    font-size: 1.25rem;
}

.product-app-description :deep(h3) {
    font-size: 1.05rem;
}

.product-app-description :deep(p) {
    margin-top: 0.75rem;
    margin-bottom: 0.75rem;
}

.product-app-description :deep(ul),
.product-app-description :deep(ol) {
    margin: 0.75rem 0;
    padding-left: 1.5rem;
}

.product-app-description :deep(ul) {
    list-style: disc;
}

.product-app-description :deep(ol) {
    list-style: decimal;
}

.product-app-description :deep(li) {
    margin: 0.35rem 0;
    padding-left: 0.15rem;
}

.product-app-description :deep(table) {
    display: block;
    max-width: 100%;
    overflow-x: auto;
    border-collapse: collapse;
}

.product-app-description :deep(th),
.product-app-description :deep(td) {
    border: 1px solid #e2e8f0;
    padding: 0.5rem 0.75rem;
    text-align: left;
}
</style>
