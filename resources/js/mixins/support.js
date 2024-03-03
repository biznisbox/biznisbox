export default {
    data() {
        return {
            supportTickets: [],
            supportTicket: {
                id: '',
                assignee_id: null,
                partner_id: null,
                category_id: null,
                department_id: null,
                number: '',
                subject: '',
                status: 'open', // open, pending, resolved, closed
                priority: 'normal', // low, normal, high, urgent
                type: 'ticket',
                source: 'manual', // manual, email, phone, chat, web
                notes: '',
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
            this.makeHttpRequest('GET', '/api/support_tickets').then((response) => {
                this.supportTickets = response.data.data
            })
        },

        /**
         * Get support ticket
         * @param {string} id uuid of support ticket
         * @returns {void}
         */
        getSupportTicket(id) {
            this.makeHttpRequest('GET', '/api/support_tickets/' + id)
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
            this.makeHttpRequest('GET', '/api/support_ticket/number').then((response) => {
                this.supportTicket.number = response.data.data
            })
        },

        updateSupportTicket() {
            this.makeHttpRequest('PUT', '/api/support_tickets/' + this.supportTicket.id, this.supportTicket).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'view-support-ticket', params: { id: this.supportTicket.id } })
            })
        },

        createSupportTicket() {
            this.makeHttpRequest('POST', '/api/support_tickets', this.supportTicket).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'view-support-ticket', params: { id: response.data.data.id } })
            })
        },

        deleteSupportTicket(id) {
            this.makeHttpRequest('DELETE', '/api/support_tickets/' + id).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'support-tickets' })
            })
        },

        deleteSupportTicketAsk(id) {
            this.$confirm.require({
                message: this.$t('support.delete_confirm_ticket'),
                header: this.$t('basic.confirmation'),
                icon: 'fa fa-circle-exclamation',
                accept: () => {
                    this.deleteSupportTicket(id)
                },
            })
        },

        getSupportTicketMessages() {
            this.makeHttpRequest('GET', '/api/support_tickets/messages/' + this.supportTicket.id).then((response) => {
                this.supportTicket.content = response.data.data
            })
        },

        createSupportTicketMessage() {
            if (this.supportTicketMessage.message === '' && this.supportTicketMessage.attachment === '') {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }
            this.makeHttpRequest('POST', '/api/support_ticket/messages/' + this.supportTicket.id, this.supportTicketMessage).then(
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

        updateSupportTicketMessage() {
            this.makeHttpRequest('PUT', '/api/support_ticket/messages/' + this.supportTicket.id, this.supportTicket).then((response) => {
                this.supportTicket = response.data.data
            })
        },

        deleteSupportTicketMessage(id) {
            this.makeHttpRequest('DELETE', '/api/support_ticket/messages/' + id).then((response) => {
                this.showToast(response.data.message)
                this.getSupportTicket(this.supportTicket.id)
            })
        },

        shareSupportTicket(id) {
            this.makeHttpRequest('GET', '/api/support_ticket/share/' + id, null, null, null, false).then((response) => {
                this.shareUrl = response.data.data
                this.shareDialog = true
            })
        },

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

        getClientSupportTicket() {
            this.makeHttpRequest('GET', '/api/client/support?key=' + this.$route.query.key).then((response) => {
                this.supportTicket = response.data.data
            })
        },

        clientSendReply() {
            if (this.supportTicketMessage.message === '') {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }
            this.makeHttpRequest('POST', '/api/client/support/replay?key=' + this.$route.query.key, this.supportTicketMessage).then(
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
    },
}
