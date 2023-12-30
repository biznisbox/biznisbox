import productsMixin from './products'
export default {
    mixins: [productsMixin],
    data() {
        return {
            invoices: [],
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
                        discount: 0,
                        total: 0,
                    },
                ],
                currency: 'EUR',
                currency_rate: 1,
                payment_method: '',
                notes: '',
                discount: 0,
                discount_type: 'percentage', // 'percentage' or 'fixed
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
        saveInvoice() {
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
                this.$router.push({ name: 'view-invoice', params: { id: id } })
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
            this.$confirm.require({
                message: this.$t('invoice.delete_confirm_invoice'),
                header: this.$t('basic.confirmation'),
                icon: 'fa fa-circle-exclamation',
                accept: () => {
                    this.deleteInvoice(id)
                },
            })
        },

        /**
         * Get new invoice number
         * @returns {string} number new invoice number
         **/
        getInvoiceNumber() {
            this.makeHttpRequest('GET', '/api/invoice/invoice_number').then((response) => {
                this.invoice.number = response.data.data
            })
        },

        /**
         * Get share url
         * @param {string} id uuid of invoice
         * @returns {string} share url
         **/
        shareInvoice(id) {
            this.makeHttpRequest('GET', '/api/invoice/share/' + id, null, null, null, false).then((response) => {
                this.shareUrl = response.data.data
                this.shareDialog = true
            })
        },

        /**
         * Get partners
         * @returns {array} partners
         **/

        getPartners() {
            this.makeHttpRequest('GET', '/api/partners_list?type=both,customers').then((response) => {
                this.partners = response.data.data
            })
        },
    },
}
