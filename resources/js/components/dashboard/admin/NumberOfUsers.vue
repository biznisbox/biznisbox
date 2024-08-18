<template>
    <div class="card p-4">
        <span class="my-2 block">
            {{ $t('admin.dashboard.number_of_users') }}
        </span>
        <span> <i class="fas fa-users"></i> {{ numberOfUsers }} </span>
    </div>
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
