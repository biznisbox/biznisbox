<template>
    <DefaultLayout>
        <PageHeader :title="$t('payment.payment', 2)" />

        <div id="payments_table" class="card">
            <DataTable
                :value="payments"
                paginator
                dataKey="id"
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50, 100]"
                :loading="loadingData"
                @row-dblclick="viewPaymentNavigation"
                filter-display="menu"
            >
                <template #empty>
                    <div class="p-4 pl-0 text-center w-full dark:text-gray-400">
                        <i class="fa fa-info-circle empty-icon"></i>
                        <p>{{ $t('payment.no_payments') }}</p>
                    </div>
                </template>

                <Column field="number" :header="$t('form.number')" />
                <Column :header="$t('form.payment_method')">
                    <template #body="{ data }">
                        <span>
                            <i v-if="data.payment_method === 'cash'" class="fa fa-money-bill"></i>
                            <i v-else-if="data.payment_method === 'bank_card'" class="fa fa-credit-card"></i>
                            <i v-else-if="data.payment_method === 'bank_transfer'" class="fa fa-university"></i>
                            <i v-else-if="data.payment_method === 'stripe'" class="fab fa-stripe"></i>
                            <i v-else-if="data.payment_method === 'paypal'" class="fab fa-paypal"></i>
                        </span>
                    </template>
                </Column>

                <Column field="amount" :header="$t('form.amount')">
                    <template #body="{ data }">
                        <span>{{ formatMoney(data.amount, data.currency) }}</span>
                    </template>
                </Column>

                <Column field="status" :header="$t('form.status')">
                    <template #body="{ data }">
                        <Tag :value="$t(`status.${data.status}`)" />
                    </template>
                </Column>

                <template #paginatorstart>
                    <div>
                        <Button icon="fa fa-sync" @click="getPayments" id="refresh_button" />
                    </div>
                </template>
            </DataTable>
        </div>
    </DefaultLayout>
</template>

<script>
export default {
    name: 'PaymentsPage',
    data() {
        return {
            payments: [],
        }
    },
    methods: {
        getPayments() {
            this.makeHttpRequest('GET', '/api/payments').then((response) => {
                this.payments = response.data.data
            })
        },
    },

    created() {
        this.getPayments()
    },
}
</script>
<style></style>
