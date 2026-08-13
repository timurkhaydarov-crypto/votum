<template>
  <Transition
    enter-active-class="transition-opacity duration-120 ease-linear"
    enter-from-class="opacity-0"
    enter-to-class="opacity-100"
    leave-active-class="transition-opacity duration-120 ease-linear"
    leave-from-class="opacity-100"
    leave-to-class="opacity-0"
    mode="out-in"
  >
    <div
      :key="product?.id ?? 'empty'"
      class="h-full bg-transparent p-0"
    >
      <div v-if="product" class="h-full">
        <div class="overflow-hidden rounded-none pt-[5px]">
          <img
            :src="image"
            :alt="product.title"
            class="h-24 w-full object-contain"
            @error="onImageError"
          />
        </div>

        <div class="px-2.5 pb-2.5 pt-2.5">
          <h3 class="text-sm font-bold leading-4 text-[#252525]">
            {{ product.title }}
          </h3>

          <p class="mt-1.5 text-xs leading-4 text-gray-600">
            {{ description }}
          </p>
        </div>
      </div>

      <div
        v-else
        class="flex h-full items-center justify-center bg-transparent p-5 text-center text-sm text-gray-400"
      >
        {{ t('megaMenu.chooseDevice') }}
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const props = defineProps({
  product: {
    type: Object,
    default: null
  },

  image: {
    type: String,
    default: '/image/logo.svg'
  },

  description: {
    type: String,
    default: ''
  }
})

const onImageError = (event) => {
  event.target.src = '/image/logo.svg'
}
</script>
