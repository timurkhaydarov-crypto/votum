<template>
    <div class="mt-1 space-y-1 px-2">

        <!-- CATEGORIES -->

        <div
            v-for="category in categories"
            :key="category.id || category.title"
            class="rounded-xl"
        >

            <!-- CATEGORY -->
            <div
                class="flex items-center gap-3
                       rounded-xl
                       px-3 py-2.5
                       transition
                       hover:bg-gray-50"
            >

                <!-- Icon -->
                <span
                    class="flex h-8 w-8 shrink-0
                           items-center justify-center
                           rounded-lg
                           bg-gray-100
                           text-gray-500"
                >
                    <i
                        :class="[
                            'bi',
                            category.icon
                        ]"
                    ></i>
                </span>


                <!-- Title -->
                <a
                    :href="category.href"
                    @click="$emit('close')"
                    class="flex-1 text-sm
                           font-medium
                           text-[#252525]"
                >
                    {{ category.shortTitle || category.title }}
                </a>


                <!-- Arrow -->
                <button
                    type="button"
                    class="flex h-8 w-8
                           items-center justify-center
                           rounded-lg
                           text-gray-400
                           transition
                           hover:bg-gray-100"
                    @click="toggleCategory(category)"
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
                </button>

            </div>


            <!-- GROUPS -->

            <Transition
                enter-active-class="transition-all duration-200 ease-out"
                enter-from-class="max-h-0 opacity-0"
                enter-to-class="max-h-[3000px] opacity-100"
                leave-active-class="transition-all duration-150 ease-in"
                leave-from-class="max-h-[3000px] opacity-100"
                leave-to-class="max-h-0 opacity-0"
            >
                <div
                    v-if="isCategoryOpen(category)"
                    class="overflow-hidden"
                >

                    <ProductGroup
                        :groups="category.groups"
                        @close="$emit('close')"
                    />

                </div>
            </Transition>

        </div>

        <a
            v-if="allLink"
            :href="allLink"
            @click="$emit('close')"
            class="mt-2 flex items-center gap-3
                   rounded-xl
                   px-3 py-3
                   text-sm font-medium
                   text-[#252525]
                   transition
                   hover:bg-gray-100"
        >

            <span
                class="flex h-8 w-8
                       items-center justify-center
                       rounded-lg
                       bg-gray-100"
            >
                <i class="bi bi-grid-3x3-gap"></i>
            </span>

            <span>
                {{ allLabel }}
            </span>

        </a>

    </div>
</template>


<script setup>
import { ref } from 'vue'
import ProductGroup from './ProductGroup.vue'


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