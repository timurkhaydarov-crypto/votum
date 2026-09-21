<template>
    <section
        v-if="gallery.length"
        class="border-t border-slate-100 pt-7"
    >
        <!-- HEADER -->
        <div class="mb-5 flex items-center gap-3">
            <div
                class="h-8 w-1 rounded-full bg-slate-900"
            ></div>

            <h3
                class="text-sm font-bold uppercase tracking-[0.18em] text-slate-900"
            >
                {{ locale === 'en' ? 'Gallery' : 'Галерея' }}
            </h3>

            <span
                class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500"
            >
                {{ gallery.length }}
            </span>
        </div>

        <!-- GALLERY -->
        <div
            class="grid grid-cols-1 justify-items-center gap-5 sm:grid-cols-2 lg:grid-cols-4"
        >
            <div
                v-for="(image, index) in gallery"
                :key="
                    image.id ??
                    image.image_url ??
                    index
                "
                class="w-full max-w-[350px] overflow-hidden rounded-2xl border border-slate-200 bg-slate-50"
            >
                <!-- IMAGE -->
                <div
                    class="aspect-[4/3] overflow-hidden"
                >
                    <img
                        :src="
                            getImageUrl(
                                image.image_url,
                            )
                        "
                        :alt="
                            getImageTitle(
                                image,
                                index,
                            )
                        "
                        class="h-full w-full object-cover"
                        loading="lazy"
                    />
                </div>

                <!-- TITLE -->
                <div
                    v-if="getImageTitle(image)"
                    class="px-4 py-3"
                >
                    <p
                        class="text-xs leading-relaxed text-slate-600"
                    >
                        {{ getImageTitle(image) }}
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { useI18n } from 'vue-i18n';

const { locale } = useI18n();

defineProps({
    gallery: {
        type: Array,
        default: () => [],
    },

    title: {
        type: String,
        default: '',
    },
});

/*
|--------------------------------------------------------------------------
| Image title
|--------------------------------------------------------------------------
*/

const getImageTitle = (
    image,
    index = null,
) => {
    const title = image?.title;

    if (!title) {
        return '';
    }

    if (typeof title === 'string') {
        return title.trim();
    }

    const value =
        title[locale.value] ||
        title.ru ||
        title.en ||
        '';

    return typeof value === 'string'
        ? value.trim()
        : '';
};

/*
|--------------------------------------------------------------------------
| Image URL
|--------------------------------------------------------------------------
|
| DB:
|
| 21446b65-beb7-48ac-b663-dd967d74055e_2.webp
|
| Result:
|
| /image/features/
|   21446b65-beb7-48ac-b663-dd967d74055e/
|   21446b65-beb7-48ac-b663-dd967d74055e_2.webp
|
|--------------------------------------------------------------------------
*/

const getImageUrl = (imageUrl) => {
    if (!imageUrl) {
        return '';
    }

    const filename = imageUrl
        .split('/')
        .pop()
        .trim();

    if (!filename) {
        return '';
    }

    /*
     * Убираем существующее расширение.
     *
     * 21446..._2.webp
     * ↓
     * 21446..._2
     */
    const baseName = filename.replace(
        /\.(webp|jpg|jpeg|png)$/i,
        '',
    );

    /*
     * Имя папки — без номера изображения.
     *
     * 21446..._2
     * ↓
     * 21446...
     */
    const folder = baseName.replace(
        /_\d+$/,
        '',
    );

    if (!folder) {
        return '';
    }

    /*
     * Все feature images физически сохраняются как WebP.
     */
    return `/image/features/${encodeURIComponent(
        folder,
    )}/${encodeURIComponent(
        baseName,
    )}.webp`;
};
</script>
