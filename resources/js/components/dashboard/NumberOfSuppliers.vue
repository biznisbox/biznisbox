<template>
    <div class="card p-4">
        <span class="my-2 block">
            {{ $t('dashboard.number_of_suppliers') }}
        </span>
        <span> <i class="fas fa-building"></i> {{ totalSuppliers }} </span>
    </div>
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
