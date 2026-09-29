<template>
    <div
        class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:border-slate-300 hover:shadow-lg hover:shadow-slate-900/5"
    >
        <!-- IMAGE AREA -->
        <div
            class="relative flex min-h-[260px] items-center justify-center overflow-hidden bg-slate-50"
        >
            <!-- TECHNICAL GRID -->
            <div
                class="pointer-events-none absolute inset-0 opacity-[0.035]"
                style="
                    background-image:
                        linear-gradient(#0f172a 1px, transparent 1px),
                        linear-gradient(90deg, #0f172a 1px, transparent 1px);
                    background-size: 32px 32px;
                "
            ></div>

            <!-- SOFT LIGHT -->
            <div
                class="pointer-events-none absolute left-1/2 top-1/2 h-[70%] w-[70%] -translate-x-1/2 -translate-y-1/2 rounded-full bg-white blur-3xl"
            ></div>

            <!-- THUMBNAIL -->
            <img
                :src="thumbnail"
                :alt="alt"
                loading="lazy"
                decoding="async"
                class="relative z-[1] h-full w-full object-contain p-5 transition duration-500 ease-out group-hover:scale-[1.025]"
            />

            <!-- HOVER OVERLAY -->
            <div
                class="absolute inset-0 z-10 flex items-center justify-center bg-slate-950/0 opacity-0 backdrop-blur-0 transition-all duration-300 group-hover:bg-slate-950/10 group-hover:opacity-100 group-hover:backdrop-blur-[2px]"
            >
                <!-- ZOOM BUTTON -->
                <button
                    type="button"
                    :aria-label="
                        $t(
                            'actions.open',
                            'Открыть изображение',
                        )
                    "
                    class="flex h-12 w-12 translate-y-2 cursor-pointer items-center justify-center rounded-full border border-white/60 bg-white/90 text-slate-800 opacity-0 shadow-xl shadow-slate-900/20 backdrop-blur-md transition-all duration-300 hover:scale-110 hover:bg-white group-hover:translate-y-0 group-hover:opacity-100"
                    @click="openModal"
                >
                    <i class="bi bi-search text-lg"></i>
                </button>
            </div>

            <!-- LABEL -->
            <div
                class="absolute left-3 top-3 z-20 rounded-lg border border-white/80 bg-white/80 px-2 py-1 text-[8px] font-semibold uppercase tracking-[0.1em] text-slate-500 shadow-sm backdrop-blur-md"
            >
                {{ $t('gallery.' + type) }}
            </div>
        </div>

        <!-- FOOTER -->
        <div
            v-if="title || description"
            class="border-t border-slate-100 px-4 py-3"
        >
            <h3
                v-if="title"
                class="text-sm font-semibold tracking-tight text-slate-900"
            >
                {{ title }}
            </h3>

            <p
                v-if="description"
                class="mt-1 text-xs leading-5 text-slate-500"
            >
                {{ description }}
            </p>
        </div>
    </div>

    <!-- MODAL -->
    <Teleport to="body">
        <Transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="isModalOpen"
                class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/90 p-4 backdrop-blur-md sm:p-8"
                @click.self="closeModal"
            >
                <div
                    class="relative flex h-full w-full items-center justify-center"
                >
                    <!-- CLOSE -->
                    <button
                        type="button"
                        :aria-label="
                            $t(
                                'common.close',
                                'Закрыть',
                            )
                        "
                        class="absolute right-2 top-2 z-20 flex h-10 w-10 cursor-pointer items-center justify-center rounded-full border border-white/15 bg-white/10 text-white backdrop-blur-md transition hover:bg-white/20 sm:right-4 sm:top-4"
                        @click="closeModal"
                    >
                        <i class="bi bi-x-lg text-sm"></i>
                    </button>

                    <!-- FULL IMAGE -->
                    <img
                        :src="imageSrc"
                        :alt="alt"
                        class="max-h-[90vh] max-w-[95vw] object-contain drop-shadow-2xl sm:max-h-[88vh] sm:max-w-[90vw]"
                    />

                    <!-- IMAGE INFO -->
                    <div
                        v-if="title"
                        class="absolute bottom-2 left-1/2 -translate-x-1/2 rounded-xl border border-white/10 bg-white/10 px-4 py-2 text-center text-xs font-medium text-white backdrop-blur-md sm:bottom-4"
                    >
                        {{ title }}
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup>
import {
    onBeforeUnmount,
    ref,
} from 'vue';

defineProps({
    /**
     * Full-size image.
     */
    imageSrc: {
        type: String,
        required: true,
    },

    /**
     * Gallery type.
     */
    type: {
        type: String,
        default: 'Product',
    },

    /**
     * Optimized thumbnail.
     */
    thumbnail: {
        type: String,
        required: true,
    },

    alt: {
        type: String,
        default: 'Product image',
    },

    title: {
        type: String,
        default: '',
    },

    description: {
        type: String,
        default: '',
    },
});

const isModalOpen = ref(false);

const openModal = () => {
    isModalOpen.value = true;

    document.body.classList.add(
        'overflow-hidden',
    );
};

const closeModal = () => {
    isModalOpen.value = false;

    document.body.classList.remove(
        'overflow-hidden',
    );
};

const handleKeydown = (event) => {
    if (
        event.key === 'Escape' &&
        isModalOpen.value
    ) {
        closeModal();
    }
};

window.addEventListener(
    'keydown',
    handleKeydown,
);

onBeforeUnmount(() => {
    window.removeEventListener(
        'keydown',
        handleKeydown,
    );

    document.body.classList.remove(
        'overflow-hidden',
    );
});
</script>
```

И **`ProductImageGallery.vue` тоже нужно очистить от `toggle-attachment` и `attached`**, оставив только открытие менеджера:

```vue
<ProductImageCard
    v-for="(image, index) in visibleImages"
    :key="
        image.id ||
        image.src ||
        index
    "
    :image-src="image.src"
    :thumbnail="image.thumbnail"
    :alt="
        image.alt ||
        localizedTitle(image) ||
        `${$t('gallery.image')} ${index + 1}`
    "
    :type="type"
    :title="localizedTitle(image)"
    :description="localizedDescription(image)"
/>