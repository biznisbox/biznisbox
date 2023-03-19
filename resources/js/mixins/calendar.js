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
            this.makeHttpRequest('get', '/api/events').then((response) => {
                this.all_events = response.data.data
            })
        },

        /**
         * Save event
         * @return {void} show toast and refetch events
         **/
        saveEvent() {
            this.makeHttpRequest('post', '/api/calendars/events', this.event).then((response) => {
                this.showToast(response.data.message)
                this.$refs.calendar.getApi().refetchEvents()
            })
        },

        /**
         * Update event
         * @param {string} id UUID of event
         * @return {void} show toast and refetch events
         */
        updateEvent(id) {
            this.makeHttpRequest('PUT', '/api/calendars/events/' + id, this.event).then((response) => {
                this.showToast(response.data.message)
                this.$refs.calendar.getApi().refetchEvents()
            })
        },

        /**
         * Get event
         * @param {string} id UUID of event
         * @return {void} return event
         */
        getEvent(id) {
            this.makeHttpRequest('get', '/api/calendars/events/' + id).then((response) => {
                this.event = response.data.data
            })
        },

        /**
         * Delete event
         * @param {string} id UUID of event
         * @return {void} show toast and refetch events
         */
        deleteEvent(id) {
            this.makeHttpRequest('DELETE', '/api/calendars/events/' + id).then((response) => {
                this.showToast(response.data.message)
                this.$refs.calendar.getApi().refetchEvents()
            })
        },
    },
}
