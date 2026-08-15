import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

export const useProductBreadcrumbs = ({
    categorySlug,
    categoryTitle,
    groupSlug,
    groupTitle,
    productTitle,
    productId,
}) => {
    const { t } = useI18n();

    const breadcrumbs = computed(() => {
        const crumbs = [
            {
                label: t('productBreadcrumbs.catalog'),
                to: '/products',
            },
        ];

        if (categorySlug?.value) {
            crumbs.push({
                label: categoryTitle?.value || categorySlug.value,
                to: `/products/${categorySlug.value}`,
            });
        }

        if (categorySlug?.value && groupSlug?.value) {
            crumbs.push({
                label: groupTitle?.value || groupSlug.value,
                to: `/products/${categorySlug.value}/${groupSlug.value}`,
            });
        }

        if (productTitle || productId) {
            crumbs.push({
                label: productTitle?.value || t('productBreadcrumbs.productFallback', {
                    id: productId?.value || '',
                }),
                to: null,
            });
        }

        return crumbs;
    });

    const backLink = computed(() => {
        if (!categorySlug?.value) {
            return '/products';
        }

        if (groupSlug?.value) {
            return `/products/${categorySlug.value}/${groupSlug.value}`;
        }

        return `/products/${categorySlug.value}`;
    });

    const backLabel = computed(() => {
        if (!categorySlug?.value) {
            return t('productBreadcrumbs.backToCatalog');
        }

        if (groupTitle?.value) {
            return t('productBreadcrumbs.backToGroup', {
                group: groupTitle.value,
            });
        }

        if (categoryTitle?.value) {
            return t('productBreadcrumbs.backToCategory', {
                category: categoryTitle.value,
            });
        }

        return t('productBreadcrumbs.backToCatalog');
    });

    return {
        breadcrumbs,
        backLink,
        backLabel,
    };
};