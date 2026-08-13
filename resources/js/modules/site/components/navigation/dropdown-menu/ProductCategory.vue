<template>
    <div class="mt-0 space-y-1 px-2">

        <!-- CATEGORIES -->

        <div
            v-for="category in categories"
            :key="category.id || category.title"
            class="rounded-xl"
        >

            <!-- CATEGORY -->
            <div
                class="group flex items-center gap-2
                       rounded-md
                       px-2 py-1
                       transition-colors duration-200
                       hover:bg-transparent
                       cursor-pointer"
                @click="toggleCategory(category)"
            >

                <!-- Icon -->
                <span
                    class="flex h-7 w-7 shrink-0
                           items-center justify-center
                           rounded-md transition-all duration-200"
                    :class="isCategoryOpen(category)
                        ? 'bg-[#252525] text-white'
                        : 'bg-[#efefef] text-gray-600 group-hover:bg-[#252525] group-hover:text-white'"
                >
                    <i
                        :class="[
                            'bi',
                            Icon[
                                category.id
                                    ?.toUpperCase()
                                    .replace(/-/g, '_')
                            ] || Icon.FOLDER
                        ]"
                    ></i>
                </span>


                <!-- Title -->
                <span
                    class="flex-1 text-[13px]
                           font-medium
                           tracking-[-0.01em] text-[#252525]"
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
                            isCategoryOpen(category)
                                ? 'bi-chevron-up'
                                : 'bi-chevron-down',
                            'text-xs'
                        ]"
                    ></i>
                </div>

            </div>


            <!-- GROUPS -->

            <Transition
                enter-active-class="transition-[max-height,opacity,transform] duration-300 ease-[cubic-bezier(0.22,1,0.36,1)]"
                enter-from-class="max-h-0 translate-y-1 opacity-0"
                enter-to-class="max-h-[3000px] translate-y-0 opacity-100"
                leave-active-class="transition-[max-height,opacity,transform] duration-250 ease-[cubic-bezier(0.4,0,0.2,1)]"
                leave-from-class="max-h-[3000px] translate-y-0 opacity-100"
                leave-to-class="max-h-0 -translate-y-1 opacity-0"
            >
                <div
                    v-if="isCategoryOpen(category)"
                    class="overflow-hidden"
                >

                    <ProductGroup
                        :groups="category.groups"
                        @close="$emit('close')"
                    />

                    <a
                        v-if="category.href"
                        :href="category.href"
                        @click="$emit('close')"
                        class="mt-2 inline-flex items-center gap-2
                               px-2 py-1.5 text-[12px]
                               font-medium text-[#555555]
                               transition-colors duration-200
                               hover:text-[#252525]"
                    >
                        <span>{{ t('megaMenu.showAllCategory') }}</span>
                        <i class="bi bi-arrow-right text-[11px]"></i>
                    </a>

                </div>
            </Transition>

        </div>

        <a
            v-if="allLink"
            :href="allLink"
            @click="$emit('close')"
            class="mt-2 inline-flex items-center gap-2
                   px-2 py-1.5 text-[12px]
                   font-medium text-[#555555]
                   transition-colors duration-200
                   hover:text-[#252525]"
        >
            <span>{{ allLabel || t('megaMenu.showAllCategory') }}</span>
            <i class="bi bi-arrow-right text-[11px]"></i>
        </a>

    </div>
</template>


<script setup>
import { ref } from 'vue'
import { useI18n } from 'vue-i18n'
import ProductGroup from './ProductGroup.vue'
import { Icon } from '@/modules/site/constants/icons.js'

const { t } = useI18n()

defineProps({
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


defineEmits([
    'close'
])


const openCategory = ref(null)


const toggleCategory = (category) => {
    const categoryId = category.id || category.title

    if (openCategory.value === categoryId) {
        openCategory.value = null
        return
    }

    openCategory.value = categoryId
}


const isCategoryOpen = (category) => {
    return openCategory.value === (category.id || category.title)
}
</script>