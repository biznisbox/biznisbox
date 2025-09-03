<template>
    <DashboardCardWithIcon
        v-if="hasPermission('employees')"
        :iconClass="'fas fa-user-friends'"
        :dashboardTitle="$t('dashboard.number_of_employees')"
        :dashboardData="totalNumberOfEmployees"
    />
</template>
<script>
export default {
    name: 'DashboardNumberOfEmployees',
    data() {
        return {
            totalNumberOfEmployees: 0,
        }
    },
    created() {
        this.makeHttpRequest('GET', '/api/dashboard/data?type=number_of_employees').then((response) => {
            this.totalNumberOfEmployees = response.data.data
        })
    },
}
</script>
