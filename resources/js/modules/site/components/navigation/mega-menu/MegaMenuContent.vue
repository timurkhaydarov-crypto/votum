<template>

    <div v-if="category" class="min-h-[330px] p-7">

        <!-- ====================================== -->
        <!-- TITLE -->
        <!-- ====================================== -->

        <div class="mb-6">

            <h2 class="text-xl font-bold
                       tracking-tight
                       text-[#252525]">
                {{ category.title }}
            </h2>

            <p v-if="category.description" class="mt-1.5 max-w-xl
                       text-sm leading-5
                       text-gray-500">
                {{ category.description }}
            </p>

        </div>


        <!-- ====================================== -->
        <!-- GROUPS -->
        <!-- ====================================== -->

        <div class="space-y-2">

            <div v-for="group in category.groups" :key="`${category.id}-${group.id}`" class="group-wrapper" :class="{
                'group-wrapper--active':
                    isGroupOpen(group.id)
            }">

                <!-- ================================== -->
                <!-- GROUP HEADER -->
                <!-- ================================== -->

                <button type="button" class="group-header" :class="{
                    'group-header--active':
                        isGroupOpen(group.id)
                }" @mouseenter="hoveredGroupId = group.id" @mouseleave="hoveredGroupId = null"
                    @click="toggleGroup(group.id)">

                    <!-- ICON -->

                    <span class="group-icon" :class="{
                        'group-icon--highlighted':
                            isGroupHighlighted(group.id)
                    }">
                        <i :class="[
                            'bi',
                            group.icon || 'bi-box'
                        ]"></i>
                    </span>


                    <!-- TITLE -->

                    <span class="group-title">
                        {{ group.title }}
                    </span>


                    <!-- CHEVRON -->

                    <span class="group-chevron" :class="{
                        'group-chevron--active':
                            isGroupOpen(group.id)
                    }">
                        <i class="bi bi-chevron-down"></i>
                    </span>

                </button>


                <!-- ================================== -->
                <!-- PRODUCTS -->
                <!-- ================================== -->

                <div class="accordion-grid" :class="{
                    'accordion-grid--open':
                        isGroupOpen(group.id)
                }">

                    <div class="accordion-inner">

                        <div class="products-panel">

                            <MegaMenuGroup
                                :group="group"
                                :limit="Infinity"
                                :all-link="group.href"
                                all-label="Показать всю продукцию"
                                @product-hover="emit('product-hover', $event)"
                            />

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- ====================================== -->
        <!-- CATEGORY LINK -->
        <!-- ====================================== -->

        <div class="category-link-wrapper">

            <a :href="category.href" class="category-link">

                <span>
                    Вся категория
                </span>

                <span class="category-link-icon">
                    <i class="bi bi-arrow-right"></i>
                </span>

            </a>

        </div>

    </div>

</template>


<script setup>

import {
    ref,
    watch
} from 'vue'

import MegaMenuGroup from './MegaMenuGroup.vue'

const emit = defineEmits(['product-hover'])

const props = defineProps({

    category: {
        type: Object,
        default: null
    }

})


/*
|--------------------------------------------------------------------------
| Active group
|--------------------------------------------------------------------------
*/

const openGroupId = ref(null)


/*
|--------------------------------------------------------------------------
| Hover group
|--------------------------------------------------------------------------
*/

const hoveredGroupId = ref(null)


/*
|--------------------------------------------------------------------------
| Toggle
|--------------------------------------------------------------------------
*/

const toggleGroup = (groupId) => {

    openGroupId.value =
        openGroupId.value === groupId
            ? null
            : groupId

}


/*
|--------------------------------------------------------------------------
| Open state
|--------------------------------------------------------------------------
*/

const isGroupOpen = (groupId) => {

    return openGroupId.value === groupId

}


/*
|--------------------------------------------------------------------------
| Highlight state
|--------------------------------------------------------------------------
*/

const isGroupHighlighted = (groupId) => {

    return (
        hoveredGroupId.value === groupId ||
        openGroupId.value === groupId
    )

}


/*
|--------------------------------------------------------------------------
| Category changed
|--------------------------------------------------------------------------
*/

watch(
    () => props.category,
    (category) => {

        hoveredGroupId.value = null

        openGroupId.value = null

    }
)

</script>


<style scoped>
/* ================================================= */
/* GROUP */
/* ================================================= */

