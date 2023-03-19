import '@fullcalendar/core/vdom'
import FullCalendar from '@fullcalendar/vue3'

export default {
    install(app) {
        app.component('FullCalendar', FullCalendar)
    },
}
