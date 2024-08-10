<template>
    <div class="card p-4">
        <span class="my-2 block">
            {{ $t('dashboard.number_of_unpaid_bills') }}
        </span>
        <span> <i class="fas fa-file"></i> {{ totalUnpaidBills }} </span>
    </div>
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
