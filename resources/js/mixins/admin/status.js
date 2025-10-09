export default {
    data() {
        return {
            version_info: [],
            status_info: {},
        }
    },

    methods: {
        /**
         * Get version of the application
         * @return {void} return version
         */
        getVersion() {
            this.makeHttpRequest('GET', '/api/admin/version').then((response) => {
                this.version_info = response.data.data
            })
        },

        /**
         * Get status of the application
         * @return {void} return status
         */
        getStatus() {
            this.makeHttpRequest('GET', '/api/admin/status').then((response) => {
                this.status_info = response.data.data
            })
        },
    },
}
