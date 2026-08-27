import { ref, computed } from 'vue';

export function useShowMore(options = {}) {
    const initialCount = options.initialCount ?? 4;
    const step = options.step ?? 4;

    const visibleCount = ref(initialCount);

    /*
    |--------------------------------------------------------------------------
    | Normalize items
    |--------------------------------------------------------------------------
    */

    const normalizeItems = (items = []) => {
        if (!Array.isArray(items)) {
            return [];
        }

        return items.filter(Boolean);
    };

    /*
    |--------------------------------------------------------------------------
    | Visible items
    |--------------------------------------------------------------------------
    */

    const visibleItems = (items = []) => {
        const normalizedItems = normalizeItems(items);

        return normalizedItems.slice(
            0,
            visibleCount.value
        );
    };

    /*
    |--------------------------------------------------------------------------
    | Has more
    |--------------------------------------------------------------------------
    */

    const hasMore = (items = []) => {
        const normalizedItems = normalizeItems(items);

        return normalizedItems.length > visibleCount.value;
    };

    /*
    |--------------------------------------------------------------------------
    | Is expanded
    |--------------------------------------------------------------------------
    */

    const isExpanded = (items = []) => {
        const normalizedItems = normalizeItems(items);

        return (
            normalizedItems.length > initialCount &&
            visibleCount.value >= normalizedItems.length
        );
    };

    /*
    |--------------------------------------------------------------------------
    | Show more
    |--------------------------------------------------------------------------
    */

    const showMore = (items = []) => {
        const normalizedItems = normalizeItems(items);

        visibleCount.value = Math.min(
            visibleCount.value + step,
            normalizedItems.length
        );
    };

    /*
    |--------------------------------------------------------------------------
    | Collapse
    |--------------------------------------------------------------------------
    */

    const collapse = (items = [], element = null) => {
        const normalizedItems = normalizeItems(items);

        visibleCount.value = Math.min(
            initialCount,
            normalizedItems.length
        );

        if (!element) {
            return;
        }

        requestAnimationFrame(() => {
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'start',
            });
        });
    };

    /*
    |--------------------------------------------------------------------------
    | Toggle
    |--------------------------------------------------------------------------
    */

    const toggle = (items = [], element = null) => {
        if (isExpanded(items)) {
            collapse(items, element);

            return;
        }

        showMore(items);
    };

    /*
    |--------------------------------------------------------------------------
    | Reset
    |--------------------------------------------------------------------------
    */

    const reset = () => {
        visibleCount.value = initialCount;
    };

    /*
    |--------------------------------------------------------------------------
    | Computed count
    |--------------------------------------------------------------------------
    */

    const count = computed(() => {
        return visibleCount.value;
    });

    return {
        visibleCount,
        count,
        visibleItems,
        hasMore,
        isExpanded,
        showMore,
        collapse,
        toggle,
        reset,
    };
}