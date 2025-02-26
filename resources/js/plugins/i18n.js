import { createI18n } from 'vue-i18n'

// Lang files
import en from '@/locales/en.json' // English
import sl from '@/locales/sl.json' // Slovenian
import es from '@/locales/es.json' // Spanish
import de from '@/locales/de.json' // German
import fr from '@/locales/fr.json' // French
import it from '@/locales/it.json' // Italian
import pt from '@/locales/pt.json' // Portuguese
import ru from '@/locales/ru.json' // Russian
import tr from '@/locales/tr.json' // Turkish
import zh from '@/locales/zh.json' // Chinese
import nl from '@/locales/nl.json' // Dutch
import no from '@/locales/no.json' // Norwegian
import da from '@/locales/da.json' // Danish
import sv from '@/locales/sv.json' // Swedish
import fi from '@/locales/fi.json' // Finnish

const i18n = createI18n({
    legacy: false,
    locale: 'en', // set locale
    fallbackLocale: 'en', // set fallback locale
    messages: {
        en,
        sl,
        es,
        de,
        fr,
        it,
        pt,
        ru,
        tr,
        zh,
        nl,
        no,
        da,
        sv,
        fi,
    },
})

export default i18n