.group-wrapper {
    position: relative;

    border-radius: 16px;

    transition:
        background-color 300ms ease,
        box-shadow 300ms ease;
}


/* ================================================= */
/* HEADER */
/* ================================================= */

.group-header {
    position: relative;

    display: flex;
    width: 100%;

    align-items: center;
    gap: 12px;

    padding: 11px 12px;

    border-radius: 14px;

    text-align: left;

    color: #252525;

    transition:
        background-color 220ms ease,
        box-shadow 220ms ease,
        transform 220ms ease;
}


.group-header:hover {
    background: #f7f7f7;
}


.group-header:active {
    transform: scale(0.995);
}


.group-header--active {
    background: #f7f7f7;
}


/* ================================================= */
/* ICON */
/* ================================================= */

.group-icon {
    display: flex;

    width: 38px;
    height: 38px;

    flex-shrink: 0;

    align-items: center;
    justify-content: center;

    border-radius: 11px;

    background: #f1f1f1;

    color: #9ca3af;

    font-size: 17px;

    transition:
        background-color 260ms ease,
        color 260ms ease,
        transform 260ms cubic-bezier(0.16, 1, 0.3, 1),
        box-shadow 260ms ease;
}


.group-header:hover .group-icon {
    transform: translateY(-1px);
}


.group-icon--highlighted {
    background: #252525;

    color: #ffffff;

    box-shadow:
        0 4px 12px rgba(0, 0, 0, 0.12);

    transform: translateY(-1px);
}


/* ================================================= */
/* TITLE */
/* ================================================= */

.group-title {
    flex: 1;

    font-size: 14px;

    font-weight: 600;

    line-height: 20px;

    color: #252525;

    transition:
        color 220ms ease;
}


.group-header:not(.group-header--active):hover .group-title {
    color: #111111;
}


/* ================================================= */
/* CHEVRON */
/* ================================================= */

.group-chevron {
    display: flex;

    width: 30px;
    height: 30px;

    align-items: center;
    justify-content: center;

    border-radius: 9px;

    color: #b0b0b0;

    font-size: 11px;

    transition:
        background-color 260ms ease,
        color 260ms ease,
        transform 400ms cubic-bezier(0.16, 1, 0.3, 1);
}


.group-header:hover .group-chevron {
    background: #eeeeee;

    color: #555555;
}


.group-chevron--active {
    background: #e9e9e9;

    color: #252525;

    transform: rotate(180deg);
}


/* ================================================= */
/* ACCORDION */
/* ================================================= */

.accordion-grid {
    display: grid;

    grid-template-rows: 0fr;

    opacity: 0;

    transition:
        grid-template-rows 450ms cubic-bezier(0.16, 1, 0.3, 1),
        opacity 300ms ease;
}


.accordion-grid--open {
    grid-template-rows: 1fr;

    opacity: 1;
}


.accordion-inner {
    min-height: 0;

    overflow: hidden;
}


/* ================================================= */
/* PRODUCTS PANEL */
/* ================================================= */

.products-panel {
    margin: 2px 12px 8px 0;

    padding: 12px 0 4px;

    transform: translateX(-2px) translateY(-6px);

    opacity: 0;

    transition:
        transform 400ms cubic-bezier(0.16, 1, 0.3, 1),
        opacity 280ms ease;
}


.accordion-grid--open .products-panel {
    transform: translateX(-2px) translateY(0);

    opacity: 1;
}


/* ================================================= */
/* CATEGORY LINK */
/* ================================================= */

.category-link-wrapper {
    margin-top: 24px;

    padding-top: 16px;

    border-top: 1px solid #eeeeee;
}


.category-link {
    display: inline-flex;

    align-items: center;

    gap: 9px;

    font-size: 13px;

    font-weight: 600;

    color: #252525;

    transition:
        gap 220ms ease,
        color 220ms ease;
}


.category-link:hover {
    gap: 12px;

    color: #000000;
}


.category-link-icon {
    display: flex;

    width: 25px;
    height: 25px;

    align-items: center;
    justify-content: center;

    border-radius: 7px;

    background: #f1f1f1;

    font-size: 11px;

    transition:
        background-color 220ms ease,
        transform 220ms ease;
}


.category-link:hover .category-link-icon {
    background: #252525;

    color: #ffffff;

    transform: translateX(1px);
}
</style>
