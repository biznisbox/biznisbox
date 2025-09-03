<template>
    <DashboardCardWithIcon
        v-if="hasPermission('bills')"
        :iconClass="'fas fa-file'"
        :dashboardTitle="$t('dashboard.number_of_unpaid_bills')"
        :dashboardData="totalUnpaidBills"
    />
</template>
<script>
export default {
    name: 'DashboardNumberOfUnpaidBills',
    data() {
        return {
            totalUnpaidBills: 0,
        }
    },
    created() {
        this.makeHttpRequest('GET', '/api/dashboard/data?type=number_of_unpaid_bills').then((response) => {
            this.totalUnpaidBills = response.data.data
        })
    },
}
</script>
