<template>

    <RouterLink
        :to="product.href"
        @click="$emit('close')"
        class="block
               rounded-md
               px-3 py-1.5
               pl-[4.5rem]
               text-[12.5px]
               leading-4
               text-gray-500
               transition
               hover:bg-[#f7f5f2]
               hover:text-[#252525]"
    >
        {{ product.title }}
    </RouterLink>

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