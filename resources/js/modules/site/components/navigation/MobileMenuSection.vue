<template>

    <div class="border-b border-gray-100 last:border-0">

        <!-- Заголовок -->

        <button v-if="item.children?.length" type="button" class="flex w-full
             items-center
             justify-between
             gap-3
             py-3.5
             text-left
             text-[#252525]" :class="{
                'pl-0': level === 0,
                'pl-4': level === 1,
                'pl-8': level === 2
            }" @click="isOpen = !isOpen">

            <span class="flex min-w-0
               items-center gap-3">

                <i v-if="item.icon" :class="[
                    'bi',
                    item.icon,
                    'shrink-0 text-base text-gray-500'
                ]" aria-hidden="true"></i>

                <span class="min-w-0
                 text-sm
                 font-medium">
                    {{ item.title }}
                </span>

            </span>


            <i class="bi bi-chevron-down
               shrink-0
               text-xs
               text-gray-400
               transition-transform duration-200" :class="{ 'rotate-180': isOpen }" aria-hidden="true"></i>

        </button>


        <!-- Ссылка без дочерних элементов -->

        <RouterLink v-else :to="item.href" class="flex items-center
             gap-3
             py-3.5
             text-sm
             text-gray-600" :class="{
                'pl-0': level === 0,
                'pl-4': level === 1,
                'pl-8': level === 2
            }">

            <i v-if="item.icon" :class="[
                'bi',
                item.icon,
                'shrink-0 text-base text-gray-400'
            ]" aria-hidden="true"></i>

            <span>
                {{ item.title }}
            </span>

        </RouterLink>


        <!-- Дочерние элементы -->

        <Transition enter-active-class="transition-all duration-200" enter-from-class="max-h-0 opacity-0"
            enter-to-class="max-h-[1000px] opacity-100" leave-active-class="transition-all duration-150"
            leave-from-class="max-h-[1000px] opacity-100" leave-to-class="max-h-0 opacity-0">

            <div v-if="isOpen" class="overflow-hidden">

                <MobileMenuSection v-for="child in item.children" :key="child.title" :item="child" :level="level + 1" />

            </div>

        </Transition>

    </div>

</template>

<script setup>
import { ref } from 'vue'

defineProps({
    item: {
        type: Object,
        required: true
    },

    level: {
        type: Number,
        default: 0
    }
})

const isOpen = ref(false)
</script>