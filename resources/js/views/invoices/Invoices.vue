<template>
    <DefaultLayout>
        <PageHeader :title="$t('invoice.invoice', 3)">
            <template #actions>
                <Button :label="$t('invoice.new_invoice')" icon="fa fa-plus" @click="$router.push('/invoices/create')" />
            </template>
        </PageHeader>

        <div id="invoice_table" class="card">
            <DataTable
                :value="invoices"
                :loading="loadingData"
                paginator
                dataKey="id"
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50, 100]"
                filter-display="menu"
                v-model:filters="filters"
                @row-dblclick="viewInvoiceNavigation"
            >
                <template #empty>
                    <div class="p-4 pl-0 text-center w-full">
                        <i class="fa fa-info-circle empty-icon"></i>
                        <p>{{ $t('invoice.no_invoices') }}</p>
                        <Button
                            class="mt-3"
                            :label="$t('invoice.create_first_invoice')"
                            icon="fa fa-plus"
                            @click="$router.push('/invoices/create')"
                        />
                    </div>
                </template>

                <Column field="number" :header="$t('form.number')">
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" type="text" placeholder="Search by number" />
                    </template>
                </Column>

                <Column field="date" :header="$t('invoice.date_and_due_date')">
                    <template #body="{ data }">
                        <span>{{ formatDate(data.date) }}</span> <br />
                        <span>{{ formatDate(data.due_date) }}</span>
                    </template>
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" type="text" placeholder="Search by date" />
                    </template>
                </Column>
                <Column field="customer" :header="$t('invoice.customer_and_payer')">
                    <template #body="{ data }">
                        {{ formatText(data.customer_name) }} <br />
                        {{ formatText(data.payer_name) }}
                    </template>
                </Column>
                <Column field="total" :header="$t('form.total')">
                    <template #body="{ data }">
                        {{ formatMoney(data.total, data.currency) }}
                    </template>

                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" type="text" placeholder="Search by total" />
                    </template>
                </Column>
                <Column field="status" :header="$t('form.status')">
                    <template #body="{ data }">
                        <Tag v-if="data.status === 'paid'" severity="success">{{ $t('status.paid') }}</Tag>
                        <Tag v-if="data.status === 'unpaid'" severity="danger">{{ $t('status.unpaid') }}</Tag>
                        <Tag v-if="data.status === 'overdue'" severity="danger">{{ $t('status.overdue') }}</Tag>
                        <Tag v-if="data.status === 'draft'" severity="warn">{{ $t('status.draft') }}</Tag>
                        <Tag v-if="data.status === 'sent'" severity="warn">{{ $t('status.sent') }}</Tag>
                        <Tag v-if="data.status === 'refunded'" severity="secondary">{{ $t('status.refunded') }}</Tag>
                        <Tag v-if="data.status === 'cancelled'" severity="secondary">{{ $t('status.cancelled') }}</Tag>
                        <Tag v-if="data.status === 'partial'" severity="warn">{{ $t('status.partial') }}</Tag>
                        <Tag v-if="data.status === 'overpaid'" severity="danger">{{ $t('status.overpaid') }}</Tag>
                    </template>
                    <template #filter="{ filterModel }">
                        <Select
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
                            option-label="label"
                            option-value="value"
                            show-clear
                        />
                    </template>
                </Column>
                <template #paginatorstart>
                    <Button icon="fa fa-sync" @click="getInvoices" id="refresh_button" />
                </template>
            </DataTable>
        </div>
    </DefaultLayout>
</template>

<script>
import { FilterMatchMode, FilterOperator } from '@primevue/core/api'
import InvoicesMixin from '@/mixins/invoices'
export default {
    name: 'InvoicesPage',
    mixins: [InvoicesMixin],
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
        initFilters() {
            this.filters = {
                number: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                date: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                total: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
                status: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
            }
        },
    },
}
</script>
