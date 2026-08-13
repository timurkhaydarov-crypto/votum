<template>

    <div class="group flex cursor-default items-center
           gap-2.5 rounded-lg
           border border-transparent
           px-2.5 py-2.5
           select-none
           transition-all duration-150" :class="active
                ? 'border-gray-200 bg-gray-200'
                : 'hover:bg-[#f2f2f2]'
            ">

        <!-- ICON -->

        <span class="flex h-7 w-7 shrink-0
             items-center justify-center
             rounded-md transition" :class="active
                    ? 'bg-[#252525] text-white'
                    : 'bg-[#efefef] text-gray-600 group-hover:bg-[#e9e9e9] group-hover:text-[#252525]'
                ">

            <i :class="[
                'bi',
                Icon[category.id?.toUpperCase().replace(/-/g, '_')] || category.icon,
                'text-sm'
            ]"></i>

        </span>


        <!-- TITLE -->

        <span class="min-w-0 flex-1">

            <span class="block text-[12px]
               font-semibold leading-4" :class="active
                    ? 'text-[#252525]'
                    : 'text-gray-700 group-hover:text-[#1f1f1f]'
                ">

                {{ category.shortTitle || category.title }}

            </span>

        </span>


        <!-- ARROW -->

        <i class="bi bi-chevron-right
             text-[9px]" :class="active
                    ? 'text-[#252525] translate-x-0.5'
                    : 'text-gray-400 group-hover:text-[#343434]'
                "></i>

    </div>

</template>
<script setup>
import { Icon } from '../../../constants/icons.js'
defineProps({
    category: {
        type: Object,
        required: true
    },

    active: {
        type: Boolean,
        default: false
    }
})
</script>