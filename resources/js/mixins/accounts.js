export default {
    data() {
        return {
            accounts: [],
            account: {
                name: '',
                type: '',
                currency: 'EUR',
                description: '',
                opening_balance: 0,
                current_balance: 0,
                bank_name: '',
                bank_address: '',
                bank_contact: '',
                iban: '',
                swift: '',
                account_number: '',
                is_default: false,
                is_enabled: true,
                integration: '',
            },
        }
    },

    methods: {
        /**
         * Get all accounts
         * @return {void} return accounts
         **/
        getAccounts() {
            this.makeHttpRequest('GET', '/api/accounts').then((response) => {
                this.accounts = response.data.data
            })
        },

        /**
         * Get account
         * @param {string} id UUID of account
         * @return {void} return account
         **/
        getAccount(id) {
            this.makeHttpRequest('GET', `/api/accounts/${id}`)
                .then((response) => {
                    this.account = response.data.data
                })
                .catch((error) => {
                    if (error.response.status === 404) {
                        this.showToast(this.$t('errors.not_found_item'), '', 'error')
                        this.$router.push({ name: 'accounts' })
                    }
                })
        },

        /**
         * Save account
         * @return {void} show toast and redirect to accounts
         */
        saveAccount() {
            this.makeHttpRequest('POST', '/api/accounts', this.account).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'accounts' })
            })
        },

        /**
         * Update account
         * @param {string} id UUID of account
         */
        updateAccount(id) {
            this.makeHttpRequest('PUT', `/api/accounts/${id}`, this.account).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'accounts' })
            })
        },

        /**
         * Delete account
         * @param {string} id UUID of account
         * @return {void} show toast and redirect to accounts
         */
        deleteAccount(id) {
            this.makeHttpRequest('DELETE', `/api/accounts/${id}`).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'accounts' })
            })
        },

        /**
         * Show confirmation dialog before delete account
         * @param {string} id UUID of account
         * @return {void} show toast and redirect to accounts
         */
        deleteAccountAsk(id) {
            this.$confirm.require({
                message: this.$t('account.delete_confirm_account'),
                header: this.$t('basic.confirmation'),
                icon: 'fa fa-circle-exclamation',
                accept: () => {
                    this.deleteAccount(id)
                },
            })
        },
    },
}
