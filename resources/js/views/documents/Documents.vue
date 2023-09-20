<template>
    <user-layout>
        <div id="documents_page">
            <user-header :title="$t('document.document', 2)">
                <template #actions>
                    <HeaderActionButton :label="$t('document.new_document')" icon="fa fa-plus" to="/documents/new" />
                </template>
            </user-header>

            <div id="documents_table" class="card">
                <DataTable
                    v-model:filters="filters"
                    :value="documents"
                    :loading="loadingData"
                    paginator
                    :rows="10"
                    paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    :rows-per-page-options="[10, 20, 50]"
                    column-resize-mode="expand"
                    filter-display="menu"
                    data-key="id"
                    :global-filter-fields="['name']"
                    @row-dblclick="viewDocumentNavigation"
                >
                    <template #empty>
                        <div class="p-4 pl-0 text-center w-full text-gray-500">
                            <i class="fa fa-info-circle empty-icon"></i>
                            <p>{{ $t('document.no_documents') }}</p>
                            <Button
                                class="mt-3"
                                :label="$t('document.create_first_document')"
                                icon="fa fa-plus"
                                @click="$router.push('/documents/new')"
                            />
                        </div>
                    </template>
                    <Column field="name" :header="$t('form.name')">
                        <template #body="{ data }">
                            {{ data.name }}
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by name" />
                        </template>
                    </Column>

                    <Column field="type" :header="$t('form.type')">
                        <template #body="{ data }">
                            <Tag severity="info">{{ $t(`document_types.${data.type}`) }}</Tag>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by name" />
                        </template>
                    </Column>

                    <Column field="status" :header="$t('form.status')">
                        <template #body="{ data }">
                            <Tag v-if="data.status === 'draft'" severity="warning">{{ $t('status.draft') }}</Tag>
                            <Tag v-if="data.status === 'pending'" severity="info">{{ $t('status.pending') }}</Tag>
                            <Tag v-if="data.status === 'approved'" severity="success">{{ $t('status.approved') }}</Tag>
                            <Tag v-if="data.status === 'rejected'" severity="danger">{{ $t('status.rejected') }}</Tag>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by name" />
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </user-layout>
</template>

<script>
import DocumentMixin from '@/mixins/documents'
import { FilterMatchMode, FilterOperator } from 'primevue/api'
export default {
    name: 'Documents',
    mixins: [DocumentMixin],
    data() {
        return {
            filters: [],
        }
    },
    created() {
        this.getDocuments()
        this.initFilters()
    },
    methods: {
        /**
         * Function that redirects to customer view page
         * @param {object} event
         */
        viewDocumentNavigation(event) {
            this.$router.push(`/documents/${event.data.id}`)
        },

        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
                type: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
                status: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
            }
        },
    },
}
</script>

<style></style>
