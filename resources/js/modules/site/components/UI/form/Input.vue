<template>
    <div>
        <label for="price" class="block first-letter:uppercase text-sm/6 font-medium text-gray-900">{{ $t(label) }}</label>
        <div class="mt-2">
            <div class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-emerald-500">
                <div class="shrink-0 text-base text-gray-500 select-none sm:text-sm/6"><i :class="icon"></i></div>
                <input @input="emit('input', $event.target.value)" type="text" name="price" :placeholder="$t(placeholder)" :required="required" class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 placeholder:capitalize focus:outline-none sm:text-sm/6" />
            </div>
        </div>
    </div>
</template>
<script setup>
import { defineEmits } from 'vue'
const emit = defineEmits(['input'])
const props = defineProps({
        label: {
            type: String,
            default: '',
        },
        placeholder: {
            type: String,
            default: '',
        },
        required: {
            type: Boolean,
            default: false,
        },
        icon: {
            type: String,
            default: '',
        },
    });
</script>