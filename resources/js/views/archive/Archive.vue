<template>
    <user-layout>
        <div id="archive_page">
            <user-header :title="$t('archive.archive')">
                <template #actions>
                    <Button id="new_document_button" :label="$t('archive.new_document')" icon="fa fa-file" @click="openNewDocumentDialog" />
                    <Button
                        id="new_folder_button"
                        :label="$t('archive.new_folder')"
                        icon="fa fa-folder-plus"
                        @click="openNewFolderDialog"
                    />
                    <Button
                        v-if="currentFolder != null"
                        id="edit_folder_button"
                        :label="$t('archive.edit_folder')"
                        icon="fa fa-folder"
                        @click="editFolderOpenDialog"
                    />
                </template>
            </user-header>
            <div class="card">
                <div id="documents" class="grid">
                    <div id="folder_tree_section" class="col-12 md:col-4">
                        <!-- Folders tree -->
                        <Tree
                            id="folder_tree"
                            :value="folders"
                            :loading="loadingData"
                            filter
                            filter-mode="strict"
                            selection-mode="single"
                            @node-select="folderSelected"
                        >
                            <template #default="{ node }">
                                <div>
                                    <span class="fiv-viv fiv-icon-folder icon-file"></span>
                                    <span class="ml-2">{{ node.label }}</span>
                                </div>
                            </template>
                        </Tree>
                    </div>

                    <div id="files_section" class="col-12 md:col-8">
                        <!-- Archive table -->
                        <DataTable
                            id="documents_table"
                            :value="documents"
                            :loading="loadingData"
                            paginator
                            :rows="10"
                            :rows-per-page-options="[10, 20, 50]"
                            data-key="id"
                            @row-click="openDocument"
                        >
                            <template #empty>
                                <div class="p-4 pl-0 text-center w-full text-gray-500">
                                    <i class="fa fa-info-circle empty-icon"></i>
                                    <p>{{ $t('archive.no_documents') }}</p>
                                    <Button
                                        class="mt-3"
                                        :label="$t('archive.upload_first_document')"
                                        icon="fa fa-plus"
                                        @click="openNewDocumentDialog"
                                    />
                                </div>
                            </template>
                            <Column field="name" :header="$t('form.name')" sortable>
                                <template #body="slotProps">
                                    <div class="">
                                        <span :class="`fiv-viv fiv-icon-${slotProps.data.file_type} icon-file`"></span>
                                        <span class="ml-2">{{ slotProps.data.name }}</span>
                                    </div>
                                </template>
                            </Column>
                            <Column field="created_at" :header="$t('form.created_at')">
                                <template #body="slotProps">
                                    <span>{{ formatDateTime(slotProps.data.created_at) }}</span>
                                </template>
                            </Column>
                            <Column field="file_size" :header="$t('form.size')">
                                <template #body="slotProps">
                                    <span>{{ formatFileSize(slotProps.data.file_size) }}</span>
                                </template>
                            </Column>
                        </DataTable>
                    </div>
                </div>
            </div>

            <!-- New folder dialog -->
            <Dialog v-model:visible="showNewFolderDialog" :header="$t('archive.new_folder')" modal>
                <TextInput id="folder_name_input" v-model="newFolderName" class="col-12" :label="$t('archive.folder_name')"></TextInput>
                <template #footer>
                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button
                            id="cancel_folder_button"
                            :label="$t('basic.cancel')"
                            icon="fa fa-times"
                            class="p-button-danger"
                            @click="closeNewFolderDialog"
                        />
                        <Button
                            id="save_folder_button"
                            :label="$t('basic.create')"
                            icon="fa fa-check"
                            class="p-button-success"
                            @click="createFolder"
                        />
                    </div>
                </template>
            </Dialog>

            <!-- New document dialog -->
            <Dialog id="upload_document_dialog" v-model:visible="showNewDocumentDialog" :header="$t('archive.new_document')" modal>
                <div id="upload_document_section" class="my-2">
                    <FileUpload
                        id="file_uploader"
                        name="file"
                        url="/api/archive/documents"
                        @before-send="uploadDocument"
                        @upload="afterUploadDocument"
                    />
                </div>
                <template #footer>
                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button :label="$t('basic.cancel')" icon="fa fa-times" class="p-button-danger" @click="closeNewDocumentDialog" />
                    </div>
                </template>
            </Dialog>

            <!-- Edit folder dialog -->
            <Dialog v-model:visible="showEditFolderDialog" :header="$t('archive.edit_folder')" modal>
                <TextInput id="folder_name_input" v-model="folder.label" class="col-12" :label="$t('archive.folder_name')"></TextInput>
                <template #footer>
                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button :label="$t('basic.save')" icon="fa fa-check" @click="updateFolder" />
                        <Button :label="$t('basic.delete')" icon="fa fa-trash" class="p-button-danger" @click="deleteFolderAsk" />
                    </div>
                </template>
            </Dialog>

            <!-- Sidebar for file -->
            <!-- prettier-ignore-attribute -->
            <Sidebar
                id="document_sidebar"
                v-model:visible="sidebarFileShow"
                position="right"
                @hide="sidebarFileShow = false; editDocument = false;"
            >
                <LoadingScreen :blocked="loadingData">
                    <span
                        v-if="!editDocument"
                        id="document_name"
                        class="font-bold text-x"
                        style="word-wrap: break-word"
                        @dblclick="editDocument = true"
                        >{{ document.name }}</span
                    >
                    <InputText v-if="editDocument" id="document_name" v-model="document.name" class="mt-2 w-full" />

                    <div class="mt-2 flex gap-2">
                        <Button
                            id="document_download_button"
                            :label="$t('basic.download')"
                            icon="fa fa-download"
                            @click="downloadDocument(document.download_url)"
                        />
                        <Button
                            id="document_preview_button"
                            :label="$t('basic.preview')"
                            icon="fa fa-eye"
                            @click="previewDocument(document.preview_url)"
                        />
                    </div>

                    <div class="mt-2">
                        <span v-if="!editDocument" class="text-x" style="word-wrap: break-word" @dblclick="editDocument = true">{{
                            document.description
                        }}</span>
                        <TextArea v-if="editDocument" v-model="document.description" class="mt-2 w-full" />
                    </div>

                    <div class="mt-4">
                        <DisplayData :input="$t('form.created_at')" :value="formatDateTime(document.created_at)" />
                    </div>

                    <div class="mt-4">
                        <DisplayData :input="$t('form.size')" :value="formatFileSize(document.file_size)" />
                    </div>

                    <div id="functions_buttons" class="mt-4">
                        <Button
                            v-if="editDocument"
                            id="document_save_button"
                            :label="$t('basic.save')"
                            icon="fa fa-save"
                            @click="updateDocument"
                        />
                        <Button
                            v-if="editDocument"
                            id="delete_document_button"
                            class="p-button-danger ml-2"
                            :label="$t('basic.delete')"
                            icon="fa fa-trash"
                            @click="deleteDocumentAsk(document)"
                        />
                    </div>
                </LoadingScreen>
            </Sidebar>
        </div>
    </user-layout>
