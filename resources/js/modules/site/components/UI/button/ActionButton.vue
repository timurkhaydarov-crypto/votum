<template>
<button :type="label" class="rounded cursor-pointer first-letter:uppercase bg-green-600 px-4 py-2 text-white hover:bg-green-500">{{ $t(label) }}</button>
</template>
<script setup>
const props = defineProps({
    label: {
        type: String,
        default: 'submit',
    },
});

</script>