import AccountMixin from './accounts'
export default {
    mixins: [AccountMixin],
    data() {
        return {
            transactionCategories: [],
            customers: [],
            suppliers: [],
            category: {
                id: '',
                name: '',
                description: '',
                module: 'transaction',
                icon: '',
                color: '',
            },
            transactions: [],
            transaction: {
                name: '',
                amount: 0,
                type: 'income',
                date: new Date().toISOString().substr(0, 10),
                invoice_id: null,
                payment_id: null,
                bill_id: null,
                customer_id: null,
                supplier_id: null,
                account_id: null,
                number: '',
                currency: '',
                category_id: '',
                description: '',
                payment_method: '',
                reference: '',
                reference_online_payment: '',
                from_account: null,
                to_account: null,
            },
        }
    },

    methods: {
        /**
         * Get all transactions
         * @returns {array} transactions
         */
        getTransactions() {
            this.makeHttpRequest('GET', '/api/transactions').then((response) => {
                this.transactions = response.data.data
            })
        },

        /**
         * Get transaction by id
         * @param {string} id  uuid of transaction
         * @returns {object}  transaction object
         **/
        getTransaction(id) {
            this.makeHttpRequest('GET', '/api/transactions/' + id)
                .then((response) => {
                    this.transaction = response.data.data
                })
                .catch((error) => {
                    if (error.response.status === 404) {
                        this.showToast(this.$t('errors.not_found_item'), '', 'error')
                        this.$router.push({ name: 'transactions' })
                    }
                })
        },

        /**
         * Create new transaction
         * @returns {void} return response
         **/
        saveTransaction() {
            this.makeHttpRequest('POST', '/api/transactions', this.transaction).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'transactions' })
            })
        },

        /**
         * Update transaction
         * @returns {void} return response
         **/
        updateTransaction() {
            this.makeHttpRequest('PUT', '/api/transactions/' + this.transaction.id, this.transaction).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'transaction-view', params: { id: this.transaction.id } })
            })
        },

        /**
         * Delete transaction
         * @param {string} id  uuid of transaction
         * @returns {void}  return response
         **/
        deleteTransaction(id) {
            this.makeHttpRequest('DELETE', '/api/transactions/' + id).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'transactions' })
            })
        },

        /**
         * Delete transaction confirmation
         * @param {string} id uuid of transaction
         * @returns {void} return response
         **/
        deleteTransactionAsk(id) {
            this.confirmDeleteDialog(this.$t('transaction.delete_confirm_transaction'), this.$t('basic.confirmation'), () => {
                this.deleteTransaction(id)
            })
        },

        /**
         * Get new transaction number
         * @returns {string}  return transaction number
         **/
        getTransactionNumber() {
            this.makeHttpRequest('GET', '/api/transaction/number').then((response) => {
                this.transaction.number = response.data.data
            })
        },

        /**
         * Get transaction categories
         * @returns {array}  return transaction categories
         * */
        getTransactionCategories() {
            this.getCategories('transaction').then((response) => {
                this.transactionCategories = response
            })
        },

        /**
         * Get customers
         * @returns {array}  return customers
         * */
        getCustomers() {
            this.makeHttpRequest('GET', '/api/partner/limited?type=customer,both').then((response) => {
                this.customers = response.data.data
            })
        },

        /**
         * Get suppliers
         * @returns {array}  return suppliers
         * */
        getSuppliers() {
            this.makeHttpRequest('GET', '/api/partner/limited?type=supplier,both').then((response) => {
                this.suppliers = response.data.data
            })
        },
    },
}
