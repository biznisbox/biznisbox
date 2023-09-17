export default {
    data() {
        return {
            partners: [],
            partner: {
                number: '',
                name: '',
                type: '',
                entity_type: '',
                vat_number: '',
                language: '',
                currency: '',
                size: '',
                website: '',
                addresses: [],
                contacts: [],
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
                this.$router.push({ name: 'view-partner', params: { id: id } })
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
         * Get next partner number
         * @return {void}
         */
        getNextPartnerNumber() {
            this.makeHttpRequest('GET', '/api/partner/partner_number').then((response) => {
                this.partner.number = response.data.data
            })
        },
    },
}
