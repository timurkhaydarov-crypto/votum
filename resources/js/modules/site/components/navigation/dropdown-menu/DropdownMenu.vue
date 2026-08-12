<template>
    <div class="space-y-1">

        <!-- CATEGORY HEADER -->
        <button
            type="button"
            class="flex w-full items-center gap-4
                   rounded-2xl px-4 py-3.5
                   text-left text-[15px] font-medium
                   text-[#252525]
                   transition
                   hover:bg-gray-100"
            @click="toggle"
        >
            <!-- Icon -->
            <span
                class="flex h-10 w-10 shrink-0
                       items-center justify-center
                       rounded-xl bg-gray-100"
            >
                <i
                    :class="[
                        'bi',
                        icon,
                        'text-xl'
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
            enter-active-class="transition-all duration-200 ease-out"
            enter-from-class="max-h-0 opacity-0"
            enter-to-class="max-h-[2000px] opacity-100"
            leave-active-class="transition-all duration-150 ease-in"
            leave-from-class="max-h-[2000px] opacity-100"
            leave-to-class="max-h-0 opacity-0"
        >
            <div
                v-if="open"
                class="overflow-hidden"
            >
                <div class="mt-1 rounded-2xl bg-gray-50 p-2">

                    <template v-if="isProductMenu">
                        <ProductCategory
                            :categories="categories"
                            :all-link="allLink"
                            :all-label="allLabel"
                            @close="$emit('close')"
                        />
                    </template>

                    <template v-else>
                        <div
                            v-for="category in categories"
                            :key="category.title"
                            class="mb-2 last:mb-0"
                        >
                            <a
                                :href="category.href"
                                @click="$emit('close')"
                                class="flex items-center gap-3
                                       rounded-xl px-3 py-2.5
                                       text-sm font-semibold
                                       text-[#252525]
                                       transition
                                       hover:bg-white"
                            >
                                <span
                                    class="flex h-8 w-8 shrink-0
                                           items-center justify-center
                                           rounded-lg bg-white
                                           text-gray-500"
                                >
                                    <i
                                        :class="[
                                            'bi',
                                            category.icon || 'bi-folder'
                                        ]"
                                    ></i>
                                </span>

                                <span>
                                    {{ category.shortTitle || category.title }}
                                </span>
                            </a>

                            <a
                                v-for="item in category.items || []"
                                :key="item.title"
                                :href="item.href"
                                @click="$emit('close')"
                                class="flex items-center gap-2
                                       rounded-lg px-3 py-2
                                       pl-14 text-sm
                                       text-gray-600
                                       transition
                                       hover:bg-white
                                       hover:text-[#252525]"
                            >
                                <i class="bi bi-chevron-right text-[9px] text-gray-400"></i>
                                <span>{{ item.title }}</span>
                            </a>
                        </div>
                    </template>

                    <!-- <a
                        v-if="allLink"
                        :href="allLink"
                        @click="$emit('close')"
                        class="mt-2 flex items-center justify-center
                               gap-2 rounded-xl bg-white
                               px-4 py-3 text-sm font-semibold
                               text-[#252525] transition
                               hover:bg-gray-100"
                    >
                        <span>{{ allLabel }}</span>
                        <i class="bi bi-arrow-right text-sm"></i>
                    </a> -->

                </div>
            </div>
        </Transition>

    </div>
</template>


<script setup>
import { computed } from 'vue'
import ProductCategory from './ProductCategory.vue'

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


const isProductMenu = computed(() => {
    return props.categories.some(category =>
        Array.isArray(category.groups) && category.groups.length
    )
})


const toggle = () => {
    emit('toggle')
}
</script>