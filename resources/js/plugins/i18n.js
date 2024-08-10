import { createI18n } from 'vue-i18n'

// Lang files
import en from '@/locales/en.json' // English
import sl from '@/locales/sl.json' // Slovenian

const i18n = createI18n({
    locale: 'en', // set locale
    fallbackLocale: 'en', // set fallback locale
    messages: {
        en,
        sl,
    },
})

export default i18n
