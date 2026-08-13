<template>
    <div class="space-y-1 px-2 pb-2">

        <div
            v-for="group in groups"
            :key="group.id || group.title"
            class="space-y-0.5"
        >

            <!-- GROUP HEADER -->

            <div
                class="group flex w-full items-center gap-2
                       rounded-md
                       px-2 py-1.5
                       pl-8
                       text-left
                       text-[12.5px]
                       font-medium
                       tracking-[-0.01em] text-gray-600
                       transition-colors duration-200
                       hover:bg-transparent hover:text-[#252525]
                       cursor-pointer"
                @click="toggleGroup(group)"
            >

                <!-- Group icon -->

                <span
                    class="flex h-5 w-5 shrink-0
                           items-center justify-center
                           rounded-md transition-all duration-200"
                    :class="isGroupOpen(group)
                        ? 'bg-[#252525] text-white'
                        : 'bg-[#efefef] text-gray-600 group-hover:bg-[#252525] group-hover:text-white'"
                >
                    <i
                        :class="[
                            'bi',
                            Icon[
                                group.id
                                    ?.toUpperCase()
                                    .replace(/-/g, '_')
                            ] || Icon.FOLDER,
                            'text-sm'
                        ]"
                    ></i>
                </span>


                <!-- Group title -->

                <span class="flex-1">
                    {{ group.title }}
                </span>


                <!-- Arrow -->

                <i
                    :class="[
                        'bi',
                        isGroupOpen(group)
                            ? 'bi-chevron-up'
                            : 'bi-chevron-down',
                        'text-xs text-gray-400'
                    ]"
                ></i>

            </div>


            <!-- PRODUCTS -->

            <Transition
                enter-active-class="transition-[max-height,opacity,transform] duration-300 ease-[cubic-bezier(0.22,1,0.36,1)]"
                enter-from-class="max-h-0 translate-y-1 opacity-0"
                enter-to-class="max-h-[1500px] translate-y-0 opacity-100"
                leave-active-class="transition-[max-height,opacity,transform] duration-250 ease-[cubic-bezier(0.4,0,0.2,1)]"
                leave-from-class="max-h-[1500px] translate-y-0 opacity-100"
                leave-to-class="max-h-0 -translate-y-1 opacity-0"
            >
                <div
                    v-if="isGroupOpen(group)"
                    class="overflow-hidden"
                >

                    <div class="space-y-0 py-0.5">

                        <ProductItem
                            v-for="product in getProducts(group)"
                            :key="product.id"
                            :product="product"
                            @close="$emit('close')"
                        />

                    </div>

                    <a
                        v-if="group.href"
                        :href="group.href"
                        @click="$emit('close')"
                        class="mt-2 inline-flex items-center gap-2
                               px-2 py-1.5 text-[12px]
                               font-medium text-[#555555]
                               transition-colors duration-200
                               hover:text-[#252525]"
                    >
                        <span>{{ t('megaMenu.showAllGroup') }}</span>
                        <i class="bi bi-arrow-right text-[11px]"></i>
                    </a>

                </div>
            </Transition>

        </div>

    </div>
</template>


<script setup>
import { ref } from 'vue'
import { useI18n } from 'vue-i18n'
import ProductItem from './ProductItem.vue'
import { resolveProductById } from '../navigation.data.js'
import { Icon } from '@/modules/site/constants/icons.js'

const { t } = useI18n()

defineProps({
    groups: {
        type: Array,
        default: () => []
    }
})


defineEmits([
    'close'
])


const openGroup = ref(null)


const toggleGroup = (group) => {
    const groupId = group.id || group.title

    if (openGroup.value === groupId) {
        openGroup.value = null
        return
    }

    openGroup.value = groupId
}


const isGroupOpen = (group) => {
    return openGroup.value === (group.id || group.title)
}


const getProducts = (group) => {

    if (Array.isArray(group.products) && group.products.length) {
        return group.products
    }

    return group.productIds
        .map(id => resolveProductById(id))
        .filter(Boolean)

}
</script>