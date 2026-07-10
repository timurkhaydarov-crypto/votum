<template>
    <label class="block">
        <span class="mb-1.5 block text-sm font-medium text-slate-700">{{ label }}</span>
        <input
            :type="type"
            :name="name"
            :autocomplete="autocomplete"
            :placeholder="placeholder"
            :value="modelValue"
            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-slate-900 outline-none ring-emerald-500 transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2"
            @input="$emit('update:modelValue', $event.target.value)"
        >
        <p v-if="error" class="mt-1.5 text-xs text-rose-600">{{ error }}</p>
    </label>
</template>

<script setup>
defineProps({
    modelValue: {
        type: [String, Number],
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
    type: {
        type: String,
        default: 'text',
    },
    placeholder: {
        type: String,
        default: '',
    },
    autocomplete: {
        type: String,
        default: 'off',
    },
    error: {
        type: String,
        default: '',
    },
});

defineEmits(['update:modelValue']);
</script>
