<template>
    <div>
        <label :for="label" class="block first-letter:uppercase text-sm/6 font-medium text-gray-900">{{ label }}</label>
        <div class="mt-2">
            <div class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-emerald-500">
                <div class="shrink-0 text-base text-gray-500 select-none sm:text-sm/6"><i :class="icon"></i></div>
                <select @change="emit('change',{id: $event.target.value, value: $event.target.options[$event.target.selectedIndex].text})" :name="label" :placeholder="placeholder" :required="required" class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6">
                    <option v-for="option in options" :key="option[optionValue]" :value="option[optionValue]">{{option.value[0].toLocaleUpperCase() + option.value.slice(1) }}</option>
                </select>
            </div>
        </div>
    </div>
</template>
<script setup>
    const props = defineProps({
        label: {
            type: String,
            default: '',
        },
        placeholder: {
            type: String,
            default: '',
        },
        icon: {
            type: String,
            default: '',
        },
        required: {
            type: Boolean,
            default: false,
        },
        options: {
            type: Array,
            default: () => [],
        },
        optionValue: {
            type: String,
            default: 'value',
        },
    });
    const emit = defineEmits(['change']);
</script>