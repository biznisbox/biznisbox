import productsMixin from './products'
export default {
    mixins: [productsMixin],
    data() {
        return {
            quotes: [],
            shareUrl: '',
            partners: [],
            payerAddresses: [],
            customerAddresses: [],
            quote: {
                number: '',
                date: '',
                valid_until: '',
                customer_id: null,
                customer_name: '',
                customer_address_id: null,
                customer_address: '',
                customer_zip_code: '',
                customer_city: '',
                customer_country: '',
                payer_id: null,
                payer_name: '',
                payer_address_id: null,
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
                currency_rate: 1,
                notes: '',
                sales_person_id: '',
                payment_method: '',
                discount: 0,
                discount_type: 'percent', // percent or fixed
                tax: '',
                total: 0.0,
                footer: '',
            },
        }
    },
    methods: {
        /**
         * Get all quotes
         * @returns {array} quotes
         */
        getQuotes() {
            this.makeHttpRequest('GET', '/api/quotes').then((response) => {
                this.quotes = response.data.data
            })
        },

        /**
         * Get quote by id
         * @param {string} id uuid of quote
         * @returns {object} quote quote object
         **/
        getQuote(id) {
            this.makeHttpRequest('GET', '/api/quotes/' + id)
                .then((response) => {
                    this.quote = response.data.data
                })
                .catch((error) => {
                    if (error.response.status === 404) {
                        this.showToast(this.$t('errors.not_found_item'), '', 'error')
                        this.$router.push({ name: 'quotes' })
                    }
                })
        },

        /**
         * Create new quote
         * @returns {void} show toast and redirect to quotes
         **/
        createQuote() {
            this.makeHttpRequest('POST', '/api/quotes', this.quote).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'quotes' })
            })
        },

        /**
         * Update quote
         * @param {string} id uuid of quote
         * @returns {void} show toast and redirect to quotes
         **/
        updateQuote(id) {
            this.makeHttpRequest('PUT', '/api/quotes/' + id, this.quote).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'quote-view', params: { id: id } })
            })
        },

        /**
         * Delete quote
         * @param {string} id  uuid of quote
         * @returns {void} show toast and redirect to quotes
         **/
        deleteQuote(id) {
            this.makeHttpRequest('DELETE', '/api/quotes/' + id).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'quotes' })
            })
        },

        /**
         * Delete quote confirmation
         * @param {string} id  uuid of quote
         * @returns {void}
         **/
        deleteQuoteAsk(id) {
            this.confirmDeleteDialog(this.$t('quote.delete_confirm_quote'), this.$t('basic.confirmation'), () => {
                this.deleteQuote(id)
            })
        },

        /**
         * Get quote number for new quote
         * @returns {void} quote number
         **/
        getQuoteNumber() {
            this.makeHttpRequest('GET', '/api/quote/number').then((response) => {
                this.quote.number = response.data.data
            })
        },

        /**
         * Convert quote to invoice
         * @param {string} id uuid of quote
         * @returns {void}
         **/
        convertQuoteToInvoice(id) {
            this.makeHttpRequest('GET', '/api/quote/convert/' + id, '', '', '', false).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'invoice-view', params: { id: response.data.data } })
            })
        },

        /**
         * Get quote share url
         * @param {string} id uuid of quote
         * @returns {void}
         **/
        shareQuote(id) {
            this.makeHttpRequest('GET', '/api/quote/share/' + id, '', '', '', false).then((response) => {
                this.shareUrl = response.data.data
                this.shareDialog = true
            })
        },

        /**
         * Get partners
         * @returns {array} partners
         **/
        getPartners() {
            this.makeHttpRequest('GET', '/api/partner/limited?type=customer,both').then((response) => {
                this.partners = response.data.data
            })
        },

        /**
         * Send quote notification
         */
        sendQuoteNotification(id) {
            this.makeHttpRequest('POST', `/api/quote/${id}/send`, null, null, null, false).then((response) => {
                this.showToast(response.data.message)
            })
        },
    },
}