</template>

<script>
import ArchiveMixin from '@/mixins/archive'
export default {
    name: 'Archive',
    mixins: [ArchiveMixin],

    data() {
        return {
            documents: [],
            folders: [],
            editDocument: false,
            showNewFolderDialog: false,
            showNewDocumentDialog: false,
            newFolderName: '',
            showEditFolderDialog: false,
            selectedDocument: null,
            sidebarFileShow: false,
        }
    },

    created() {
        this.getFolders()
        this.getDocuments(this.currentFolder || null)
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

        uploadDocument(event) {
            event.formData.append('folder_id', this.currentFolder || null)
            event.xhr.setRequestHeader('Authorization', `Bearer ${this.token}`)
        },

        afterUploadDocument() {
            this.closeNewDocumentDialog()
            this.getDocuments(this.currentFolder || null)
        },

        viewDocument(document) {
            if (document.type === 'folder') {
                this.currentPath = document.path
                this.$router.push('/archive/documents?path=' + document.path)
                this.getDocuments(this.currentPath)
            }
        },

        previewDocument(url) {
            window.open(url, '_blank')
        },

        downloadDocument(url) {
            window.open(url, '_blank')
        },

        editFolderOpenDialog() {
            this.getFolder(this.currentFolder || null)
            this.showEditFolderDialog = true
        },
    },
}
</script>

<style scoped>
.icon-file {
    font-size: 1.5rem;
}
</style>
