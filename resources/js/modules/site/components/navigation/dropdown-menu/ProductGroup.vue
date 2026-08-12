<template>
    <div class="space-y-1 px-2 pb-2">

        <div
            v-for="group in groups"
            :key="group.id || group.title"
        >

            <!-- GROUP HEADER -->

            <button
                type="button"
                class="flex w-full items-center gap-3
                       rounded-lg
                       px-3 py-2.5
                       pl-10
                       text-left
                       text-sm
                       font-medium
                       text-gray-600
                       transition
                       hover:bg-gray-50
                       hover:text-[#252525]"
                @click="toggleGroup(group)"
            >

                <!-- Group icon -->

                <span
                    class="flex h-7 w-7 shrink-0
                           items-center justify-center
                           rounded-lg
                           bg-gray-100
                           text-gray-500"
                >
                    <i
                        :class="[
                            'bi',
                            group.icon,
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

            </button>


            <!-- PRODUCTS -->

            <Transition
                enter-active-class="transition-all duration-200 ease-out"
                enter-from-class="max-h-0 opacity-0"
                enter-to-class="max-h-[1500px] opacity-100"
                leave-active-class="transition-all duration-150 ease-in"
                leave-from-class="max-h-[1500px] opacity-100"
                leave-to-class="max-h-0 opacity-0"
            >
                <div
                    v-if="isGroupOpen(group)"
                    class="overflow-hidden"
                >

                    <div class="space-y-0.5 py-1">

                        <ProductItem
                            v-for="product in getProducts(group)"
                            :key="product.id"
                            :product="product"
                            @close="$emit('close')"
                        />

                    </div>

                </div>
            </Transition>

        </div>

    </div>
</template>


<script setup>
import { ref } from 'vue'
import ProductItem from './ProductItem.vue'
import { products } from '../navigation.data.js'


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

    return group.productIds
        .map(id => products.find(product => product.id === id))
        .filter(Boolean)

}
</script>