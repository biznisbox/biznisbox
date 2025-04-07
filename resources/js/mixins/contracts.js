export default {
    data() {
        return {
            contracts: [],
            partners: [],
            contractTypes: [],
            shareUrl: '',
            contract: {
                partner_id: null,
                category_id: null,
                number: '',
                type: '',
                title: '',
                description: '',
                status: 'draft',
                content: '',
                start_date: '',
                end_date: '',
                signed_date: '',
                date_for_signature: '',
                notes: '',
                sha256: '',
                signers: [
                    {
                        user_id: null,
                        custom_signer: true,
                        signer_name: '',
                        signer_email: '',
                        signer_phone: '',
                        signer_notes: '',
                        status: 'waiting_signature',
                    },
                ],
            },
        }
    },

    created() {},

    methods: {
        /**
         * Save contract
         * @returns {void}
         */
        createContract() {
            this.makeHttpRequest('POST', '/api/contracts', this.contract).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'contracts' })
            })
        },

        /**
         * Get contract
         * @param {string} id uuid of contract
         * @returns {void}
         */
        getContract(id) {
            this.makeHttpRequest('GET', '/api/contracts/' + id)
                .then((response) => {
                    this.contract = response.data.data
                })
                .catch((error) => {
                    if (error.response.status === 404) {
                        this.$router.push({ name: 'contracts' })
                    }
                })
        },

        /**
         * Get all contracts
         * @returns {void}
         **/
        getContracts() {
            this.makeHttpRequest('GET', '/api/contracts').then((response) => {
                this.contracts = response.data.data
            })
        },

        /**
         * Update contract
         * @param {string} id uuid of contract
         * @returns {void}
         */
        updateContract(id) {
            this.makeHttpRequest('PUT', '/api/contracts/' + id, this.contract).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'contracts' })
            })
        },

        /**
         * Delete contract
         * @param {string} id uuid of contract
         * @returns {void}
         */
        deleteContract(id) {
            this.makeHttpRequest('DELETE', '/api/contracts/' + id).then((response) => {
                if (response.data.data.error == true) {
                    this.showToast(response.data.data.message, this.$t('basic.error'), 'error')
                    return
                }
                this.showToast(response.data.message)
                this.$router.push({ name: 'contracts' })
            })
        },

        /**
         * Ask for confirmation before deleting contract
         * @param {string} id  uuid of contract
         * @returns {void}
         */
        deleteContractAsk(id) {
            this.confirmDeleteDialog(this.$t('contract.delete_confirm_contract'), this.$t('basic.confirmation'), () => {
                this.deleteContract(id)
            })
        },

        /**
         * Get contract number
         * @returns {void}
         */
        getContractNumber() {
            this.makeHttpRequest('GET', '/api/contract/number').then((response) => {
                this.contract.number = response.data.data
            })
        },

        /**
         * Get partners
         * @returns {array} partners
         **/

        getPartners() {
            this.makeHttpRequest('GET', '/api/partner/limited').then((response) => {
                this.partners = response.data.data
            })
        },

        /**
         * Share contract
         */
        shareContract(id) {
            this.makeHttpRequest('POST', '/api/contract/' + id + '/share').then((response) => {
                this.shareUrl = response.data.data.url
                this.shareDialog = true
            })
        },

        getContractTypes() {
            this.getCategories('contract_types').then((response) => {
                this.contractTypes = response
            })
        },
    },
}
