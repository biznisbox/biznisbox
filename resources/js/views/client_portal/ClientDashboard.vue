<template>
    <DefaultLayout menu_type="client">
        <PageHeader :title="$t('client_portal.dashboard')" />

        <!-- Dashboard Cards -->
        <div class="grid md:grid-cols-2 grid-cols-1 gap-4 mb-4">
            <DashboardCardWithIcon
                :dashboard-data="dashboardData.contracts_count"
                :dashboard-title="$t('client_portal.number_of_contracts')"
                icon-class="fa fa-file-alt"
            />
            <DashboardCardWithIcon
                :dashboard-data="dashboardData.unpaid_invoices"
                :dashboard-title="$t('client_portal.number_of_unpaid_invoices')"
                icon-class="fa fa-file-invoice-dollar"
            />
            <DashboardCardWithIcon
                :dashboard-data="dashboardData.number_of_support_tickets"
                :dashboard-title="$t('client_portal.number_of_support_tickets')"
                icon-class="fa fa-headset"
            />
            <DashboardCardWithIcon
                :dashboard-data="dashboardData.number_of_bills"
                :dashboard-title="$t('client_portal.number_of_bills')"
                icon-class="fa fa-file-invoice"
            />
            <DashboardCardWithIcon
                :dashboard-data="dashboardData.number_of_quotes"
                :dashboard-title="$t('client_portal.number_of_quotes')"
                icon-class="fa fa-file-alt"
            />
        </div>
    </DefaultLayout>
</template>
<script>
export default {
    name: 'ClientPortalDashboard',
    data() {
        return {
            dashboardData: {
                contracts_count: 0,
                unpaid_invoices: 0,
                number_of_support_tickets: 0,
                number_of_bills: 0,
                number_of_quotes: 0,
                partner: [],
            },
        }
    },

    methods: {
        getDashboardData() {
            this.makeHttpRequest('GET', '/api/client-portal/dashboard').then((response) => {
                this.dashboardData = response.data.data
            })
        },
    },

    created() {
        this.getDashboardData()
    },
}
</script>
