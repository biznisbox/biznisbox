export default {
    data() {
        return {
            events: [],
            event: {
                id: null,
                title: '',
                start: '',
                end: '',
                all_day: false,
                color: '#007bff',
                description: '',
                location: '',
                attendees: [],
                reminders: [],
                rrule: '',
                status: 'confirmed',
                privacy: 'private',
                show_as: 'busy',
            },
        }
    },

    methods: {
        /**
         * Get all events
         * @return {void} return events
         */
        getEvents() {
            this.makeHttpRequest('GET', '/api/calendar/events').then((response) => {
                this.all_events = response.data.data
            })
        },

        /**
         * Save event
         * @return {void} show toast and refetch events
         **/
        createEvent() {
            this.makeHttpRequest('POST', '/api/calendar/events', this.event).then((response) => {
                this.showToast(response.data.message)
                this.showEventDialog = false
                this.$refs.calendar.getApi().refetchEvents()
            })
        },

        /**
         * Update event
         * @param {string} id UUID of event
         * @return {void} show toast and refetch events
         */
        updateEvent(id) {
            this.makeHttpRequest('PUT', '/api/calendar/events/' + id, this.event).then((response) => {
                this.showToast(response.data.message)
                this.showEventDialog = false
                this.resetEvent()
                this.$refs.calendar.getApi().refetchEvents()
            })
        },

        /**
         * Get event
         * @param {string} id UUID of event
         * @return {void} return event
         */
        getEvent(id) {
            this.makeHttpRequest('GET', '/api/calendar/events/' + id).then((response) => {
                this.event = response.data.data
            })
        },

        /**
         * Delete event
         * @param {string} id UUID of event
         * @return {void} show toast and refetch events
         */
        deleteEvent(id) {
            this.makeHttpRequest('DELETE', '/api/calendar/events/' + id).then((response) => {
                this.showToast(response.data.message)
                this.$refs.calendar.getApi().refetchEvents()
            })
        },

        /**
         * Delete event ask for confirmation
         * @param {string} id UUID of event
         * @return {void} show toast and refetch events
         */
        deleteEventAsk(id) {
            this.confirmDeleteDialog(this.$t('calendar.delete_event_confirmation'), this.$t('basic.confirmation'), () => {
                this.deleteEvent(id)
                this.$refs.calendar.getApi().refetchEvents()
                this.showEventDialog = false
            })
        },

        /**
         * Reset event
         * @return {void} reset event
         */
        resetEvent(start, end) {
            this.event = {
                id: null,
                title: '',
                start: start || '',
                end: end || '',
                all_day: false,
                color: '#007bff',
                description: '',
                location: '',
                attendees: [],
                reminders: [],
                rrule: '',
                status: 'confirmed',
                privacy: 'private',
                show_as: 'busy',
            }
        },
    },
}
