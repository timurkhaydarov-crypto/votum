<template>
    <div class="space-y-6">
        <div>
            <h3 class="text-base font-semibold text-slate-900">
                {{ $t('product.info.documentation.title') }}
            </h3>
        </div>

        <div
            v-if="documentationLinks.length"
            class="space-y-3"
        >
            <a
                v-for="(document, index) in documentationLinks"
                :key="`${document.locale}-${index}`"
                :href="document.url"
                target="_blank"
                rel="noopener noreferrer"
                class="flex items-center justify-between gap-4 rounded-xl border border-slate-200 bg-white p-4 transition hover:border-slate-300 hover:bg-slate-50"
            >
                <div class="flex min-w-0 items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-600">
                        <i :class="`bi ${document.icon} text-lg`"></i>
                    </div>

                    <span class="truncate text-sm font-medium text-slate-800">
                        {{ document.label }}
                    </span>
                </div>

                <span class="inline-flex shrink-0 items-center gap-2 text-sm font-medium text-slate-600">
                    {{ $t('product.info.documentation.open') }}
                    <i class="bi bi-box-arrow-up-right"></i>
                </span>
            </a>
        </div>

        <div
            v-else
            class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-5 py-10 text-center"
        >
            <i class="bi bi-file-earmark-x text-2xl text-slate-300"></i>

            <p class="mt-3 text-sm text-slate-500">
                {{ $t('common.notAvailable') }}
            </p>
        </div>
    </div>
</template>

<script setup>
defineProps({
    documentationLinks: {
        type: Array,
        default: () => [],
    },
});
</script>