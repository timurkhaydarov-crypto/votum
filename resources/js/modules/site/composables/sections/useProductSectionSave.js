import { productsApi } from '../../services/productsApi.js';

export function useProductSectionSave({
    props,
    emit,
    isSaving,
    formError,
    errors,
    form,
    originalFeaturesGalleryIds,
    originalSpecificationIds,
    isManager,
    close,
}) {
    function resetValidationErrors() {
        errors.value = {
            full_description_ru: '',
            full_description_en: '',
            features_ru: '',
            features_en: '',
            specifications: {},
            certificates: {},
            gallery: {},
        };

        formError.value = '';
    }

    function normalizeLocalizedValue(value) {
        if (!value) {
            return {
                ru: '',
                en: '',
            };
        }

        if (typeof value === 'string') {
            return {
                ru: value,
                en: value,
            };
        }

        return {
            ru: value.ru ?? '',
            en: value.en ?? '',
        };
    }

    function validateDetails() {
        let valid = true;

        if (
            !String(
                form.value.details?.ru ?? '',
            ).trim()
        ) {
            errors.value.full_description_ru =
                'required';

            valid = false;
        }

        if (
            !String(
                form.value.details?.en ?? '',
            ).trim()
        ) {
            errors.value.full_description_en =
                'required';

            valid = false;
        }

        return valid;
    }

    function validateFeatures() {
        let valid = true;

        errors.value.features_ru = '';
        errors.value.features_en = '';

        if (
            !String(
                form.value.features?.ru ?? '',
            ).trim()
        ) {
            errors.value.features_ru =
                'required';

            valid = false;
        }

        if (
            !String(
                form.value.features?.en ?? '',
            ).trim()
        ) {
            errors.value.features_en =
                'required';

            valid = false;
        }

        return valid;
    }

    function validateSpecifications() {
        const specificationErrors = {};
        let valid = true;

        form.value.specifications.forEach(
            (specification, index) => {
                const name =
                    normalizeLocalizedValue(
                        specification.name,
                    );

                const value =
                    normalizeLocalizedValue(
                        specification.value,
                    );

                const fieldErrors = {};

                if (!name.ru.trim()) {
                    fieldErrors.name_ru = true;
                }

                if (!name.en.trim()) {
                    fieldErrors.name_en = true;
                }

                if (!value.ru.trim()) {
                    fieldErrors.value_ru = true;
                }

                if (!value.en.trim()) {
                    fieldErrors.value_en = true;
                }

                if (
                    Object.keys(fieldErrors).length
                ) {
                    specificationErrors[index] =
                        fieldErrors;

                    valid = false;
                }
            },
        );

        errors.value.specifications =
            specificationErrors;

        return valid;
    }

    function validateCertificates() {
        const certificateErrors = {};
        let valid = true;

        form.value.certificates.forEach(
            (certificate, index) => {
                const name =
                    normalizeLocalizedValue(
                        certificate.name,
                    );

                const itemErrors = {};

                if (!name.ru.trim()) {
                    itemErrors.name_ru = true;
                }

                if (!name.en.trim()) {
                    itemErrors.name_en = true;
                }

                if (
                    certificate.is_new &&
                    !certificate.file
                ) {
                    itemErrors.file = true;
                }

                if (
                    Object.keys(itemErrors).length
                ) {
                    certificateErrors[index] =
                        itemErrors;

                    valid = false;
                }
            },
        );

        errors.value.certificates =
            certificateErrors;

        return valid;
    }

    function validateGallery() {
        const galleryErrors = {};
        let valid = true;

        form.value.gallery.forEach(
            (item, index) => {
                const title =
                    normalizeLocalizedValue(
                        item.title,
                    );

                const itemErrors = {};

                if (!title.ru.trim()) {
                    itemErrors.title_ru = true;
                }

                if (!title.en.trim()) {
                    itemErrors.title_en = true;
                }

                if (
                    item.is_new &&
                    !item.file
                ) {
                    itemErrors.file = true;
                }

                if (
                    Object.keys(itemErrors).length
                ) {
                    galleryErrors[index] =
                        itemErrors;

                    valid = false;
                }
            },
        );

        errors.value.gallery =
            galleryErrors;

        return valid;
    }

    async function saveDetails() {
        if (!isManager.value) {
            return false;
        }

        if (!validateDetails()) {
            return false;
        }

        await productsApi.updateDetails(
            props.product.id,
            {
                full_description: {
                    ru: form.value.details.ru,
                    en: form.value.details.en,
                },
            },
        );

        return true;
    }

    async function saveFeatures() {
        if (!isManager.value) {
            return false;
        }

        if (!validateFeatures()) {
            return false;
        }

        const productId =
            props.product.id;

        await productsApi.updateFeatures(
            productId,
            {
                features: {
                    ru: form.value.features.ru,
                    en: form.value.features.en,
                },
            },
        );

        const currentIds =
            form.value.features_gallery
                .filter(item => item.id)
                .map(item => item.id);

        const removedIds =
            originalFeaturesGalleryIds.value.filter(
                id => !currentIds.includes(id),
            );

        for (const galleryId of removedIds) {
            await productsApi.deleteFeaturesGallery(
                productId,
                galleryId,
            );
        }

        for (const item of form.value.features_gallery) {
            if (
                item.is_new &&
                item.file
            ) {
                await productsApi.createFeaturesGallery(
                    productId,
                    item.file,
                    item.title,
                );

                continue;
            }

            if (item.id) {
                await productsApi.updateFeaturesGallery(
                    productId,
                    item.id,
                    {
                        title:
                            normalizeLocalizedValue(
                                item.title,
                            ),
                    },
                );
            }
        }

        return true;
    }

    async function saveSpecifications() {
        if (!isManager.value) {
            return false;
        }

        if (!validateSpecifications()) {
            return false;
        }

        const productId =
            props.product.id;

        const currentIds =
            form.value.specifications
                .filter(item => item.id)
                .map(item => item.id);

        const removedIds =
            originalSpecificationIds.value.filter(
                id => !currentIds.includes(id),
            );

        for (const specificationId of removedIds) {
            await productsApi.deleteSpecification(
                productId,
                specificationId,
            );
        }

        for (const specification of form.value.specifications) {
            const payload = {
                name:
                    normalizeLocalizedValue(
                        specification.name,
                    ),

                value:
                    normalizeLocalizedValue(
                        specification.value,
                    ),
            };

            if (specification.id) {
                await productsApi.updateSpecification(
                    productId,
                    specification.id,
                    payload,
                );
            } else {
                await productsApi.createSpecification(
                    productId,
                    payload,
                );
            }
        }

        return true;
    }

    async function saveCertificates() {
        if (!isManager.value) {
            return false;
        }

        if (!validateCertificates()) {
            return false;
        }

        const productId =
            props.product.id;

        for (const certificate of form.value.certificates) {
            if (
                certificate.is_new &&
                certificate.file
            ) {
                await productsApi.createCertificate(
                    productId,
                    certificate.file,
                    {
                        name:
                            normalizeLocalizedValue(
                                certificate.name,
                            ),
                    },
                );

                continue;
            }

            if (certificate.id) {
                await productsApi.updateCertificate(
                    productId,
                    certificate.id,
                    {
                        name:
                            normalizeLocalizedValue(
                                certificate.name,
                            ),
                    },
                );
            }
        }

        return true;
    }

    async function saveGallery() {
        if (!isManager.value) {
            return false;
        }

        if (!validateGallery()) {
            return false;
        }

        const productId =
            props.product.id;

        for (const item of form.value.gallery) {
            if (
                item.is_new &&
                item.file
            ) {
                await productsApi.createGallery(
                    productId,
                    item.file,
                    item.title,
                    item.description,
                );

                continue;
            }

            if (item.id) {
                await productsApi.updateGallery(
                    productId,
                    item.id,
                    {
                        title:
                            normalizeLocalizedValue(
                                item.title,
                            ),

                        description:
                            normalizeLocalizedValue(
                                item.description,
                            ),
                    },
                );
            }
        }

        return true;
    }

    async function saveCompatible() {
        if (!isManager.value) {
            return false;
        }

        await productsApi.updateCompatible(
            props.product.id,
            {
                compatible_product_ids:
                    (
                        form.value
                            .compatible_product_ids ??
                        []
                    ).map(Number),
            },
        );

        return true;
    }

    async function saveSection() {
        if (
            isSaving.value ||
            !isManager.value
        ) {
            return false;
        }

        resetValidationErrors();

        isSaving.value = true;

        try {
            let saved = false;

            switch (props.section) {
                case 'details':
                    saved =
                        await saveDetails();
                    break;

                case 'features':
                    saved =
                        await saveFeatures();
                    break;

                case 'specifications':
                    saved =
                        await saveSpecifications();
                    break;

                case 'certificates':
                    saved =
                        await saveCertificates();
                    break;

                case 'gallery':
                    saved =
                        await saveGallery();
                    break;

                case 'compatible':
                    saved =
                        await saveCompatible();
                    break;

                default:
                    saved = false;
            }

            if (!saved) {
                return false;
            }

            emit('updated', {
                productId:
                    props.product.id,

                section:
                    props.section,
            });

            close(true);

            return true;
        } catch (error) {
            console.error(
                'Failed to save product section:',
                error,
            );

            formError.value =
                error?.message ??
                'Не удалось сохранить изменения.';

            return false;
        } finally {
            isSaving.value = false;
        }
    }

    return {
        validateDetails,
        validateFeatures,
        validateSpecifications,
        validateCertificates,
        validateGallery,

        saveDetails,
        saveFeatures,
        saveSpecifications,
        saveCertificates,
        saveGallery,
        saveCompatible,

        saveSection,
    };
}