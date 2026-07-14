<template>
    <details class="group relative">
        <summary class="inline-flex list-none cursor-pointer items-center gap-1.5 transition hover:text-amber-300">
            <i class="bi bi-telephone text-[14px] leading-none" aria-hidden="true"></i>
            <span>Телефоны</span>
            <i class="bi bi-chevron-down text-[12px] leading-none transition group-open:rotate-180" aria-hidden="true"></i>
        </summary>

        <div class="absolute right-0 top-full mt-2 min-w-max whitespace-nowrap rounded-md border border-slate-700 bg-slate-900/95 p-2 normal-case tracking-normal shadow-xl">
            <a href="tel:+74999950061" class="block whitespace-nowrap rounded px-2 py-1.5 text-[12px] transition hover:bg-slate-800 hover:text-amber-300">
                +7 (499) 995-00-61
            </a>
            <a href="tel:+74999950062" class="block whitespace-nowrap rounded px-2 py-1.5 text-[12px] transition hover:bg-slate-800 hover:text-amber-300">
                +7 (499) 995-00-62
            </a>
            <a href="tel:+74999952475" class="block whitespace-nowrap rounded px-2 py-1.5 text-[12px] transition hover:bg-slate-800 hover:text-amber-300">
                +7 (499) 995-24-75
            </a>
        </div>
    </details>
</template>