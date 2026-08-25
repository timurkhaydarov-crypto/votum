<template>

    <div>

        <!-- PRODUCTS -->

        <div
            v-if="visibleProducts.length"
            class="grid grid-cols-1 gap-0.5 sm:grid-cols-2"
        >

            <RouterLink
                v-for="product in visibleProducts"
                :key="product.id"
                :to="product.href"
                class="product-link"
                @mouseenter="$emit('product-hover', product.id)"
                @mouseleave="$emit('product-hover', null)"
                @click="handleNavigation"
            >

                <span class="product-dot"></span>

                <span class="truncate">
                    {{ product.title }}
                </span>

            </RouterLink>

        </div>


        <!-- EMPTY -->

        <div
            v-else
            class="px-2 py-3 text-sm text-gray-400"
        >
            {{ t('megaMenu.noProducts') }}
        </div>


        <!-- ALL -->

        <div
            v-if="group.href"
            class="mt-2 px-2 pt-2"
        >

            <RouterLink
                :to="group.href"
                class="all-products-link"
                @click="handleNavigation"
            >

                <span>
                    {{ allLabel || t('megaMenu.showAllProducts') }}
                </span>

                <i class="bi bi-arrow-right"></i>

            </RouterLink>

        </div>

    </div>

</template>


<script setup>

import {
    computed
} from 'vue'

import {
    useI18n
} from 'vue-i18n'

import {
    resolveProductById
} from '../navigation.data.js'


const { t } = useI18n()


const emit = defineEmits([
    'product-hover',
    'navigate'
])


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
        default: ''
    }

})


const groupProducts = computed(() => {

    if (
        Array.isArray(props.group.products) &&
        props.group.products.length
    ) {
        return props.group.products
    }

    if (!Array.isArray(props.group.productIds)) {
        return []
    }

    return props.group.productIds
        .map(id => resolveProductById(id))
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


/**
 * Закрытие mega-menu после перехода
 */
const handleNavigation = () => {
    emit('product-hover', null)
    emit('navigate')
}

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