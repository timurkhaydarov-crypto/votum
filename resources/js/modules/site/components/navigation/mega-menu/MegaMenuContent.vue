<template>

    <!-- ====================================== -->
    <!-- CATEGORY -->
    <!-- ====================================== -->

    <div
        v-if="category"
        class="min-h-[250px] p-4"
    >

        <!-- ====================================== -->
        <!-- TITLE -->
        <!-- ====================================== -->

        <div class="mb-3">

            <h2
                class="text-base font-bold tracking-tight text-[#252525]"
            >
                {{ category.title }}
            </h2>

            <p
                v-if="category.description"
                class="mt-1 max-w-xl text-[11px] leading-4 text-gray-500"
            >
                {{ category.description }}
            </p>

        </div>


        <!-- ====================================== -->
        <!-- GROUPS -->
        <!-- ====================================== -->

        <div
            :class="[
                category.groups?.length > 3
                    ? 'grid grid-cols-2 gap-x-3 gap-y-1.5'
                    : 'flex flex-col gap-1.5'
            ]"
        >

            <div
                v-for="group in category.groups"
                :key="`${category.id}-${group.id}`"
                class="relative rounded-xl transition-all duration-300"
            >

                <!-- ================================== -->
                <!-- GROUP HEADER -->
                <!-- ================================== -->

                <button
                    type="button"
                    class="group relative flex w-full items-center gap-2
                           rounded-[10px] border border-transparent px-2 py-[8px]
                           text-left text-[#252525]
                           transition-all duration-[220ms]
                           hover:bg-[#f8f8f8]
                           active:scale-[0.995]"
                    :class="{
                        'border-gray-200 bg-[#f5f5f5]': isGroupOpen(group.id)
                    }"
                    @mouseenter="hoveredGroupId = group.id"
                    @mouseleave="hoveredGroupId = null"
                    @click="toggleGroup(group.id)"
                >

                    <!-- ICON -->

                    <span
                        class="flex size-[22px] shrink-0 items-center
                               justify-center rounded-[5px]
                               bg-gray-100 text-[12px] text-gray-400
                               transition-all duration-300"
                        :class="{
                            'bg-gray-900 text-white':
                                isGroupHighlighted(group.id)
                        }"
                    >

                        <i
                            :class="[
                                'bi',
                                Icon[
                                    group.id
                                        ?.toUpperCase()
                                        .replace(/-/g, '_')
                                ]
                                || group.icon
                                || 'bi-box'
                            ]"
                        ></i>

                    </span>


                    <!-- TITLE -->

                    <span
                        class="flex-1 text-[12px] font-semibold
                               leading-4 text-[#252525]
                               transition-colors duration-[220ms]"
                    >
                        {{ group.title }}
                    </span>


                    <!-- CHEVRON -->

                    <span
                        class="flex size-[24px] shrink-0 items-center
                               justify-center rounded-[5px]
                               text-[9px] text-[#b0b0b0]
                               transition-all duration-300"
                        :class="{
                            'bg-gray-200 text-gray-600':
                                hoveredGroupId === group.id,

                            'rotate-180 bg-gray-200 text-gray-900':
                                isGroupOpen(group.id)
                        }"
                    >

                        <i class="bi bi-chevron-down"></i>

                    </span>

                </button>


                <!-- ================================== -->
                <!-- PRODUCTS -->
                <!-- ================================== -->

                <div
                    class="grid grid-rows-[0fr] opacity-0
                           transition-[grid-template-rows,opacity]
                           duration-[450ms]
                           ease-[cubic-bezier(0.16,1,0.3,1)]"
                    :class="{
                        'grid-rows-[1fr] opacity-100':
                            isGroupOpen(group.id)
                    }"
                >

                    <div class="min-h-0 overflow-hidden">

                        <div
                            class="mr-3 mb-2 mt-0
                                   -translate-x-0.5 -translate-y-1.5
                                   px-0 pb-1 pt-3
                                   opacity-0
                                   transition-[transform,opacity]
                                   duration-[400ms]
                                   ease-[cubic-bezier(0.16,1,0.3,1)]"
                            :class="{
                                'translate-y-0 opacity-100':
                                    isGroupOpen(group.id)
                            }"
                        >

                            <MegaMenuGroup
                                :group="group"
                                :limit="Infinity"
                                :all-link="group.href"
                                :all-label="t('megaMenu.showAllProducts')"
                                @product-hover="emit('product-hover', $event)"
                            />

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- ====================================== -->
        <!-- CATEGORY LINK -->
        <!-- ====================================== -->

        <div
            class="mt-3 border-t border-gray-200 pt-2.5"
        >

            <RouterLink
                :to="category.href"
                class="group inline-flex items-center gap-[6px]
                       text-[11px] font-semibold text-[#252525]
                       transition-all duration-[220ms]
                       hover:gap-2 hover:text-black"
            >

                <span>
                    {{ t('megaMenu.allCategory') }}
                </span>

                <span
                    class="flex size-[22px] items-center
                           justify-center rounded-[6px]
                           bg-gray-100 text-[10px]
                           transition-all duration-[220ms]
                           group-hover:translate-x-px
                           group-hover:bg-gray-900
                           group-hover:text-white"
                >

                    <i class="bi bi-arrow-right"></i>

                </span>

            </RouterLink>

        </div>

    </div>

</template>


<script setup>

import {
    ref,
    watch
} from 'vue'
import { useI18n } from 'vue-i18n'

import MegaMenuGroup from './MegaMenuGroup.vue'
import { Icon } from '../../../constants/icons.js'

const { t } = useI18n()


const emit = defineEmits([
    'product-hover'
])


const props = defineProps({

    category: {
        type: Object,
        default: null
    }

})


/*
|--------------------------------------------------------------------------
| Active group
|--------------------------------------------------------------------------
*/

const openGroupId = ref(null)


/*
|--------------------------------------------------------------------------
| Hover group
|--------------------------------------------------------------------------
*/

const hoveredGroupId = ref(null)


/*
|--------------------------------------------------------------------------
| Toggle
|--------------------------------------------------------------------------
*/

const toggleGroup = (groupId) => {

    openGroupId.value =
        openGroupId.value === groupId
            ? null
            : groupId

}


/*
|--------------------------------------------------------------------------
| Open state
|--------------------------------------------------------------------------
*/

const isGroupOpen = (groupId) => {

    return openGroupId.value === groupId

}


/*
|--------------------------------------------------------------------------
| Highlight state
|--------------------------------------------------------------------------
*/

const isGroupHighlighted = (groupId) => {

    return (
        hoveredGroupId.value === groupId ||
        openGroupId.value === groupId
    )

}


/*
|--------------------------------------------------------------------------
| Category changed
|--------------------------------------------------------------------------
*/

watch(
    () => props.category,
    () => {

        hoveredGroupId.value = null

        openGroupId.value = null

    }
)

</script>