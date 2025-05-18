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
                id: '',
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
                activities: [],
            },
            activity: {
                partner_id: null,
                partner_contact_id: null,
                type: 'meeting',
                subject: '',
                location: '',
                content: '',
                start_date: null,
                end_date: null,
                status: 'planned',
                priority: 'normal',
                notes: '',
                outcome: '',
            },
            partner_email_message: {
                partner_contact_id: null,
                subject: '',
                content: '',
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
            this.confirmDeleteDialog(this.$t('partner.delete_confirm_partner'), this.$t('basic.confirmation'), () => {
                this.deletePartner(id)
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

        /**
         * Add partner activity
         * @return {void}
         */
        addPartnerActivity() {
            this.activity.partner_id = this.partner.id // set partner id
            this.makeHttpRequest('POST', '/api/partners/activity', this.activity).then((response) => {
                this.showToast(response.data.message)
                this.showAddEditActivityDialog = false
                this.getPartner(this.partner.id)
            })
        },

        /**
         * Update partner activity
         * @return {void}
         */
        updatePartnerActivity() {
            this.makeHttpRequest('PUT', '/api/partners/activity/' + this.activity.id, this.activity).then((response) => {
                this.showToast(response.data.message)
                this.getPartner(this.partner.id)
                this.showAddEditActivityDialog = false
            })
        },

        /**
         * Delete partner activity
         * @return {void}
         */

        deletePartnerActivity(id) {
            this.makeHttpRequest('DELETE', '/api/partners/activity/' + id).then((response) => {
                this.showToast(response.data.message)
                this.showAddEditActivityDialog = false
                this.getPartner(this.partner.id)
            })
        },

        /**
         * Send email to partner
         * @return {void}
         */
        sendEmailToPartner() {
            this.makeHttpRequest('POST', '/api/partner/message', this.partner_email_message).then((response) => {
                this.showToast(response.data.message)
                this.showSendEmailDialog = false
            })
        },

        /**
         * Add partner to client portal
         */
        addContactToClientPortal(partner_data) {
            this.makeHttpRequest('POST', '/api/partner/client-portal/' + partner_data.id).then((response) => {
                this.showToast(response.data.message)
                this.getPartner(this.partner.id)
            })
        },
    },
}
