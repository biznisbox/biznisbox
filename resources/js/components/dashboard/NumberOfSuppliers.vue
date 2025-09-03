<template>
    <DashboardCardWithIcon
        v-if="hasPermission('partners')"
        :iconClass="'fas fa-building'"
        :dashboardTitle="$t('dashboard.number_of_suppliers')"
        :dashboardData="totalSuppliers"
    />
</template>
<script>
export default {
    name: 'DashboardNumberOfSuppliers',
    data() {
        return {
            totalSuppliers: 0,
        }
    },
    created() {
        this.makeHttpRequest('GET', '/api/dashboard/data?type=number_of_suppliers').then((response) => {
            this.totalSuppliers = response.data.data
        })
    },
}
</script>
