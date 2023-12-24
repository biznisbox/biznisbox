<template>
    <user-layout>
        <div id="view_document_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="document.name">
                    <template #actions>
                        <Button
                            :label="$t('basic.edit')"
                            icon="fa fa-edit"
                            class="p-button-success"
                            @click="goTo(`/documents/${document.id}/edit`)"
                        />
                        <Button
                            :label="$t('basic.delete')"
                            icon="fa fa-trash"
                            class="p-button-danger"
                            @click="deleteDocumentAsk($route.params.id)"
                        />
                        <Button :label="$t('basic.download')" icon="fa fa-download" @click="downloadDocument($route.params.id)" />
                    </template>
                </user-header>

                <div class="card">
                    <div class="grid">
                        <div id="number" class="col-12 md:col-4">
                            <DisplayData :input="$t('form.number')" :value="document.number" />
                        </div>

                        <div id="name" class="col-12 md:col-4">
                            <DisplayData :input="$t('form.name')" :value="document.name" />
                        </div>

                        <div class="col-12 md:col-4">
                            <DisplayData :input="$t('form.type')" custom-value>
                                <Tag severity="info">{{ $t(`document.${document.type}`) }}</Tag>
                            </DisplayData>
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-12 md:col-4">
                            <DisplayData :input="$t('form.status')" custom-value>
                                <Tag v-if="document.status === 'draft'" severity="warning">{{ $t('status.draft') }}</Tag>
                                <Tag v-if="document.status === 'pending'" severity="info">{{ $t('status.pending') }}</Tag>
                                <Tag v-if="document.status === 'approved'" severity="success">{{ $t('status.approved') }}</Tag>
                                <Tag v-if="document.status === 'rejected'" severity="danger">{{ $t('status.rejected') }}</Tag>
                            </DisplayData>
                        </div>

                        <div class="col-12 md:col-4">
                            <DisplayData :input="$t('form.date')" :value="formatDateTime(document.date)" />
                        </div>

                        <div class="col-12 md:col-4">
                            <DisplayData :input="$t('form.due_date')" :value="document.due_date ? formatDateTime(document.due_date) : ''" />
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-12 md:col-4">
                            <DisplayData :input="$t('form.version')" :value="document.version" />
                        </div>

                        <div class="col-12 md:col-4">
                            <DisplayData :input="$t('form.archived')" custom-value>
                                <Tag v-if="document.archived" severity="success">{{ $t('basic.yes') }}</Tag>
                                <Tag v-else severity="danger">{{ $t('basic.no') }}</Tag>
                            </DisplayData>
                        </div>

                        <div class="col-12 md:col-4">
                            <DisplayData :input="$t('form.access')" :value="document.access" custom-value>
                                <Tag v-if="document.access === 'public'" severity="success">{{ $t('basic.public') }}</Tag>
                                <Tag v-else-if="document.access === 'private'" severity="danger">{{ $t('basic.private') }}</Tag>
                                <Tag v-else-if="document.access === 'internal'" severity="info">{{ $t('basic.shared') }}</Tag>
                            </DisplayData>
                        </div>
                    </div>

                    <div>
                        <DisplayData :input="$t('form.notes')" :value="document.notes" />
                    </div>

                    <div class="mt-3">
                        <DisplayData :input="$t('form.content')" custom-value>
                            <div class="grid content">
                                <div class="col-12" v-html="document.content"></div>
                            </div>
                        </DisplayData>
                    </div>
                </div>

                <div id="function_buttons" class="flex gap-2 justify-content-end">
                    <Button
                        id="close_button"
                        :label="$t('basic.close')"
                        icon="fa fa-times"
                        class="p-button-danger"
                        @click="goTo('/documents')"
                    />
                </div>
            </LoadingScreen>
        </div>
    </user-layout>
</template>

<script>
import DocumentMixin from '@/mixins/documents'
export default {
    name: 'ViewDocument',
    mixins: [DocumentMixin],
    created() {
        this.getDocument(this.$route.params.id)
    },

    methods: {
        downloadDocument(id) {
            window.open(this.document.preview, '_blank')
        },
    },
}
</script>
