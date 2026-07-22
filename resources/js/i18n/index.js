import { createI18n } from 'vue-i18n'
import en from '@/locales/en.json'
import ru from '@/locales/ru.json'

const i18n = createI18n({
  legacy: false, // Отключаем режим legacy для поддержки Composition API
  locale: 'ru',  // Язык по умолчанию
  fallbackLocale: 'en', // Запасной язык, если перевод не найден
  messages: {
    en,
    ru
  }
})

export default i18n