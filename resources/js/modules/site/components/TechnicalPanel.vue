<template>
    <div class="fixed inset-x-0 top-0 z-40 h-[42px] border-b border-slate-800 bg-slate-950/95 backdrop-blur">
        <div class="mx-auto flex h-full max-w-5xl items-center justify-end px-6">
            <div class="flex items-center gap-2">
                <div class="inline-flex h-8 items-center gap-2 rounded-md border border-slate-700 bg-slate-900/80 px-2.5 text-xs font-medium text-slate-100">
                    <svg class="h-4 w-4 text-teal-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 2a4 4 0 100 8 4 4 0 000-8zM4 15a6 6 0 1112 0v1H4v-1z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ userName }}</span>
                </div>

                <button
                    type="button"
                    class="inline-flex h-8 items-center gap-1.5 rounded-md border border-rose-400/30 bg-rose-500/10 px-2.5 text-xs font-medium text-rose-100 transition hover:border-rose-300/60 hover:bg-rose-500/20 disabled:cursor-not-allowed disabled:opacity-70"
                    :disabled="isLoggingOut"
                    @click="$emit('logout')"
                >
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h6a1 1 0 110 2H5v10h5a1 1 0 110 2H4a1 1 0 01-1-1V4zm10.293 2.293a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L14.586 11H8a1 1 0 110-2h6.586l-1.293-1.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ isLoggingOut ? 'Logging out...' : 'Logout' }}</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    userName: {
        type: String,
        default: 'User',
    },
    isLoggingOut: {
        type: Boolean,
        default: false,
    },
});

defineEmits(['logout']);
</script>
