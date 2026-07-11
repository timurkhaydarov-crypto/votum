<template>
    <label class="block">
        <span class="mb-1.5 block text-sm font-medium text-slate-700">{{ label }}</span>
        <select
            :name="name"
            :value="modelValue"
            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-slate-900 outline-none ring-emerald-500 transition focus:border-emerald-500 focus:ring-2"
            @change="$emit('update:modelValue', $event.target.value)"
        >
            <option
                v-for="option in options"
                :key="option.value"
                :value="option.value"
            >
                {{ option.label }}
            </option>
        </select>
        <p v-if="error" class="mt-1.5 text-xs text-rose-600">{{ error }}</p>
    </label>
</template>

<script setup>
defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    label: {
        type: String,
        required: true,
    },
    name: {
        type: String,
        default: '',
    },
    options: {
        type: Array,
        default: () => [],
    },
    error: {
        type: String,
        default: '',
    },
});

defineEmits(['update:modelValue']);
</script>
