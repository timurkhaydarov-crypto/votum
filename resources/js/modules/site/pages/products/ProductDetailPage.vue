<template>
    <ProductsLayout :title="pageTitle" subtitle="Детальная информация о приборе неразрушающего контроля">
        <!-- ========================================================= -->
        <!-- LOADING -->
        <!-- ========================================================= -->

        <div v-if="isLoading" class="space-y-6">
            <div class="h-6 w-40 animate-pulse rounded bg-slate-200"></div>

            <div class="h-[520px] animate-pulse rounded-[2rem] bg-slate-100"></div>

            <div class="grid gap-5 lg:grid-cols-3">
                <div v-for="i in 3" :key="i" class="h-48 animate-pulse rounded-2xl bg-slate-100"></div>
            </div>
        </div>

        <!-- ========================================================= -->
        <!-- ERROR -->
        <!-- ========================================================= -->

        <div v-else-if="errorMessage" class="rounded-2xl border border-rose-200 bg-rose-50 p-6">
            <div class="flex items-start gap-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-rose-100 text-rose-600">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>

                <div>
                    <h2 class="font-semibold text-rose-900">
                        Не удалось загрузить продукцию
                    </h2>

                    <p class="mt-1 text-sm text-rose-700">
                        {{ errorMessage }}
                    </p>
                </div>
            </div>
        </div>

        <!-- ========================================================= -->
        <!-- NOT FOUND -->
        <!-- ========================================================= -->

        <div v-else-if="isNotFound" class="rounded-[2rem] border border-amber-200 bg-amber-50 p-8">
            <div class="max-w-xl">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 text-amber-700">
                    <i class="bi bi-search text-xl"></i>
                </div>

                <h2 class="mt-5 text-2xl font-bold tracking-tight text-slate-900">
                    Прибор не найден
                </h2>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Запрошенная карточка продукции не найдена
                    или была удалена из каталога.
                </p>

                <RouterLink to="/products"
                    class="mt-6 inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    <i class="bi bi-arrow-left"></i>
                    Вернуться в каталог
                </RouterLink>
            </div>
        </div>

        <!-- ========================================================= -->
        <!-- PRODUCT -->
        <!-- ========================================================= -->

        <div v-else-if="product" class="space-y-6">
            <!-- ===================================================== -->
            <!-- BREADCRUMBS -->
            <!-- ===================================================== -->

            <ProductBreadcrumbs :items="breadcrumbs" />

            <!-- ===================================================== -->
            <!-- HERO -->
            <!-- ===================================================== -->

            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="grid lg:grid-cols-[1.05fr_0.95fr]">

                    <!-- ===================================================== -->
                    <!-- IMAGE -->
                    <!-- ===================================================== -->

                    <div
                        class="relative min-h-[340px] overflow-hidden bg-gradient-to-br from-slate-50 via-white to-slate-100 sm:min-h-[400px] lg:min-h-[480px]">
                        <!-- decorative -->
                        <div class="absolute -right-20 -top-20 h-56 w-56 rounded-full bg-blue-100/40 blur-3xl"></div>

                        <div class="absolute -bottom-20 -left-20 h-56 w-56 rounded-full bg-slate-200/50 blur-3xl"></div>

                        <!-- technical grid -->
                        <div class="absolute inset-0 opacity-[0.03]" style="
                    background-image:
                        linear-gradient(#0f172a 1px, transparent 1px),
                        linear-gradient(90deg, #0f172a 1px, transparent 1px);
                    background-size: 32px 32px;
                "></div>

                        <!-- group badge -->
                        <div class="absolute left-5 top-5 z-10">
                            <span :class="[
                                'inline-flex items-center gap-2 rounded-lg border px-3 py-1.5 text-[10px] font-semibold uppercase tracking-[0.12em] shadow-sm backdrop-blur-md',
                                groupBadgeClasses
                            ]">
                                <span :class="[
                                    'h-1.5 w-1.5 shrink-0 rounded-full',
                                    groupDotClass
                                ]"></span>

                                {{ product.groupTitle || 'NDT Equipment' }}
                            </span>
                        </div>

                        <!-- product image -->
                        <div
                            class="relative z-[1] flex h-full min-h-[340px] items-center justify-center p-6 sm:min-h-[400px] sm:p-8 lg:min-h-[480px] lg:p-10">
                            <img :src="imageSrc" :alt="product.name || 'NDT equipment'"
                                class="max-h-[360px] w-full object-contain drop-shadow-[0_22px_30px_rgba(15,23,42,0.14)] transition duration-500 hover:scale-[1.02]" />
                        </div>

                        <!-- bottom metadata -->
                        <div class="absolute bottom-4 left-5 right-5 z-10 flex items-center justify-between gap-3">
                            <div
                                class="max-w-[70%] truncate rounded-lg border border-white/80 bg-white/75 px-2.5 py-1.5 text-[9px] font-medium uppercase tracking-[0.12em] text-slate-500 shadow-sm backdrop-blur-md">
                                {{ product.categoryTitle || 'Non-Destructive Testing' }}
                            </div>

                            <div v-if="product.videoUrl"
                                class="shrink-0 rounded-lg border border-white/80 bg-white/75 px-2.5 py-1.5 text-[10px] font-medium text-slate-600 shadow-sm backdrop-blur-md">
                                <i class="bi bi-play-circle mr-1"></i>
                                Video
                            </div>
                        </div>
                    </div>

                    <!-- ===================================================== -->
                    <!-- INFO -->
                    <!-- ===================================================== -->

                    <div
                        class="flex flex-col justify-between border-t border-slate-200 p-6 sm:p-7 lg:border-l lg:border-t-0 lg:p-8">

                        <div>

                            <!-- article / stock -->
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-400">
                                    {{ product.article || 'ARTICLE N/A' }}
                                </span>

                                <span class="h-0.5 w-0.5 rounded-full bg-slate-300"></span>

                                <span :class="[
                                    'inline-flex items-center gap-1.5 text-[10px] font-semibold',
                                    isInStock
                                        ? 'text-emerald-600'
                                        : 'text-slate-400'
                                ]">
                                    <span :class="[
                                        'h-1.5 w-1.5 rounded-full',
                                        isInStock
                                            ? 'bg-emerald-500'
                                            : 'bg-slate-300'
                                    ]"></span>

                                    {{
                                        isInStock
                                            ? 'В наличии'
                                            : 'Нет в наличии'
                                    }}
                                </span>
                            </div>

                            <!-- title -->
                            <h1
                                class="mt-3 max-w-2xl text-2xl font-bold leading-tight tracking-[-0.025em] text-slate-900 sm:text-[1.75rem]">
                                {{ product.name || 'Без названия' }}
                            </h1>

                            <!-- description -->
                            <p class="mt-3 max-w-xl text-sm leading-6 text-slate-500">
                                {{
                                    product.shortDescription ||
                                    staticContent.shortDescription
                                }}
                            </p>

                            <!-- divider -->
                            <div class="my-5 h-px bg-slate-200"></div>

                            <!-- quick specifications -->
                            <div class="grid grid-cols-2 gap-2.5">
                                <InfoItem label="Метод контроля" :value="product.method" icon="bi-broadcast" />

                                <InfoItem label="Область применения"
                                    :value="product.application || product.categoryTitle" icon="bi-buildings" />

                                <InfoItem label="Диапазон частот" :value="product.frequency" icon="bi-activity" />

                                <InfoItem label="Дисплей" :value="product.display" icon="bi-display" />
                            </div>

                        </div>

                        <!-- ================================================= -->
                        <!-- ACTIONS -->
                        <!-- ================================================= -->

                        <div class="mt-7">

                            <div class="mb-2 text-[9px] font-semibold uppercase tracking-[0.15em] text-slate-400">
                                Цена
                            </div>

                            <div class="flex flex-col gap-2.5 sm:flex-row sm:items-center">

                                <!-- price -->
                                <div class="shrink-0 text-xl font-bold tracking-tight text-slate-900">
                                    {{ priceLabel }}
                                </div>

                                <div class="hidden h-7 w-px bg-slate-200 sm:block"></div>

                                <!-- cart -->
                                <button type="button"
                                    class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg bg-slate-900 px-4 py-2.5 text-xs font-semibold text-white shadow-sm transition-all duration-200 hover:bg-slate-800 hover:shadow-md active:scale-[0.98]">
                                    <i class="bi bi-cart3 text-sm"></i>

                                    Добавить в корзину
                                </button>

                            </div>

                            <!-- back -->
                            <RouterLink :to="backLink"
                                class="mt-3 inline-flex items-center gap-1.5 text-xs font-medium text-slate-400 transition hover:text-slate-800">
                                <i class="bi bi-arrow-left"></i>

                                {{ backLabel }}
                            </RouterLink>

                        </div>

                    </div>

                </div>
            </section>
            <!-- ===================================================== -->
            <!-- FEATURES -->
            <!-- ===================================================== -->

            <section>
                <SectionHeader eyebrow="04 / CAPABILITIES" title="Функциональные особенности"
                    description="Ключевые функции и возможности прибора." />

                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    <FeatureCard v-for="(feature, index) in features" :key="index" :feature="feature" />

                    <div v-if="!features.length"
                        class="col-span-full rounded-2xl border border-amber-200 bg-amber-50/50 p-6">
                        <EmptyData />
                    </div>
                </div>
            </section>
            <!-- ===================================================== -->
            <!-- TECHNICAL CHARACTERISTICS -->
            <!-- ===================================================== -->

            <section>
                <SectionHeader eyebrow="01 / TECHNICAL DATA" title="Технические характеристики"
                    description="Основные параметры и технические возможности оборудования." />

                <div class="overflow-hidden rounded-[1.5rem] border border-slate-200 bg-white shadow-sm">

                    <!-- TECHNICAL DATA -->
                    <div v-for="(item, index) in visibleTechnicalCharacteristics" :key="item.key" :class="[
                        'grid gap-2 px-5 py-4 sm:grid-cols-[minmax(180px,0.7fr)_1.3fr] sm:px-6',
                        index !== visibleTechnicalCharacteristics.length - 1
                            ? 'border-b border-slate-100'
                            : '',
                        !item.available
                            ? 'bg-amber-50/40'
                            : 'bg-white'
                    ]">
                        <!-- LABEL -->
                        <div class="text-xs font-medium uppercase tracking-wider text-slate-400">
                            {{ item.label }}
                        </div>

                        <!-- VALUE -->
                        <div v-if="item.available" class="text-sm font-semibold text-slate-800">
                            {{ item.value }}
                        </div>

                        <!-- MISSING DATA -->
                        <div v-else class="flex items-center gap-2 text-sm text-amber-700">
                            <i class="bi bi-info-circle"></i>

                            <span>
                                Данные отсутствуют
                            </span>
                        </div>
                    </div>

                    <!-- SHOW MORE / LESS -->
                    <button v-if="technicalCharacteristics.length > 6" type="button"
                        class="flex w-full items-center justify-center gap-2 border-t border-slate-100 bg-slate-50/60 px-5 py-3.5 text-xs font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900"
                        @click="showAllTechnicalCharacteristics = !showAllTechnicalCharacteristics">
                        <span>
                            {{
                                showAllTechnicalCharacteristics
                                    ? 'Скрыть характеристики'
                                    : `Показать все характеристики`
                            }}
                        </span>

                        <i :class="[
                            'bi text-sm transition-transform duration-200',
                            showAllTechnicalCharacteristics
                                ? 'bi-chevron-up'
                                : 'bi-chevron-down'
                        ]"></i>
                    </button>

                </div>
            </section>

            <!-- ===================================================== -->
            <!-- METHODS / TRANSDUCERS -->
            <!-- ===================================================== -->


            <section class="grid gap-5 lg:grid-cols-1">
                <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <!-- HEADER -->

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">
                                03 / TRANSDUCERS
                            </div>

                            <div class="mt-2 flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 text-slate-700">
                                    <i class="bi bi-broadcast-pin text-lg"></i>
                                </div>

                                <h2 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                                    Применяемые преобразователи
                                </h2>
                            </div>

                            <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-500">
                                Совместимые преобразователи и датчики для
                                выполнения различных методов неразрушающего
                                контроля.
                            </p>
                        </div>

                        <div v-if="transducers.length"
                            class="shrink-0 rounded-lg bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-500">
                            {{ transducers.length }}
                            {{
                                transducers.length === 1
                                    ? 'преобразователь'
                                    : 'преобразователей'
                            }}
                        </div>
                    </div>

                    <!-- STANDARD TRANSDUCERS NOTICE -->

                    <div v-if="
                        !hasProductTransducers &&
                        transducers.length
                    "
                        class="mt-6 flex items-start gap-3 rounded-xl border border-blue-100 bg-blue-50 px-4 py-3 text-xs leading-5 text-blue-700">
                        <i class="bi bi-info-circle mt-0.5 shrink-0"></i>

                        <span>
                            Для данного прибора индивидуальные преобразователи
                            не указаны. Показаны стандартные ультразвуковые
                            преобразователи из каталога.
                        </span>
                    </div>

                    <!-- LOADING -->

                    <div v-if="isLoadingTransducers"
                        class="mt-8 flex items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 p-10">
                        <div class="flex items-center gap-3 text-sm text-slate-500">
                            <div class="h-5 w-5 animate-spin rounded-full border-2 border-slate-200 border-t-slate-900">
                            </div>

                            Загрузка преобразователей...
                        </div>
                    </div>

                    <!-- ERROR -->

                    <div v-else-if="
                        transducersErrorMessage &&
                        !transducers.length
                    " class="mt-8 rounded-2xl border border-rose-200 bg-rose-50 p-6 text-sm text-rose-700">
                        Не удалось загрузить стандартные преобразователи.
                    </div>

                    <!-- CARDS -->

                    <div v-else-if="transducers.length" class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                        <article v-for="(
