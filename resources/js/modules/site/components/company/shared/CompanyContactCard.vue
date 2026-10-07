<template>
    <article
        class="bg-white p-6 transition-colors hover:bg-slate-50 sm:p-7 lg:p-8"
    >
        <div
            class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-700"
        >
            <i :class="['bi', icon, 'text-base']"></i>
        </div>

        <div class="mt-7">
            <div
                class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500"
            >
                {{ label }}
            </div>

            <div
                v-for="item in items"
                :key="item.id ?? `${item.href ?? ''}-${item.text}`"
                class="mt-2 text-base font-semibold leading-6 text-slate-900"
            >
                <div
                    v-if="item.department"
                    class="mb-1 text-xs font-medium text-slate-500"
                >
                    {{ item.department }}
                </div>
                <a
                    v-if="item.href"
                    :href="item.href"
                    class="break-words hover:underline"
                >
                    {{ item.text }}
                </a>
                <span v-else>{{ item.text }}</span>
            </div>
        </div>
    </article>
</template>

<script setup>
defineProps({
    label: {
        type: String,
        required: true,
    },

    items: {
        type: Array,
        default: () => [],
    },

    icon: {
        type: String,
        required: true,
    },
})
</script>