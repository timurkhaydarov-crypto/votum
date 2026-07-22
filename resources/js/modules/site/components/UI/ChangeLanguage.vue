<script setup>
import { ref, computed } from 'vue'
import { useI18n } from 'vue-i18n'

const { locale } = useI18n()

// Список доступных языков с кодами стран для флагов
const languages = [
  { code: 'ru', name: 'Ру', flag: '🇷🇺' },
  { code: 'en', name: 'En', flag: '🇬🇧' },
]

// Получаем текущий выбранный объект языка
const currentLanguage = computed(() => {
  return languages.find(lang => lang.code === locale.value) || languages[0]
})

// Метод смены языка
const changeLanguage = (code) => {
  locale.value = code
}
</script>

<template>
    <button
        type="button"
        class="inline-flex cursor-pointer text-2xl items-center justify-center rounded transition hover:bg-slate-800 hover:text-red-400"
        @click="changeLanguage(languages.find(lang => lang.code !== currentLanguage.code).code)"
    >
    {{ languages.find(lang => lang.code !== currentLanguage.code).flag }}
    </button>
</template>