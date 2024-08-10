<template>
    <div class="card">
        <span class="font-bold"> {{ $t('dashboard.current_month_income_expense_chart') }} </span>
        <apexchart type="pie" height="250" :options="options" :series="series"></apexchart>
    </div>
</template>
<script>
export default {
    name: 'MonthIncomeExpenseGraph',
    data() {
        return {
            options: {
                labels: [this.$t('dashboard.income'), this.$t('dashboard.expense')],
                colors: ['#28a745', '#dc3545'],
            },
            series: [0, 0],
        }
    },
    created() {
        this.makeHttpRequest('GET', '/api/dashboard/data?type=current_month_income_and_expenses').then((response) => {
            const income = response.data.data.income
            const expense = response.data.data.expense
            this.series = [income, expense]
        })
    },
}
</script>
