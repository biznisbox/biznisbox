<template>
    <DefaultLayout menu_type="client">
        <PageHeader :title="$t('invoice.invoice', 3)" />

        <div id="invoice_table" class="card">
            <DataTable
                :value="invoices"
                :loading="loadingData"
                paginator
                dataKey="id"
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50, 100]"
                @row-dblclick="viewInvoiceNavigationClientPortal"
            >
                <template #empty>
                    <div class="p-4 pl-0 text-center w-full dark:text-gray-400">
                        <i class="fa fa-info-circle empty-icon"></i>
                        <p>{{ $t('invoice.no_invoices') }}</p>
                    </div>
                </template>

                <Column field="number" :header="$t('form.number')"> </Column>

                <Column field="date" :header="$t('invoice.date_and_due_date')">
                    <template #body="{ data }">
                        <span>{{ formatDate(data.date) }}</span> <br />
                        <span>{{ formatDate(data.due_date) }}</span>
                    </template>
                </Column>
                <Column field="total" :header="$t('form.total')">
                    <template #body="{ data }">
                        {{ formatMoney(data.total, data.currency) }}
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
                </Column>
                <template #paginatorstart>
                    <Button icon="fa fa-sync" @click="getInvoices" id="refresh_button" />
                </template>
            </DataTable>
        </div>
    </DefaultLayout>
</template>

<script>
export default {
    name: 'ClientPortalInvoicesPage',
    data() {
        return {
            invoices: null,
        }
    },

    methods: {
        getInvoices() {
            this.makeHttpRequest('GET', '/api/client-portal/invoices').then((response) => {
                this.invoices = response.data.data
            })
        },

        viewInvoiceNavigationClientPortal(rowData) {
            this.$router.push({
                name: 'client-portal-invoice-view',
                params: { id: rowData.data.id },
            })
        },
    },

    created() {
        this.getInvoices()
    },
}
</script>
