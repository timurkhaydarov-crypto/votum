<template>
    <main class="min-h-screen bg-[radial-gradient(circle_at_top,_#d5f2e3,_#f2fbf6_42%,_#f9fafb_70%)] px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto flex min-h-[calc(100vh-5rem)] w-full max-w-6xl items-center justify-center gap-14">
            <section class="hidden max-w-lg lg:block">
                <p class="mb-5 inline-flex rounded-full border border-emerald-400/40 bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-emerald-800">
                    Technovotum
                </p>
                <h1 class="text-5xl font-semibold leading-tight text-slate-900">
                    Secure access for your NDT platform.
                </h1>
                <p class="mt-5 max-w-md text-base text-slate-600">
                    Authorization screens are now separated into reusable Vue modules.
                    Plug API endpoints into auth service methods and the flow is ready.
                </p>
            </section>

            <router-view />
        </div>
    </main>
</template>
