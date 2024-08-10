import './bootstrap'
import { createApp } from 'vue'
import App from './App.vue'
import router from '@/router'
import PrimeVue from '@/plugins/primevue'
import i18n from '@/plugins/i18n'
import VueAxios from 'vue-axios'
import axios from 'axios'
import VueCookies from 'vue3-cookies'
import IndexMixin from '@/mixins/index'
import CustomComponents from '@/plugins/components'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import VueApexCharts from 'vue3-apexcharts'
import '@fortawesome/fontawesome-free/css/all.min.css'
import '@fortawesome/fontawesome-free/js/all.min.js'
import 'flag-icons/css/flag-icons.min.css'
import 'file-icon-vectors/dist/file-icon-vivid.css'
import 'leaflet/dist/leaflet.css'
import 'vue-map-ui/dist/style.css'
import 'vue-map-ui/dist/theme-all.css'

const app = createApp(App)
app.use(router)
app.use(PrimeVue)
app.use(i18n)
app.use(VueAxios, axios)
app.use(VueCookies)
app.mixin(IndexMixin)
app.use(CustomComponents)
app.use(VueApexCharts)
app.component('DefaultLayout', DefaultLayout)
app.mount('#app')
