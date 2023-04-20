<template>
    <user-layout>
        <div id="estimates_page">
            <user-header :title="$t('estimate.estimate', 2)">
                <template #actions>
                    <HeaderActionButton :label="$t('estimate.new_estimate')" icon="fa fa-plus" to="/estimates/new" />
                </template>
            </user-header>
            <div id="estimate_table" class="card">
                <DataTable
                    :value="estimates"
                    v-model:filters="filters"
                    :loading="loadingData"
                    column-resize-mode="expand"
                    paginator
                    data-key="id"
                    filter-display="menu"
                    :rows="10"
                    paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    :rows-per-page-options="[10, 20, 50]"
                    :globalFilterFields="['number', 'status', 'total']"
                    @row-dblclick="viewEstimateNavigation"
                >
                    <template #empty>
                        <div class="p-4 pl-0 text-center w-full text-gray-500">
                            <i class="fa fa-info-circle empty-icon"></i>
                            <p>{{ $t('estimate.no_estimates') }}</p>
                            <Button
                                class="mt-3"
                                :label="$t('estimate.create_first_estimate')"
                                icon="fa fa-plus"
                                @click="$router.push('/estimates/new')"
                            />
                        </div>
                    </template>

                    <Column field="number" :header="$t('estimate.estimate_number')">
                        <template #body="{ data }">
                            {{ data.number }}
                        </template>

                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by number" />
                        </template>
                    </Column>

                    <Column field="date" :header="$t('estimate.date_and_due_date')">
                        <template #body="{ data }">
                            <span>{{ data.date ? formatDate(data.date) : '' }}</span> <br />
                            <span>{{ data.valid_until ? formatDate(data.valid_until) : '' }}</span>
                        </template>

                        <template #filter="{ filterModel }">
                            <div class="flex">
                                <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by date" />
                            </div>
                        </template>
                    </Column>

                    <Column field="customer" :header="$t('estimate.customer_and_payer')">
                        <template #body="{ data }">
                            {{ formatText(data.customer_name) }} <br />
                            {{ formatText(data.payer_name) }}
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by customer" />
                        </template>
                    </Column>

                    <Column field="total" :header="$t('invoice.total')">
                        <template #body="{ data }">
                            {{ data.total + ' ' + data.currency }}
                        </template>

                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by total" />
                        </template>
                    </Column>

                    <Column filter-field="status" :header="$t('invoice.status')">
                        <template #body="{ data }">
                            <Tag v-if="data.status === 'accepted'" severity="success">{{ $t('status.accepted') }}</Tag>
                            <Tag v-if="data.status === 'rejected'" severity="danger">{{ $t('status.rejected') }}</Tag>
                            <Tag v-if="data.status === 'draft'" severity="warning">{{ $t('status.draft') }}</Tag>
                            <Tag v-if="data.status === 'sent'" severity="warning">{{ $t('status.sent') }}</Tag>
                            <Tag v-if="data.status === 'viewed'" severity="warning">{{ $t('status.viewed') }}</Tag>
                            <Tag v-if="data.status === 'expired'" severity="danger">{{ $t('status.expired') }}</Tag>
                            <Tag v-if="data.status === 'cancelled'" severity="">{{ $t('status.cancelled') }}</Tag>
                            <Tag v-if="data.status === 'converted'" severity="success">{{ $t('status.converted') }}</Tag>
                        </template>

                        <template #filter="{ filterModel }">
                            <Dropdown
                                v-model="filterModel.value"
                                :options="[
                                    { label: $t('status.accepted'), value: 'accepted' },
                                    { label: $t('status.rejected'), value: 'rejected' },
                                    { label: $t('status.draft'), value: 'draft' },
                                    { label: $t('status.sent'), value: 'sent' },
                                    { label: $t('status.viewed'), value: 'viewed' },
                                    { label: $t('status.expired'), value: 'expired' },
                                    { label: $t('status.cancelled'), value: 'cancelled' },
                                    { label: $t('status.converted'), value: 'converted' },
                                ]"
                                optionLabel="label"
                                optionValue="value"
                                class="p-column-filter"
                                placeholder="Select a status"
                            />
                        </template>
                    </Column>
                    <template #paginatorstart>
                        <div class="p-d-flex p-ai-center p-mr-2">
                            <Button class="p-button-rounded p-button-text p-button-plain" icon="fa fa-sync" @click="getEstimates()" />
                        </div>
                    </template>
                </DataTable>
            </div>
        </div>
    </user-layout>
</template>

<script>
import EstimateMixin from '@/mixins/estimates'
import { FilterMatchMode, FilterOperator } from 'primevue/api'
export default {
    name: 'EstimatesPage',
    mixins: [EstimateMixin],
    created() {
        this.getEstimates()
        this.initFilters()
    },

    data() {
        return {
            filters: null,
        }
    },

    methods: {
        viewEstimateNavigation(rowData) {
            this.$router.push(`/estimates/${rowData.data.id}`)
        },

        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                number: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                date: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                total: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
                status: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
            }
        },
    },
}
</script>

<style></style>
