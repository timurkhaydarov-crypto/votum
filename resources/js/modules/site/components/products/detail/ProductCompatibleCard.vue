<template>
    <article
        class="group overflow-hidden rounded-2xl border border-slate-200 bg-white transition-all duration-300 hover:-translate-y-1 hover:border-slate-300 hover:shadow-xl hover:shadow-slate-200/50"
    >
        <!-- IMAGE -->
        <div
            class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-slate-50 via-white to-slate-100"
        >
            <!-- Decorative elements -->
            <div
                class="absolute -right-12 -top-12 h-32 w-32 rounded-full bg-slate-100 blur-2xl"
            ></div>

            <div
                class="absolute -bottom-12 -left-12 h-32 w-32 rounded-full bg-blue-50 blur-2xl"
            ></div>

            <!-- PRODUCT IMAGE -->
            <div
                class="flex h-full items-center justify-center p-7 transition-transform duration-500 group-hover:scale-[1.04]"
            >
                <img
                    v-if="imageSrc"
                    :src="imageSrc"
                    :srcset="product.imageSrcSet"
                    :sizes="product.imageSizes"
                    :alt="productName"
                    class="h-full w-full object-contain drop-shadow-[0_18px_20px_rgba(15,23,42,0.14)]"
                    loading="lazy"
                />

                <!-- FALLBACK -->
                <div
                    v-else
                    class="flex h-28 w-28 items-center justify-center rounded-3xl bg-slate-100 text-slate-300"
                >
                    <i
                        class="bi bi-box-seam text-4xl"
                    ></i>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="p-5">
            <!-- ARTICLE -->
            <div
                v-if="product.article"
                class="text-[10px] font-bold uppercase tracking-[0.16em] text-slate-400"
            >
                {{ product.article }}
            </div>

            <!-- NAME -->
            <h3
                class="mt-1 text-base font-bold leading-tight tracking-tight text-slate-900"
            >
                {{ productName }}
            </h3>

            <!-- DESCRIPTION -->
            <p
                v-if="description"
                class="mt-2 line-clamp-3 text-xs leading-5 text-slate-500"
            >
                {{ description }}
            </p>

            <!-- PRODUCT DATA -->
            <div
                v-if="hasProductData"
                class="mt-4 grid grid-cols-2 overflow-hidden rounded-xl border border-slate-200"
            >
                <!-- FREQUENCY -->
                <div
                    v-if="product.frequency"
                    class="bg-slate-50 px-3 py-2.5"
                >
                    <div
                        class="text-[9px] font-bold uppercase tracking-wider text-slate-400"
                    >
                        Частота
                    </div>

                    <div
                        class="mt-1 text-xs font-semibold text-slate-700"
                    >
                        {{ product.frequency }}
                    </div>
                </div>

                <!-- ANGLE -->
                <div
                    v-if="product.angle"
                    class="bg-white px-3 py-2.5"
                >
                    <div
                        class="text-[9px] font-bold uppercase tracking-wider text-slate-400"
                    >
                        Угол
                    </div>

                    <div
                        class="mt-1 text-xs font-semibold text-slate-700"
                    >
                        {{ product.angle }}
                    </div>
                </div>

                <!-- METHOD -->
                <div
                    v-if="
                        product.method &&
                        !product.frequency &&
                        !product.angle
                    "
                    class="col-span-2 bg-slate-50 px-3 py-2.5"
                >
                    <div
                        class="text-[9px] font-bold uppercase tracking-wider text-slate-400"
                    >
                        Метод
                    </div>

                    <div
                        class="mt-1 text-xs font-semibold text-slate-700"
                    >
                        {{ product.method }}
                    </div>
                </div>
            </div>

            <!-- FOOTER -->
            <div
                class="mt-4 flex items-center justify-between border-t border-slate-100 pt-4"
            >
                <!-- CATEGORY -->
                <span
                    class="max-w-[60%] truncate text-[10px] font-bold uppercase tracking-[0.14em] text-slate-400"
                    :title="categoryTitle"
                >
                    {{ categoryTitle || 'Совместимый товар' }}
                </span>

                <!-- LINK -->
                <RouterLink
                    v-if="product.id"
                    :to="productUrl"
                    class="inline-flex shrink-0 items-center gap-1.5 text-xs font-bold text-slate-700 transition hover:text-slate-900"
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
    product: {
        type: Object,
        required: true,
    },

    hasProductTransducers: {
        type: Boolean,
        default: false,
    },
});

/*
|--------------------------------------------------------------------------
| Product
|--------------------------------------------------------------------------
*/

const product = computed(() => props.product);

/*
|--------------------------------------------------------------------------
| Product name
|--------------------------------------------------------------------------
*/

const productName = computed(() => {
    const name = product.value.name;

    if (!name) {
        return 'Совместимый товар';
    }

    if (typeof name === 'string') {
        return name;
    }

    if (typeof name === 'object') {
        return (
            name.ru ||
            name.en ||
            Object.values(name)[0] ||
            'Совместимый товар'
        );
    }

    return String(name);
});

/*
|--------------------------------------------------------------------------
| Description
|--------------------------------------------------------------------------
*/

const description = computed(() => {
    const value =
        product.value.short_description ||
        product.value.shortDescription ||
        product.value.description;

    if (!value) {
        return null;
    }

    if (typeof value === 'string') {
        return value;
    }

    if (typeof value === 'object') {
        return (
            value.ru ||
            value.en ||
            Object.values(value)[0] ||
            null
        );
    }

    return String(value);
});

/*
|--------------------------------------------------------------------------
| Category
|--------------------------------------------------------------------------
*/

const categorySlug = computed(() => {
    return (
        product.value.categorySlug ||
        product.value.category?.slug ||
        'transducers'
    );
});

const categoryTitle = computed(() => {
    const category =
        product.value.categoryTitle ||
        product.value.category?.title ||
        product.value.category?.category;

    if (!category) {
        return null;
    }

    if (typeof category === 'string') {
        return category;
    }

    if (typeof category === 'object') {
        return (
            category.ru ||
            category.en ||
            Object.values(category)[0] ||
            null
        );
    }

    return String(category);
});

/*
|--------------------------------------------------------------------------
| Image
|--------------------------------------------------------------------------
*/

const imageName = computed(() => {
    const image =
        product.value.imageUrl ||
        product.value.image_url ||
        product.value.image;

    if (!image) {
        return null;
    }

    return image.includes('.')
        ? image
        : `${image}.webp`;
});

const imageSrc = computed(() => {
    const image =
        product.value.imageUrl ||
        product.value.image_url ||
        product.value.image;

    if (!image) {
        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Absolute URL
    |--------------------------------------------------------------------------
    */

    if (
        image.startsWith('http://') ||
        image.startsWith('https://') ||
        image.startsWith('/')
    ) {
        return image;
    }

    /*
    |--------------------------------------------------------------------------
    | Product image
    |--------------------------------------------------------------------------
    |
    | /image/product/{categorySlug}/{image}.webp
    |
    */

    return `/image/product/${categorySlug.value}/${imageName.value}`;
});

/*
|--------------------------------------------------------------------------
| Product URL
|--------------------------------------------------------------------------
*/

const productUrl = computed(() => {
    if (!product.value.id) {
        return '#';
    }

    return `/products/item/${product.value.id}`;
});

/*
|--------------------------------------------------------------------------
| Product data
|--------------------------------------------------------------------------
*/

const hasProductData = computed(() => {
    return Boolean(
        product.value.frequency ||
        product.value.angle ||
        product.value.method
    );
});
</script>