<template>
    <section class="overflow-hidden rounded-[1.75rem] bg-slate-900">
        <div
            class="relative p-7 sm:p-10 lg:flex lg:items-center lg:justify-between lg:p-12"
        >
            <div
                class="absolute -right-24 -top-32 h-80 w-80 rounded-full bg-white/5 blur-3xl"
            ></div>

            <div class="relative max-w-2xl">
                <div
                    class="text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-400"
                >
                    Need assistance?
                </div>

                <h2
                    class="mt-3 text-2xl font-bold tracking-tight text-white sm:text-3xl"
                >
                    Нужна помощь в выборе оборудования?
                </h2>

                <p
                    class="mt-3 text-sm leading-6 text-slate-400"
                >
                    Наши специалисты помогут подобрать
                    конфигурацию оборудования под конкретную
                    задачу контроля.
                </p>
            </div>

            <RouterLink
                to="/contacts"
                class="relative mt-7 inline-flex shrink-0 items-center justify-center gap-3 rounded-xl bg-white px-6 py-3.5 text-sm font-semibold text-slate-900 transition hover:bg-slate-100 lg:mt-0"
            >
                Связаться со специалистом

                <i class="bi bi-arrow-right"></i>
            </RouterLink>
        </div>
    </section>
</template>