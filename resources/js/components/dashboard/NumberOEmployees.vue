<template>
    <div class="card p-4">
        <span class="my-2 block">
            {{ $t('dashboard.number_of_employees') }}
        </span>
        <span> <i class="fas fa-users"></i> {{ totalNumberOfEmployees }} </span>
    </div>
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
