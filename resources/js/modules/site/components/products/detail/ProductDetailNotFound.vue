<template>
    <div class="rounded-[2rem] border border-amber-200 bg-amber-50 p-8">
        <div class="max-w-xl">
            <div
                class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 text-amber-700"
            >
                <i class="bi bi-search text-xl"></i>
            </div>

            <h2 class="mt-5 text-2xl font-bold tracking-tight text-slate-900">
                Прибор не найден
            </h2>

            <p class="mt-2 text-sm leading-6 text-slate-600">
                Запрошенная карточка продукции не найдена
                или была удалена из каталога.
            </p>

            <RouterLink
                to="/products"
                class="mt-6 inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
            >
                <i class="bi bi-arrow-left"></i>

                Вернуться в каталог
            </RouterLink>
        </div>
    </div>
</template>