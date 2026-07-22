

<template>
    <button type="button" class="rounded cursor-pointer first-letter:uppercase bg-gray-600 px-4 py-2 text-white hover:bg-gray-500" @click="$emit('close')">{{ $t('actions.cancel') }}</button>
</template>
<script setup>

defineEmits(['close']);

</script>
