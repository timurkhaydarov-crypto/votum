<template>

    <Transition
        enter-active-class="transition-all duration-200 ease-out"
        enter-from-class="opacity-0 -translate-y-2"
        enter-to-class="opacity-100 translate-y-0"

        leave-active-class="transition-all duration-150 ease-in"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 -translate-y-2"
    >

        <div
            v-if="open"
            class="fixed
                   left-1/2
                   z-50
                   -translate-x-1/2
                   pt-3"
            style="width: min(1050px, calc(100vw - 32px));"
            @contextmenu.prevent
        >

            <div
                class="w-full
                       overflow-hidden
                       rounded-2xl
                       border border-gray-100
                       bg-white
                       shadow-[0_25px_70px_rgba(0,0,0,0.13)]"
            >

                <!-- HEADER -->

                <MegaMenuHeader
                    :title="title"
                    :icon="icon"
                    :all-link="allLink"
                    :all-label="resolvedAllLabel"
                    @navigate="closeMegaMenu"
                />


                <!-- CONTENT -->

                <div
                    :class="[
                        'grid',
                        variant === 'cards'
                            ? 'grid-cols-[minmax(190px,260px)_minmax(0,1fr)]'
                            : 'grid-cols-[minmax(190px,260px)_minmax(0,1fr)_minmax(170px,210px)]'
                    ]"
                >

                    <!-- CATEGORIES -->

                    <MegaMenuCategories
                        :categories="categories"
                        :active-index="activeCategory"
                        @select="selectCategory"
                    />


                    <!-- MAIN CONTENT -->

                    <div
                        class="min-w-0 overflow-hidden border-r border-gray-100"
                    >

                        <MegaMenuContent
                            v-if="variant === 'content'"
                            :category="categories[activeCategory]"
                            @product-hover="handleProductHover"
                            @navigate="closeMegaMenu"
                        />

                        <MegaMenuCards
                            v-else-if="variant === 'cards'"
                            :category="categories[activeCategory]"
                            @navigate="closeMegaMenu"
                        />

                    </div>


                    <!-- PREVIEW -->

                    <aside
                        v-if="variant !== 'cards'"
                        class="p-0"
                        @mouseenter="clearPreviewHideTimer()"
                        @mouseleave="schedulePreviewHide()"
                    >

                        <MegaMenuPreview
                            :product="previewProduct"
                            :image="previewProductImage"
                            :description="previewProductDescription"
                        />

                    </aside>

                </div>


                <!-- FOOTER -->

                <MegaMenuFooter
                    :footer="footer"
                />

            </div>

        </div>

    </Transition>

</template>


<script setup>

import {
    computed,
    ref,
    watch
} from 'vue'

import {
    useI18n
} from 'vue-i18n'


import MegaMenuHeader from './MegaMenuHeader.vue'
import MegaMenuCategories from './MegaMenuCategories.vue'
import MegaMenuContent from './MegaMenuContent.vue'
import MegaMenuCards from './MegaMenuCards.vue'
import MegaMenuPreview from './MegaMenuPreview.vue'
import MegaMenuFooter from './MegaMenuFooter.vue'

import {
    useProductPreviewHover
} from './useProductPreviewHover.js'

import {
    resolveProductById
} from '../navigation.data.js'


const { t } = useI18n()


/*
|--------------------------------------------------------------------------
| Props
|--------------------------------------------------------------------------
*/

const props = defineProps({

    open: {
        type: Boolean,
        default: false
    },

    title: {
        type: String,
        required: true
    },

    icon: {
        type: String,
        default: 'bi-grid'
    },

    categories: {
        type: Array,
        default: () => []
    },

    allLink: {
        type: String,
        default: '#'
    },

    allLabel: {
        type: String,
        default: ''
    },

    footer: {
        type: Object,
        default: () => ({})
    },

    variant: {
        type: String,
        default: 'content'
    }

})


/*
|--------------------------------------------------------------------------
| Emits
|--------------------------------------------------------------------------
*/

const emit = defineEmits([
    'update:open',
    'navigate',
    'close'
])


