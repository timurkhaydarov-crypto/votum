<template>
    <details v-if="operatingHoursArray.length > 1 || operatingHoursArray[0]?.operating_hours?.length > 1" :open="isOpen" class="group relative" @click.stop>
        <summary @click.prevent="$emit('toggle')" class="inline-flex list-none cursor-pointer items-center gap-1.5 transition hover:text-amber-300">
            <i class="bi bi-clock text-[14px] leading-none" aria-hidden="true"></i>
            <span class="hidden sm:inline">$t('contacts.work_time')</span>
            <i class="bi bi-chevron-down text-[12px] leading-none transition group-open:rotate-180" aria-hidden="true"></i>
        </summary>

        <div class="absolute right-0 top-full mt-2 min-w-max whitespace-nowrap rounded-md border border-slate-700 bg-slate-900/95 p-2 normal-case tracking-normal shadow-xl">
          <template v-for="department in operatingHoursArray" :key="department.id ?? department.name">
                <span class="mb-1 block px-2 text-[13px] font-semibold text-[#00979f] text-center underline decoration-1 underline-offset-3">
                    {{ department.name }}
                </span>
                <div
                    v-for="operatingHours in department.operating_hours"
                    :key="operatingHours.id ?? `${operatingHours.from}-${operatingHours.to}`"
                    class="flex items-center justify-between gap-2 rounded px-2 py-1.5 text-[12px] transition hover:bg-slate-800"
                >
                    <span class="inline-flex items-center gap-1.5">
                        <i class="bi bi-clock text-[14px] leading-none" aria-hidden="true"></i>
                        {{ $t(`weekdays.${operatingHours.from}`) }} - {{ $t(`weekdays.${operatingHours.to}`) }} {{ operatingHours.time }}
                    </span>
                </div>
            </template>
        </div>
    </details>
    <span v-else class="inline-flex items-center gap-1.5">
        <i class="bi bi-clock text-[14px] leading-none" aria-hidden="true"></i>
        <span v-if="operatingHoursArray.length === 1">
            {{ $t(`weekdays.${operatingHoursArray[0].operating_hours[0].from}`) }} - {{ $t(`weekdays.${operatingHoursArray[0].operating_hours[0].to}`) }} {{ operatingHoursArray[0].operating_hours[0].time }}
        </span>
    </span>
</template>
<script setup>
defineProps({
    operatingHoursArray: {
        type: Array,
        default: () => [],
    },
    isOpen: {
        type: Boolean,
        default: false,
    },
});
defineEmits(['toggle']);

</script>