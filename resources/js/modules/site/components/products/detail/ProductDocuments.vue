<template>
    <section>
        <SectionHeader
            eyebrow="06 / DOCUMENTATION"
            title="Документация и материалы"
            description="Техническая документация, сертификаты, программное обеспечение и дополнительные материалы."
        />

        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            <ProductDocumentCard
                title="Технические характеристики"
                description="Подробные технические параметры прибора"
                icon="bi-file-earmark-text"
                :href="documents.characteristics"
            />

            <ProductDocumentCard
                title="Сертификаты"
                description="Сертификационные документы и подтверждения"
                icon="bi-patch-check"
                :href="documents.certificates"
            />

            <ProductDocumentCard
                title="Документация"
                description="Руководства и эксплуатационные документы"
                icon="bi-book"
                :href="documents.documentation"
            />

            <ProductDocumentCard
                title="Обновление ПО"
                description="Программное обеспечение и обновления"
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