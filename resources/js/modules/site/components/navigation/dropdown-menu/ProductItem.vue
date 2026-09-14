<template>

    <RouterLink
        :to="product.href"
        @click="$emit('close')"
        class="product-link"
    >

        <MenuDot />

        <span class="truncate">
            {{ product.title }}
        </span>

    </RouterLink>

</template>


<script setup>

import MenuDot from '@/modules/site/components/shared/MenuDot.vue'


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


<style scoped>

.product-link {
    display: flex;

    align-items: center;

    min-width: 0;

    gap: 8px;

    border-radius: 9px;

    padding: 7px 9px;

    padding-left: 4.5rem;

    font-size: 12.5px;

    line-height: 16px;

    color: #666666;

    transition:
        background-color 180ms ease,
        color 180ms ease,
        transform 180ms ease;
}


.product-link:hover {
    background: #f7f7f7;

    color: #252525;

    transform: translateX(2px);
}


.product-link:hover :deep(.menu-dot) {
    background: #252525;

    transform: scale(1.25);
}

</style>
