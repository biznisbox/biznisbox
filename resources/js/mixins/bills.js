export default {
    data() {
        return {
            bills: [],
            vendors: [],
            products: [],
            bill: {
                number: '',
                date: '',
                due_date: '',
                vendor_id: '',
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
                        total: 0,
                    },
                ],
                currency: 'EUR',
                discount: 0,
                discount_type: '',
                total: 0.0,
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
                this.showToast(response.data.message, '', 'success')
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
                this.showToast(response.data.message, '', 'success')
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
                this.showToast(response.data.message, '', 'success')
                this.$router.push({ name: 'bills' })
            })
        },

        /**
         * Show confirmation dialog before delete bill
         * @param {string} id UUID of bill
         * @return {void} delete bill
         */
        deleteBillAsk(id) {
            this.$confirm.require({
                message: this.$t('bill.delete_confirm_bill'),
                header: this.$t('basic.confirmation'),
                icon: 'fa fa-circle-exclamation',
                accept: () => {
                    this.deleteBill(id)
                },
            })
        },

        getVendors() {
            this.makeHttpRequest('GET', '/api/vendors').then((response) => {
                this.vendors = response.data.data
            })
        },

        getProducts() {
            this.makeHttpRequest('GET', '/api/products').then((response) => {
                this.products = response.data.data
            })
        },

        /**
         * Get next bill number
         * @return {void} set bill number
         */
        getBillNumber() {
            this.makeHttpRequest('GET', '/api/bill/bill_number').then((response) => {
                this.bill.number = response.data.data
            })
        },
    },
}
