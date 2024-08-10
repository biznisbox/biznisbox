export default {
    data() {
        return {
            documents: [],
            folders: [],
            currentFolder: null,
            currentDocument: null,
            selectDocumentArray: [],
            document: {
                id: '',
                number: '',
                name: '',
                type: '',
                folder_id: '',
                description: '',
                preview_url: '',
                download_url: '',
                partner_id: '',
                connected_document_id: '',
                connected_document_type: 'App\\Models\\Archive',
                storage_location_id: '',
                protection_level: '',
                preview_link: '',
                download_link: '',
            },
            folder: {
                id: '',
                module: 'archive',
                name: '',
                icon: null,
                parent_id: '',
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
                    if (folder_id === 'all') {
                        this.selectDocumentArray = response.data.data
                    } else {
                        this.documents = response.data.data
                    }
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
         * Function for open document
         * @param {object} document document object
         * @returns {void}
         **/
        openDocument(document) {
            if (this.currentFolder === 'trash') {
                this.$confirm.require({
                    message: this.$t('archive.restore_confirm_document'),
                    header: this.$t('basic.confirmation'),
                    icon: 'fa fa-circle-exclamation',
                    accept: () => {
                        this.restoreDocument(document.data.id)
                    },
                })
            } else {
                this.getDocument(document.data.id)
                this.sidebarFileShow = true
            }
        },

        /**
         * Function for get document data
         * @param {uuid} id document UUID
         * @returns {void}  set document data to document object
         **/
        getDocument(id) {
            this.makeHttpRequest('GET', `/api/archive/documents/${id}`)
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
            this.getCategories('archive').then((response) => {
                this.folders = response

                // Add root folder
                this.folders.unshift({
                    id: null,
                    label: '/',
                    parent_id: null,
                })

                // Add trash folder
                this.folders.push({
                    id: 'trash',
                    label: 'Trash',
                    parent_id: null,
                })
            })
        },

        folderSelected(folder) {
            this.currentFolder = folder.id
            this.getDocuments(folder.id)
        },

        updateDocument() {
            this.makeHttpRequest('PUT', `/api/archive/documents/${this.document.id}`, this.document)
                .then((response) => {
                    this.getDocument(this.document.id)
                    this.showToast(response.data.message)
                    this.editDocument = false
                    this.getDocuments(this.currentFolder || null)
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
            let data = {
                name: this.folder.name,
                module: 'archive',
                parent_id: this.currentFolder || null,
            }
            this.createCategory(data).then((response) => {
                this.showToast(response)
                this.showNewEditFolderDialog = false
                this.newFolderName = ''
                this.resetFolder()
                this.getFolders()
            })
        },

        /**
         * Function for delete document
         * @param {object} document document object
         * @returns {void}
         **/
        deleteDocument(document) {
            this.makeHttpRequest('DELETE', `/api/archive/documents/${document.id}`)
                .then((response) => {
                    this.showToast(response.data.message)
                    this.getDocuments(this.currentFolder || null)
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

        restoreDocument(id) {
            this.makeHttpRequest('PUT', `/api/archive/documents/${id}/restore`).then((response) => {
                this.showToast(response.data.message)
                this.getDocuments(this.currentFolder || null)
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
            let data = {
                id: this.folder.id,
                name: this.folder.name,
                module: 'archive',
                parent_id: this.folder.parent_id || null,
            }

            this.updateCategory(this.folder.id, data).then((response) => {
                this.showToast(response)
                this.resetFolder()
                this.showNewEditFolderDialog = false
                this.getFolders()
            })
        },

        getFolder() {
            this.getCategory(this.currentFolder).then((response) => {
                this.folder = response
            })
        },

        resetFolder() {
            this.folder = {
                id: '',
                module: 'archive',
                name: '',
                parent_id: '',
            }
        },

        resetDocument() {
            this.document = {
                name: '',
                description: '',
                file: null,
            }
        },

        /**
         * Function for delete folder
         * @param {UUID} folder_id folder UUID
         * @returns {void}
         **/
        deleteFolder() {
            this.deleteCategory(this.currentFolder).then((response) => {
                this.showNewEditFolderDialog = false
                this.showToast(response)
                this.getFolders()
                this.currentFolder = null
                this.getDocuments(null)
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
