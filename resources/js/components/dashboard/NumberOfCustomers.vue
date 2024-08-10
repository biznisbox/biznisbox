<template>
    <div class="card p-4">
        <span class="my-2 block">
            {{ $t('dashboard.number_of_customers') }}
        </span>
        <span> <i class="fas fa-users"></i> {{ totalCustomers }} </span>
    </div>
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