transducer, index
                            ) in transducers" :key="transducer.id ||
                                transducer.slug ||
                                index
                                "
                            class="group overflow-hidden rounded-2xl border border-slate-200 bg-white transition-all duration-300 hover:-translate-y-1 hover:border-slate-300 hover:shadow-xl hover:shadow-slate-200/50">
                            <!-- IMAGE -->

                            <div
                                class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-slate-50 via-white to-slate-100">
                                <div class="absolute -right-12 -top-12 h-32 w-32 rounded-full bg-slate-100 blur-2xl">
                                </div>

                                <div class="absolute -bottom-12 -left-12 h-32 w-32 rounded-full bg-blue-50 blur-2xl">
                                </div>

                                <div class="absolute left-4 top-4 z-10">
                                    <span
                                        class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white/90 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-600 shadow-sm backdrop-blur">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-900"></span>

                                        {{
                                            transducer.type ||
                                            transducer.method ||
                                            'Ультразвуковой'
                                        }}
                                    </span>
                                </div>
                                <div
                                    class="flex h-full items-center justify-center p-7 transition-transform duration-500 group-hover:scale-[1.04]">
                                    <img v-if="
                                        transducer.imageUrl ||
                                        transducer.image
                                    " :src="`/image/product/${transducer.categorySlug}/${transducer.imageUrl}.webp`"
                                        :srcset="transducer.imageSrcSet" :sizes="transducer.imageSizes"
                                        :alt="transducer.article"
                                        class="h-full w-full object-contain drop-shadow-[0_18px_20px_rgba(15,23,42,0.14)]" />

                                    <div v-else
                                        class="flex h-28 w-28 items-center justify-center rounded-3xl bg-slate-100 text-slate-300">
                                        <i class="bi bi-broadcast-pin text-4xl"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- CONTENT -->

                            <div class="p-5">
                                <div v-if="transducer.article"
                                    class="text-[10px] font-bold uppercase tracking-[0.16em] text-slate-400">
                                    {{ transducer.article }}
                                </div>

                                <h3 class="mt-1 text-base font-bold leading-tight tracking-tight text-slate-900">
                                    {{
                                        transducer.name ||
                                        transducer.title ||
                                        'Преобразователь'
                                    }}
                                </h3>

                                <p v-if="
                                    transducer.shortDescription ||
                                    transducer.description
                                " class="mt-2 line-clamp-3 text-xs leading-5 text-slate-500">
                                    {{
                                        transducer.shortDescription ||
                                        transducer.description
                                    }}
                                </p>

                                <div class="mt-4 grid grid-cols-2 overflow-hidden rounded-xl border border-slate-200">
                                    <div class="bg-slate-50 px-3 py-2.5">
                                        <div class="text-[9px] font-bold uppercase tracking-wider text-slate-400">
                                            Частота
                                        </div>

                                        <div class="mt-1 text-xs font-semibold text-slate-700">
                                            {{
                                                transducer.frequency ||
                                                '—'
                                            }}
                                        </div>
                                    </div>

                                    <div class="bg-white px-3 py-2.5">
                                        <div class="text-[9px] font-bold uppercase tracking-wider text-slate-400">
                                            Угол
                                        </div>

                                        <div class="mt-1 text-xs font-semibold text-slate-700">
                                            {{
                                                transducer.angle ||
                                                '—'
                                            }}
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-4">
                                    <span class="text-[10px] font-bold uppercase tracking-[0.14em] text-slate-400">
                                        {{
                                            hasProductTransducers
                                                ? 'Для прибора'
                                                : 'Стандартные'
                                        }}
                                    </span>

                                    <RouterLink v-if="transducer.id" :to="`/products/item/${transducer.id}`"
                                        class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-700 transition hover:text-slate-900">
                                        Подробнее

                                        <i
                                            class="bi bi-arrow-right transition-transform group-hover:translate-x-0.5"></i>
                                    </RouterLink>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- EMPTY -->

                    <div v-else class="mt-8 rounded-2xl border border-dashed border-amber-200 bg-amber-50/60 p-6">
                        <MissingContent title="Преобразователи не указаны"
                            text="Для данного прибора преобразователи не указаны, а стандартные ультразвуковые преобразователи отсутствуют в каталоге." />
                    </div>
                </div>
            </section>



            <!-- ===================================================== -->
            <!-- APPLICATION -->
            <!-- ===================================================== -->

            <section class="overflow-hidden rounded-[1.75rem] border border-slate-200 bg-slate-900 text-white">
                <div class="relative p-7 sm:p-10 lg:p-12">
                    <div class="absolute -right-20 -top-20 h-72 w-72 rounded-full bg-white/5 blur-3xl"></div>

                    <div class="relative max-w-4xl">
                        <div class="text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-400">
                            05 / APPLICATION
                        </div>

                        <h2 class="mt-3 text-2xl font-bold tracking-tight sm:text-3xl">
                            Область применения
                        </h2>

                        <p v-if="applicationAvailable"
                            class="mt-5 max-w-3xl text-sm leading-7 text-slate-300 sm:text-base">
                            {{ product.application || product.categoryTitle }}
                        </p>

                        <div v-else
                            class="mt-5 inline-flex items-center gap-2 rounded-xl border border-amber-300/20 bg-amber-300/10 px-4 py-3 text-sm text-amber-200">
                            <i class="bi bi-info-circle"></i>
                            Информация пока не заполнена
                        </div>
                    </div>
                </div>
            </section>

            <!-- ===================================================== -->
            <!-- DOCUMENTS -->
            <!-- ===================================================== -->

            <section>
                <SectionHeader eyebrow="06 / DOCUMENTATION" title="Документация и материалы"
                    description="Техническая документация, сертификаты, программное обеспечение и дополнительные материалы." />

                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    <DocumentCard title="Технические характеристики"
                        description="Подробные технические параметры прибора" icon="bi-file-earmark-text"
                        :href="documents.characteristics" />

                    <DocumentCard title="Сертификаты" description="Сертификационные документы и подтверждения"
                        icon="bi-patch-check" :href="documents.certificates" />

                    <DocumentCard title="Документация" description="Руководства и эксплуатационные документы"
                        icon="bi-book" :href="documents.documentation" />

                    <DocumentCard title="Обновление ПО" description="Программное обеспечение и обновления"
                        icon="bi-cloud-arrow-down" :href="documents.software" />
                </div>
            </section>

            <!-- ===================================================== -->
            <!-- GALLERY -->
            <!-- ===================================================== -->

            <section>
                <SectionHeader eyebrow="07 / GALLERY" title="Фотогалерея"
                    description="Визуальный обзор оборудования." />

                <div v-if="galleryImages.length" class="grid grid-cols-2 gap-3 md:grid-cols-3">
                    <div v-for="(image, index) in galleryImages" :key="index"
                        class="group relative aspect-[4/3] overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                        <img :src="image" :alt="`${product.name} ${index + 1}`"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />

                        <div
                            class="absolute inset-0 bg-gradient-to-t from-slate-900/30 via-transparent to-transparent opacity-0 transition group-hover:opacity-100">
                        </div>
                    </div>
                </div>

                <div v-else class="rounded-2xl border border-amber-200 bg-amber-50/50 p-8">
                    <EmptyData />
                </div>
            </section>



            <!-- ===================================================== -->
            <!-- CTA -->
            <!-- ===================================================== -->

            <section class="overflow-hidden rounded-[1.75rem] bg-slate-900">
                <div class="relative p-7 sm:p-10 lg:flex lg:items-center lg:justify-between lg:p-12">
                    <div class="absolute -right-24 -top-32 h-80 w-80 rounded-full bg-white/5 blur-3xl"></div>

                    <div class="relative max-w-2xl">
                        <div class="text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-400">
                            Need assistance?
                        </div>

                        <h2 class="mt-3 text-2xl font-bold tracking-tight text-white sm:text-3xl">
                            Нужна помощь в выборе оборудования?
                        </h2>

                        <p class="mt-3 text-sm leading-6 text-slate-400">
                            Наши специалисты помогут подобрать
                            конфигурацию оборудования под конкретную
                            задачу контроля.
                        </p>
                    </div>

                    <RouterLink to="/contacts"
                        class="relative mt-7 inline-flex shrink-0 items-center justify-center gap-3 rounded-xl bg-white px-6 py-3.5 text-sm font-semibold text-slate-900 transition hover:bg-slate-100 lg:mt-0">
                        Связаться со специалистом

                        <i class="bi bi-arrow-right"></i>
                    </RouterLink>
                </div>
            </section>
        </div>

        <!-- ========================================================= -->
        <!-- EMPTY -->
        <!-- ========================================================= -->

        <div v-else class="rounded-2xl border border-slate-200 bg-slate-50 p-6 text-sm text-slate-600">
            Нет данных о продукции.
        </div>
    </ProductsLayout>
