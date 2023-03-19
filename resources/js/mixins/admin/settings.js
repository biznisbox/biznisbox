export default {
    data() {
        return {
            settings: {},
        }
    },

    methods: {
        /**
         * Get all settings
         * @return {void} return settings
         **/
        getSettings() {
            this.makeHttpRequest('get', '/api/admin/settings').then((response) => {
                this.settings = response.data.data
            })
        },

        /**
         * Update settings
         * @return {void} show toast
         */
        updateSettings() {
            this.makeHttpRequest('put', '/api/admin/settings', this.settings).then((response) => {
                this.showToast(response.data.message)
            })
        },
    },

    created() {
        this.getSettings()
    },
}
