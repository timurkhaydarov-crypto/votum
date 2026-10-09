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
                        'grid-cols-[minmax(190px,260px)_minmax(0,1fr)]'
                    ]"
                >

                    <!-- CATEGORIES -->

                    <MegaMenuCategories
                        :categories="categories"
                        :active-index="activeCategory"
                        @select="selectCategory"
                    />


                    <!-- MAIN CONTENT -->

                    <div class="min-w-0 overflow-hidden">

                        <MegaMenuContent
                            v-if="variant === 'content'"
                            :category="categories[activeCategory]"
                            @navigate="closeMegaMenu"
                        />

                        <MegaMenuCards
                            v-else-if="variant === 'cards'"
                            :category="categories[activeCategory]"
                            @navigate="closeMegaMenu"
                        />

                    </div>
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
import MegaMenuFooter from './MegaMenuFooter.vue'


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
| Close mega menu
|--------------------------------------------------------------------------
*/

const closeMegaMenu = () => {
    emit('update:open', false)
    emit('navigate')
    emit('close')

}


</script>