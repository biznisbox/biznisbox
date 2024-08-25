<template>
    <div id="client_view_invoice_page" class="p-2">
        <LoadingScreen :blocked="loadingData">
            <div>
                <div id="company_data" class="p-3">
                    <span class="font-bold">{{ formatText($settings.company_name) }}</span
                    ><br />
                    <span>{{ formatText($settings.company_address) }}</span> <br />
                    <span>{{ formatText($settings.company_zip) + ' ' + formatText($settings.company_city) }}</span> <br />
                    <span>{{ formatCountry($settings.company_country) }}</span> <br />
                    <span v-if="$settings.company_vat">{{ $t('form.tax_id') + ': ' + $settings.company_vat }}</span>
                </div>

                <div v-if="!no_found" class="card m-2">
                    <PageHeader :title="$t('invoice.invoice') + ' ' + invoice.number">
                        <template #actions>
                            <Button
                                id="download_button"
                                v-tooltip:top="$t('invoice.click_for_download')"
                                class="mr-2 no-print"
                                :disabled="!invoice"
                                icon="fa fa-download"
                                @click="downloadInvoice"
                            />
                            <Button
                                v-if="$settings.stripe_available && invoice.status != 'paid' && invoice.status != 'overpaid'"
                                id="stripe_button"
                                v-tooltip:top="$t('invoice.click_for_pay')"
                                class="mr-2 no-print"
                                icon="fa fa-credit-card"
                                @click="payWithCard"
                            />
                            <Button
                                v-if="$settings.paypal_available && invoice.status != 'paid' && invoice.status != 'overpaid'"
                                id="paypal_button"
                                v-tooltip:top="$t('invoice.click_for_pay_with_paypal')"
                                class="mr-2 no-print"
                                icon="fab fa-paypal"
                                @click="payWithPaypal"
                            />

                            <Button
                                v-if="invoice.transactions.length > 0"
                                id="show_transactions_button"
                                class="mr-2 no-print"
                                icon="fa fa-list"
                                :label="$t('invoice.show_transactions')"
                                @click="showTransactionsDialog = true"
                            />
                        </template>
                    </PageHeader>

                    <div class="py-3">
                        <Message v-if="$route.query.status == 'success' && invoice.status == 'paid'" severity="success" closable>
                            {{ $t('invoice.payment_success') }}
                        </Message>

                        <Message v-if="$route.query.status == 'error' && invoice.status != 'paid'" severity="error" closable>
                            {{ $t('invoice.payment_error') }}
                        </Message>
                    </div>

                    <div id="payer_customer_data" class="grid grid-cols-1 md:grid-cols-2">
                        <div v-if="!loadingData" id="customer_data">
                            <DisplayData :input="$t('form.customer')" custom-value>
                                <div v-if="invoice.customer_id != null">
                                    <span>{{ formatText(invoice.customer_name) }}</span>
                                    <br />
                                    <span>{{ formatText(invoice.customer_address) }}</span>
                                    <br />
                                    <span>{{ formatText(invoice.customer_zip_code) + ' ' + formatText(invoice.customer_city) }}</span>
                                    <br />
                                    <span>{{ formatCountry(invoice.customer_country) }}</span>
                                    <br />
                                </div>
                                <div v-else>
                                    <span>{{ $t('invoice.no_customer') }}</span>
                                </div>
                            </DisplayData>
                        </div>

                        <div v-if="!loadingData" id="payer_data">
                            <DisplayData :input="$t('form.payer')" custom-value>
                                <div v-if="invoice.payer_id != null">
                                    <span>{{ formatText(invoice.payer_name) }}</span> <br />
                                    <span>{{ formatText(invoice.payer_address) }}</span>
                                    <br />
                                    <span>{{ formatText(invoice.payer_zip_code) + ' ' + formatText(invoice.payer_city) }}</span>
                                    <br />
                                    <span>{{ formatCountry(invoice.payer_country) }}</span>
                                    <br />
                                </div>
                                <div v-else>
                                    <span>{{ $t('invoice.no_payer') }}</span>
                                </div>
                            </DisplayData>
                        </div>
                    </div>

                    <div id="invoice_data" class="grid grid-cols-1 md:grid-cols-4">
                        <DisplayData v-if="!loadingData" :input="$t('form.date')" :value="formatDate(invoice.date)" />
                        <DisplayData v-if="!loadingData" :input="$t('form.due_date')" :value="formatDate(invoice.due_date)" />
                        <DisplayData v-if="!loadingData" :input="$t('form.status')" custom-value>
                            <Tag v-if="invoice.status === 'paid'" severity="success">{{ $t('status.paid') }}</Tag>
                            <Tag v-if="invoice.status === 'unpaid'" severity="danger">{{ $t('status.unpaid') }}</Tag>
                            <Tag v-if="invoice.status === 'overdue'" severity="danger">{{ $t('status.overdue') }}</Tag>
                            <Tag v-if="invoice.status === 'draft'" severity="warn">{{ $t('status.draft') }}</Tag>
                            <Tag v-if="invoice.status === 'sent'" severity="warn">{{ $t('status.sent') }}</Tag>
                            <Tag v-if="invoice.status === 'refunded'" severity="secondary">{{ $t('status.refunded') }}</Tag>
                            <Tag v-if="invoice.status === 'partial'" severity="warn">{{ $t('status.partial') }}</Tag>
                            <Tag v-if="invoice.status === 'overpaid'" severity="danger">{{ $t('status.overpaid') }}</Tag>
                            <Tag v-if="invoice.status === 'cancelled'" severity="secondary">{{ $t('status.cancelled') }}</Tag>
                        </DisplayData>
                        <DisplayData v-if="!loadingData" :input="$t('form.currency')" :value="formatText(invoice.currency)" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <DisplayData v-if="!loadingData" :input="$t('form.sales_person')" custom-value>
                            <span v-if="invoice.sales_person_id">{{
                                invoice.sales_person?.first_name + ' ' + invoice.sales_person?.last_name
                            }}</span>
                            <span v-else>{{ $t('invoice.no_sales_person') }}</span>
                        </DisplayData>

                        <DisplayData v-if="!loadingData" :input="$t('form.payment_method')" custom-value>
                            <span v-if="invoice.payment_method">{{ $t('payment_methods.' + invoice.payment_method) }}</span>
                            <span v-else>{{ $t('invoice.no_payment_method') }}</span>
                        </DisplayData>
                    </div>

                    <div v-if="!loadingData" id="invoice_items">
                        <DataTable :value="invoice.items">
                            <template #empty>
                                <div class="p-3 text-center w-full">
                                    <i class="fa fa-info-circle empty-icon"></i>
                                    <p>
                                        {{ $t('invoice.no_items') }}
                                    </p>
                                </div>
                            </template>
                            <Column field="name" :header="$t('form.name')" />
                            <Column field="description" :header="$t('form.description')" />
                            <Column field="quantity" :header="$t('form.quantity')">
                                <template #body="{ data }">
                                    <span>{{ data.quantity + ' ' + data.unit }}</span>
                                </template>
                            </Column>
                            <Column field="price" :header="$t('form.price')">
                                <template #body="{ data }">
                                    <span>{{ formatMoney(data.price) }}</span>
                                </template>
                            </Column>
                            <Column field="tax" :header="$t('form.tax')">
                                <template #body="{ data }">
                                    <span>{{ data.tax !== null ? data.tax + ' %' : '-' }}</span>
                                </template>
                            </Column>
                            <Column field="discount" :header="$t('form.discount')">
                                <template #body="{ data }">
                                    <span>{{ data.discount + ' %' }}</span>
                                </template>
                            </Column>
                            <Column field="total" :header="$t('form.total')">
                                <template #body="{ data }">
                                    <span>{{ formatMoney(data.total) }}</span>
                                </template>
                            </Column>
                        </DataTable>
                    </div>

                    <div id="invoice_calculations" class="grid mt-5 grid-cols-1 md:grid-cols-2">
                        <div id="invoice_footer">
                            <DisplayData v-if="invoice.footer && !loadingData" :input="$t('form.footer')" custom-value>
                                <span v-html="invoice.footer"></span>
                            </DisplayData>
                        </div>

                        <div>
                            <table class="w-full">
                                <tr>
                                    <td class="w-6 font-bold mb-1">{{ $t('form.discount') }}</td>
                                    <td class="text-right">
                                        <span v-if="invoice.discount_type === 'percent'">{{ invoice.discount + ' %' }}</span>
                                        <span v-if="invoice.discount_type === 'fixed'">{{
                                            invoice.discount + ' ' + $settings.default_currency
                                        }}</span>
                                    </td>
                                </tr>
                                <tr v-if="invoice.currency != $settings.default_currency">
                                    <td class="w-6 font-bold mb-1">{{ $t('form.currency_rate') }}</td>
                                    <td class="text-right">
                                        {{ `1 ${$settings.default_currency} = ${invoice.currency_rate} ${invoice.currency}` }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-6 font-bold mb-1">{{ $t('form.total') }}</td>
                                    <td class="text-right">{{ formatMoney(invoice.total, invoice.currency) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Show transactions table dialog -->
            <Dialog
                ref="show_transactions_dialog"
                v-model:visible="showTransactionsDialog"
                :header="$t('invoice.list_of_transactions')"
                modal
            >
                <div id="show_transactions_dialog_content">
                    <DataTable :value="invoice.transactions">
                        <template #empty>
                            <div class="p-4 pl-0 text-center w-full text-gray-500">
                                <i class="fa fa-info-circle empty-icon"></i>
                                <p>{{ $t('transaction.no_transactions') }}</p>
                            </div>
                        </template>

                        <Column field="name" :header="$t('transaction.name')">
                            <template #body="{ data }">
                                <span>{{ data.name ? data.name : '-' }}</span>
                            </template>
                        </Column>

                        <Column field="date" :header="$t('transaction.date_and_number')">
                            <template #body="{ data }">
                                <span>{{ data.date ? formatDate(data.date) : '-' }}</span
                                ><br />
                                <span>{{ data.number }}</span>
                            </template>
                        </Column>

                        <Column field="amount" :header="$t('form.amount')">
                            <template #body="{ data }">
                                <span>{{ formatMoney(data.amount, data.currency) }}</span> <br />
                            </template>
                        </Column>

                        <Column field="type" :header="$t('form.type')">
                            <template #body="{ data }">
                                <span v-if="data.type === 'income'">
                                    <i class="fa fa-arrow-up text-green-500 mr-2"></i>
                                    <span>{{ $t('transaction_type.income') }}</span>
                                </span>
                                <span v-if="data.type === 'expense'">
                                    <i class="fa fa-arrow-down text-red-500 mr-2"></i>
                                    <span>{{ $t('transaction_type.expense') }}</span>
                                </span>
                                <span v-if="data.type === 'transfer'">
                                    <i class="fa fa-exchange-alt text-blue-500 mr-2"></i>
                                    <span>{{ $t('transaction_type.transfer') }}</span>
                                </span>
                            </template>
                        </Column>
                    </DataTable>
                </div>
                <template #footer>
                    <Button :label="$t('basic.cancel')" icon="fa fa-times" severity="secondary" @click="showTransactionsDialog = false" />
                </template>
            </Dialog>
        </LoadingScreen>
    </div>
</template>

<script>
export default {
    name: 'ClientViewInvoice',
    data() {
        return {
            no_found: false,
            showTransactionsDialog: false,
            invoice: {
                number: '',
                date: '',
                due_date: '',
                customer_id: '',
                payer_id: '',
                customer_city: '',
                customer_name: '',
                customer_address: '',
                customer_zip_code: '',
                customer_country: '',
                payer_city: '',
                payer_name: '',
                payer_address: '',
                payer_zip_code: '',
                payer_country: '',
                status: 'draft',
                items: [],
                currency: 'EUR',
                payment_method: '',
                terms: '',
                notes: '',
                discount: 0,
                discount_type: '',
                tax: '',
                total: 0.0,
                transactions: [],
            },
        }
    },
    mounted() {
        this.getInvoice()
    },
    methods: {
        getInvoice() {
            this.makeHttpRequest('GET', '/api/client/invoice', null, { key: this.$route.query.key }, { 'X-CLIENT-ROUTE': true })
                .then((response) => {
                    this.invoice = response.data.data
                })
                .catch((error) => {
                    if (error.response.status == 404) {
                        this.no_found = true
                        this.showToast(error.response.data.message, '', 'error')
                    }
                })
        },

        downloadInvoice() {
            window.open(this.invoice.download, '_blank')
        },

        payWithCard() {
            this.makeHttpRequest('POST', '/api/online-payment/invoice/stripe', { key: this.$route.query.key }, null, null, false).then(
                (response) => {
                    this.$cookies.set('payment_id', response.data.data.payment_id, '1h')
                    window.open(response.data.data.redirect_url, '_blank')
                }
            )
        },

        payWithPaypal() {
            this.makeHttpRequest('POST', '/api/online-payment/invoice/paypal', { key: this.$route.query.key }, null, null, false).then(
                (response) => {
                    this.$cookies.set('payment_id', response.data.data.payment_id, '1h')
                    window.open(response.data.data.redirect_url, '_blank')
                }
            )
        },
    },
}
</script>

<style>
@media print {
    .no-print,
    .no-print * {
        display: none !important;
    }
}
</style>