</template>

<script setup>
import { ref, computed, watch, defineComponent, h } from 'vue';
import { useProductsCatalog } from '../../composables/useProductsCatalog.js';
import { useRoute } from 'vue-router';
import { useI18n } from 'vue-i18n';

import ProductBreadcrumbs from '../../components/products/ProductBreadcrumbs.vue';
import ProductsLayout from '../../components/products/ProductsLayout.vue';

import { useProductDetails } from '../../composables/useProductDetails.js';
import { useProductBreadcrumbs } from '../../composables/useProductBreadcrumbs.js';

/*
|--------------------------------------------------------------------------
| Route / i18n
|--------------------------------------------------------------------------
*/

const route = useRoute();
const { t, locale } = useI18n();

/*
|--------------------------------------------------------------------------
| Product
|--------------------------------------------------------------------------
*/

const {
    product,
    isLoading,
    isNotFound,
    errorMessage,
    loadProductById,
} = useProductDetails();

/*
|--------------------------------------------------------------------------
| Standard transducers catalog
|--------------------------------------------------------------------------
*/

const {
    products: standardTransducers,
    isLoading: isLoadingTransducers,
    errorMessage: transducersErrorMessage,
    loadProductsByGroup,
} = useProductsCatalog();

/*
|--------------------------------------------------------------------------
| Product ID
|--------------------------------------------------------------------------
*/

