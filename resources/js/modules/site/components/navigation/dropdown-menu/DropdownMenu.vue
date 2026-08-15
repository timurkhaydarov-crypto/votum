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
            enter-to-class="max-h-[2000px] translate-y-0 opacity-100"
            leave-active-class="transition-[max-height,opacity,transform] duration-250 ease-[cubic-bezier(0.4,0,0.2,1)]"
            leave-from-class="max-h-[2000px] translate-y-0 opacity-100"
            leave-to-class="max-h-0 -translate-y-1 opacity-0"
        >
            <div
                v-if="open"
                class="overflow-hidden"
            >
                <div class="mt-0 rounded-xl p-0.5">

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
                            <RouterLink
                                :to="category.href"
                                @click="$emit('close')"
                                class="group flex items-center gap-2.5
                                       rounded-md px-2.5 py-1.75
                                       text-[13px] font-medium
                                       text-[#252525]
                                       transition-colors duration-200
                                       hover:bg-transparent"
                            >
                                <span
                                    class="flex h-6 w-6 shrink-0
                                           items-center justify-center
                                           rounded-md bg-[#efefef] text-gray-600
                                           shadow-[inset_0_0_0_1px_rgba(0,0,0,0.02)]
                                           transition-all duration-200
                                           group-hover:bg-[#252525] group-hover:text-white"
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

                                <span>
                                    {{ category.shortTitle || category.title }}
                                </span>
                            </RouterLink>

                            <RouterLink
                                v-for="item in category.items || []"
                                :key="item.title"
                                :to="item.href"
                                @click="$emit('close')"
                                class="flex items-center gap-2
                                       rounded-md px-2.5 py-1.25
                                       pl-11 text-[12.5px]
                                       text-gray-600
                                       transition-colors duration-200
                                       hover:bg-[#f7f5f2] hover:text-[#252525]"
                            >
                                <i class="bi bi-chevron-right text-[9px] text-gray-400"></i>
                                <span>{{ item.title }}</span>
                            </RouterLink>
                        </div>
                    </template>

                    <!-- <RouterLink
                        v-if="allLink"
                        :to="allLink"
                        @click="$emit('close')"
                        class="mt-2 flex items-center justify-center
                               gap-2 rounded-xl bg-white
                               px-4 py-3 text-sm font-semibold
                               text-[#252525] transition
                               hover:bg-gray-100"
                    >
                        <span>{{ allLabel }}</span>
                        <i class="bi bi-arrow-right text-sm"></i>
                    </RouterLink> -->

                </div>
            </div>
        </Transition>

    </div>
</template>


<script setup>
import { computed } from 'vue'
import ProductCategory from './ProductCategory.vue'
import { Icon } from '@/modules/site/constants/icons.js'

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