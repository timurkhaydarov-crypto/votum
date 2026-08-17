<template>
    <div class="space-y-6">
        <div class="h-6 w-40 animate-pulse rounded bg-slate-200"></div>

        <div class="h-[520px] animate-pulse rounded-[2rem] bg-slate-100"></div>

        <div class="grid gap-5 lg:grid-cols-3">
            <div
                v-for="i in 3"
                :key="i"
                class="h-48 animate-pulse rounded-2xl bg-slate-100"
            ></div>
        </div>
    </div>
</template>