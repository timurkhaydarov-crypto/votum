<template>

    <div class="border-r border-gray-100
           bg-[#f8f8f8] p-3">

        <div class="mb-2 px-2
             text-[9px] font-bold
             uppercase tracking-[0.12em]
             text-gray-500">
            {{ t('megaMenu.categories') }}
        </div>


        <div class="space-y-0.5">

            <MegaMenuCategoryItem v-for="(category, index) in categories" :key="category.title" :category="category"
                :active="activeIndex === index" @mouseenter="$emit('select', index)" @focus="$emit('select', index)" />

        </div>

    </div>

</template>
<script setup>
import { useI18n } from 'vue-i18n'
import MegaMenuCategoryItem from './MegaMenuCategoryItem.vue'

const { t } = useI18n()

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
