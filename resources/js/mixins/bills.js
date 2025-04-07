export default {
    data() {
        return {
            bills: [],
            suppliers: [],
            products: [],
            supplierAddresses: [],
            paymentMethods: [],
            bill: {
                id: '',
                number: '',
                date: new Date().toISOString().substr(0, 10),
                due_date: '',
                supplier_id: null,
                supplier_address_id: null,
                supplier_address: '',
                supplier_city: '',
                supplier_zip_code: '',
                supplier_country: '',
                supplier_name: '',
                currency: 'EUR',
                currency_rate: 1,
                discount: 0,
                discount_type: 'percent',
                total: 0.0,
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
                        discount: 0,
                        discount_type: 'percent',
                        total: 0,
                    },
                ],
            },
        }
    },

    methods: {
        /**
         * Get all bills
         */
        getBills() {
            this.makeHttpRequest('GET', '/api/bills').then((response) => {
                this.bills = response.data.data
            })
        },

        /**
         * Get bill
         * @param {string} id UUID of bill
         */
        getBill(id) {
            this.makeHttpRequest('GET', '/api/bills/' + id)
                .then((response) => {
                    this.bill = response.data.data
                })
                .catch((error) => {
                    if (error.response.status === 404) {
                        this.showToast(this.$t('errors.not_found_item'), '', 'error')
                        this.$router.push({ name: 'bills' })
                    }
                })
        },

        /**
         * Save bill
         * @return {void} show toast and redirect to bills
         */
        createBill() {
            this.makeHttpRequest('POST', '/api/bills', this.bill).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'bills' })
            })
        },

        /**
         * Update bill
         * @param {string} id UUID of bill
         * @return {void} show toast and redirect to bills
         */
        updateBill() {
            this.makeHttpRequest('PUT', '/api/bills/' + this.bill.id, this.bill).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'bills' })
            })
        },

        /**
         * Delete bill
         * @param {string} id UUID of bill
         * @return {void} show toast and redirect to bills
         */
        deleteBill(id) {
            this.makeHttpRequest('DELETE', '/api/bills/' + id).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'bills' })
            })
        },

        /**
         * Show confirmation dialog before delete bill
         * @param {string} id UUID of bill
         * @return {void} delete bill
         */
        deleteBillAsk(id) {
            this.confirmDeleteDialog(this.$t('bill.delete_confirm_bill'), this.$t('basic.confirmation'), () => {
                this.deleteBill(id)
            })
        },

        /**
         * Get suppliers
         * @return {void} set suppliers
         */
        getSuppliers() {
            this.makeHttpRequest('GET', '/api/partner/limited?type=both,supplier').then((response) => {
                this.suppliers = response.data.data
            })
        },

        /**
         * Get products
         * @return {void} set products
         */
        getProducts() {
            this.makeHttpRequest('GET', '/api/data?type=products').then((response) => {
                this.products = response.data.data
            })
        },

        /**
         * Get next bill number
         * @return {void} set bill number
         */
        getBillNumber() {
            this.makeHttpRequest('GET', '/api/bill/number').then((response) => {
                this.bill.number = response.data.data
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
