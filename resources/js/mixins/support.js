export default {
    data() {
        return {
            supportTickets: [],
            supportTicket: {
                id: '',
                custom_contact: false,
                assignee_id: null,
                partner_id: null,
                contact_id: null,
                category_id: null,
                department_id: null,
                number: '',
                subject: '',
                is_internal: false,
                status: 'open', // open, pending, resolved, closed
                priority: 'normal', // low, normal, high, urgent
                type: 'ticket',
                source: 'manual', // manual, email, phone, chat, web
                notes: '',
                contact_name: '',
                contact_email: '',
                contact_phone_number: '',
                content: [
                    {
                        id: '',
                        message: '',
                        attachment: '',
                        type: 'message', // message, note
                        status: null, // sent, received, read, replied, forwarded
                    },
                ],
            },
            supportTicketMessage: {
                id: '',
                message: '',
                attachment: '',
                type: 'message', // message, note
                status: null, // sent, received, read, replied, forwarded
            },
            supportTicketCategories: [],
            partners: [], // customers or suppliers or both
            shareUrl: '',
        }
    },

    methods: {
        /**
         * Get support tickets
         * @returns {void}
         */
        getSupportTickets() {
            this.makeHttpRequest('GET', '/api/support-tickets').then((response) => {
                this.supportTickets = response.data.data
            })
        },

        /**
         * Get support ticket
         * @param {string} id uuid of support ticket
         * @returns {void}
         */
        getSupportTicket(id) {
            this.makeHttpRequest('GET', '/api/support-tickets/' + id)
                .then((response) => {
                    this.supportTicket = response.data.data
                })
                .catch((error) => {
                    if (error.response.status === 404) {
                        this.showToast(this.$t('errors.not_found_item'), '', 'error')
                        this.$router.push({ name: 'support-tickets' })
                    }
                })
        },

        /**
         * Get support ticket categories
         * @returns {void}
         */
        getSupportTicketCategories() {
            this.makeHttpRequest('GET', '/api/categories?module=support_ticket').then((response) => {
                this.supportTicketCategories = response.data.data
            })
        },

        /**
         * Get new support ticket number
         * @returns {void}
         */
        getSupportTicketNumber() {
            this.makeHttpRequest('GET', '/api/support-ticket/number').then((response) => {
                this.supportTicket.number = response.data.data
            })
        },

        /**
         * Update support ticket
         * @returns {void}
         */
        updateSupportTicket() {
            this.makeHttpRequest('PUT', '/api/support-tickets/' + this.supportTicket.id, this.supportTicket).then((response) => {
                this.showToast(response.data.message)
            })
        },

        /**
         * Create support ticket
         * @returns {void}
         */
        createSupportTicket() {
            this.makeHttpRequest('POST', '/api/support-tickets', this.supportTicket).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'support-ticket-view', params: { id: response.data.data.id } })
            })
        },

        /**
         * Delete support ticket
         * @param {string} id uuid of support ticket
         * @returns {void}
         */
        deleteSupportTicket(id) {
            this.makeHttpRequest('DELETE', '/api/support-tickets/' + id).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'support-tickets' })
            })
        },

        /**
         * Delete support ticket ask
         * @param {string} id uuid of support ticket
         * @returns {void}
         */
        deleteSupportTicketAsk(id) {
            this.confirmDeleteDialog(this.$t('support.delete_confirm_ticket'), this.$t('basic.confirmation'), () => {
                this.deleteSupportTicket(id)
            })
        },

        /**
         * Get support ticket messages
         * @returns {void}
         */
        getSupportTicketMessages() {
            this.makeHttpRequest('GET', '/api/support-tickets/messages/' + this.supportTicket.id).then((response) => {
                this.supportTicket.content = response.data.data
            })
        },

        /**
         * Create support ticket message
         * @returns {void}
         */
        createTicketMessage() {
            if (this.supportTicketMessage.message === '' && this.supportTicketMessage.attachment === '') {
                return this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
            }
            this.makeHttpRequest('POST', `/api/support-tickets/${this.supportTicket.id}/messages`, this.supportTicketMessage).then(
                (response) => {
                    this.supportTicketMessage = {
                        id: '',
                        message: '',
                        attachment: '',
                        type: 'message',
                        status: null,
                    }
                    this.showToast(response.data.message)
                    this.supportTicket = response.data.data
                }
            )
        },

        /**
         * Update support ticket message
         * @returns {void}
         */
        updateSupportTicketMessage() {
            this.makeHttpRequest('PUT', '/api/support-tickets/messages/' + this.supportTicket.id, this.supportTicket).then((response) => {
                this.supportTicket = response.data.data
            })
        },

        /**
         * Delete support ticket message
         * @param {string} id uuid of support ticket message
         * @returns {void}
         */
        deleteSupportTicketMessage(id) {
            this.makeHttpRequest('DELETE', '/api/support-tickets/messages/' + id).then((response) => {
                this.showToast(response.data.message)
                this.getSupportTicket(this.supportTicket.id)
            })
        },

        /**
         * Share support ticket
         * @param {string} id uuid of support ticket
         * @returns {void} - open share dialog with url
         */
        shareSupportTicket(id) {
            this.makeHttpRequest('GET', '/api/support-ticket/share/' + id, null, null, null, false).then((response) => {
                this.shareUrl = response.data.data
                this.shareDialog = true
            })
        },

        /**
         * Delete support ticket message ask
         * @param {string} id uuid of support ticket message
         * @returns {void} - open delete confirmation dialog
         */
        deleteSupportTicketMessageAsk(id) {
            this.$confirm.require({
                message: this.$t('support.delete_confirm_message'),
                header: this.$t('basic.confirmation'),
                icon: 'fa fa-circle-exclamation',
                accept: () => {
                    this.deleteSupportTicketMessage(id)
                },
            })
        },

        /**
         * Mark support ticket as resolved
         * @returns {void}
         */
        markSupportTicketAsResolved() {
            this.supportTicket.status = 'resolved'
            this.updateSupportTicket().then(() => {
                this.supportTicket = this.getSupportTicket(this.supportTicket.id)
            })
        },

        /**
         * Mark support ticket as closed
         * @returns {void}
         */
        markSupportTicketAsClosed() {
            this.supportTicket.status = 'closed'
            this.updateSupportTicket().then(() => {
                this.supportTicket = this.getSupportTicket(this.supportTicket.id)
            })
        },

        /**
         * Mark support ticket as reopened
         * @returns {void}
         */
        markSupportTicketAsReopened() {
            this.supportTicket.status = 'reopened'
            this.updateSupportTicket().then(() => {
                this.supportTicket = this.getSupportTicket(this.supportTicket.id)
            })
        },

        getPartners() {
            this.makeHttpRequest('GET', '/api/partner/limited?type=customer,both,supplier').then((response) => {
                this.partners = response.data.data
            })
        },
    },
}
