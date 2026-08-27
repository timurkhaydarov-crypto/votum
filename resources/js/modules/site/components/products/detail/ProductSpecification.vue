<template>
    <section>
        <!-- DATA -->
        <div
            v-if="specifications.length"
            class="w-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
        >
            <!-- DESKTOP / TABLET -->
            <div class="hidden sm:block">
                <table class="w-full border-collapse text-left">
                    <!-- HEADER -->
                    <thead>
                        <tr
                            class="border-b border-slate-200 bg-slate-50/80"
                        >
                            <th
                                class="w-[45%] px-5 py-4 text-[10px] font-bold uppercase tracking-[0.14em] text-slate-500 lg:w-[40%] lg:px-6"
                            >
                                <div class="flex items-center gap-2">
                                    <span
                                        class="flex h-6 w-6 items-center justify-center rounded-md bg-slate-200/70 text-slate-500"
                                    >
                                        <i
                                            class="bi bi-list-ul text-xs"
                                        ></i>
                                    </span>

                                    <span>
                                        {{
                                            $t(
                                                'product.info.specifications.title',
                                            )
                                        }}
                                    </span>
                                </div>
                            </th>

                            <th
                                class="w-[55%] px-5 py-4 text-[10px] font-bold uppercase tracking-[0.14em] text-slate-500 lg:w-[60%] lg:px-6"
                            >
                                <div class="flex items-center gap-2">
                                    <span
                                        class="flex h-6 w-6 items-center justify-center rounded-md bg-slate-200/70 text-slate-500"
                                    >
                                        <i
                                            class="bi bi-info-lg text-xs"
                                        ></i>
                                    </span>

                                    <span>
                                        {{
                                            $t(
                                                'product.info.specifications.value',
                                            )
                                        }}
                                    </span>
                                </div>
                            </th>
                        </tr>
                    </thead>

                    <!-- BODY -->
                    <tbody>
                        <tr
                            v-for="(item, index) in specifications"
                            :key="item.id || index"
                            class="group border-b border-slate-100 last:border-b-0"
                        >
                            <!-- NAME -->
                            <td
                                class="relative px-5 py-4 align-top text-sm leading-6 text-slate-600 transition-colors group-hover:bg-slate-50/60 lg:px-6"
                            >
                                <div
                                    class="absolute inset-y-0 left-0 w-0.5 bg-slate-900 opacity-0 transition-opacity duration-150 group-hover:opacity-100"
                                ></div>

                                {{
                                    item.name?.[locale] ||
                                    item.name?.ru ||
                                    item.name?.en ||
                                    ''
                                }}
                            </td>

                            <!-- VALUE -->
                            <td
                                class="px-5 py-4 align-top text-sm font-semibold leading-6 text-slate-900 transition-colors group-hover:bg-slate-50/60 lg:px-6"
                            >
                                {{
                                    item.value?.[locale] ||
                                    item.value?.ru ||
                                    item.value?.en ||
                                    ''
                                }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- MOBILE -->
            <div class="divide-y divide-slate-100 sm:hidden">
                <div
                    v-for="(item, index) in specifications"
                    :key="item.id || index"
                    class="px-4 py-4 transition-colors active:bg-slate-50"
                >
                    <!-- NAME -->
                    <div
                        class="mb-1.5 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400"
                    >
                        {{
                            $t(
                                'product.info.specifications.title',
                            )
                        }}
                    </div>

                    <div
                        class="text-sm font-medium leading-5 text-slate-600"
                    >
                        {{
                            item.name?.[locale] ||
                            item.name?.ru ||
                            item.name?.en ||
                            ''
                        }}
                    </div>

                    <!-- VALUE -->
                    <div
                        class="mt-3 border-l-2 border-slate-200 pl-3"
                    >
                        <div
                            class="mb-1 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400"
                        >
                            {{
                                $t(
                                    'product.info.specifications.value',
                                )
                            }}
                        </div>

                        <div
                            class="text-sm font-semibold leading-6 text-slate-900"
                        >
                            {{
                                item.value?.[locale] ||
                                item.value?.ru ||
                                item.value?.en ||
                                ''
                            }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- EMPTY -->
        <div
            v-else
            class="flex min-h-[180px] items-center justify-center rounded-2xl border border-dashed border-slate-200 bg-slate-50/70"
        >
            <div class="px-6 text-center">
                <div
                    class="mx-auto mb-3 flex h-11 w-11 items-center justify-center rounded-xl bg-white text-slate-400 shadow-sm ring-1 ring-slate-100"
                >
                    <i
                        class="bi bi-list-columns-reverse text-lg"
                    ></i>
                </div>

                <p class="text-xs font-medium text-slate-500">
                    {{
                        $t(
                            'product.info.specifications.empty',
                        )
                    }}
                </p>
            </div>
        </div>
    </section>
</template>

<script setup>
import { useI18n } from 'vue-i18n';

const { locale } = useI18n();

defineProps({
    specifications: {
        type: Array,
        default: () => [],
    },
});
</script>