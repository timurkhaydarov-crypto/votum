const pickLocalized = (value) => {
    if (typeof value === 'string') {
        return value;
    }

    if (!value || typeof value !== 'object') {
        return '';
    }

    return value.ru || value.en || Object.values(value)[0] || '';
};

const normalizeRelationTitle = (relation, key) => {
    if (!relation) {
        return '';
    }

    if (relation.title) {
        return pickLocalized(relation.title);
    }

    return pickLocalized(relation[key]);
};

export const normalizeProduct = (product) => ({
    id: product.id,
    article: product.article || '',
    name: pickLocalized(product.name),
    shortDescription: pickLocalized(product.short_description),
    fullDescription: pickLocalized(product.full_description),
    categorySlug: product.category?.slug || null,
    categoryTitle: normalizeRelationTitle(product.category, 'category'),
    groupSlug: product.group?.slug || null,
    groupTitle: normalizeRelationTitle(product.group, 'group'),
    price: product.price,
    quantity: product.quantity,
    imageUrl: product.image_url || '',
    videoUrl: product.video_url || '',
});

export const normalizeProducts = (products) => {
    if (!Array.isArray(products)) {
        return [];
    }

    return products.map(normalizeProduct);
};
