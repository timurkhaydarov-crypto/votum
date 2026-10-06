const pickLocalized = (value, locale = 'ru') => {
    if (typeof value === 'string') {
        return value;
    }

    if (!value || typeof value !== 'object') {
        return '';
    }

    return value[locale] || value.ru || value.en || Object.values(value)[0] || '';
};

const normalizeRelationTitle = (relation, key, locale = 'ru') => {
    if (!relation) {
        return '';
    }

    if (relation.title) {
        return pickLocalized(relation.title, locale);
    }

    return pickLocalized(relation[key], locale);
};

const normalizeSpecValue = (value, locale = 'ru') => {
    if (typeof value === 'string') {
        return value;
    }

    if (!value || typeof value !== 'object') {
        return '';
    }

    return pickLocalized(value, locale);
};

export const normalizeProduct = (product, locale = 'ru') => ({
    id: product.id,
    article: product.article || '',
    name: pickLocalized(product.name, locale),
    shortDescription: pickLocalized(product.short_description, locale),
    fullDescription: pickLocalized(product.full_description, locale),
    hasFeatures: product.has_features,
    hasSpecifications: product.has_specifications,
    compatible_products: product.compatible_products,
    certificates: product.certificates,
    gallery: product.gallery,
    categorySlug: product.category?.slug || null,
    categoryTitle: normalizeRelationTitle(product.category, 'category', locale),
    groupSlug: product.group?.slug || null,
    groupTitle: normalizeRelationTitle(product.group, 'group', locale),
    price: product.price,
    quantity: product.quantity,
    status: product.status == null ? null : Boolean(product.status),
    imageUrl: product.image_url || '',
    videoUrl: product.video_url || '',
    pdfUrl: product.pdf_url || '',
    method: normalizeSpecValue(product.method, locale),
    frequency: normalizeSpecValue(product.frequency, locale),
    display: normalizeSpecValue(product.display, locale),
    application: normalizeSpecValue(product.application, locale),
});

export const normalizeProducts = (products, locale = 'ru') => {
    if (!Array.isArray(products)) {
        return [];
    }

    return products.map((product) => normalizeProduct(product, locale));
};
