<template>
    <user-layout>
        <div id="documents_page">
            <user-header :title="$t('document.document', 2)">
                <template #actions>
                    <Button :label="$t('document.document')" icon="fa fa-file" @click="openNewDocumentDialog" />
                    <Button :label="$t('document.new_folder')" icon="fa fa-folder-plus" @click="openNewFolderDialog" />
                    <Button
                        v-if="currentFolder != null"
                        :label="$t('document.edit_folder')"
                        icon="fa fa-folder"
                        @click="editFolderOpenDialog"
                    />
                </template>
            </user-header>
            <div class="card">
                <div id="documents" class="grid">
                    <div class="col-12 md:col-4">
                        <!-- Folders tree -->
                        <Tree
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

                    <div class="col-12 md:col-8">
                        <!-- Documents table -->
                        <DataTable
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
                                <template #body="slotProps">
                                    <div class="">
                                        <span :class="`fiv-viv fiv-icon-${slotProps.data.file_type} icon-file`"></span>
                                        <span class="ml-2">{{ slotProps.data.name }}</span>
                                    </div>
                                </template>
                            </Column>
                            <Column field="created_at" :header="$t('document.created_at')">
                                <template #body="slotProps">
                                    <span>{{ formatDateTime(slotProps.data.created_at) }}</span>
                                </template>
                            </Column>
                            <Column field="file_size" :header="$t('document.size')">
                                <template #body="slotProps">
                                    <span>{{ formatFileSize(slotProps.data.file_size) }}</span>
                                </template>
                            </Column>
                        </DataTable>
                    </div>
                </div>
            </div>

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
                        <Button :label="$t('basic.create')" icon="fa fa-check" @click="createFolder" />
                    </div>
                </template>
            </Dialog>

            <!-- New document dialog -->
            <div class="mt-4">
                <Dialog v-model:visible="showNewDocumentDialog" :header="$t('document.new_document')" modal>
                    <FileUpload name="file" url="/api/documents" @before-send="uploadDocument" @upload="afterUploadDocument" />
                    <template #footer>
                        <div id="function_buttons" class="flex gap-2 justify-content-end">
                            <Button
                                :label="$t('basic.cancel')"
                                icon="fa fa-times"
                                class="p-button-danger"
                                @click="closeNewDocumentDialog"
                            />
                        </div>
                    </template>
                </Dialog>
            </div>

            <!-- Edit folder dialog -->

            <div class="mt-4">
                <Dialog v-model:visible="showEditFolderDialog" :header="$t('document.edit_folder')" modal>
                    <TextInput
                        id="folder_name_input"
                        v-model="folder.label"
                        class="field col-12"
                        :label="$t('document.folder_name')"
                    ></TextInput>
                    <template #footer>
                        <div id="function_buttons" class="flex gap-2 justify-content-end">
                            <Button :label="$t('basic.save')" icon="fa fa-check" @click="updateFolder" />
                            <Button :label="$t('basic.delete')" icon="fa fa-trash" class="p-button-danger" @click="deleteFolderAsk" />
                        </div>
                    </template>
                </Dialog>
            </div>

            <!-- Sidebar for file -->

            <!-- prettier-ignore-attribute -->
            <Sidebar v-model:visible="sidebarFileShow" position="right" @hide="sidebarFileShow = false; editDocument = false;">
                <LoadingScreen :blocked="loadingData">
                    <span v-if="!editDocument" class="font-bold text-x" style="word-wrap: break-word" @dblclick="editDocument = true">{{
                        document.name
                    }}</span>
                    <InputText v-if="editDocument" v-model="document.name" class="mt-2 w-full" />

                    <div class="mt-2 flex gap-2">
                        <Button :label="$t('basic.download')" icon="fa fa-download" @click="downloadDocument(document.download_url)" />
                        <Button :label="$t('basic.preview')" icon="fa fa-eye" @click="previewDocument(document.preview_url)" />
                    </div>

                    <div class="mt-2">
                        <span v-if="!editDocument" class="text-x" style="word-wrap: break-word" @dblclick="editDocument = true">{{
                            document.description
                        }}</span>
                        <TextArea v-if="editDocument" v-model="document.description" class="mt-2 w-full" />
                    </div>

                    <div class="mt-4">
                        <DisplayData :input="$t('document.created_at')" :value="formatDateTime(document.created_at)" />
                    </div>

                    <div class="mt-4">
                        <DisplayData :input="$t('document.size')" :value="formatFileSize(document.file_size)" />
                    </div>

                    <div class="mt-4">
                        <Button v-if="editDocument" :label="$t('basic.save')" icon="fa fa-save" @click="updateDocument" />
                        <Button
                            v-if="editDocument"
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
import DocumentsMixin from '@/mixins/documents'
export default {
    name: 'DocumentsPage',
    mixins: [DocumentsMixin],

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
        this.getDocuments(this.currentFolder?.id || null)
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
            event.formData.append('folder_id', this.currentFolder?.id || null)
            event.xhr.setRequestHeader('Authorization', `Bearer ${this.token}`)
        },

        afterUploadDocument() {
            this.closeNewDocumentDialog()
            this.getDocuments(this.currentFolder?.id || null)
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

        editFolderOpenDialog() {
            this.getFolder(this.currentFolder?.id || null)
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
