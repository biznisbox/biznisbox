<template>
    <div class="card">
        <span class="font-bold">{{ $t('dashboard.current_year_monthly_income_and_expenses') }}</span>
        <apexchart type="line" height="250" :options="options" :series="series"></apexchart>
    </div>
</template>
<script>
export default {
    name: 'DashboardCurrentYearMonthlyIncomeAndExpenses',
    data() {
        return {
            options: {
                chart: {
                    toolbar: {
                        show: false,
                    },
                },
                labels: [
                    this.$t('month.january'),
                    this.$t('month.february'),
                    this.$t('month.march'),
                    this.$t('month.april'),
                    this.$t('month.may'),
                    this.$t('month.june'),
                    this.$t('month.july'),
                    this.$t('month.august'),
                    this.$t('month.september'),
                    this.$t('month.october'),
                    this.$t('month.november'),
                    this.$t('month.december'),
                ],
                colors: ['#28a745', '#dc3545'],
            },
            series: [
                {
                    name: this.$t('dashboard.income'),
                    data: [],
                },
                {
                    name: this.$t('dashboard.expense'),
                    data: [],
                },
            ],
        }
    },
    created() {
        this.makeHttpRequest('GET', '/api/dashboard/data?type=current_year_monthly_income_and_expenses').then((response) => {
            this.income = response.data.data.income
            this.expense = response.data.data.expense

            this.series[0].data = this.income
            this.series[1].data = this.expense
        })
    },
}
</script>