const productId = computed(() => {
    return route.params.productId || '';
});

/*
|--------------------------------------------------------------------------
| Page title
|--------------------------------------------------------------------------
*/

const pageTitle = computed(() => {
    return (
        product.value?.name ||
        t('productBreadcrumbs.productFallback', {
            id: productId.value || '',
        })
    );
});

/*
|--------------------------------------------------------------------------
| Breadcrumbs
|--------------------------------------------------------------------------
*/

const categorySlug = computed(() => {
    return product.value?.categorySlug || '';
});

const categoryTitle = computed(() => {
    return product.value?.categoryTitle || '';
});

const groupSlug = computed(() => {
    return product.value?.groupSlug || '';
});

const groupTitle = computed(() => {
    return product.value?.groupTitle || '';
});

const productTitle = computed(() => {
    return product.value?.name || '';
});

const {
    breadcrumbs,
    backLink,
    backLabel,
} = useProductBreadcrumbs({
    categorySlug,
    categoryTitle,
    groupSlug,
    groupTitle,
    productTitle,
    productId,
});

const showAllTechnicalCharacteristics = ref(false);

const visibleTechnicalCharacteristics = computed(() => {
    if (showAllTechnicalCharacteristics.value) {
        return technicalCharacteristics.value;
    }

    return technicalCharacteristics.value.slice(0, 6);
});

