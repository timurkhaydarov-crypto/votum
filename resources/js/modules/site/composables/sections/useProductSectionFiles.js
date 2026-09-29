import { productsApi } from '../../services/productsApi.js';
const FEATURES_GALLERY_MAX = 4;
const FEATURES_GALLERY_MAX_SIZE = 100 * 1024;
export function useProductSectionFiles({ props, form, isManager, getFeaturesImageUrl }) {
    /* |-------------------------------------------------------------------------- | Local helpers |-------------------------------------------------------------------------- */ function revokePreview(
        item
    ) {
        if (item?.preview_url && item.preview_url.startsWith('blob:')) {
            URL.revokeObjectURL(item.preview_url);
        }
    }
    function revokeFeaturesGalleryPreviews() {
        for (const item of form.value.features_gallery) {
            revokePreview(item);
        }
    }
    function revokeGalleryPreviews() {
        for (const item of form.value.gallery) {
            revokePreview(item);
        }
    }
    /* |-------------------------------------------------------------------------- | Features gallery |-------------------------------------------------------------------------- */ function validateFeaturesGalleryFile(
        file
    ) {
        if (!file) {
            return false;
        }
        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            return false;
        }
        if (file.size > FEATURES_GALLERY_MAX_SIZE) {
            return false;
        }
        return true;
    }
    function addFeaturesGalleryFiles(files) {
        if (!isManager.value) {
            return;
        }
        const selectedFiles = Array.from(files ?? []);
        if (!selectedFiles.length) {
            return;
        }
        const currentCount = form.value.features_gallery.length;
        const availableSlots = FEATURES_GALLERY_MAX - currentCount;
        if (availableSlots <= 0) {
            return;
        }
        for (const file of selectedFiles.slice(0, availableSlots)) {
            if (!validateFeaturesGalleryFile(file)) {
                continue;
            }
            form.value.features_gallery.push({
                id: null,
                title: { ru: '', en: '' },
                image_url: '',
                image_name: getFeaturesImageUrl({ image_url: file.name }) || file.name,
                preview_url: URL.createObjectURL(file),
                is_new: true,
                file,
            });
        }
    }
    function removeFeaturesGalleryItem(index) {
        if (!isManager.value) {
            return;
        }
        const item = form.value.features_gallery[index];
        if (!item) {
            return;
        }
        revokePreview(item);
        form.value.features_gallery.splice(index, 1);
    }
    /* |-------------------------------------------------------------------------- | Product gallery |-------------------------------------------------------------------------- */ function addGalleryFiles(
        files
    ) {
        if (!isManager.value) {
            return;
        }
        const selectedFiles = Array.from(files ?? []);
        if (!selectedFiles.length) {
            return;
        }
        for (const file of selectedFiles) {
            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                continue;
            }
            form.value.gallery.push({
                id: null,
                title: { ru: '', en: '' },
                description: { ru: '', en: '' },
                image_url: '',
                preview_url: URL.createObjectURL(file),
                file,
                is_new: true,
            });
        }
    }
    async function removeGalleryItem(index) {
        if (!isManager.value) {
            return;
        }
        const galleryItem = form.value.gallery[index];
        if (!galleryItem) {
            return;
        }
        try {
            if (galleryItem.id) {
                await productsApi.deleteGallery(props.product.id, galleryItem.id);
            }
            revokePreview(galleryItem);
            form.value.gallery.splice(index, 1);
        } catch (error) {
            console.error('Failed to remove gallery image:', error);
            throw error;
        }
    }
    /* |-------------------------------------------------------------------------- | Cleanup |-------------------------------------------------------------------------- */ function revokeAllPreviews() {
        revokeFeaturesGalleryPreviews();
        revokeGalleryPreviews();
    }
    return {
        FEATURES_GALLERY_MAX,
        FEATURES_GALLERY_MAX_SIZE,
        addFeaturesGalleryFiles,
        removeFeaturesGalleryItem,
        addGalleryFiles,
        removeGalleryItem,
        revokeFeaturesGalleryPreviews,
        revokeGalleryPreviews,
        revokeAllPreviews,
    };
}
