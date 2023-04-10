<template>
    <user-layout>
        <div id="view_customer_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="customer.name">
                    <template #actions>
                        <Button :label="$t('basic.edit')" icon="fa fa-pen" class="p-button-success" @click="editCustomerNavigate" />
                        <Button
                            :label="$t('basic.delete')"
                            icon="fa fa-trash"
                            class="p-button-danger"
                            @click="deleteCustomerAsk($route.params.id)"
                        />
                    </template>
                </user-header>

                <div class="grid">
                    <div class="col-12 md:col-4">
                        <div class="card">
                            <div class="card-header">
                                <h3>{{ $t('customer.customer_details') }}</h3>
                            </div>
                            <div class="grid">
                                <div class="col-6">
                                    <DisplayData :input="$t('customer.name')" :value="customer.name" />
                                </div>
                                <div class="col-6">
                                    <Tag v-if="customer.type === 'company'" :value="$t('customer.company')" />
                                    <Tag v-if="customer.type === 'individual'" :value="$t('customer.individual')" />
                                </div>
                            </div>
                            <DisplayData :input="$t('customer.vat_number')" :value="customer.vat_number" />
                            <DisplayData :input="$t('customer.website')" :value="customer.website" is-link />
                            <DisplayData :input="$t('customer.language')" :value="customer.language" />
                            <DisplayData
                                :input="$t('customer.email')"
                                :value="`${customer.email}`"
                                :link="`mailto:${customer.email}`"
                                is-link
                            />
                            <DisplayData :input="$t('customer.phone')" :value="customer.phone" :link="`tel:${customer.phone}`" is-link />
                            <DisplayData :input="$t('customer.notes')" :value="customer.notes" />
                        </div>
                    </div>

                    <div class="col-12 md:col-8">
                        <div class="card">
                            <TabView id="customers_tabs">
                                <TabPanel :header="$t('customer.address', 2)">
                                    <div class="p-3">
                                        <div class="grid">
                                            <div class="col-12 md:col-6">
                                                <h3 class="text-lg font-bold">{{ $t('customer.billing_address') }}</h3>
                                                <DisplayData :input="$t('address.address')" :value="customer.addresses[0].address" />
                                                <DisplayData :input="$t('address.zip')" :value="customer.addresses[0].zip_code" />
                                                <DisplayData :input="$t('address.city')" :value="customer.addresses[0].city" />
                                                <DisplayData
                                                    :input="$t('address.country')"
                                                    :value="formatCountry(customer.addresses[0].country)"
                                                />
                                                <DisplayData :input="$t('customer.notes')" :value="customer.addresses[0].notes" />
                                            </div>

                                            <div class="col-12 md:col-6">
                                                <h3 class="text-lg font-bold">{{ $t('customer.shipping_address') }}</h3>
                                                <DisplayData :input="$t('address.address')" :value="customer.addresses[1].address" />
                                                <DisplayData :input="$t('address.zip')" :value="customer.addresses[1].zip_code" />
                                                <DisplayData :input="$t('address.city')" :value="customer.addresses[1].city" />
                                                <DisplayData :input="$t('address.country')" :value="customer.addresses[1].country" />
                                                <DisplayData :input="$t('customer.notes')" :value="customer.addresses[1].notes" />
                                            </div>
                                        </div>
                                    </div>
                                </TabPanel>

                                <TabPanel :header="$t('invoice.invoice', 2)">
                                    <DataTable :value="customer.invoices" @row-dblclick="viewInvoiceNavigation">
                                        <template #empty>
                                            <div class="p-4 pl-0 text-center w-full text-gray-500">
                                                <i class="fa fa-info-circle empty-icon"></i>
                                                <p>{{ $t('invoice.no_invoices') }}</p>
                                            </div>
                                        </template>
                                        <Column field="number" :header="$t('invoice.invoice_number')" />
                                        <Column field="date" header="Date and due date">
                                            <template #body="{ data }">
                                                <div>{{ data.date ? formatDate(data.date) : '' }}</div>
                                                <div>{{ data.due_date ? formatDate(data.due_date) : '' }}</div>
                                            </template>
                                        </Column>
                                        <Column field="total" :header="$t('invoice.date_and_due_date')">
                                            <template #body="{ data }">
                                                {{ data.total + ' ' + data.currency }}
                                            </template>
                                        </Column>
                                        <Column filter-field="status" :header="$t('invoice.status')">
                                            <template #body="{ data }">
                                                <Tag v-if="data.status === 'paid'" severity="success">{{ $t('status.paid') }}</Tag>
                                                <Tag v-if="data.status === 'unpaid'" severity="danger">{{ $t('status.unpaid') }}</Tag>
                                                <Tag v-if="data.status === 'overdue'" severity="danger">{{ $t('status.overdue') }}</Tag>
                                                <Tag v-if="data.status === 'draft'" severity="warning">{{ $t('status.draft') }}</Tag>
                                                <Tag v-if="data.status === 'sent'" severity="warning">{{ $t('status.sent') }}</Tag>
                                                <Tag v-if="data.status === 'refunded'" severity="">{{ $t('status.refunded') }}</Tag>
                                                <Tag v-if="data.status === 'cancelled'" severity="">{{ $t('status.cancelled') }}</Tag>
                                            </template>
                                        </Column>
                                    </DataTable>
                                </TabPanel>
                                <TabPanel :header="$t('estimate.estimate', 2)">
                                    <DataTable :value="customer.estimates" @row-dblclick="viewEstimateNavigation">
                                        <template #empty>
                                            <div class="p-4 pl-0 text-center w-full text-gray-500">
                                                <i class="fa fa-info-circle empty-icon"></i>
                                                <p>{{ $t('estimate.no_estimates') }}</p>
                                            </div>
                                        </template>
                                        <Column field="number" :header="$t('estimate.estimate_number')" />
                                        <Column :header="$t('estimate.date_and_due_date')">
                                            <template #body="{ data }">
                                                <span>{{ data.date ? formatDate(data.date) : '' }}</span> <br />
                                                <span>{{ data.valid_until ? formatDate(data.valid_until) : '' }}</span>
                                            </template>
                                        </Column>
                                        <Column field="total" :header="$t('invoice.total')">
                                            <template #body="{ data }">
                                                {{ data.total + ' ' + data.currency }}
                                            </template>
                                        </Column>
                                        <Column filter-field="status" :header="$t('invoice.status')">
                                            <template #body="{ data }">
                                                <Tag v-if="data.status === 'accepted'" severity="success">{{ $t('status.accepted') }}</Tag>
                                                <Tag v-if="data.status === 'rejected'" severity="danger">{{ $t('status.rejected') }}</Tag>
                                                <Tag v-if="data.status === 'draft'" severity="warning">{{ $t('status.draft') }}</Tag>
                                                <Tag v-if="data.status === 'sent'" severity="warning">{{ $t('status.sent') }}</Tag>
                                                <Tag v-if="data.status === 'viewed'" severity="warning">{{ $t('status.viewed') }}</Tag>
                                                <Tag v-if="data.status === 'expired'" severity="danger">{{ $t('status.expired') }}</Tag>
                                                <Tag v-if="data.status === 'cancelled'" severity="">{{ $t('status.cancelled') }}</Tag>
                                                <Tag v-if="data.status === 'converted'" severity="success">{{
                                                    $t('status.converted')
                                                }}</Tag>
                                            </template>
                                        </Column>
                                    </DataTable>
                                </TabPanel>
                                <TabPanel :header="$t('transaction.transaction', 2)">
                                    <DataTable :value="customer.transactions" @row-dblclick="viewTransactionNavigation">
                                        <template #empty>
                                            <div class="p-4 pl-0 text-center w-full text-gray-500">
                                                <i class="fa fa-info-circle empty-icon"></i>
                                                <p>{{ $t('transaction.no_transactions') }}</p>
                                            </div>
                                        </template>

                                        <Column field="date" :header="$t('transaction.date')">
                                            <template #body="{ data }">
                                                {{ formatDate(data.date) }}
                                            </template>
                                        </Column>
                                        <Column field="amount" :header="$t('transaction.amount')">
                                            <template #body="{ data }">
                                                {{ data.amount + ' ' + data.currency }}
                                            </template>
                                        </Column>
                                        <Column field="payment_method" :header="$t('transaction.payment_method')" />
                                        <Column field="reference" :header="$t('transaction.reference')" />
                                        <Column field="description" :header="$t('transaction.description')" />
                                    </DataTable>
                                </TabPanel>
                            </TabView>
                        </div>
                    </div>
                </div>
            </LoadingScreen>
        </div>
    </user-layout>
</template>

<script>
import CustomerMixin from '@/mixins/customers'
export default {
    name: 'ViewCustomerPage',
    mixins: [CustomerMixin],
    created() {
        this.getCustomer(this.$route.params.id)
    },
    methods: {
        editCustomerNavigate() {
            this.$router.push({ name: 'edit-customer', params: { id: this.$route.params.id } })
        },
        viewInvoiceNavigation(rowData) {
            this.$router.push(`/invoices/${rowData.data.id}`)
        },
        viewEstimateNavigation(rowData) {
            this.$router.push(`/estimates/${rowData.data.id}`)
        },
        viewTransactionNavigation(rowData) {
            this.$router.push(`/transactions/${rowData.data.id}`)
        },
    },
}
</script>

<style>
#customers_tabs .p-tabview-panels {
    padding: 0 !important;
}
</style>