/*
|--------------------------------------------------------------------------
| Load standard ultrasonic transducers
|--------------------------------------------------------------------------
*/

const loadStandardTransducers = () => {
    if (hasProductTransducers.value) {
        return;
    }

    loadProductsByGroup(
        'transducers',
        'ultrasonic'
    );
};


/*
|--------------------------------------------------------------------------
| Load product
|--------------------------------------------------------------------------
*/

const loadDetails = async () => {
    if (!productId.value) {
        return;
    }

    await loadProductById(productId.value);

    /*
     * После получения товара проверяем:
     * есть ли у него собственные преобразователи.
     *
     * Если нет — загружаем стандартные ультразвуковые.
     */
    if (!hasProductTransducers.value) {
        loadProductsByGroup(
            'transducers',
            'ultrasonic'
        );
    }
};
watch(
    () => route.params.productId,
    () => {
        loadDetails();
    },
    {
        immediate: true,
    }
);

/*
|--------------------------------------------------------------------------
| Load standard transducers after product loaded
|--------------------------------------------------------------------------
*/

watch(
    product,
    () => {
        if (
            product.value &&
            !hasProductTransducers.value
        ) {
            loadStandardTransducers();
        }
    },
    {
        immediate: true,
    }
);

watch(locale, () => {
    loadDetails();
});

