<template>
    <main class="min-h-screen bg-slate-50">
        <div
            class="mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8 lg:py-12"
        >
            <!-- SUCCESS -->
            <section
                v-if="submitted"
                class="mx-auto max-w-2xl rounded-2xl border border-slate-200 bg-white p-8 text-center shadow-sm sm:p-10"
            >
                <div
                    class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100"
                >
                    <i
                        class="bi bi-check-lg text-2xl text-slate-700"
                    ></i>
                </div>

                <h1
                    class="mt-5 text-2xl font-bold tracking-tight text-slate-900"
                >
                    {{ t('request.success.title') }}
                </h1>

                <p
                    class="mx-auto mt-3 max-w-lg text-sm leading-6 text-slate-500"
                >
                    {{ t('request.success.description') }}
                </p>

                <!-- REQUEST NUMBER -->
                <div
                    v-if="request?.number"
                    class="mx-auto mt-5 inline-flex items-center gap-2 rounded-lg bg-slate-50 px-4 py-2.5 text-xs font-semibold text-slate-700"
                >
                    <i class="bi bi-hash text-slate-400"></i>

                    <span>
                        {{ request.number }}
                    </span>
                </div>

                <RouterLink
                    to="/products"
                    class="mt-6 inline-flex items-center gap-2 rounded-lg bg-slate-900 px-5 py-3 text-xs font-semibold text-white shadow-sm transition hover:bg-slate-800"
                >
                    {{ t('request.success.backToProducts') }}

                    <i class="bi bi-arrow-right"></i>
                </RouterLink>
            </section>

            <!-- CHECKOUT -->
            <template v-else>
                <!-- HEADER -->
                <header class="mb-8">
                    <div
                        class="text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-400"
                    >
                        {{ t('request.eyebrow') }}
                    </div>

                    <h1
                        class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl"
                    >
                        {{ t('request.title') }}
                    </h1>

                    <p
                        class="mt-2 max-w-2xl text-sm leading-6 text-slate-500"
                    >
                        {{ t('request.description') }}
                    </p>
                </header>

                <!-- CONTENT -->
                <div
                    v-if="itemCount"
                    class="grid grid-cols-1 gap-6 lg:grid-cols-[minmax(0,1fr)_360px]"
                >
                    <!-- FORM -->
                    <section class="min-w-0">
                        <RequestForm
                            @success="handleSuccess"
                        />
                    </section>

                    <!-- SUMMARY -->
                    <aside
                        class="lg:sticky lg:top-6 lg:self-start"
                    >
                        <div
                            class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6"
                        >
                            <div
                                class="text-[9px] font-semibold uppercase tracking-[0.15em] text-slate-400"
                            >
                                {{ t('request.summary.label') }}
                            </div>

                            <h2
                                class="mt-1 text-lg font-semibold text-slate-900"
                            >
                                {{ t('request.summary.title') }}
                            </h2>

                            <div
                                class="mt-5 space-y-3 border-b border-slate-200 pb-5"
                            >
                                <!-- PRODUCTS -->
                                <div
                                    class="flex items-center justify-between gap-4"
                                >
                                    <span
                                        class="text-sm text-slate-500"
                                    >
                                        {{ t('cart.summary.products') }}
                                    </span>

                                    <span
                                        class="text-sm font-semibold text-slate-900"
                                    >
                                        {{ itemCount }}
                                    </span>
                                </div>

                                <!-- QUANTITY -->
                                <div
                                    class="flex items-center justify-between gap-4"
                                >
                                    <span
                                        class="text-sm text-slate-500"
                                    >
                                        {{ t('cart.summary.quantity') }}
                                    </span>

                                    <span
                                        class="text-sm font-semibold text-slate-900"
                                    >
                                        {{ count }}
                                    </span>
                                </div>
                            </div>

                            <!-- TOTAL -->
                            <div
                                class="flex items-center justify-between pt-5"
                            >
                                <span
                                    class="text-sm font-medium text-slate-600"
                                >
                                    {{ t('cart.summary.total') }}
                                </span>

                                <span
                                    class="text-2xl font-bold tracking-tight text-slate-900"
                                >
                                    {{ count }}
                                </span>
                            </div>

                            <!-- BACK TO CART -->
                            <RouterLink
                                to="/cart"
                                class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-600 transition hover:bg-slate-50"
                            >
                                <i class="bi bi-arrow-left"></i>

                                {{ t('request.backToCart') }}
                            </RouterLink>
                        </div>
                    </aside>
                </div>

                <!-- EMPTY -->
                <EmptyCart v-else />
            </template>
        </div>
    </main>
</template>

<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import { useCart } from '../../composables/useCart';

import EmptyCart from '../components/cart/EmptyCart.vue';
import RequestForm from '../components/request/RequestForm.vue';

const { t } = useI18n();

const {
    count,
    itemCount,
} = useCart();

/**
 * Whether request was successfully created.
 */
const submitted = ref(false);

/**
 * Created request returned by API.
 *
 * Example:
 *
 * {
 *     id: 15,
 *     number: "REQ-20260827-A7K4M2",
 *     status: "pending"
 * }
 */
const request = ref(null);

/**
 * Handle successful request creation.
 */
const handleSuccess = (data) => {
    request.value = data?.request ?? null;

    submitted.value = true;
};
</script>

