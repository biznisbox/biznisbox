export default {
    data() {
        return {
            vendors: [],
            vendor: {
                name: '',
                address: '',
                city: '',
                state: '',
                zip_code: '',
                country: '',
                phone: '',
                email: '',
                website: '',
                vat_number: '',
                currency: '',
            },
        }
    },

    methods: {
        /**
         * Get all vendors
         * @returns {array} vendors
         */
        getVendors() {
            this.makeHttpRequest('GET', '/api/vendors').then((response) => {
                this.vendors = response.data.data
            })
        },

        /**
         * Get vendor by id
         * @param {string} id uuid of vendor
         * @returns {object} vendor object
         **/
        getVendor(id) {
            this.makeHttpRequest('GET', '/api/vendors/' + id).then((response) => {
                this.vendor = response.data.data
            })
        },

        /**
         * Create new vendor
         * @returns {void} return response
         **/
        createVendor() {
            this.makeHttpRequest('POST', '/api/vendors', this.vendor).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'vendors' })
            })
        },

        /**
         * Update vendor
         * @param {string} id uuid of vendor
         * @returns {void} return response
         **/
        updateVendor(id) {
            this.makeHttpRequest('PUT', '/api/vendors/' + id, this.vendor).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'vendors' })
            })
        },

        /**
         * Delete vendor
         * @param {string} id uuid of vendor
         * @returns {void} return response
         **/
        deleteVendor(id) {
            this.makeHttpRequest('DELETE', '/api/vendors/' + id).then((response) => {
                this.$toast.add({ severity: 'success', summary: response.data.message, life: 3000 })
                this.$router.push({ name: 'vendors' })
            })
        },

        /**
         * Delete vendor confirmation
         * @param {string} id uuid of vendor
         * @returns {void} return response
         **/
        deleteVendorAsk(id) {
            this.$confirm.require({
                message: this.$t('vendor.delete_confirm_vendor'),
                header: this.$t('basic.confirmation'),
                icon: 'fa fa-circle-exclamation',
                accept: () => {
                    this.deleteVendor(id)
                },
            })
        },
    },
}