/*
|--------------------------------------------------------------------------
| Image
|--------------------------------------------------------------------------
*/

const imageSrc = computed(() => {
    const image = product.value?.imageUrl;

    if (!image) {
        return '/image/logo.svg';
    }

    if (
        image.startsWith('http://') ||
        image.startsWith('https://') ||
        image.startsWith('/')
    ) {
        return image;
    }

    if (!product.value?.categorySlug) {
        return `/image/product/${image}`;
    }

    const imageName = image.includes('.')
        ? image
        : `${image}.webp`;

    return `/image/product/${product.value.categorySlug}/${imageName}`;
});

/*
|--------------------------------------------------------------------------
| Stock
|--------------------------------------------------------------------------
*/

const isInStock = computed(() => {
    return Number(product.value?.quantity || 0) > 0;
});

/*
|--------------------------------------------------------------------------
| Price
|--------------------------------------------------------------------------
*/

const priceLabel = computed(() => {
    return product.value?.price
        ? `${product.value.price} ₽`
        : 'По запросу';
});

/*
|--------------------------------------------------------------------------
| Group color
|--------------------------------------------------------------------------
|
| railway-sector   -> red
| aerospace-sector -> blue
| industrial-sector -> orange
| everything else  -> slate
|
*/

const groupDotClass = computed(() => {
    switch (product.value?.groupSlug) {
        case 'railway-sector':
            return 'bg-red-500';

        case 'aerospace-sector':
            return 'bg-blue-500';

        case 'industrial-sector':
            return 'bg-orange-500';

        default:
            return 'bg-slate-400';
    }
});

const groupBadgeClasses = computed(() => {
    switch (product.value?.groupSlug) {
        case 'railway-sector':
            return 'border-red-100 bg-red-50 text-red-700';

        case 'aerospace-sector':
            return 'border-blue-100 bg-blue-50 text-blue-700';

        case 'industrial-sector':
            return 'border-orange-100 bg-orange-50 text-orange-700';

        default:
            return 'border-slate-200 bg-white text-slate-600';
    }
});

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

const hasValue = (value) => {
    if (value === null || value === undefined) {
        return false;
    }

    if (typeof value === 'string') {
        return value.trim().length > 0;
    }

    if (Array.isArray(value)) {
        return value.length > 0;
    }

    return true;
};

const normalizeArray = (value) => {
    if (!value) {
        return [];
    }

    if (Array.isArray(value)) {
        return value;
    }

    if (typeof value === 'string') {
        return value
            .split(/[,;\n]/)
            .map(item => item.trim())
            .filter(Boolean);
    }

    return [];
};

/*
|--------------------------------------------------------------------------
| Technical characteristics
|--------------------------------------------------------------------------
|
| Здесь сначала используются данные БД.
| Если конкретного поля нет — показываем строку
| "Данные отсутствуют", а сам блок НЕ скрываем.
|
*/

const technicalCharacteristics = computed(() => {
    const p = product.value || {};

    return [
        {
            key: 'frequency',
            label: 'Диапазон частот',
            value: p.frequency,
        },
        {
            key: 'display',
            label: 'Дисплей',
            value: p.display,
        },
        {
            key: 'channels',
            label: 'Количество каналов',
            value: p.channels,
        },
        {
            key: 'dynamicRange',
            label: 'Динамический диапазон',
            value: p.dynamicRange,
        },
        {
            key: 'measurementRange',
            label: 'Диапазон измерений',
            value: p.measurementRange,
        },
        {
            key: 'resolution',
            label: 'Разрешение',
            value: p.resolution,
        },
        {
            key: 'dimensions',
            label: 'Габариты',
            value: p.dimensions,
        },
        {
            key: 'weight',
            label: 'Масса',
            value: p.weight,
        },
        {
            key: 'power',
            label: 'Питание',
            value: p.power,
        },
    ].map(item => ({
        ...item,
        available: hasValue(item.value),
    }));
});

/*
|--------------------------------------------------------------------------
| Methods
|--------------------------------------------------------------------------
*/

const methods = computed(() => {
    return normalizeArray(
        product.value?.methods ||
        product.value?.controlMethods ||
        product.value?.method
    );
});

/*
|--------------------------------------------------------------------------
| Transducers
|--------------------------------------------------------------------------
*/

const productTransducers = computed(() => {
    const value =
        product.value?.transducers ??
        product.value?.probes ??
        product.value?.converters;

    if (!value) {
        return [];
    }

    if (Array.isArray(value)) {
        return value.filter(Boolean);
    }

    return [];
});


const hasProductTransducers = computed(() => {
    return productTransducers.value.length > 0;
});


const transducers = computed(() => {
    /*
     * Если у конкретного прибора есть свои преобразователи —
     * используем их.
     */
    if (hasProductTransducers.value) {
        return productTransducers.value;
    }

    /*
     * Если у прибора преобразователи не указаны —
     * используем стандартные ультразвуковые преобразователи
     * из каталога БД.
     */
    // standardTransducers.value = '/image/product/transducers/ultrasonic.webp';
    return standardTransducers.value || [];
});
/*
|--------------------------------------------------------------------------
| Features
|--------------------------------------------------------------------------
*/

