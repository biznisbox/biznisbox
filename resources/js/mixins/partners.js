export default {
    data() {
        return {
            partners: [],
            industries: [
                { value: 'agriculture', name: this.$t('industries.agriculture') },
                { value: 'automotive', name: this.$t('industries.automotive') },
                { value: 'banking', name: this.$t('industries.banking') },
                { value: 'construction', name: this.$t('industries.construction') },
                { value: 'consulting', name: this.$t('industries.consulting') },
                { value: 'education', name: this.$t('industries.education') },
                { value: 'engineering', name: this.$t('industries.engineering') },
                { value: 'entertainment', name: this.$t('industries.entertainment') },
                { value: 'finance', name: this.$t('industries.finance') },
                { value: 'food', name: this.$t('industries.food') },
                { value: 'government', name: this.$t('industries.government') },
                { value: 'healthcare', name: this.$t('industries.healthcare') },
                { value: 'hospitality', name: this.$t('industries.hospitality') },
                { value: 'insurance', name: this.$t('industries.insurance') },
                { value: 'legal', name: this.$t('industries.legal') },
                { value: 'manufacturing', name: this.$t('industries.manufacturing') },
                { value: 'media', name: this.$t('industries.media') },
                { value: 'nonprofit', name: this.$t('industries.nonprofit') },
                { value: 'recreation', name: this.$t('industries.recreation') },
                { value: 'shipping', name: this.$t('industries.shipping') },
                { value: 'IT', name: this.$t('industries.IT') },
                { value: 'technology', name: this.$t('industries.technology') },
                { value: 'telecommunications', name: this.$t('industries.telecommunications') },
                { value: 'transportation', name: this.$t('industries.transportation') },
                { value: 'utilities', name: this.$t('industries.utilities') },
                { value: 'other', name: this.$t('industries.other') },
            ],
            partner: {
                number: '',
                name: '',
                type: '',
                entity_type: '',
                vat_number: '',
                language: null,
                currency: '',
                size: null,
                website: '',
                addresses: [],
                contacts: [],
                notes: '',
                invoices: [],
                quotes: [],
                transactions: [],
                bills: [],
            },
        }
    },

    methods: {
        /**
         * Get all partners
         * @return {void}
         */
        getPartners() {
            this.makeHttpRequest('GET', '/api/partners').then((response) => {
                this.partners = response.data.data
            })
        },

        /**
         * Get partner by id
         * @param  {uuid} id
         * @return {void}
         */
        getPartner(id) {
            this.makeHttpRequest('GET', '/api/partners/' + id).then((response) => {
                this.partner = response.data.data
            })
        },

        /**
         * Create a new partner
         * @param  {object} partner
         * @return {void}
         */
        createPartner() {
            this.makeHttpRequest('POST', '/api/partners', this.partner).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'partners' })
            })
        },

        /**
         * Update partner by id
         * @param  {uuid} id
         * @return {void}
         */
        updatePartner(id) {
            this.makeHttpRequest('PUT', '/api/partners/' + id, this.partner).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'partner-view', params: { id: id } })
            })
        },

        /**
         * Delete partner by id
         * @param  {uuid} id
         * @return {void}
         */
        deletePartner(id) {
            this.makeHttpRequest('DELETE', '/api/partners/' + id).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'partners' })
            })
        },

        /**
         * Delete partner ask confirmation
         * @param  {uuid} id
         * @return {void}
         */
        deletePartnerAsk(id) {
            this.$confirm.require({
                message: this.$t('partner.delete_confirm_partner'),
                header: this.$t('basic.confirmation'),
                icon: 'fa fa-circle-exclamation',
                accept: () => {
                    this.deletePartner(id)
                },
            })
        },

        /**
         * Get next partner number
         * @return {void}
         */
        getNextPartnerNumber() {
            this.makeHttpRequest('GET', '/api/partner/number').then((response) => {
                this.partner.number = response.data.data
            })
        },
    },
}
