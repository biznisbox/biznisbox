export default {
    data() {
        return {
            customers: [],
            customer: {
                id: '',
                name: '',
                number: '',
                type: '',
                vat_number: '',
                language: '',
                website: '',
                email: '',
                phone: '',
                notes: '',
                estimates: [],
                invoices: [],
                transactions: [],
                addresses: [
                    {
                        address: '',
                        city: '',
                        state: '',
                        zip_code: '',
                        country: null,
                        type: 'billing',
                    },
                    {
                        address: '',
                        city: '',
                        state: '',
                        zip_code: '',
                        country: null,
                        type: 'shipping',
                    },
                ],
            },
        }
    },

    methods: {
        /**
         * Get all customers
         * @returns {array} customers
         **/
        getCustomers() {
            this.makeHttpRequest('GET', '/api/customers').then((response) => {
                this.customers = response.data.data
            })
        },

        /**
         * Get customer by ID
         * @param {string} id
         * @returns {object} customer
         **/
        getCustomer(id) {
            this.makeHttpRequest('GET', '/api/customers/' + id)
                .then((response) => {
                    this.customer = response.data.data
                })
                .catch((error) => {
                    if (error.response.status === 404) {
                        this.showToast(this.$t('errors.not_found_item'), '', 'error')
                        this.$router.push({ name: 'customers' })
                    }
                })
        },

        /**
         * Save customer
         * @returns {void} return response
         **/
        saveCustomer() {
            this.makeHttpRequest('POST', '/api/customers', this.customer).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'customers' })
            })
        },

        /**
         * Update customer by ID
         * @param {string} id uuid of customer
         * @returns {void} return response
         **/
        updateCustomer(id) {
            this.makeHttpRequest('PUT', '/api/customers/' + id, this.customer).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'view-customer', params: { id: id } })
            })
        },

        /**
         * Delete customer by ID
         * @param {string} id uuid of customer
         * @returns {void} return response
         **/
        deleteCustomer(id) {
            this.makeHttpRequest('DELETE', '/api/customers/' + id).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'customers' })
            })
        },

        /**
         * Ask for confirmation before deleting customer
         * @param {string} id uuid of customer
         * @returns {void} return response
         **/
        deleteCustomerAsk(id) {
            this.$confirm.require({
                message: this.$t('customer.delete_confirm_customer'),
                header: this.$t('basic.confirmation'),
                icon: 'fa fa-circle-exclamation',
                accept: () => {
                    this.deleteCustomer(id)
                },
            })
        },

        /**
         * Add new address in table
         * @returns {void} add new address in table
         **/
        addContact() {
            this.customer.contacts.push({
                name: '',
                email: '',
                phone: '',
                function: '',
                notes: '',
            })
        },

        /**
         * Remove address from table
         * @param {number} index of address
         * @returns {void} remove address from table
         */
        removeContact(index) {
            this.customer.contacts.splice(index, 1)
        },

        getCustomerNumber() {
            this.makeHttpRequest('GET', '/api/customer/customer_number').then((response) => {
                this.customer.number = response.data.data
            })
        },
    },
}
