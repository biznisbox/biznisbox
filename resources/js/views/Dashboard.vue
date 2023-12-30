<template>
    <user-layout>
        <LoadingScreen :blocked="loadingData">
            <user-header :title="$t('dashboard.title')" />

            <div id="numbers" class="grid">
                <div class="col-12 md:col-6 lg:col-3">
                    <DashboardCard :title="$t('dashboard.total_customers')" icon="fa fa-users" link="/partners" :data="data.customers" />
                </div>
                <div class="col-12 md:col-6 lg:col-3">
                    <DashboardCard :title="$t('dashboard.total_products')" icon="fa fa-boxes" link="/products" :data="data.products" />
                </div>

                <div class="col-12 md:col-6 lg:col-3">
                    <DashboardCard
                        :title="$t('dashboard.total_unpaid_invoices')"
                        icon="fa fa-file-invoice"
                        link="/invoices"
                        :data="data.unpaid_invoices"
                    />
                </div>
                <div class="col-12 md:col-6 lg:col-3">
                    <DashboardCard
                        :title="$t('dashboard.total_unpaid_bills')"
                        icon="fa fa-money-bill"
                        link="/bills"
                        :data="data.unpaid_bills"
                    />
                </div>
            </div>

            <div id="charts" style="max-height: 30rem">
                <div class="grid">
                    <div id="char_year" class="col-12 md:col-6">
                        <div class="card">
                            <DisplayData :input="$t('dashboard.year_income_expense_chart')" custom-value>
                                <Chart :data="data.year_income_expense_char" type="line" :height="100" />
                            </DisplayData>
                        </div>
                    </div>
                    <div id="char_current_month" class="col-12 md:col-6">
                        <div class="card">
                            <DisplayData :input="$t('dashboard.current_month_income_expense_chart')" custom-value>
                                <Chart :data="data.current_month_income_expense_char" type="pie" :height="100" />
                            </DisplayData>
                        </div>
                    </div>
                </div>
            </div>
        </LoadingScreen>
        <SpeedDial
            v-if="speedDialItems.length > 0"
            :model="speedDialItems"
            direction="up"
            :style="{ right: '1rem', bottom: '1rem' }"
            :tooltipOptions="{ position: 'left' }"
        />
    </user-layout>
</template>

<script>
export default {
    name: 'Dashboard',
    data() {
        return {
            speedDialItems: [],
            data: {
                year_income_expense_char: {
                    labels: [],
                    datasets: [],
                },
                current_month_income_expense_char: {
                    labels: [],
                    datasets: [],
                },
                customers: 0,
                products: 0,
                unpaid_invoices: 0,
                unpaid_bills: 0,
            },
        }
    },
    created() {
        this.getDashboardData()
        this.setSpeedDialItems()
    },
    methods: {
        getDashboardData() {
            this.makeHttpRequest('GET', '/api/dashboard').then((response) => {
                this.data = response.data.data
            })
        },
        setSpeedDialItems() {
            if (this.hasPermission('invoices')) {
                this.speedDialItems.push({
                    icon: 'fa fa-file-invoice',
                    label: this.$t('invoice.new_invoice'),
                    command: () => this.$router.push('/invoices/new'),
                })
            }
            if (this.hasPermission('bills')) {
                this.speedDialItems.push({
                    icon: 'fa fa-money-bill',
                    label: this.$t('bill.new_bill'),
                    command: () => this.$router.push('/bills/new'),
                })
            }
            if (this.hasPermission('products')) {
                this.speedDialItems.push({
                    icon: 'fa fa-boxes',
                    label: this.$t('product.new_product'),
                    command: () => this.$router.push('/products/new'),
                })
            }
            if (this.hasPermission('partners')) {
                this.speedDialItems.push({
                    icon: 'fa fa-users',
                    label: this.$t('partner.new_partner'),
                    command: () => this.$router.push('/partners/new'),
                })
            }
        },
    },
}
</script>

<style>
#char_year canvas {
    max-height: 25rem !important;
}
#char_current_month canvas {
    max-height: 15rem !important;
}
.p-speeddial-item {
    margin: 0.3rem 0 !important;
}
</style>
