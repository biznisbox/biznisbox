<template>
    <DefaultLayout>
        <PageHeader :title="$t('archive.archive')">
            <template #actions>
                <Button
                    v-if="currentFolder != 'trash'"
                    id="new_document_button"
                    :label="$t('archive.new_document')"
                    icon="fa fa-file"
                    @click="openNewDocumentDialog"
                />
                <Button
                    v-if="currentFolder !== 'trash'"
                    id="new_folder_button"
                    :label="$t('archive.new_folder')"
                    icon="fa fa-folder-plus"
                    @click="openNewFolderDialog"
                />
                <Button
                    v-if="currentFolder != null && currentFolder !== 'trash'"
                    id="edit_folder_button"
                    :label="$t('archive.edit_folder')"
                    icon="fa fa-folder-open"
                    @click="openEditFolderDialog"
                />
            </template>
        </PageHeader>

        <div class="card">
            <div id="documents" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div id="folder_tree_section" class="col-span-1 md:col-span-4">
                    <!-- Folders tree -->
                    <Tree
                        id="folder_tree"
                        :value="folders"
                        filter
                        filter-mode="strict"
                        selection-mode="single"
                        @node-select="folderSelected"
                    >
                        <template #default="{ node }">
                            <div :id="`${node.id}`" class="flex items-center">
                                <span v-if="node.id !== 'trash'" class="fiv-viv fiv-icon-folder icon-file"></span>
                                <span v-if="node.id === 'trash'" class="fa fa-trash icon-file"></span>
                                <span class="ml-2" :class="{ 'font-bold': node.id === currentFolder }">{{ node.label }}</span>
                            </div>
                        </template>
                    </Tree>
                </div>

                <div id="files_section" class="col-span-1 md:col-span-8">
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
                            <div class="p-4 pl-0 text-center w-full">
                                <div v-if="currentFolder !== 'trash'">
                                    <i class="fa fa-info-circle empty-icon"></i>
                                    <p>{{ $t('archive.no_documents') }}</p>
                                    <Button
                                        class="mt-3"
                                        :label="$t('archive.upload_first_document')"
                                        icon="fa fa-plus"
                                        @click="openNewDocumentDialog"
                                    />
                                </div>

                                <div v-if="currentFolder === 'trash'">
                                    <i class="fa fa-info-circle empty-icon"></i>
                                    <p>{{ $t('archive.no_documents_in_trash') }}</p>
                                </div>
                            </div>
                        </template>
                        <Column field="number" :header="$t('form.number')" sortable />
                        <Column field="name" :header="$t('form.name')" sortable>
                            <template #body="{ data }">
                                <div class="flex items-center">
                                    <span :class="`fiv-viv fiv-icon-${data.file_extension} icon-file`"></span>
                                    <span class="ml-2">{{ data.name }}</span>
                                </div>
                            </template>
                        </Column>
                        <Column field="created_at" :header="$t('form.created_at')">
                            <template #body="{ data }">
                                <span>{{ formatDateTime(data.created_at) }}</span>
                            </template>
                        </Column>
                        <Column field="file_size" :header="$t('form.size')">
                            <template #body="{ data }">
                                <span>{{ formatFileSize(data.file_size) }}</span>
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>
        </div>

        <!-- New/Update folder dialog -->
        <Dialog
            v-model:visible="showNewEditFolderDialog"
            :header="folderMethod === 'new' ? $t('archive.new_folder') : $t('archive.edit_folder')"
            modal
            :style="{ width: '400px' }"
            class="m-2"
        >
            <form>
                <TextInput id="folder_name_input" v-model="folder.name" :label="$t('archive.folder_name')" />
            </form>
            <template #footer>
                <div id="function_buttons" class="flex gap-2 justify-end flex-wrap">
                    <Button
                        id="cancel_folder_button"
                        :label="$t('basic.cancel')"
                        icon="fa fa-times"
                        severity="secondary"
                        @click="closeNewEditFolderDialog"
                    />
                    <Button
                        v-if="folderMethod === 'edit'"
                        id="delete_folder_button"
                        :label="$t('basic.delete')"
                        icon="fa fa-trash"
                        severity="danger"
                        @click="deleteFolderAsk"
                    />

                    <Button
                        id="save_folder_button"
                        :label="folderMethod === 'new' ? $t('basic.create') : $t('basic.update')"
                        icon="fa fa-save"
                        severity="success"
                        :disabled="!folder.name"
                        @click="folderMethod === 'new' ? createFolder() : updateFolder()"
                    />
                </div>
            </template>
        </Dialog>

        <!-- New document dialog -->
        <Dialog
            id="upload_document_dialog"
            v-model:visible="showNewDocumentDialog"
            :header="$t('archive.new_document')"
            modal
            :style="{ width: '400px' }"
            class="m-2"
        >
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
                    <Button :label="$t('basic.cancel')" icon="fa fa-times" severity="secondary" @click="closeNewDocumentDialog" />
                </div>
            </template>
        </Dialog>

        <!-- Pdf view dialog-->
        <Dialog v-model:visible="filePreviewDialog" modal maximizable class="w-full m-2 lg:w-1/2" :header="fileViewerTitle">
            <div v-if="filePreviewFormat === 'pdf'">
                <PdfViewer style="height: 100vh" :pdf="filePreviewUrl" :fileName="fileViewerTitle" />
            </div>

            <div v-if="filePreviewFormat === 'image'">
                <img :src="filePreviewUrl" alt="preview" style="width: 100%" />
            </div>
        </Dialog>

        <!-- Sidebar for file -->
        <!-- prettier-ignore-attribute -->
        <Drawer
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
                <div v-if="editDocument" class="flex gap-2">
                    <InputText v-if="editDocument" id="document_name" v-model="document.name" class="mt-2 w-full" />
                </div>

                <div class="mt-2 flex gap-2">
                    <Button
                        id="document_download_button"
                        :label="$t('basic.download')"
                        icon="fa fa-download"
                        @click="downloadDocument(document.download_link)"
                    />
                    <Button id="document_preview_button" :label="$t('basic.preview')" icon="fa fa-eye" @click="previewDocument(document)" />
                </div>

                <div class="mt-2">
                    <span v-if="!editDocument" class="text-x" style="word-wrap: break-word" @dblclick="editDocument = true">{{
                        document.description
                    }}</span>
                    <Textarea v-if="editDocument" v-model="document.description" class="mt-2 w-full" />
                </div>

                <div class="mt-4">
                    <DisplayData :input="$t('form.number')" :value="document.number" />
                    <DisplayData :input="$t('form.created_at')" :value="formatDateTime(document.created_at)" />
                    <DisplayData :input="$t('form.size')" :value="formatFileSize(document.file_size)" />
                </div>

                <div class="mt-4">
                    <DisplayData :input="$t('form.status')" custom-value v-if="!editDocument">
                        <Tag v-if="document.status !== 'archived'" :severity="document.status === 'active' ? 'success' : 'danger'">{{
                            $t(`status.${document.status}`)
                        }}</Tag>
                        <Tag v-else>{{ $t(`status.${document.status}`) }}</Tag>
                    </DisplayData>

                    <DisplayData :input="$t('form.partner')" :value="document.partner?.name" v-if="!editDocument && document.partner" />
                    <DisplayData
                        :input="$t('form.connected_document')"
                        :value="document.connected_document?.name"
                        v-if="!editDocument && document.connected_document"
                    />
                    <DisplayData
                        :input="$t('form.protection_level')"
                        :value="$t(`protection_level.${document.protection_level}`)"
                        v-if="!editDocument && document.protection_level"
                    />
                    <DisplayData
                        :input="$t('form.storage_location')"
                        :value="document.storage_location?.name"
                        v-if="!editDocument && document.storage_location"
                    />

                    <div v-if="editDocument" class="mt-2">
                        <SelectInput
                            id="document_status"
                            v-model="document.status"
                            :options="[
                                { label: $t('status.active'), value: 'active' },
                                { label: $t('status.inactive'), value: 'inactive' },
                                { label: $t('status.archived'), value: 'archived' },
                            ]"
                            option-label="label"
                            option-value="value"
                            :label="$t('form.status')"
                            placeholder="Select a status"
                        />

                        <SelectInput
                            id="document_partner"
                            v-model="document.partner_id"
                            :options="partners"
                            option-label="name"
                            option-value="id"
                            show-clear
                            filter
                            :label="$t('form.partner')"
                            placeholder="Select a partner"
                        />

                        <div class="mt-2">
                            <SelectInput
                                id="connected_document_id"
                                v-model="document.connected_document_id"
                                :options="selectDocumentArray"
                                option-label="name"
                                option-value="id"
                                show-clear
                                filter
                                :label="$t('form.connected_document')"
                                placeholder="Select a document"
                            />

                            <SelectInput
                                id="protection_level"
                                v-model="document.protection_level"
                                :options="[
                                    { label: $t('protection_level.public'), value: 'public' },
                                    { label: $t('protection_level.private'), value: 'private' },
                                    { label: $t('protection_level.internal'), value: 'internal' },
                                    { label: $t('protection_level.confidential'), value: 'confidential' },
                                    { label: $t('protection_level.secret'), value: 'secret' },
                                    { label: $t('protection_level.top_secret'), value: 'top_secret' },
                                ]"
                                option-label="label"
                                option-value="value"
                                :label="$t('form.protection_level')"
                                placeholder="Select a protection level"
                            />

                            <SelectInput
                                id="storage_location"
                                v-model="document.storage_location_id"
                                :options="departments"
                                option-label="name"
                                option-value="id"
                                show-clear
                                filter
                                :label="$t('form.storage_location')"
                                placeholder="Select a storage location"
                            />
                        </div>
                    </div>
                </div>

                <div id="functions_buttons" class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-4">
                    <Button
                        v-if="editDocument"
                        id="document_save_button"
                        :label="$t('basic.save')"
                        icon="fa fa-save"
                        severity="success"
                        @click="updateDocument"
                    />
                    <Button
                        v-if="editDocument"
                        id="delete_document_button"
                        severity="danger"
                        :label="$t('basic.delete')"
                        icon="fa fa-trash"
                        @click="deleteDocumentAsk(document)"
                    />
                    <Button
                        id="document_audit_log_button"
                        :label="$t('basic.audit_log')"
                        icon="fa fa-history"
                        @click="showAuditLogDialogFun(document.id)"
                    />
                </div>
            </LoadingScreen>
        </Drawer>

        <!--Audit log dialog -->
        <Dialog
            v-model:visible="showAuditLogDialog"
            modal
            maximizable
            class="w-full m-2 lg:w-1/2"
            :header="$t('audit_log.audit_log')"
            :draggable="false"
        >
            <AuditLog
                :item_id="auditLogElementId"
                item_type="Archive"
                :hiddenFields="[
                    'partner_id',
                    'connected_document_id',
                    'storage_location_id',
                    'folder_id',
                    'file_name',
                    'file_mime',
                    'file_size',
                    'file_path',
                    'file_hash_sha256',
                    'file_hash_md5',
                    'file_extension',
                    'user_id',
                    'connected_document_type',
                ]"
            />
        </Dialog>
    </DefaultLayout>
