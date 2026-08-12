<template>

    <div class="border-r border-gray-100
           bg-gray-50/70 p-4">

        <div class="mb-2 px-3
             text-[10px] font-bold
             uppercase tracking-[0.12em]
             text-gray-400">
            Категории
        </div>


        <div class="space-y-1">

            <MegaMenuCategoryItem v-for="(category, index) in categories" :key="category.title" :category="category"
                :active="activeIndex === index" @mouseenter="$emit('select', index)" @focus="$emit('select', index)" />

        </div>

    </div>

</template>
<script setup>
import MegaMenuCategoryItem from './MegaMenuCategoryItem.vue'

defineProps({
    categories: {
        type: Array,
        default: () => []
    },

    activeIndex: {
        type: Number,
        default: 0
    }
})

defineEmits(['select'])
</script>
