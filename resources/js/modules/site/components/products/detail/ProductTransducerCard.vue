<template>
    <article
        class="group overflow-hidden rounded-2xl border border-slate-200 bg-white transition-all duration-300 hover:-translate-y-1 hover:border-slate-300 hover:shadow-xl hover:shadow-slate-200/50"
    >
        <!-- IMAGE -->
        <div
            class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-slate-50 via-white to-slate-100"
        >
            <div
                class="absolute -right-12 -top-12 h-32 w-32 rounded-full bg-slate-100 blur-2xl"
            ></div>

            <div
                class="absolute -bottom-12 -left-12 h-32 w-32 rounded-full bg-blue-50 blur-2xl"
            ></div>

            <div class="absolute left-4 top-4 z-10">
                <span
                    class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white/90 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-600 shadow-sm backdrop-blur"
                >
                    <span class="h-1.5 w-1.5 rounded-full bg-slate-900"></span>

                    {{
                        transducer.type ||
                        transducer.method ||
                        'Ультразвуковой'
                    }}
                </span>
            </div>

            <div
                class="flex h-full items-center justify-center p-7 transition-transform duration-500 group-hover:scale-[1.04]"
            >
                <img
                    v-if="
                        transducer.imageUrl ||
                        transducer.image
                    "
                    :src="imageSrc"
                    :srcset="transducer.imageSrcSet"
                    :sizes="transducer.imageSizes"
                    :alt="transducer.article"
                    class="h-full w-full object-contain drop-shadow-[0_18px_20px_rgba(15,23,42,0.14)]"
                />

                <div
                    v-else
                    class="flex h-28 w-28 items-center justify-center rounded-3xl bg-slate-100 text-slate-300"
                >
                    <i class="bi bi-broadcast-pin text-4xl"></i>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="p-5">
            <div
                v-if="transducer.article"
                class="text-[10px] font-bold uppercase tracking-[0.16em] text-slate-400"
            >
                {{ transducer.article }}
            </div>

            <h3
                class="mt-1 text-base font-bold leading-tight tracking-tight text-slate-900"
            >
                {{
                    transducer.name ||
                    transducer.title ||
                    'Преобразователь'
                }}
            </h3>

            <p
                v-if="
                    transducer.shortDescription ||
                    transducer.description
                "
                class="mt-2 line-clamp-3 text-xs leading-5 text-slate-500"
            >
                {{
                    transducer.shortDescription ||
                    transducer.description
                }}
            </p>

            <div
                class="mt-4 grid grid-cols-2 overflow-hidden rounded-xl border border-slate-200"
            >
                <div class="bg-slate-50 px-3 py-2.5">
                    <div
                        class="text-[9px] font-bold uppercase tracking-wider text-slate-400"
                    >
                        Частота
                    </div>

                    <div class="mt-1 text-xs font-semibold text-slate-700">
                        {{ transducer.frequency || '—' }}
                    </div>
                </div>

                <div class="bg-white px-3 py-2.5">
                    <div
                        class="text-[9px] font-bold uppercase tracking-wider text-slate-400"
                    >
                        Угол
                    </div>

                    <div class="mt-1 text-xs font-semibold text-slate-700">
                        {{ transducer.angle || '—' }}
                    </div>
                </div>
            </div>

            <div
                class="mt-4 flex items-center justify-between border-t border-slate-100 pt-4"
            >
                <span
                    class="text-[10px] font-bold uppercase tracking-[0.14em] text-slate-400"
                >
                    {{
                        hasProductTransducers
                            ? 'Для прибора'
                            : 'Стандартные'
                    }}
                </span>

                <RouterLink
                    v-if="transducer.id"
                    :to="`/products/item/${transducer.id}`"
                    class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-700 transition hover:text-slate-900"
                >
                    Подробнее

                    <i
                        class="bi bi-arrow-right transition-transform group-hover:translate-x-0.5"
                    ></i>
                </RouterLink>
            </div>
        </div>
    </article>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    transducer: {
        type: Object,
        required: true,
    },

    hasProductTransducers: {
        type: Boolean,
        default: false,
    },
});

const imageSrc = computed(() => {
    const transducer = props.transducer;

    const image =
        transducer.imageUrl ||
        transducer.image;

    if (!image) {
        return '/image/logo.svg';
    }

    if (
        image.startsWith('http://') ||
        image.startsWith('https://') ||
        image.startsWith('/')
    ) {
        return image;
    }

    const imageName = image.includes('.')
        ? image
        : `${image}.webp`;

    return `/image/product/${transducer.categorySlug || 'transducers'}/${imageName}`;
});
</script>