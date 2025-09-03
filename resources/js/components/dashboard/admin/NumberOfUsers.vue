<template>
    <DashboardCardWithIcon
        v-if="hasPermission('admin_users')"
        :iconClass="'fas fa-user'"
        :dashboardTitle="$t('admin.dashboard.number_of_users')"
        :dashboardData="numberOfUsers"
    />
</template>
<script>
export default {
    name: 'AdminDashboardNumberOfUsers',
    data() {
        return {
            numberOfUsers: 0,
        }
    },
    created() {
        this.makeHttpRequest('GET', '/api/admin/dashboard?type=number_of_users').then((response) => {
            this.numberOfUsers = response.data.data
        })
    },
}
</script>
