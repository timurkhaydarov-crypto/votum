<template>
    <section>
        <SectionHeader
            eyebrow="06 / DOCUMENTATION"
            :title="$t('siteUi.product.documentsTitle')"
            :description="$t('siteUi.product.documentsDescription')"
        />

        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            <ProductDocumentCard
                :title="$t('product.documents.characteristics')"
                :description="$t('siteUi.product.specificationsDescription')"
                icon="bi-file-earmark-text"
                :href="documents.characteristics"
            />

            <ProductDocumentCard
                :title="$t('product.documents.certificates')"
                :description="$t('siteUi.product.certificatesDescription')"
                icon="bi-patch-check"
                :href="documents.certificates"
            />

            <ProductDocumentCard
                :title="$t('product.documents.documentation')"
                :description="$t('siteUi.product.documentationDescription')"
                icon="bi-book"
                :href="documents.documentation"
            />

            <ProductDocumentCard
                :title="$t('siteUi.product.softwareTitle')"
                :description="$t('siteUi.product.softwareDescription')"
                icon="bi-cloud-arrow-down"
                :href="documents.software"
            />
        </div>
    </section>
</template>

<script setup>
import SectionHeader from '../SectionHeader.vue';
import ProductDocumentCard from './ProductDocumentCard.vue';

defineProps({
    documents: {
        type: Object,
        default: () => ({}),
    },
});
</script>