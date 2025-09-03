<template>
    <DashboardCardWithIcon
        v-if="hasPermission('invoices')"
        :iconClass="'fas fa-file-invoice'"
        :dashboardTitle="$t('dashboard.number_of_unpaid_invoices')"
        :dashboardData="totalUnpaidInvoices"
    />
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
