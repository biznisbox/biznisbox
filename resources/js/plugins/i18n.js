import { createI18n } from 'vue-i18n'

// Lang files
import en from '@/locales/en.json' // English
import sl from '@/locales/sl.json' // Slovenian
import de from '@/locales/de.json' // German

const i18n = createI18n({
    locale: 'en', // set locale
    fallbackLocale: 'en', // set fallback locale
    messages: {
        en,
        sl,
        de,
    },
})

export default i18n
