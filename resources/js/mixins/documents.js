export default {
    data() {
        return {
            documents: [],
            document: {
                id: '',
                name: '',
                number: '',
                date: new Date().toISOString().substr(0, 10),
                due_date: '',
                version: '1.0',
                content: '',
                status: 'draft',
                type: 'document',
                access: 'internal',
                notes: '',
            },
        }
    },

    methods: {
        getDocuments() {
            this.makeHttpRequest('get', '/api/documents').then((response) => {
                this.documents = response.data.data
            })
        },

        getDocument(id) {
            this.makeHttpRequest('get', '/api/documents/' + id).then((response) => {
                this.document = response.data.data
            })
        },

        getDocumentNumber() {
            this.makeHttpRequest('get', '/api/document/number').then((response) => {
                this.document.number = response.data
            })
        },

        saveDocument() {
            this.makeHttpRequest('post', '/api/documents', this.document).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'documents' })
            })
        },

        updateDocument(id) {
            this.makeHttpRequest('PUT', '/api/documents/' + id, this.document).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'view-document' }, { params: { id: id } })
            })
        },

        deleteDocument(id) {
            this.makeHttpRequest('DELETE', '/api/documents/' + id).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'documents' })
            })
        },

        deleteDocumentAsk(id) {
            this.$confirm.require({
                message: this.$t('document.delete_confirm_document'),
                header: this.$t('basic.confirmation'),
                icon: 'fa fa-circle-exclamation',
                accept: () => {
                    this.deleteDocument(id)
                },
            })
        },
    },
}
