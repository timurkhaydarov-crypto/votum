<template>
    <RouterLink
        to="/cart"
        class="relative inline-flex items-center justify-center"
        aria-label="Cart"
    >
        <i class="bi bi-cart3 text-xl"></i>

        <span
            v-if="count > 0"
            class="absolute -right-2 -top-2 flex h-[18px] min-w-[18px] items-center justify-center rounded-full bg-slate-900 px-1 text-[10px] font-bold leading-none text-white"
        >
            {{ displayCount }}
        </span>
    </RouterLink>
</template>

<script setup>
import {
    computed,
} from 'vue';

import {
    RouterLink,
} from 'vue-router';

import {
    useCart,
} from '../../composables/useCart';

const {
    count,
} = useCart();

const displayCount = computed(() => {
    return count.value > 99
        ? '99+'
        : count.value;
});
</script>