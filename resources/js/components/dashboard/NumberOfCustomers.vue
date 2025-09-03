<template>
    <DashboardCardWithIcon
        v-if="hasPermission('partners')"
        :iconClass="'fas fa-users'"
        :dashboardTitle="$t('dashboard.number_of_customers')"
        :dashboardData="totalCustomers"
    />
</template>
<script>
export default {
    name: 'DashboardNumberOfCustomers',
    data() {
        return {
            totalCustomers: 0,
        }
    },
    created() {
        this.makeHttpRequest('GET', '/api/dashboard/data?type=number_of_customers').then((response) => {
            this.totalCustomers = response.data.data
        })
    },
}
</script>
