export default {
    data() {
        return {
            documents: [],
            document: {
                id: '',
                name: '',
                type: '',
                description: '',
                preview_url: '',
                download_url: '',
            },
            currentPath: '',
        }
    },

    methods: {
        /**
         * Get all documents
         * @param {string} path path of folder
         * @returns {array} documents
         **/
        getDocuments(path) {
            this.makeHttpRequest('GET', '/api/documents', null, { path: path })
                .then((response) => {
                    this.documents = response.data.data
                })
                .catch((error) => {
                    if (error.response.status === 404) {
                        this.documents = []
                        this.showToast('Error', error.response.data.message, 'error')
                        this.$router.push('/documents')
                    }
                })
        },

        /**
         * Function for format file size
         * @param {number} bytes size in bytes
         * @param {number} decimals number of decimals
         * @returns {string} size
         **/
        formatFileSize(bytes, decimals = 2) {
            if (!+bytes) return '0 Bytes'

            const k = 1024
            const dm = decimals < 0 ? 0 : decimals
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']

            const i = Math.floor(Math.log(bytes) / Math.log(k))

            return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`
        },

        /**
         * Function for open document
         * @param {object} document document object
         * @returns {void}
         **/

        openDocument(document) {
            if (document.data.extension == 'folder') {
                this.$router.push('/documents?path=' + document.data.path)
            } else {
                this.sidebarFileShow = true
                this.getFileData(document)
            }
        },

        /**
         * Function for get file data
         * @param {object} document  document object
         * @returns {void}  set document data to document object
         **/
        getFileData(document) {
            this.makeHttpRequest('GET', '/api/documents/file', null, { path: document.data.path })
                .then((response) => {
                    this.document = response.data.data
                })
                .catch((error) => {
                    if (error.response.status === 404) {
                        this.showToast('Error', error.response.data.message, 'error')
                    }
                })
        },

        /**
         * Function for delete document
         * @param {object} document document object
         * @returns {void}
         **/
        deleteDocument(document) {
            if (document.type == 'folder') {
                this.makeHttpRequest('DELETE', '/api/document/folders', null, { path: document.path })
                    .then((response) => {
                        this.showToast(response.data.message)
                        this.getDocuments(this.currentPath)
                    })
                    .catch((error) => {
                        if (error.response.status === 404) {
                            this.showToast('Error', error.response.data.message, 'error')
                        }
                    })
            } else {
                this.makeHttpRequest('DELETE', '/api/documents/file', null, { path: document.path })
                    .then((response) => {
                        this.showToast(response.data.message)
                        this.getDocuments(this.currentPath)
                    })
                    .catch((error) => {
                        if (error.response.status === 404) {
                            this.showToast('Error', error.response.data.message, 'error')
                        }
                    })
            }
        },

        /**
         * Function for delete document confirmation
         * @param {object} document document object
         * @returns {void}
         **/
        deleteDocumentAsk(document) {
            this.$confirm.require({
                message: this.$t('document.delete_confirm_document'),
                header: this.$t('basic.confirmation'),
                icon: 'fa fa-circle-exclamation',
                accept: () => {
                    this.deleteDocument(document)
                },
            })
        },
    },
}
