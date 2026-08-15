<template>
    <div v-if="footer?.title" class="flex items-center justify-between
           bg-[#252525]
           px-7 py-4">

        <!-- Текст -->

        <div>
            <div class="text-sm font-semibold
               text-white">
                {{ footer.title }}
            </div>

            <div v-if="footer.description" class="mt-0.5 text-xs
               text-gray-400">
                {{ footer.description }}
            </div>
        </div>


        <!-- Кнопка -->

        <RouterLink :to="footer.link || '#'" class="inline-flex items-center
             gap-2 rounded-lg
             bg-white px-4 py-2
             text-sm font-semibold
             text-[#252525]
             transition
             hover:bg-gray-100">
            {{ footer.button || t('megaMenu.contactUs') }}

            <i class="bi bi-arrow-right"></i>
        </RouterLink>

    </div>
</template>
<script setup>
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

defineProps({
    footer: {
        type: Object,
        default: () => ({})
    }
})
</script>