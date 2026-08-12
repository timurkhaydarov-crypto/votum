<template>

    <div v-if="category" class="min-h-[330px] p-7">

        <!-- Заголовок -->

        <div class="mb-6">

            <h2 class="text-xl font-bold
               tracking-tight
               text-[#252525]">
                {{ category.title }}
            </h2>

            <p v-if="category.description" class="mt-1.5 max-w-xl
               text-sm leading-5
               text-gray-500">
                {{ category.description }}
            </p>

        </div>


        <!-- Карточки -->

        <div class="grid
         grid-cols-[repeat(auto-fit,minmax(min(220px,100%),1fr))]
         gap-4">

            <a v-for="item in category.items" :key="item.title" :href="item.href" class="group min-w-0
           rounded-2xl
           border border-gray-100
           bg-gray-50/70
           p-5
           transition-all duration-200
           hover:-translate-y-0.5
           hover:border-gray-200
           hover:bg-white
           hover:shadow-[0_12px_35px_rgba(0,0,0,0.08)]">

                <!-- Иконка -->

                <div class="mb-5 flex h-11 w-11
                 items-center justify-center
                 rounded-xl
                 bg-white
                 text-[#252525]
                 shadow-sm
                 transition-all
                 group-hover:bg-[#252525]
                 group-hover:text-white">

                    <i :class="[
                        'bi',
                        item.icon || category.icon,
                        'text-xl'
                    ]" aria-hidden="true"></i>

                </div>


                <!-- Название -->

                <h3 class="text-sm font-bold
                 text-[#252525]">
                    {{ item.title }}
                </h3>


                <!-- Описание -->

                <p v-if="item.description" class="mt-2 text-xs
                 leading-5
                 text-gray-500">
                    {{ item.description }}
                </p>


                <!-- Ссылка -->

                <div class="mt-5 flex items-center gap-2
                 text-xs font-semibold
                 text-[#252525]">

                    Подробнее

                    <i class="bi bi-arrow-right
                   transition-transform
                   group-hover:translate-x-1" aria-hidden="true"></i>

                </div>

            </a>

        </div>


        <!-- Вся категория -->

        <div class="mt-6 border-t
             border-gray-100 pt-4">

            <a :href="category.href" class="inline-flex items-center gap-2
               text-sm font-semibold
               text-[#252525]
               hover:underline">

                Все услуги «{{ category.title }}»

                <i class="bi bi-arrow-right" aria-hidden="true"></i>

            </a>

        </div>

    </div>

</template>
<script setup>
defineProps({
    category: {
        type: Object,
        default: null
    }
})
</script>