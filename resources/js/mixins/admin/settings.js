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

        /**
         * Get numbering settings
         * @return {void} return settings
         */
        getNumberingSettings() {
            this.makeHttpRequest('get', '/api/admin/settings/numbering').then((response) => {
                this.settings = response.data.data
            })
        },

        /**
         * Update numbering settings
         * @return {void} show toast
         * */
        updateNumberingSettings() {
            this.makeHttpRequest('put', '/api/admin/settings/numbering', this.settings).then((response) => {
                this.showToast(response.data.message)
            })
        },
    },
}
