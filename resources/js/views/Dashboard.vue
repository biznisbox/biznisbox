<template>
    <DefaultLayout>
        <PageHeader :title="$t('dashboard.title')">
            <template v-slot:actions>
                <Button v-if="!editDashboard" @click="editDashboard = true" icon="fa fa-edit" text />
                <Button
                    v-if="editDashboard"
                    @click="editDashboard = false"
                    icon="fa fa-save"
                    :label="$t('basic.save')"
                    severity="success"
                />
                <Button
                    v-if="editDashboard"
                    @click="addElementDialog = true"
                    icon="fa fa-plus"
                    :label="$t('dashboard.add_element')"
                    severity="secondary"
                />
                <Button
                    v-if="editDashboard"
                    @click="removeElementDialog = true"
                    icon="fa fa-trash"
                    :label="$t('dashboard.remove_element')"
                    severity="danger"
                />
            </template>
        </PageHeader>

        <LoadingScreen :blocked="loadingData">
            <GridLayout
                v-model:layout="layout"
                responsive
                prevent-collision
                :is-resizable="editDashboard"
                :col-num="12"
                :row-height="50"
                :is-draggable="editDashboard"
                use-css-transforms
            >
                <GridItem
                    v-for="item in layout"
                    :key="item.i"
                    :x="item.x"
                    :y="item.y"
                    :w="item.w"
                    :min-w="item.minW"
                    :min-h="item.minH"
                    :max-w="item.maxW"
                    :max-h="item.maxH"
                    :h="item.h"
                    :i="item.i"
                    @moved="saveDashboardLayout"
                    @resized="saveDashboardLayout"
                    class="grid-item"
                >
                    <div
                        v-if="hasPermission(item.permission) || item.permission === 'dashboard'"
                        :id="item.i"
                        :data-component="item.component"
                    >
                        <component :is="item.component" />
                    </div>
                </GridItem>
            </GridLayout>
        </LoadingScreen>

        <!-- Add Element Dialog -->
        <Dialog v-model:visible="addElementDialog" :header="$t('dashboard.add_element')" modal :style="{ width: '400px' }">
            <SelectInput v-model="selectedComponent" :options="availableComponents" option-label="name" option-value="i" />

            <template v-slot:footer>
                <Button @click="addElementDialog = false" severity="secondary" :label="$t('basic.cancel')" />
                <Button @click="addToDashboard" severity="success" :label="$t('basic.add')" />
            </template>
        </Dialog>

        <!-- Remove Element Dialog -->
        <Dialog v-model:visible="removeElementDialog" :header="$t('dashboard.remove_element')" modal :style="{ width: '400px' }">
            <SelectInput v-model="selectedComponent" :options="layout" option-label="name" option-value="i" />

            <template v-slot:footer>
                <Button @click="removeElementDialog = false" severity="secondary" :label="$t('basic.cancel')" />
                <Button @click="removeFromDashboard" severity="danger" :label="$t('basic.remove')" />
            </template>
        </Dialog>

        <SpeedDial
            v-if="speedDialItems.length > 0"
            :model="speedDialItems"
            direction="up"
            :style="{ position: 'absolute', right: '20px', bottom: '20px' }"
            :buttonProps="{ rounded: true }"
            :tooltipOptions="{ position: 'right' }"
        />
    </DefaultLayout>
</template>

<script>
import { GridLayout, GridItem } from 'grid-layout-plus'
import Welcome from '@/components/dashboard/Welcome.vue'
import NumberOfCustomers from '@/components/dashboard/NumberOfCustomers.vue'
import NumberOfSuppliers from '@/components/dashboard/NumberOfSuppliers.vue'
import MonthIncomeExpenseGraph from '@/components/dashboard/MonthIncomeExpenseGraph.vue'
import NumberOfUnpaidInvoices from '@/components/dashboard/NumberOfUnpaidInvoices.vue'
import NumberOfUnpaidBills from '@/components/dashboard/NumberOfUnpaidBills.vue'
import NumberOEmployees from '@/components/dashboard/NumberOEmployees.vue'
import CurrentYearMonthlyIncomeAndExpenses from '@/components/dashboard/CurrentYearMonthlyIncomeAndExpenses.vue'
import Clock from '@/components/dashboard/Clock.vue'

