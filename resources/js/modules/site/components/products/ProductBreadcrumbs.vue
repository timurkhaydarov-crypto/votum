<template>
    <nav
        class="mb-5 flex flex-wrap items-center gap-2 text-xs text-slate-500"
        aria-label="Breadcrumb"
    >
        <template
            v-for="(item, index) in items"
            :key="`${item.label}-${index}`"
        >
            <RouterLink
                v-if="item.to && index < items.length - 1"
                :to="item.to"
                class="text-slate-500 transition hover:text-slate-800"
            >
                {{ item.label }}
            </RouterLink>

            <span
                v-else
                :aria-current="index === items.length - 1 ? 'page' : undefined"
                :class="
                    index === items.length - 1
                        ? 'font-semibold text-slate-950'
                        : 'text-slate-500'
                "
            >
                {{ item.label }}
            </span>

            <span
                v-if="index < items.length - 1"
                class="text-slate-400"
            >
                /
            </span>
        </template>
    </nav>
</template>

<script setup>
defineProps({
    items: {
        type: Array,
        default: () => [],
    },
});
</script>