<template>

    <div class="flex items-center justify-between
           border-b border-gray-100
           px-7 py-5">

        <div class="flex items-center gap-3">
            <div class="flex h-11 w-11
               items-center justify-center
               rounded-xl bg-gray-100">

                <i :class="[
                    'bi',
                    icon,
                    'text-xl',
                    'text-[#252525]'
                ]"></i>

            </div>


            <div>

                <h3 class="text-base font-bold
                 text-[#252525]">
                    {{ title }}
                </h3>

                <p class="mt-0.5 text-xs
                 text-gray-500">
                    {{ t('megaMenu.chooseCategory') }}
                </p>

            </div>

        </div>


        <RouterLink :to="allLink" class="flex items-center gap-2
             rounded-lg px-3 py-2
             text-sm font-medium
             text-[#252525]
             hover:bg-gray-100"
            @click="$emit('navigate')"
        >

            {{ allLabel || t('megaMenu.allProducts') }}

            <i class="bi bi-arrow-right"></i>

        </RouterLink>

    </div>

</template>
<script setup>
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

defineEmits(['navigate'])

defineProps({
    title: String,
    icon: String,
    allLink: String,
    allLabel: String
})
</script>