<template>
    <div class="space-y-1">

        <!-- CATEGORY HEADER -->

        <button
            type="button"
            class="group flex w-full items-center gap-2.5
                   rounded-lg px-2.5 py-2.5
                   text-left text-[13.5px] font-medium
                   tracking-[-0.01em] text-[#252525]
                   transition-colors duration-200
                   hover:bg-transparent"
            :class="{
                'bg-transparent': open
            }"
            @click="toggle"
        >
            <!-- Icon -->

            <span
                class="flex h-8 w-8 shrink-0
                       items-center justify-center
                       rounded-md transition-all duration-200"
                :class="open
                    ? 'bg-[#252525] text-white'
                    : 'bg-[#efefef] text-gray-600 group-hover:bg-[#252525] group-hover:text-white'"
            >
                <i
                    :class="[
                        'bi',
                        icon,
                        'text-lg'
                    ]"
                ></i>
            </span>

            <!-- Title -->

            <span class="flex-1">
                {{ title }}
            </span>

            <!-- Arrow -->

            <i
                :class="[
                    'bi',
                    open
                        ? 'bi-chevron-up'
                        : 'bi-chevron-down',
                    'text-sm text-gray-400'
                ]"
            ></i>
        </button>


        <!-- CONTENT -->

        <Transition
            enter-active-class="transition-[max-height,opacity,transform] duration-300 ease-[cubic-bezier(0.22,1,0.36,1)]"
            enter-from-class="max-h-0 translate-y-1 opacity-0"
            enter-to-class="max-h-[3000px] translate-y-0 opacity-100"
            leave-active-class="transition-[max-height,opacity,transform] duration-250 ease-[cubic-bezier(0.4,0,0.2,1)]"
            leave-from-class="max-h-[3000px] translate-y-0 opacity-100"
            leave-to-class="max-h-0 -translate-y-1 opacity-0"
        >
            <div
                v-if="open"
                class="overflow-hidden"
            >
                <div class="mt-0 rounded-xl p-0.5">

                    <!-- ======================================== -->
                    <!-- PRODUCTS -->
                    <!-- ======================================== -->

                    <template v-if="isProductMenu">

                        <ProductCategory
                            :categories="categories"
                            :all-link="allLink"
                            :all-label="allLabel"
                            @close="$emit('close')"
                        />

                    </template>


                    <!-- ======================================== -->
                    <!-- SERVICES -->
                    <!-- ======================================== -->

                    <template v-else>

                        <div
                            v-for="category in categories"
                            :key="category.id || category.title"
                            class="rounded-xl"
                        >

                            <!-- SERVICE CATEGORY -->

                            <div
                                class="group flex cursor-pointer items-center gap-2
                                       rounded-md px-2 py-1
                                       transition-colors duration-200
                                       hover:bg-transparent"
                                @click="toggleServiceCategory(category)"
                            >

                                <!-- Icon -->

                                <span
                                    class="flex h-7 w-7 shrink-0
                                           items-center justify-center
                                           rounded-md transition-all duration-200"
                                    :class="isServiceCategoryOpen(category)
                                        ? 'bg-[#252525] text-white'
                                        : 'bg-[#efefef] text-gray-600 group-hover:bg-[#252525] group-hover:text-white'"
                                >
                                    <i
                                        :class="[
                                            'bi',
                                            category.icon || Icon.FOLDER
                                        ]"
                                    ></i>
                                </span>


                                <!-- Title -->

                                <span
                                    class="flex-1 text-[13px]
                                           font-medium
                                           tracking-[-0.01em]
                                           text-[#252525]"
                                >
                                    {{ category.shortTitle || category.title }}
                                </span>


                                <!-- Arrow -->

                                <div
                                    class="flex h-7 w-7
                                           items-center justify-center
                                           rounded-md
                                           text-gray-400
                                           transition-colors duration-200"
                                >
                                    <i
                                        :class="[
                                            'bi',
                                            isServiceCategoryOpen(category)
                                                ? 'bi-chevron-up'
                                                : 'bi-chevron-down',
                                            'text-xs'
                                        ]"
                                    ></i>
                                </div>

                            </div>


                            <!-- SERVICE ITEMS -->

                            <Transition
                                enter-active-class="transition-[max-height,opacity,transform] duration-300 ease-[cubic-bezier(0.22,1,0.36,1)]"
                                enter-from-class="max-h-0 translate-y-1 opacity-0"
                                enter-to-class="max-h-[2000px] translate-y-0 opacity-100"
                                leave-active-class="transition-[max-height,opacity,transform] duration-250 ease-[cubic-bezier(0.4,0,0.2,1)]"
                                leave-from-class="max-h-[2000px] translate-y-0 opacity-100"
                                leave-to-class="max-h-0 -translate-y-1 opacity-0"
                            >
                                <div
                                    v-if="isServiceCategoryOpen(category)"
                                    class="overflow-hidden"
                                >

                                    <div class="space-y-0.5">

                                        <RouterLink
                                            v-for="item in category.items || []"
                                            :key="item.href || item.title"
                                            :to="item.href"
                                            @click="$emit('close')"
                                            class="group flex items-center gap-2
                                                   rounded-md px-2.5 py-1.5
                                                   pl-11 text-[12.5px]
                                                   text-gray-600
                                                   transition-colors duration-200
                                                   hover:bg-[#f7f5f2]
                                                   hover:text-[#252525]"
                                        >

                                            <!-- Item Icon -->

                                            <span
                                                class="flex h-6 w-6 shrink-0
                                                       items-center justify-center
                                                       rounded-md
                                                       bg-[#efefef]
                                                       text-gray-500
                                                       transition-all duration-200
                                                       group-hover:bg-[#252525]
                                                       group-hover:text-white"
                                            >
                                                <i
                                                    :class="[
                                                        'bi',
                                                        item.icon || Icon.FOLDER
                                                    ]"
                                                ></i>
                                            </span>

                                            <!-- Item title -->

                                            <span>
                                                {{ item.title }}
                                            </span>

                                        </RouterLink>

                                    </div>


                                    <!-- SHOW ALL CATEGORY -->

                                    <RouterLink
                                        v-if="category.href"
                                        :to="category.href"
                                        @click="$emit('close')"
                                        class="mt-2 inline-flex items-center gap-2
                                               px-2 py-1.5
                                               text-[12px]
                                               font-medium
                                               text-[#555555]
                                               transition-colors
                                               duration-200
                                               hover:text-[#252525]"
                                    >
                                        <span>
                                            {{ t('megaMenu.showAllCategory') }}
                                        </span>

                                        <i
                                            class="bi bi-arrow-right text-[11px]"
                                        ></i>
                                    </RouterLink>

                                </div>
                            </Transition>

                        </div>


                        <!-- ALL SERVICES -->

                        <RouterLink
                            v-if="allLink"
                            :to="allLink"
                            @click="$emit('close')"
                            class="mt-2 inline-flex items-center gap-2
                                   px-2 py-1.5
                                   text-[12px]
                                   font-medium
                                   text-[#555555]
                                   transition-colors duration-200
                                   hover:text-[#252525]"
                        >
                            <span>
                                {{ allLabel || t('megaMenu.showAllCategory') }}
                            </span>

                            <i
                                class="bi bi-arrow-right text-[11px]"
                            ></i>
                        </RouterLink>

                    </template>

                </div>
            </div>
        </Transition>

    </div>
</template>


<script setup>
import { computed, ref } from 'vue'
import { useI18n } from 'vue-i18n'

import ProductCategory from './ProductCategory.vue'
import { Icon } from '@/modules/site/constants/icons.js'

const { t } = useI18n()


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
        required: true
    },

    categories: {
        type: Array,
        default: () => []
    },

    allLink: {
        type: String,
        default: ''
    },

    allLabel: {
        type: String,
        default: ''
    }
})


const emit = defineEmits([
    'toggle',
    'close'
])


/*
|--------------------------------------------------------------------------
| PRODUCT MENU
|--------------------------------------------------------------------------
*/

const isProductMenu = computed(() => {
    return props.categories.some(category =>
        Array.isArray(category.groups) &&
        category.groups.length
    )
})


/*
|--------------------------------------------------------------------------
| SERVICE MENU
|--------------------------------------------------------------------------
*/

const openServiceCategory = ref(null)


const toggleServiceCategory = (category) => {
    const categoryId = category.id || category.title

    if (openServiceCategory.value === categoryId) {
        openServiceCategory.value = null
        return
    }

    openServiceCategory.value = categoryId
}


const isServiceCategoryOpen = (category) => {
    return openServiceCategory.value === (
        category.id || category.title
    )
}


/*
|--------------------------------------------------------------------------
| MAIN MENU TOGGLE
|--------------------------------------------------------------------------
*/

const toggle = () => {
    emit('toggle')
}


/*
|--------------------------------------------------------------------------
| CLOSE
|--------------------------------------------------------------------------
*/

const close = () => {
    openServiceCategory.value = null

    emit('close')
}
</script>