export default {
    name: 'DashboardPage',
    components: {
        GridLayout,
        GridItem,
        // Import the dashboard components
        Welcome,
        NumberOfCustomers,
        NumberOfSuppliers,
        MonthIncomeExpenseGraph,
        NumberOfUnpaidInvoices,
        NumberOfUnpaidBills,
        NumberOEmployees,
        CurrentYearMonthlyIncomeAndExpenses,
        Clock,
    },
    methods: {
        saveDashboardLayout() {
            this.makeHttpRequest('POST', '/api/dashboard', { layout: this.layout })
        },

        getDashboardLayout() {
            this.makeHttpRequest('GET', '/api/dashboard').then((response) => {
                this.layout = JSON.parse(response.data.data.content)
            })
        },

        removeFromDashboard() {
            this.availableComponents.push(this.layout.find((item) => item.i === this.selectedComponent))
            this.layout = this.layout.filter((item) => item.i !== this.selectedComponent)
            this.removeElementDialog = false
            this.saveDashboardLayout()
        },

        addToDashboard() {
            let component = this.availableComponents.find((component) => component.i === this.selectedComponent)
            if (this.hasPermission(component.permission) || component.permission === 'dashboard') {
                this.layout.push({
                    x: Math.floor(Math.random() * 6) * 2,
                    y: Math.floor(Math.random() * 6) * 2,
                    w: component.minW,
                    h: component.minH,
                    minH: component.minH,
                    minW: component.minW,
                    i: component.i,
                    name: component.name,
                    component: component.component,
                    permission: component.permission,
                })
                this.addElementDialog = false
                this.saveDashboardLayout()
            } else {
                this.showToast(this.$t('errors.permission_denied'), this.$t('errors.permission_denied_message'), 'error')
            }
        },

        setSpeedDialItems() {
            if (this.hasPermission('invoices')) {
                this.speedDialItems.push({
                    icon: 'fa fa-file-invoice',
                    label: this.$t('invoice.new_invoice'),
                    command: () => this.$router.push({ name: 'invoice-create' }),
                })
            }
            if (this.hasPermission('bills')) {
                this.speedDialItems.push({
                    icon: 'fa fa-money-bill',
                    label: this.$t('bill.new_bill'),
                    command: () => this.$router.push({ name: 'bill-create' }),
                })
            }
            if (this.hasPermission('products')) {
                this.speedDialItems.push({
                    icon: 'fa fa-boxes',
                    label: this.$t('product.new_product'),
                    command: () => this.$router.push({ name: 'product-create' }),
                })
            }
            if (this.hasPermission('partners')) {
                this.speedDialItems.push({
                    icon: 'fa fa-users',
                    label: this.$t('partner.new_partner'),
                    command: () => this.$router.push({ name: 'partner-create' }),
                })
            }
            if (this.hasPermission('support')) {
                this.speedDialItems.push({
                    icon: 'fa fa-life-ring',
                    label: this.$t('support.new_ticket'),
                    command: () => this.$router.push({ name: 'support-ticket-create' }),
                })
            }
        },
    },

    created() {
        this.getDashboardLayout()
        this.setSpeedDialItems()
    },

    data() {
        return {
            speedDialItems: [],
            layout: [],
            selectedComponent: null,
            addElementDialog: false,
            removeElementDialog: false,
            editDashboard: false,
            availableComponents: [
                { name: this.$t('dashboard.welcome'), component: 'Welcome', minW: 2, minH: 1, i: 0, permission: 'dashboard' },
                {
                    name: this.$t('dashboard.number_of_customers'),
                    component: 'NumberOfCustomers',
                    minW: 4,
                    minH: 2,
                    i: 1,
                    permission: 'partners',
                },
                {
                    name: this.$t('dashboard.number_of_suppliers'),
                    component: 'NumberOfSuppliers',
                    minW: 4,
                    minH: 2,
                    i: 2,
                    permission: 'partners',
                },
                {
                    name: this.$t('dashboard.current_month_income_expense_chart'),
                    component: 'MonthIncomeExpenseGraph',
                    minW: 6,
                    minH: 5,
                    i: 3,
                    permission: 'transactions',
                },
                {
                    name: this.$t('dashboard.number_of_unpaid_invoices'),
                    component: 'NumberOfUnpaidInvoices',
                    minW: 4,
                    minH: 2,
                    i: 4,
                    permission: 'invoices',
                },
                {
                    name: this.$t('dashboard.number_of_unpaid_bills'),
                    component: 'NumberOfUnpaidBills',
                    minW: 4,
                    minH: 2,
                    i: 5,
                    permission: 'bills',
                },
                {
                    name: this.$t('dashboard.number_of_employees'),
                    component: 'NumberOEmployees',
                    minW: 4,
                    minH: 2,
                    i: 6,
                    permission: 'employees',
                },
                {
                    name: this.$t('dashboard.current_year_monthly_income_and_expenses'),
                    component: 'CurrentYearMonthlyIncomeAndExpenses',
                    minW: 6,
                    minH: 5,
                    i: 7,
                    permission: 'transactions',
                },
                { name: this.$t('dashboard.current_time'), component: 'Clock', minW: 2, minH: 2, i: 8, permission: 'dashboard' },
            ],
        }
    },

    watch: {
        layout: {
            handler: function (newVal) {
                this.availableComponents = this.availableComponents.filter((component) => !newVal.find((item) => item.i === component.i))
            },
            deep: true,
        },
    },
}
</script>
<style></style>
