export default {
    data() {
        return {
            documents: [],
            folders: [],
            currentFolder: null,
            currentDocument: null,
            document: {
                id: '',
                name: '',
                type: '',
                description: '',
                preview_url: '',
                download_url: '',
            },
        }
    },

    methods: {
        /**
         * Get all documents
         * @param {string} folder_id current folder id
         * @returns {array} documents
         **/
        getDocuments(folder_id) {
            this.makeHttpRequest('GET', '/api/documents', null, { folder_id: folder_id })
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
            this.makeHttpRequest('GET', '/api/documents/file', null, { document_id: document.data.id })
                .then((response) => {
                    this.document = response.data.data
                    this.sidebarFileShow = true
                })
                .catch((error) => {
                    if (error.response.status === 404) {
                        this.showToast('Error', error.response.data.message, 'error')
                    }
                })
        },

        /**
         * Function for get file data
         * @param {object} document  document object
         * @returns {void}  set document data to document object
         **/
        getFileData(document) {
            console.log(document)
        },

        getFolders() {
            this.makeHttpRequest('GET', '/api/document/folders')
                .then((response) => {
                    this.folders = response.data.data
                })
                .catch((error) => {
                    if (error.response.status === 404) {
                        this.showToast('Error', error.response.data.message, 'error')
                    }
                })
        },

        folderSelected(folder) {
            this.currentFolder = folder
            this.getDocuments(folder.id)
        },

        /**
         * Function for create folder
         * @returns {void}
         **/
        createFolder() {
            this.makeHttpRequest('POST', '/api/document/folders', {
                name: this.newFolderName,
                parent_folder_id: this.currentFolder?.id || null,
            }).then((response) => {
                this.showNewFolderDialog = false
                this.newFolderName = ''
                this.showToast(response.data.message)
                this.getFolders()
            })
        },

        /**
         * Function for delete document
         * @param {object} document document object
         * @returns {void}
         **/
        deleteDocument(document) {
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
