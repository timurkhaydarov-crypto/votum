<script setup>
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

const { locale } = useI18n()

const languages = [
    { code: 'ru', name: 'Ру', flag: '🇷🇺' },
    { code: 'en', name: 'En', flag: '🇬🇧' },
]

const currentLanguage = computed(() => {
    return (
        languages.find(lang => lang.code === locale.value) ||
        languages[0]
    )
})

const changeLanguage = (code) => {
    locale.value = code
}

const toggleLanguage = () => {
    const nextLanguage = languages.find(
        lang => lang.code !== currentLanguage.value.code
    )

    if (nextLanguage) {
        changeLanguage(nextLanguage.code)
    }
}
</script>

<template>
    <button
        type="button"
        class="
            inline-flex
            h-10
            w-10
            cursor-pointer
            items-center
            justify-center
            rounded-xl
            text-2xl
            transition
            hover:bg-slate-800
            hover:text-red-400
            active:bg-slate-800
            active:text-red-400
        "
        @click="toggleLanguage"
    >
        {{ languages.find(lang => lang.code !== currentLanguage.code).flag }}
    </button>
</template>