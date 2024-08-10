<template>
    <div class="card p-4" v-if="hasPermission('invoices')">
        <span class="my-2 block">
            {{ $t('dashboard.number_of_unpaid_invoices') }}
        </span>
        <span> <i class="fas fa-file-invoice"></i> {{ totalUnpaidInvoices }} </span>
    </div>
</template>
<script>
export default {
    name: 'DashboardNumberOfUnpaidInvoices',
    data() {
        return {
            totalUnpaidInvoices: 0,
        }
    },
    created() {
        this.makeHttpRequest('GET', '/api/dashboard/data?type=number_of_unpaid_invoices').then((response) => {
            this.totalUnpaidInvoices = response.data.data
        })
    },
}
</script>
