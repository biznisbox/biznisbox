import './bootstrap'
import { createApp, defineAsyncComponent } from 'vue'
import { createPinia } from 'pinia'
import router from '@/router'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueCookies from 'vue3-cookies'
import * as Sentry from '@sentry/vue'
import i18n from '@/plugins/i18n'
import PrimeVue from '@/plugins/primevue'
import Form from '@/plugins/form'
import FullCalendar from '@/plugins/fullcalendar'
import GlobalMixin from '@/mixins'
import UserLayout from '@/layouts/UserLayout.vue'
import AdminLayout from '@/layouts/AdminLayout.vue'
import UserHeader from '@/components/UserHeader.vue'
import '@fortawesome/fontawesome-free/css/all.min.css'
import '@fortawesome/fontawesome-free/js/all.min.js'

const app = createApp(defineAsyncComponent(() => import('./App.vue')))

Sentry.init({
    app,
    dsn: import.meta.env.VITE_SENTRY_DSN_PUBLIC,
})

const pinia = createPinia()
app.use(router)
app.use(pinia)
app.use(PrimeVue)
app.mixin(GlobalMixin)
app.use(VueCookies)
app.use(i18n)
app.use(Form)
app.use(FullCalendar)
app.component('UserLayout', UserLayout)
app.component('AdminLayout', AdminLayout)
app.component('UserHeader', UserHeader)
app.use(VueAxios, axios)
app.mount('#app')
