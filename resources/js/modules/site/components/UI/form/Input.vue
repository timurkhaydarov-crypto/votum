<template>
    <div>
        <label :for="id" class="block first-letter:uppercase text-sm/6 font-medium text-gray-900">{{ label }}</label>
        <div class="mt-2">
            <div
                class="
                    flex items-center rounded-md bg-white pl-3
                    outline-1 -outline-offset-1
                    focus-within:outline-2
                    focus-within:-outline-offset-2
                "
                :class="[
                    error
                        ? 'outline-red-500 focus-within:outline-red-500'
                        : 'outline-gray-300 focus-within:outline-emerald-500'
                ]"
            >
                <div class="shrink-0 text-base text-gray-500 select-none sm:text-sm/6"><i :class="icon" aria-hidden="true"></i></div>
                <input v-model="model" v-maska="mask" :type="type" v-bind="pattern ? { pattern } : {}" :name="name"
                    :id="id" :placeholder="placeholder" :required="required" :aria-required="required"
                    class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 placeholder:capitalize focus:outline-none sm:text-sm/6"
                    :aria-invalid="!!error" :aria-describedby="error ? `${id}-error` : undefined" />
            </div>
            
            <p
                v-if="error"
                :id="`${id}-error`"
                role="alert"
                class="mt-1 text-sm text-red-500"
            >
                {{ error }}
            </p>
        </div>
    </div>
</template>
<script setup>
import { vMaska } from 'maska/vue'
import { useId } from 'vue';

const id = useId();
const model = defineModel({
    type: String,
    default: '',
});

defineProps({
    label: {
        type: String,
        default: '',
    },
    name: {
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
    pattern: {
        type: String,
        default: '',
    },
    type: {
        type: String,
        default: 'text',
    },
    mask: {
        type: String,
        default: '',
    },
    error: {
        type: String,
        default: '',
    },
});
</script>