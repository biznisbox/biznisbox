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
                    :loading="loadingData"
                    column-resize-mode="expand"
                    paginator
                    :rows="10"
                    paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    :rows-per-page-options="[10, 20, 50]"
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
                    </Column>

                    <Column :header="$t('invoice.date_and_due_date')">
                        <template #body="{ data }">
                            <span>{{ formatDate(data.date) }}</span> <br />
                            <span>{{ formatDate(data.date) }}</span>
                        </template>
                    </Column>

                    <Column :header="$t('invoice.customer_and_payer')">
                        <template #body="{ data }">
                            {{ formatText(data.customer?.name) }} <br />
                            {{ formatText(data.payer?.name) }}
                        </template>
                    </Column>

                    <Column field="total" :header="$t('invoice.total')">
                        <template #body="{ data }">
                            {{ data.total + ' ' + data.currency }}
                        </template>
                    </Column>

                    <Column filter-field="status" :header="$t('invoice.status')">
                        <template #body="{ data }">
                            <Tag v-if="data.status === 'paid'" severity="success">{{ $t('status.paid') }}</Tag>
                            <Tag v-if="data.status === 'unpaid'" severity="danger">{{ $t('status.unpaid') }}</Tag>
                            <Tag v-if="data.status === 'overdue'" severity="danger">{{ $t('status.overdue') }}</Tag>
                            <Tag v-if="data.status === 'draft'" severity="warning">{{ $t('status.draft') }}</Tag>
                            <Tag v-if="data.status === 'sent'" severity="warning">{{ $t('status.sent') }}</Tag>
                            <Tag v-if="data.status === 'refunded'" severity="">{{ $t('status.refunded') }}</Tag>
                            <Tag v-if="data.status === 'cancelled'" severity="">{{ $t('status.cancelled') }}</Tag>
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
export default {
    name: 'InvoicesPage',
    mixins: [InvoiceMixin],
    created() {
        this.getInvoices()
    },

    methods: {
        viewInvoiceNavigation(rowData) {
            this.$router.push(`/invoices/${rowData.data.id}`)
        },
    },
}
</script>

<style></style>
