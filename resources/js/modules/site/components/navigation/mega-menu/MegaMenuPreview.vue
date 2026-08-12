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
      v-if="product"
      :key="product.id"
      class="h-full bg-transparent p-0"
    >
      <div class="overflow-hidden rounded-none bg-[#f5f5f5]">
        <img
          :src="image"
          :alt="product.title"
          class="h-32 w-full object-cover"
          @error="onImageError"
        />
      </div>

      <div class="px-3 pb-3 pt-3">
        <h3 class="text-base font-bold leading-5 text-[#252525]">
          {{ product.title }}
        </h3>

        <p class="mt-2 text-sm leading-5 text-gray-600">
          {{ description }}
        </p>
      </div>
    </div>

    <div
      v-else
      key="empty"
      class="flex h-full items-center justify-center bg-transparent p-5 text-center text-sm text-gray-400"
    >
      Выберите прибор
    </div>
  </Transition>
</template>

<script setup>
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
    default: 'Выберите прибор из списка, чтобы увидеть краткое описание.'
  }
})

const onImageError = (event) => {
  event.target.src = '/image/logo.svg'
}
</script>