/*
|--------------------------------------------------------------------------
| Active category
|--------------------------------------------------------------------------
*/

const activeCategory = ref(0)


const resolvedAllLabel = computed(() => {

    return props.allLabel ||
        t('megaMenu.allProducts')

})


/*
|--------------------------------------------------------------------------
| Reset active category when menu opens
|--------------------------------------------------------------------------
*/

watch(
    () => props.open,
    (value) => {

        if (value) {

            activeCategory.value = 0

        }

    }
)


/*
|--------------------------------------------------------------------------
| Select category
|--------------------------------------------------------------------------
*/

const selectCategory = (index) => {

    activeCategory.value = index

}


/*
|--------------------------------------------------------------------------
| Product preview
|--------------------------------------------------------------------------
*/

const {
    hoveredProductId,
    clearPreviewHideTimer,
    schedulePreviewHide,
    handleProductHover
} = useProductPreviewHover()


/*
|--------------------------------------------------------------------------
| Close mega menu
|--------------------------------------------------------------------------
*/

const closeMegaMenu = () => {
    clearPreviewHideTimer()
    emit('update:open', false)
    emit('navigate')
    emit('close')

}


/*
|--------------------------------------------------------------------------
| Current category
|--------------------------------------------------------------------------
*/

const currentCategory = computed(() => {

    return props.categories[
        activeCategory.value
    ] || null

})


/*
|--------------------------------------------------------------------------
| Fallback preview product
|--------------------------------------------------------------------------
*/

const fallbackPreviewProduct = computed(() => {

    const category = currentCategory.value

    if (!category?.groups?.length) {
        return null
    }

    for (const group of category.groups) {

        if (
            !Array.isArray(group.productIds) ||
            !group.productIds.length
        ) {
            continue
        }

        return resolveProductById(
            group.productIds[0]
        )

    }

    return null

})


/*
|--------------------------------------------------------------------------
| Product map
|--------------------------------------------------------------------------
*/

const productMap = computed(() => {

    const map = {}

    for (const category of props.categories || []) {

        for (const group of category.groups || []) {

            if (!Array.isArray(group.products)) {
                continue
            }

            for (const product of group.products) {

                if (product?.id) {

                    map[product.id] = product

                }

            }

        }

    }

    return map

})


/*
|--------------------------------------------------------------------------
| Preview product
|--------------------------------------------------------------------------
*/

const previewProduct = computed(() => {

    if (!hoveredProductId.value) {
        return null
    }

    return (
        productMap.value[
            hoveredProductId.value
        ] ||
        resolveProductById(
            hoveredProductId.value
        )
    )

})


/*
|--------------------------------------------------------------------------
| Preview category title
|--------------------------------------------------------------------------
*/

const previewProductCategoryTitle = computed(() => {

    return (
        currentCategory.value?.shortTitle ||
        currentCategory.value?.title ||
        t('megaMenu.deviceDefault')
    )

})


/*
|--------------------------------------------------------------------------
| Preview image
|--------------------------------------------------------------------------
*/

const previewProductImage = computed(() => {

    if (!previewProduct.value) {
        return ''
    }

    const categorySlug =
        currentCategory.value?.id ||
        currentCategory.value?.slug

    const rawImageName =
        previewProduct.value.image_url || ''

    if (!categorySlug || !rawImageName) {
        return ''
    }

    const imageName =
        rawImageName.includes('.')
            ? rawImageName
            : `${rawImageName}.webp`

    return `/image/product/${categorySlug}/${imageName}`

})


/*
|--------------------------------------------------------------------------
| Preview description
|--------------------------------------------------------------------------
*/

const previewProductDescription = computed(() => {

    if (!previewProduct.value) {

        return t(
            'megaMenu.deviceHint'
        )

    }

    return (
        previewProduct.value.description ||
        t(
            'megaMenu.deviceDescription',
            {
                product:
                    previewProduct.value.title.toLowerCase()
            }
        )
    )

})


/*
|--------------------------------------------------------------------------
| Preview image error
|--------------------------------------------------------------------------
*/

const onPreviewImageError = (event) => {

    event.target.src =
        '/image/logo.svg'

}

</script>