const features = computed(() => {
    return normalizeArray(
        product.value?.features ||
        product.value?.functionalFeatures
    );
});

/*
|--------------------------------------------------------------------------
| Application
|--------------------------------------------------------------------------
*/

const applicationAvailable = computed(() => {
    return hasValue(
        product.value?.application ||
        product.value?.applications ||
        product.value?.categoryTitle
    );
});

/*
|--------------------------------------------------------------------------
| Static fallback content
|--------------------------------------------------------------------------
|
| Эти данные используются ТОЛЬКО как визуальный fallback.
| Они не подменяют реальные данные БД.
|
*/

const staticContent = {
    shortDescription:
        'Профессиональная система неразрушающего контроля для обнаружения и оценки дефектов в металлических и композитных материалах.',

    methods: [
        'Ультразвуковой контроль',
        'Фазированные решётки',
        'TOFD',
        'Томографический контроль',
    ],

    transducers: [
        'Прямые преобразователи',
        'Угловые преобразователи',
        'Многоэлементные преобразователи',
        'Специализированные преобразователи',
    ],

    videoUrl: '',
};

/*
|--------------------------------------------------------------------------
| Documents
|--------------------------------------------------------------------------
|
| Если в БД ссылки отсутствуют, используем
| заранее определённые информационные ссылки.
|
*/

const documents = computed(() => {
    const p = product.value || {};

    return {
        characteristics:
            p.characteristicsUrl ||
            p.technicalSpecificationsUrl ||
            '',

        certificates:
            p.certificatesUrl ||
            '',

        documentation:
            p.documentationUrl ||
            '',

        software:
            p.softwareUrl ||
            '',

        videoTraining:
            p.videoTrainingUrl ||
            '',

        photogallery:
            p.photogalleryUrl ||
            '',
    };
});

/*
|--------------------------------------------------------------------------
| Gallery
|--------------------------------------------------------------------------
*/

const galleryImages = computed(() => {
    return normalizeArray(
        product.value?.photogallery ||
        product.value?.gallery ||
        product.value?.galleryImages
    );
});

/*
|--------------------------------------------------------------------------
| Video
|--------------------------------------------------------------------------
*/

const videoUrl = computed(() => {
    return (
        product.value?.videoUrl ||
        product.value?.videoTrainingUrl ||
        staticContent.videoUrl
    );
});

/*
|--------------------------------------------------------------------------
| Components
|--------------------------------------------------------------------------
*/

const InfoItem = defineComponent({
    props: {
        label: String,
        value: [String, Number],
        icon: String,
    },

    setup(props) {
        return () =>
            h(
                'div',
                {
                    class: [
                        'rounded-xl border p-3.5',
                        hasValue(props.value)
                            ? 'border-slate-200 bg-white'
                            : 'border-amber-200 bg-amber-50/50',
                    ],
                },
                [
                    h(
                        'div',
                        {
                            class: 'flex items-center gap-2',
                        },
                        [
                            h(
                                'div',
                                {
                                    class: [
                                        'flex h-8 w-8 shrink-0 items-center justify-center rounded-lg',
                                        hasValue(props.value)
                                            ? 'bg-slate-100 text-slate-700'
                                            : 'bg-amber-100 text-amber-700',
                                    ],
                                },
                                [
                                    h('i', {
                                        class: `bi ${props.icon}`,
                                    }),
                                ]
                            ),

                            h(
                                'span',
                                {
                                    class: 'text-[10px] font-semibold uppercase tracking-wider text-slate-400',
                                },
                                props.label
                            ),
                        ]
                    ),

                    h(
                        'div',
                        {
                            class: [
                                'mt-2 text-xs font-semibold',
                                hasValue(props.value)
                                    ? 'text-slate-800'
                                    : 'text-amber-700',
                            ],
                        },
                        hasValue(props.value)
                            ? props.value
                            : 'Данные отсутствуют'
                    ),
                ]
            );
    },
});

const SectionHeader = defineComponent({
    props: {
        eyebrow: String,
        title: String,
        description: String,
    },

    setup(props) {
        return () =>
            h(
                'div',
                {
                    class: 'mb-5',
                },
                [
                    h(
                        'div',
                        {
                            class: 'text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-400',
                        },
                        props.eyebrow
                    ),

                    h(
                        'h2',
                        {
                            class: 'mt-2 text-2xl font-bold tracking-tight text-slate-900',
                        },
                        props.title
                    ),

                    h(
                        'p',
                        {
                            class: 'mt-2 max-w-2xl text-sm leading-6 text-slate-500',
                        },
                        props.description
                    ),
                ]
            );
    },
});

const EmptyData = defineComponent({
    setup() {
        return () =>
            h(
                'div',
                {
                    class: 'flex items-center gap-3 text-sm text-amber-700',
                },
                [
                    h(
                        'div',
                        {
                            class: 'flex h-9 w-9 items-center justify-center rounded-xl bg-amber-100',
                        },
                        [
                            h('i', {
                                class: 'bi bi-info-circle',
                            }),
                        ]
                    ),

                    h(
                        'span',
                        {},
                        'Данные для данного прибора пока не заполнены.'
                    ),
                ]
            );
    },
});

