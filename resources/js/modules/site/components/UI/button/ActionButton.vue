<template>
    <button :class="`rounded cursor-pointer first-letter:uppercase px-4 py-2 ${actionClasses[action]}`">{{ label }}</button>
</template>
<script setup>
const props = defineProps({
    label: {
        type: String,
        default: 'submit',
    },
    action: {
        type: String,
        default: 'neutral',
    },

});
const actionClasses = {
    neutral: 'text-black bg-gray-600 hover:bg-gray-500',
    add: 'text-white bg-green-600 hover:bg-green-500',
    delete: 'text-white bg-red-600 hover:bg-red-500',
    update: 'text-white bg-yellow-600 hover:bg-yellow-500',
};
</script>