</template>

<script>
import ArchiveMixin from '@/mixins/archive'
export default {
    name: 'ArchivePage',
    mixins: [ArchiveMixin],
    data() {
        return {
            showAuditLogDialog: false,
            auditLogElementId: null,
            editDocument: false,
            showNewEditFolderDialog: false,
            selectedDocument: null,
            sidebarFileShow: false,
            showNewDocumentDialog: false,
            folderMethod: 'new',
            partners: [],
            departments: [],
            filePreviewDialog: false,
            filePreviewUrl: '',
            fileViewerTitle: '',
            filePreviewFormat: '', // pdf or image
        }
    },

    created() {
        this.getFolders()
        this.getDocuments(this.currentFolder || null)
        this.getPartners()
        this.getDocuments('all')
        this.getDepartments()
    },

    methods: {
        openNewFolderDialog() {
            this.resetFolder()
            this.folderMethod = 'new'
            this.showNewEditFolderDialog = true
        },

        openEditFolderDialog() {
            this.resetFolder()
            this.getFolder(this.currentFolder || null)
            this.folderMethod = 'edit'
            this.showNewEditFolderDialog = true
        },

        closeNewEditFolderDialog() {
            this.showNewEditFolderDialog = false
            this.resetFolder()
        },

        openNewDocumentDialog() {
            this.resetDocument()
            this.showNewDocumentDialog = true
        },

        closeNewDocumentDialog() {
            this.resetDocument()
            this.showNewDocumentDialog = false
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

        previewDocument(document) {
            if (document.file_extension === 'pdf') {
                this.filePreviewDialog = true
                this.filePreviewUrl = document.preview_link
                this.fileViewerTitle = document.name
                this.filePreviewFormat = 'pdf'
            } else if (document.file_extension === 'jpg' || document.file_extension === 'jpeg' || document.file_extension === 'png') {
                this.filePreviewDialog = true
                this.filePreviewUrl = document.preview_link
                this.fileViewerTitle = document.name
                this.filePreviewFormat = 'image'
            } else if (document.file_extension == 'txt') {
                this.filePreviewDialog = true
                this.filePreviewUrl = document.preview_link
                this.fileViewerTitle = document.name
                this.filePreviewFormat = 'txt'
            } else {
                this.downloadDocument(document.preview_link)
            }
        },

        downloadDocument(url) {
            window.open(url, '_blank')
        },

        editFolderOpenDialog() {
            this.getFolder(this.currentFolder || null)
            this.showNewEditFolderDialog = true
        },

        showAuditLogDialogFun(id) {
            this.auditLogElementId = id
            this.showAuditLogDialog = true
        },

        /**
         * Get partners
         * @returns {array} partners
         **/

        getPartners() {
            this.makeHttpRequest('GET', '/api/partner/limited').then((response) => {
                this.partners = response.data.data
            })
        },
    },
}
</script>

<style scoped>
.icon-file {
    font-size: 1.5rem;
}
</style>
