<template>

    <div>

        <!-- PRODUCTS -->

        <div
            v-if="visibleProducts.length"
            class="grid grid-cols-1
                   gap-0.5
                   sm:grid-cols-2"
        >

            <a
                v-for="product in visibleProducts"
                :key="product.id"
                :href="product.href"
                class="product-link"
                @mouseenter="$emit('product-hover', product.id)"
                @mouseleave="$emit('product-hover', null)"
            >

                <span class="product-dot"></span>

                <span class="truncate">
                    {{ product.title }}
                </span>

            </a>

        </div>


        <!-- EMPTY -->

        <div
            v-else
            class="px-2 py-3
                   text-sm text-gray-400"
        >
            Продукция отсутствует
        </div>


        <!-- ALL -->

        <div
            v-if="group.href"
            class="mt-2 px-2 pt-2"
        >

            <a
                :href="group.href"
                class="all-products-link"
            >

                <span>
                    {{ allLabel }}
                </span>

                <i class="bi bi-arrow-right"></i>

            </a>

        </div>

    </div>

</template>


<script setup>

import {
    computed
} from 'vue'

import {
    products
} from '../navigation.data.js'


const emit = defineEmits(['product-hover'])

const props = defineProps({

    group: {
        type: Object,
        required: true
    },

    limit: {
        type: Number,
        default: 5
    },

    allLabel: {
        type: String,
        default: 'Показать всю продукцию'
    }

})


const groupProducts = computed(() => {

    if (!Array.isArray(props.group.productIds)) {
        return []
    }

    return props.group.productIds
        .map(id => {
            return products.find(
                product => product.id === id
            )
        })
        .filter(Boolean)

})


const visibleProducts = computed(() => {

    if (!Number.isFinite(props.limit)) {
        return groupProducts.value
    }

    return groupProducts.value.slice(
        0,
        props.limit
    )

})

</script>


<style scoped>

.product-link {
    display: flex;

    align-items: center;

    min-width: 0;

    gap: 8px;

    border-radius: 9px;

    padding: 7px 9px;

    font-size: 13px;

    line-height: 18px;

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


.product-dot {
    width: 5px;
    height: 5px;

    flex-shrink: 0;

    border-radius: 999px;

    background: #d1d1d1;

    transition:
        background-color 180ms ease,
        transform 180ms ease;
}


.product-link:hover .product-dot {
    background: #252525;

    transform: scale(1.25);
}


/* ================================================ */
/* ALL PRODUCTS */
/* ================================================ */

.all-products-link {
    display: inline-flex;

    align-items: center;

    gap: 7px;

    font-size: 12px;

    font-weight: 600;

    color: #555555;

    transition:
        gap 200ms ease,
        color 200ms ease;
}


.all-products-link:hover {
    gap: 10px;

    color: #252525;
}

</style>

