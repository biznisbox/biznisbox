<template>
    <user-layout>
        <div id="documents_page">
            <user-header :title="$t('document.document', 2)">
                <template #actions>
                    <Button :label="$t('document.document')" icon="fa fa-file" @click="openNewDocumentDialog" />
                    <Button :label="$t('document.new_folder')" icon="fa fa-folder-plus" @click="openNewFolderDialog" />
                </template>
            </user-header>
            <div class="card">
                <div id="documents_table">
                    <DataTable
                        v-model:contextMenuSelection="selectedDocument"
                        :value="documents"
                        :loading="loadingData"
                        :resizable-columns="true"
                        column-resize-mode="expand"
                        responsive-layout="scroll"
                        context-menu
                        @row-dblclick="openDocument"
                        @rowContextmenu="openRightClickMenu"
                    >
                        <template #empty>
                            <div class="p-4 pl-0 text-center w-full text-gray-500">
                                <i class="fa fa-info-circle empty-icon"></i>
                                <p>{{ $t('document.no_documents') }}</p>
                                <Button
                                    class="mt-3"
                                    :label="$t('document.upload_first_document')"
                                    icon="fa fa-plus"
                                    @click="openNewDocumentDialog"
                                />
                            </div>
                        </template>

                        <Column field="name" :header="$t('document.name')" sortable>
                            <template #body="{ data }">
                                <span :class="`fiv-viv fiv-icon-${data.extension} icon-file`"></span>
                                <span class="ml-2">{{ data.name }}</span>
                            </template>
                        </Column>
                        <Column field="created_at" :header="$t('document.created_at')" sortable>
                            <template #body="{ data }">
                                <span>{{ formatDateTime(data.created_at, true) }}</span>
                            </template>
                        </Column>
                        <Column field="size" :header="$t('document.size')" sortable>
                            <template #body="{ data }">
                                <span>{{ formatFileSize(data.size) }}</span>
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>

            <!-- Right menu -->
            <ContextMenu ref="rightClickMenu" :model="rightClickMenuItems" />

            <!-- New folder dialog -->
            <Dialog v-model:visible="showNewFolderDialog" :header="$t('document.new_folder')" modal>
                <TextInput
                    id="folder_name_input"
                    v-model="newFolderName"
                    class="field col-12"
                    :label="$t('document.folder_name')"
                ></TextInput>
                <template #footer>
                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button :label="$t('basic.close')" icon="fa fa-times" class="p-button-danger" @click="closeNewFolderDialog" />
                        <Button :label="$t('basic.create')" icon="fa fa-check" @click="createFolder" />
                    </div>
                </template>
            </Dialog>

            <!-- New document dialog -->
            <Dialog v-model:visible="showNewDocumentDialog" :header="$t('document.new_document')" modal>
                <FileUpload name="file" url="/api/documents" @before-send="uploadDocument" @upload="afterUploadDocument" />
                <template #footer>
                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button :label="$t('basic.cancel')" icon="fa fa-times" class="p-button-danger" @click="closeNewDocumentDialog" />
                    </div>
                </template>
            </Dialog>

            <!-- Sidebar for file -->
            <Sidebar v-model:visible="sidebarFileShow" position="right">
                <LoadingScreen :blocked="loadingData">
                    <span class="font-bold text-x" style="word-wrap: break-word">{{ document.name }}</span>

                    <div class="mt-2 flex gap-2">
                        <Button :label="$t('basic.download')" icon="fa fa-download" @click="downloadDocument(document.download_url)" />
                        <Button :label="$t('basic.preview')" icon="fa fa-eye" @click="previewDocument(document.preview_url)" />
                    </div>

                    <div class="mt-4">
                        <span class="font-bold">{{ $t('document.created_at') }}</span>
                        <span class="ml-2">{{ formatDateTime(document.created_at) }}</span>
                    </div>

                    <div class="mt-4">
                        <span class="font-bold">{{ $t('document.size') }}</span>
                        <span class="ml-2">{{ formatFileSize(document.file_size) }}</span>
                    </div>

                    <div class="mt-4">
                        <span class="font-bold">{{ $t('document.type') }}</span>
                        <span class="ml-2">{{ document.file_type }}</span>
                    </div>
                </LoadingScreen>
            </Sidebar>
        </div>
    </user-layout>
</template>

<script>
import DocumnetsMixin from '@/mixins/documents'
export default {
    name: 'DocumentsPage',
    mixins: [DocumnetsMixin],

    data() {
        return {
            showNewFolderDialog: false,
            showNewDocumentDialog: false,
            newFolderName: '',
            selectedDocument: null,
            sidebarFileShow: false,
            rightClickMenuItems: [
                { label: this.$t('basic.view'), icon: 'fa fa-search', command: () => this.viewDocument(this.selectedDocument) },
                { label: this.$t('basic.delete'), icon: 'fa fa-times', command: () => this.deleteDocumentAsk(this.selectedDocument) },
            ],
        }
    },

    watch: {
        '$route.query.path': {
            handler: function (path) {
                if (path == undefined) {
                    this.currentPath = '/'
                } else {
                    this.currentPath = path
                }
                this.getDocuments(path)
            },
            deep: true,
            immediate: true,
        },
    },

    methods: {
        openNewFolderDialog() {
            this.showNewFolderDialog = true
        },

        closeNewFolderDialog() {
            this.showNewFolderDialog = false
            this.newFolderName = ''
        },

        openNewDocumentDialog() {
            this.showNewDocumentDialog = true
        },

        closeNewDocumentDialog() {
            this.showNewDocumentDialog = false
            this.document.file = null
        },

        openRightClickMenu(event) {
            this.$refs.rightClickMenu.show(event.originalEvent)
        },

        uploadDocument(event) {
            event.formData.append('path', this.currentPath)
            event.xhr.setRequestHeader('Authorization', `Bearer ${this.token}`)
        },

        afterUploadDocument(event) {
            this.closeNewDocumentDialog()
            this.getDocuments(this.currentPath)
        },

        viewDocument(document) {
            if (document.type === 'folder') {
                this.currentPath = document.path
                this.$router.push('/documents?path=' + document.path)
                this.getDocuments(this.currentPath)
            }
        },

        previewDocument(url) {
            window.open(url, '_blank')
        },

        downloadDocument(url) {
            window.open(url, '_blank')
        },

        createFolder() {
            this.makeHttpRequest('POST', '/api/document/folders', { path: this.currentPath, name: this.newFolderName }).then((response) => {
                this.showNewFolderDialog = false
                this.newFolderName = ''
                this.showToast(response.data.message)
                this.getDocuments(this.currentPath)
            })
        },
    },
}
</script>

<style scoped>
.icon-file {
    font-size: 1.5rem;
}

#documents_table {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
</style>
