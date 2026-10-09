<template>
    <div class="space-y-1 px-2 pb-2">

        <RouterLink
            v-for="group in groups"
            :key="group.id || group.title"
            :to="group.href"
            class="group flex w-full items-center gap-2 rounded-md px-2 py-2
                   pl-8 text-left text-[12.5px] font-medium tracking-[-0.01em]
                   text-gray-600 transition-colors duration-200 hover:bg-gray-50
                   hover:text-[#252525]"
            @click="emit('close')"
        >

            <span
                class="flex h-5 w-5 shrink-0 items-center justify-center
                       rounded-md bg-[#efefef] text-gray-600
                       transition-colors group-hover:bg-[#252525]
                       group-hover:text-white"
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

            <span class="min-w-0 flex-1 truncate">
                {{ group.title }}
            </span>

            <i class="bi bi-arrow-right text-xs text-gray-400 transition-transform group-hover:translate-x-1 group-hover:text-[#252525]"></i>

        </RouterLink>

    </div>
</template>


<script setup>
import { Icon } from '@/modules/site/constants/icons.js'

defineProps({
    groups: {
        type: Array,
        default: () => []
    }
})


const emit = defineEmits(['close'])
</script>