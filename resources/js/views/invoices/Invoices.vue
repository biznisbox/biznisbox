<template>
    <user-layout>
        <div id="invoices_page">
            <user-header :title="$t('invoice.invoice', 2)">
                <template #actions>
                    <HeaderActionButton :label="$t('invoice.new_invoice')" icon="fa fa-plus" to="/invoices/new" />
                </template>
            </user-header>
            <div id="invoice_table" class="card">
                <DataTable
                    :value="invoices"
                    v-model:filters="filters"
                    :loading="loadingData"
                    column-resize-mode="expand"
                    paginator
                    data-key="id"
                    :rows="10"
                    filterDisplay="menu"
                    paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    :rows-per-page-options="[10, 20, 50]"
                    :globalFilterFields="['number']"
                    @row-dblclick="viewInvoiceNavigation"
                >
                    <template #empty>
                        <div class="p-4 pl-0 text-center w-full text-gray-500">
                            <i class="fa fa-info-circle empty-icon"></i>
                            <p>{{ $t('invoice.no_invoices') }}</p>
                            <Button
                                class="mt-3"
                                :label="$t('invoice.create_first_invoice')"
                                icon="fa fa-plus"
                                @click="$router.push('/invoices/new')"
                            />
                        </div>
                    </template>

                    <Column field="number" :header="$t('invoice.invoice_number')">
                        <template #body="{ data }">
                            {{ data.number }}
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by number" />
                        </template>
                    </Column>

                    <Column field="date" :header="$t('invoice.date_and_due_date')">
                        <template #body="{ data }">
                            <span>{{ formatDate(data.date) }}</span> <br />
                            <span>{{ formatDate(data.due_date) }}</span>
                        </template>

                        <template #filter="{ filterModel }">
                            <div class="flex">
                                <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by date" />
                            </div>
                        </template>
                    </Column>

                    <Column field="customer" :header="$t('invoice.customer_and_payer')">
                        <template #body="{ data }">
                            {{ formatText(data.customer?.name) }} <br />
                            {{ formatText(data.payer?.name) }}
                        </template>

                        <template #filter="{ filterModel }">
                            <div class="flex">
                                <InputText
                                    v-model="filterModel.value"
                                    type="text"
                                    class="p-column-filter"
                                    placeholder="Search by customer"
                                />
                            </div>
                        </template>
                    </Column>

                    <Column field="total" :header="$t('invoice.total')">
                        <template #body="{ data }">
                            {{ data.total + ' ' + data.currency }}
                        </template>

                        <template #filter="{ filterModel }">
                            <div class="flex">
                                <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by total" />
                            </div>
                        </template>
                    </Column>

                    <Column field="status" :header="$t('invoice.status')">
                        <template #body="{ data }">
                            <Tag v-if="data.status === 'paid'" severity="success">{{ $t('status.paid') }}</Tag>
                            <Tag v-if="data.status === 'unpaid'" severity="danger">{{ $t('status.unpaid') }}</Tag>
                            <Tag v-if="data.status === 'overdue'" severity="danger">{{ $t('status.overdue') }}</Tag>
                            <Tag v-if="data.status === 'draft'" severity="warning">{{ $t('status.draft') }}</Tag>
                            <Tag v-if="data.status === 'sent'" severity="warning">{{ $t('status.sent') }}</Tag>
                            <Tag v-if="data.status === 'refunded'" severity="">{{ $t('status.refunded') }}</Tag>
                            <Tag v-if="data.status === 'cancelled'" severity="">{{ $t('status.cancelled') }}</Tag>
                        </template>

                        <template #filter="{ filterModel }">
                            <Dropdown
                                v-model="filterModel.value"
                                :options="[
                                    { label: $t('status.paid'), value: 'paid' },
                                    { label: $t('status.unpaid'), value: 'unpaid' },
                                    { label: $t('status.overdue'), value: 'overdue' },
                                    { label: $t('status.draft'), value: 'draft' },
                                    { label: $t('status.sent'), value: 'sent' },
                                    { label: $t('status.refunded'), value: 'refunded' },
                                    { label: $t('status.cancelled'), value: 'cancelled' },
                                ]"
                                optionLabel="label"
                                optionValue="value"
                                filter
                                filterBy="label"
                                showClear
                                placeholder="Select a Status"
                                class="p-column-filter"
                            />
                        </template>
                    </Column>
                    <template #paginatorstart>
                        <div class="p-d-flex p-ai-center p-mr-2">
                            <Button class="p-button-rounded p-button-text p-button-plain" icon="fa fa-sync" @click="getInvoices()" />
                        </div>
                    </template>
                </DataTable>
            </div>
        </div>
    </user-layout>
</template>

<script>
import InvoiceMixin from '@/mixins/invoices'
import { FilterMatchMode, FilterOperator } from 'primevue/api'
export default {
    name: 'InvoicesPage',
    mixins: [InvoiceMixin],
    created() {
        this.getInvoices()
        this.initFilters()
    },

    data() {
        return {
            filters: null,
        }
    },

    methods: {
        viewInvoiceNavigation(rowData) {
            this.$router.push(`/invoices/${rowData.data.id}`)
        },

        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                number: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                customer: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                date: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                total: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
                status: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
            }
        },
    },
}
</script>

<style></style>