const DataSection = defineComponent({
    props: {
        title: String,
        eyebrow: String,
        icon: String,
        items: {
            type: Array,
            default: () => [],
        },
        fallback: {
            type: Array,
            default: () => [],
        },
    },

    setup(props) {
        const available = computed(() => props.items.length > 0);

        return () =>
            h(
                'div',
                {
                    class: [
                        'rounded-[1.5rem] border p-6 shadow-sm sm:p-7',
                        available.value
                            ? 'border-slate-200 bg-white'
                            : 'border-amber-200 bg-amber-50/40',
                    ],
                },
                [
                    h(
                        'div',
                        {
                            class: 'flex items-start justify-between gap-4',
                        },
                        [
                            h(
                                'div',
                                {},
                                [
                                    h(
                                        'div',
                                        {
                                            class: 'text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-400',
                                        },
                                        props.eyebrow
                                    ),

                                    h(
                                        'h2',
                                        {
                                            class: 'mt-2 text-xl font-bold tracking-tight text-slate-900',
                                        },
                                        props.title
                                    ),
                                ]
                            ),

                            h(
                                'div',
                                {
                                    class: [
                                        'flex h-10 w-10 shrink-0 items-center justify-center rounded-xl',
                                        available.value
                                            ? 'bg-slate-100 text-slate-700'
                                            : 'bg-amber-100 text-amber-700',
                                    ],
                                },
                                [
                                    h('i', {
                                        class: `bi ${props.icon}`,
                                    }),
                                ]
                            ),
                        ]
                    ),

                    available.value
                        ? h(
                            'div',
                            {
                                class: 'mt-6 space-y-2',
                            },
                            props.items.map(item =>
                                h(
                                    'div',
                                    {
                                        class: 'flex items-center gap-3 rounded-xl bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700',
                                    },
                                    [
                                        h(
                                            'span',
                                            {
                                                class: 'h-1.5 w-1.5 shrink-0 rounded-full bg-slate-900',
                                            }
                                        ),

                                        item,
                                    ]
                                )
                            )
                        )
                        : h(
                            'div',
                            {
                                class: 'mt-6 space-y-3',
                            },
                            [
                                h(
                                    'div',
                                    {
                                        class: 'flex items-center gap-2 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-medium text-amber-700',
                                    },
                                    [
                                        h('i', {
                                            class: 'bi bi-info-circle',
                                        }),

                                        'Данные отсутствуют',
                                    ]
                                ),

                                props.fallback.length
                                    ? h(
                                        'div',
                                        {
                                            class: 'opacity-60',
                                        },
                                        props.fallback.map(item =>
                                            h(
                                                'div',
                                                {
                                                    class: 'border-b border-amber-100 py-2 text-xs text-slate-500 last:border-0',
                                                },
                                                item
                                            )
                                        )
                                    )
                                    : null,
                            ]
                        ),
                ]
            );
    },
});

const FeatureCard = defineComponent({
    props: {
        feature: {
            type: String,
            default: '',
        },
    },

    setup(props) {
        return () =>
            h(
                'div',
                {
                    class: 'group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-md',
                },
                [
                    h(
                        'div',
                        {
                            class: 'flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100 text-slate-700 transition group-hover:bg-slate-900 group-hover:text-white',
                        },
                        [
                            h('i', {
                                class: 'bi bi-check2',
                            }),
                        ]
                    ),

                    h(
                        'div',
                        {
                            class: 'mt-4 text-sm font-semibold leading-6 text-slate-800',
                        },
                        props.feature
                    ),
                ]
            );
    },
});

const DocumentCard = defineComponent({
    props: {
        title: String,
        description: String,
        icon: String,
        href: String,
    },

    setup(props) {
        const available = computed(() => hasValue(props.href));

        return () =>
            h(
                props.href ? 'a' : 'div',
                {
                    ...(props.href
                        ? {
                            href: props.href,
                            target: '_blank',
                            rel: 'noopener noreferrer',
                        }
                        : {}),

                    class: [
                        'group rounded-2xl border p-5 transition',
                        available.value
                            ? 'border-slate-200 bg-white shadow-sm hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-md'
                            : 'border-amber-200 bg-amber-50/40',
                    ],
                },
                [
                    h(
                        'div',
                        {
                            class: 'flex items-start justify-between gap-4',
                        },
                        [
                            h(
                                'div',
                                {
                                    class: [
                                        'flex h-10 w-10 items-center justify-center rounded-xl',
                                        available.value
                                            ? 'bg-slate-100 text-slate-700 group-hover:bg-slate-900 group-hover:text-white'
                                            : 'bg-amber-100 text-amber-700',
                                    ],
                                },
                                [
                                    h('i', {
                                        class: `bi ${props.icon}`,
                                    }),
                                ]
                            ),

                            h(
                                'i',
                                {
                                    class: [
                                        'bi bi-arrow-up-right text-sm',
                                        available.value
                                            ? 'text-slate-400'
                                            : 'text-amber-500',
                                    ],
                                }
                            ),
                        ]
                    ),

                    h(
                        'h3',
                        {
                            class: 'mt-5 text-sm font-bold text-slate-900',
                        },
                        props.title
                    ),

                    h(
                        'p',
                        {
                            class: 'mt-1.5 text-xs leading-5 text-slate-500',
                        },
                        props.description
                    ),

                    !available.value
                        ? h(
                            'div',
                            {
                                class: 'mt-4 text-[10px] font-semibold uppercase tracking-wider text-amber-700',
                            },
                            'Ссылка отсутствует'
                        )
                        : null,
                ]
            );
    },
});
</script>