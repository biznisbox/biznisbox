export default {
    data() {
        return {
            version_info: [],
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
    },
}
