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
                        ? 'grid grid-cols-2 gap-2'
                        : 'flex flex-col gap-2'
                ]"
        >

                <RouterLink
                    v-for="group in category.groups"
                    :key="`${category.id}-${group.id}`"
                    :to="group.href"
                    class="group flex min-w-0 items-center gap-3 rounded-lg
                           border border-gray-100 px-3 py-3 text-[#252525]
                           transition-colors hover:border-gray-300 hover:bg-[#f8f8f8]"
                    @click="emit('navigate')"
                >

                    <!-- ICON -->

                    <span
                        class="flex size-[22px] shrink-0 items-center
                               justify-center rounded-[5px]
                               bg-gray-100 text-[12px] text-gray-400
                               transition-colors group-hover:bg-gray-900
                               group-hover:text-white"
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

                    <span class="min-w-0 flex-1">
                        <span class="block truncate text-[12px] font-semibold leading-4">
                            {{ group.title }}
                        </span>
                        <span class="mt-1 block text-[11px] leading-4 text-gray-500">
                            {{ t('megaMenu.showAllProducts') }}
                        </span>
                    </span>

                    <i class="bi bi-arrow-right shrink-0 text-xs text-gray-400 transition-transform group-hover:translate-x-1 group-hover:text-gray-900"></i>

                </RouterLink>

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
                @click="emit('navigate')"
            >

                <span>
                    {{ t('megaMenu.allCategory', { category: category.title.toLowerCase() }) }}
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

import { useI18n } from 'vue-i18n'

import {
    Icon
} from '../../../constants/icons.js'


const { t } = useI18n()


const emit = defineEmits(['navigate'])

defineProps({

    category: {
        type: Object,
        default: null
    }

})

</script>
