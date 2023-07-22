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
                category_id: '',
                description: '',
                preview_url: '',
                download_url: '',
            },
            folder: {
                id: '',
                name: '',
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
            this.makeHttpRequest('GET', '/api/archive/documents', null, { folder_id: folder_id })
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
            this.makeHttpRequest('GET', '/api/archive/documents/file', null, { document_id: document.data.id })
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
         * Function for get document data
         * @param {uuid} id document UUID
         * @returns {void}  set document data to document object
         **/
        getDocument(id) {
            this.makeHttpRequest('GET', '/api/archive/documents/file', null, { document_id: id })
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

        getFolders() {
            this.makeHttpRequest('GET', '/api/archive/document/folders')
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

        updateDocument() {
            this.makeHttpRequest('PUT', '/api/archive/documents/file', {
                id: this.document.id,
                name: this.document.name,
                description: this.document.description,
            })
                .then((response) => {
                    this.showToast(response.data.message)
                    this.editDocument = false
                })
                .catch((error) => {
                    if (error.response.status === 404) {
                        this.showToast('Error', error.response.data.message, 'error')
                    }
                })
        },

        /**
         * Function for create folder
         * @returns {void}
         **/
        createFolder() {
            this.makeHttpRequest('POST', '/api/archive/document/folders', {
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
            this.makeHttpRequest('DELETE', '/api/archive/documents/file', null, { document_id: document.id })
                .then((response) => {
                    this.showToast(response.data.message)
                    this.getDocuments(this.currentFolder?.id || null)
                    this.sidebarFileShow = false
                    this.document = {
                        id: '',
                        name: '',
                        type: '',
                        description: '',
                        preview_url: '',
                        download_url: '',
                    }
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
                message: this.$t('archive.delete_confirm_document'),
                header: this.$t('basic.confirmation'),
                icon: 'fa fa-circle-exclamation',
                accept: () => {
                    this.deleteDocument(document)
                },
            })
        },

        /**
         * Function for update folder
         * @returns {void}
         */
        updateFolder() {
            this.makeHttpRequest('PUT', '/api/archive/document/folders', {
                id: this.folder.id,
                label: this.folder.label,
            }).then((response) => {
                this.showToast(response.data.message)
                this.showEditFolderDialog = false
                this.getFolders()
            })
        },

        getFolder() {
            this.makeHttpRequest('GET', '/api/archive/document/folders/' + this.currentFolder?.id).then((response) => {
                this.folder = response.data.data
            })
        },

        /**
         * Function for delete folder
         * @param {UUID} folder_id folder UUID
         * @returns {void}
         **/
        deleteFolder() {
            this.makeHttpRequest('DELETE', '/api/archive/document/folders', null, { folder_id: this.currentFolder.id })
                .then((response) => {
                    this.showToast(response.data.message)
                    this.getFolders()
                    this.currentFolder = null
                    this.getDocuments(null)
                    this.showEditFolderDialog = false
                })
                .catch((error) => {
                    if (error.response.status === 404) {
                        this.showToast('Error', error.response.data.message, 'error')
                    }
                })
        },

        /**
         * Function for delete folder confirmation
         * @returns {void} delete folder
         **/
        deleteFolderAsk() {
            this.$confirm.require({
                message: this.$t('archive.delete_confirm_folder'),
                header: this.$t('basic.confirmation'),
                icon: 'fa fa-circle-exclamation',
                accept: () => {
                    this.deleteFolder()
                },
            })
        },
    },
}
