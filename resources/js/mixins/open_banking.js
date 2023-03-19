export default {
    data() {
        return {
            banks: [],
            accounts: [],
            app_accounts: [],
            account: null,
        }
    },

    methods: {
        getBanks(country) {
            this.makeHttpRequest('GET', '/api/open_banking/banks', null, { country: country }).then((response) => {
                this.banks = response.data.data
            })
        },

        initSession(bank_id) {
            this.makeHttpRequest('POST', '/api/open_banking/init_session', { institution_id: bank_id }).then((response) => {
                window.location.href = response.data.data.link
            })
        },

        getRequisitions(id) {
            this.makeHttpRequest('POST', '/api/open_banking/get_requisition', { requisition_id: id }).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'open-banking' })
            })
        },

        getAccounts() {
            this.makeHttpRequest('GET', '/api/open_banking/accounts').then((response) => {
                this.accounts = response.data.data
            })
        },

        getAccount(id) {
            this.makeHttpRequest('GET', '/api/open_banking/accounts/' + id).then((response) => {
                this.account = response.data.data
            })
        },

        updateAccount(id) {
            this.makeHttpRequest('PUT', '/api/open_banking/accounts/' + id, this.account?.internal_data).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'open-banking' })
            })
        },

        getAppAccounts() {
            this.makeHttpRequest('GET', '/api/accounts').then((response) => {
                this.app_accounts = response.data.data
            })
        },
    },
}
