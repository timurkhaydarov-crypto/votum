<template>

    <a :href="category.href" class="group flex items-center
           gap-3 rounded-xl
           px-3 py-3
           transition-all duration-150" :class="active
                ? 'bg-white shadow-sm'
                : 'hover:bg-white/70'
            ">

        <!-- ICON -->

        <span class="flex h-9 w-9 shrink-0
             items-center justify-center
             rounded-lg transition" :class="active
                    ? 'bg-[#252525] text-white'
                    : 'bg-white text-gray-500'
                ">

            <i :class="[
                'bi',
                category.icon,
                'text-base'
            ]"></i>

        </span>


        <!-- TITLE -->

        <span class="min-w-0 flex-1">

            <span class="block text-[13px]
               font-semibold leading-4" :class="active
                    ? 'text-[#252525]'
                    : 'text-gray-600'
                ">

                {{ category.shortTitle || category.title }}

            </span>

        </span>


        <!-- ARROW -->

        <i class="bi bi-chevron-right
             text-[10px]" :class="active
                    ? 'text-[#252525] translate-x-0.5'
                    : 'text-gray-300'
                "></i>

    </a>

</template>
<script setup>
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