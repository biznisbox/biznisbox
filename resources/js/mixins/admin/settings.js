export default {
    data() {
        return {
            settings: [],
            timezones: [],
        }
    },

    methods: {
        /**
         * Get all settings
         * @return {void} return settings
         **/
        getSettings() {
            this.makeHttpRequest('GET', '/api/admin/settings').then((response) => {
                this.settings = response.data.data
            })
        },

        /**
         * Update settings
         * @return {void} show toast
         */
        updateSettings() {
            this.makeHttpRequest('PUT', '/api/admin/settings', this.settings).then((response) => {
                this.showToast(response.data.message)
            })
        },

        /**
         * Get numbering settings
         * @return {void} return settings
         */
        getNumberingSettings() {
            this.makeHttpRequest('GET', '/api/admin/settings/numbering').then((response) => {
                this.settings = response.data.data
            })
        },

        /**
         * Update numbering settings
         * @return {void} show toast
         * */
        updateNumberingSettings() {
            this.makeHttpRequest('PUT', '/api/admin/settings/numbering', this.settings).then((response) => {
                this.showToast(response.data.message)
            })
        },

        /**
         * Get company settings
         * @return {void} return settings
         */
        getCompanySettings() {
            this.makeHttpRequest('GET', '/api/admin/settings/company').then((response) => {
                this.settings = response.data.data
            })
        },

        /**
         * Update company settings
         * @return {void} show toast
         */
        updateCompanySettings() {
            this.makeHttpRequest('PUT', '/api/admin/settings/company', this.settings).then((response) => {
                this.showToast(response.data.message)
            })
        },

        /**
         * Get timezones
         * @return {void} return timezones
         */
        getTimezones() {
            this.makeHttpRequest('GET', '/api/timezones?fields=country').then((response) => {
                this.timezones = response.data.data
            })
        },
    },
}
