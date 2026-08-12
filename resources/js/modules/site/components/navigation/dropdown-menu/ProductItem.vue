<template>

    <a
        :href="product.href"
        @click="$emit('close')"
        class="block
               rounded-lg
               px-3 py-2
               pl-[4.5rem]
               text-sm
               leading-5
               text-gray-500
               transition
               hover:bg-gray-50
               hover:text-[#252525]"
    >
        {{ product.title }}
    </a>

</template>


<script setup>
defineProps({
    product: {
        type: Object,
        required: true
    }
})


defineEmits([
    'close'
])
</script>