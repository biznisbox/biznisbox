import productsMixin from './products'
export default {
    mixins: [productsMixin],
    data() {
        return {
            invoices: [],
            paymentMethods: [],
            shareUrl: '',
            partners: [],
            customerAddresses: [],
            payerAddresses: [],
            invoice: {
                sales_person_id: null,
                sales_person: '',
                number: '',
                date: '',
                due_date: '',
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
                        tax_type: 'percent', // percent, fixed
                        discount: 0,
                        discount_type: 'percent', // percent, fixed
                        total: 0,
                    },
                ],
                currency: 'EUR',
                currency_rate: 1,
                payment_method_id: null,
                payment_method: {},
                notes: '',
                discount: 0,
                discount_type: 'percent', // percent, fixed
                tax: '',
                total: 0.0,
            },
        }
    },

    methods: {
        /**
         * Get all invoices
         * @returns {array} invoices
         */
        getInvoices() {
            this.makeHttpRequest('GET', '/api/invoices').then((response) => {
                this.invoices = response.data.data
            })
        },

        /**
         * Get invoice by id
         * @param {string} id uuid of invoice
         * @returns {object}  invoice object
         **/
        getInvoice(id) {
            this.makeHttpRequest('GET', '/api/invoices/' + id)
                .then((response) => {
                    this.invoice = response.data.data
                })
                .catch((error) => {
                    if (error.response.status === 404) {
                        this.showToast(this.$t('errors.not_found_item'), '', 'error')
                        this.$router.push({ name: 'invoices' })
                    }
                })
        },

        /**
         * Create new invoice
         * @returns {void} redirect to invoices page
         **/
        createInvoice() {
            this.makeHttpRequest('POST', '/api/invoices', this.invoice).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'invoices' })
            })
        },

        /**
         * Update invoice
         * @param {string} id uuid of invoice
         * @returns {void} redirect to invoice page
         **/
        updateInvoice(id) {
            this.makeHttpRequest('PUT', '/api/invoices/' + id, this.invoice).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'invoice-view', params: { id: id } })
            })
        },

        /**
         * Delete invoice
         * @param {string} id uuid of invoice
         * @returns {void} redirect to invoices page
         **/
        deleteInvoice(id) {
            this.makeHttpRequest('DELETE', '/api/invoices/' + id).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'invoices' })
            })
        },

        /**
         * Delete invoice confirmation
         * @param {string} id uuid of invoice
         * @returns {void} confirmation dialog
         **/
        deleteInvoiceAsk(id) {
            this.confirmDeleteDialog(this.$t('invoice.delete_confirm_invoice'), this.$t('basic.confirmation'), () => {
                this.deleteInvoice(id)
            })
        },

        /**
         * Get new invoice number
         * @returns {string} number new invoice number
         **/
        getInvoiceNumber() {
            this.makeHttpRequest('GET', '/api/invoice/number').then((response) => {
                this.invoice.number = response.data.data
            })
        },

        /**
         * Get share url
         * @param {string} id uuid of invoice
         * @returns {string} share url
         **/
        shareInvoice(id) {
            this.makeHttpRequest('GET', `/api/invoice/${id}/share`, null, null, null, false).then((response) => {
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
         * Send invoice by email
         * @param {UUID} id uuid of invoice
         */
        sendInvoiceNotification(id) {
            this.makeHttpRequest('POST', `/api/invoice/${id}/send`, null, null, null, false).then((response) => {
                this.showToast(response.data.message)
            })
        },

        /**
         * Get payment methods
         * @returns {array} payment methods
         */
        getPaymentMethods() {
            this.getCategories('payment_methods').then((response) => {
                this.paymentMethods = response
            })
        },
    },
}
