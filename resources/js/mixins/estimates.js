import customers from './customers'
import products from './products'

export default {
    mixins: [customers, products],
    data() {
        return {
            estimates: [],
            shareUrl: '',
            estimate: {
                number: '',
                date: '',
                valid_until: '',
                customer_id: null,
                customer_name: '',
                customer_address: '',
                customer_zip_code: '',
                customer_city: '',
                customer_country: '',
                payer_id: null,
                payer_name: '',
                payer_address: '',
                payer_zip_code: '',
                payer_city: '',
                payer_country: '',
                status: 'draft',
                items: [
                    {
                        product_id: '',
                        type: '',
                        item: '',
                        name: '',
                        description: '',
                        quantity: 1,
                        unit: '',
                        price: 0,
                        tax: null,
                        discount: 0,
                        total: 0,
                    },
                ],
                currency: 'EUR',
                payment_method: '',
                terms: '',
                notes: '',
                discount: 0,
                discount_type: '',
                tax: '',
                total: 0.0,
            },
        }
    },
    methods: {
        /**
         * Get all estimates
         * @returns {array} estimates
         */
        getEstimates() {
            this.makeHttpRequest('GET', '/api/estimates').then((response) => {
                this.estimates = response.data.data
            })
        },

        /**
         * Get estimate by id
         * @param {string} id uuid of estimate
         * @returns {object} estimate estimate object
         **/
        getEstimate(id) {
            this.makeHttpRequest('GET', '/api/estimates/' + id)
                .then((response) => {
                    this.estimate = response.data.data
                })
                .catch((error) => {
                    if (error.response.status === 404) {
                        this.showToast(this.$t('errors.not_found_item'), '', 'error')
                        this.$router.push({ name: 'estimates' })
                    }
                })
        },

        /**
         * Create new estimate
         * @returns {void} show toast and redirect to estimates
         **/
        createEstimate() {
            this.makeHttpRequest('POST', '/api/estimates', this.estimate).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'estimates' })
            })
        },

        /**
         * Update estimate
         * @param {string} id uuid of estimate
         * @returns {void} show toast and redirect to estimates
         **/
        updateEstimate(id) {
            this.makeHttpRequest('PUT', '/api/estimates/' + id, this.estimate).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'view-estimate', params: { id: id } })
            })
        },

        /**
         * Delete estimate
         * @param {string} id  uuid of estimate
         * @returns {void} show toast and redirect to estimates
         **/
        deleteEstimate(id) {
            this.makeHttpRequest('DELETE', '/api/estimates/' + id).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'estimates' })
            })
        },

        /**
         * Delete estimate confirmation
         * @param {string} id  uuid of estimate
         * @returns {void}
         **/
        deleteEstimateAsk(id) {
            this.$confirm.require({
                message: this.$t('estimate.delete_confirm_estimate'),
                header: this.$t('basic.confirmation'),
                icon: 'fa fa-circle-exclamation',
                accept: () => {
                    this.deleteEstimate(id)
                },
            })
        },

        /**
         * Get estimate number for new estimate
         * @returns {void} estimate number
         **/
        getEstimateNumber() {
            this.makeHttpRequest('GET', '/api/estimate/estimate_number').then((response) => {
                this.estimate.number = response.data.data
            })
        },

        /**
         * Convert estimate to invoice
         * @param {string} id uuid of estimate
         * @returns {void}
         **/
        convertEstimateToInvoice(id) {
            this.makeHttpRequest('GET', '/api/estimate/convert/' + id, '', '', '', false).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'view-invoice', params: { id: response.data.data } })
            })
        },

        /**
         * Get estimate share url
         * @param {string} id uuid of estimate
         * @returns {void}
         **/
        shareEstimate(id) {
            this.makeHttpRequest('GET', '/api/estimate/share/' + id, '', '', '', false).then((response) => {
                this.shareUrl = response.data.data
                this.shareDialog = true
            })
        },

        /**
         * Send estimate by email
         * @param {string} id uuid of estimate
         * @returns {void}
         **/
        sendEstimate(id) {
            this.makeHttpRequest('POST', '/api/estimate/send/' + id, '', '', '', false).then((response) => {
                this.showToast(response.data.message)
            })
        },
    },
}
