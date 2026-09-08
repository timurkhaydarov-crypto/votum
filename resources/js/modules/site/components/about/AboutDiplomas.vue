<template>
    <section class="mx-auto w-full max-w-5xl">
        <ProductImageGallery
            :images="diplomas"
            gallery-title="diplomas.eyebrow"
            gallery-sub-title="diplomas.title"
            type="document"
        />
    </section>
</template>

<script setup>
import ProductImageGallery from '../products/detail/ProductImageGallery.vue';

import diplomas from '../../constants/diplomas.js';
</script>