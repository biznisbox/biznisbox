<template>
    <div class="card">
        <span class="font-bold">{{ $t('admin.dashboard.chart_of_logins_this_month') }}</span>
        <apexchart type="line" height="250" :options="options" :series="series"></apexchart>
    </div>
</template>

<script>
export default {
    name: 'ChartOfLoginsThisMonth',
    data() {
        return {
            options: [],
            series: [],
        }
    },
    created() {
        this.makeHttpRequest('GET', '/api/admin/dashboard?type=graph_of_logins_in_last_month').then((response) => {
            const dates = response.data.data.dates
            const counts = response.data.data.counts

            ;(this.options = {
                chart: {
                    toolbar: {
                        show: false,
                    },
                },
                markers: {
                    size: 4,
                },
                stroke: {
                    curve: 'smooth',
                },
                xaxis: {
                    categories: dates,
                },
            }),
                (this.series = [
                    {
                        name: 'Logins',
                        data: counts,
                    },
                ])
        })
    },
}
</script>
