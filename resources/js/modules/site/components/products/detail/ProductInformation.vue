<template>
    <section>
        <div
            class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8"
        >
            <p
                class="whitespace-pre-line text-sm leading-7 text-slate-700"
            >
                {{ content }}
            </p>
        </div>
    </section>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    content: {
        type: String,
        required: true,
    },

});


</script>