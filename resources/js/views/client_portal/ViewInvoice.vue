<template>
    <DefaultLayout menu_type="client">
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="invoice.number">
                <template #actions>
                    <Button
                        v-if="$settings.stripe_available && invoice.status != 'paid' && invoice.status != 'overpaid'"
                        id="stripe_button"
                        v-tooltip:top="$t('invoice.click_for_pay')"
                        class="mr-2 no-print"
                        icon="fa fa-credit-card"
                        @click="payInvoiceWithGateway('stripe')"
                    />
                    <Button
                        v-if="$settings.paypal_available && invoice.status != 'paid' && invoice.status != 'overpaid'"
                        id="paypal_button"
                        v-tooltip:top="$t('invoice.click_for_pay_with_paypal')"
                        class="mr-2 no-print"
                        icon="fab fa-paypal"
                        @click="payInvoiceWithGateway('paypal')"
                    />

                    <Button
                        v-if="$settings.coinbase_available && invoice.status != 'paid' && invoice.status != 'overpaid'"
                        id="coinbase_button"
                        v-tooltip:top="$t('invoice.click_for_pay_with_coinbase')"
                        class="mr-2 no-print"
                        icon="fab fa-bitcoin"
                        @click="payInvoiceWithGateway('coinbase')"
                    />
                    <Button
                        v-if="invoice.download"
                        :label="$t('basic.download')"
                        icon="fa fa-download"
                        class="no-print"
                        @click="downloadFile(invoice.download)"
                    />
                </template>
            </PageHeader>

            <div class="pb-3">
                <Message v-if="$route.query.status == 'success' && invoice.status == 'paid'" severity="success" closable>
                    {{ $t('invoice.payment_success') }}
                </Message>

                <Message v-if="$route.query.status == 'error' && invoice.status != 'paid'" severity="error" closable>
                    {{ $t('invoice.payment_error') }}
                </Message>
            </div>
            <div class="card">
                <div id="payer_customer_data" class="grid grid-cols-1 lg:grid-cols-2">
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
                                <span> {{ $t('invoice.no_customer') }}</span>
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

                <div id="invoice_data" class="grid grid-cols-1 lg:grid-cols-4">
                    <div v-if="!loadingData">
                        <DisplayData :input="$t('form.date')" :value="formatDate(invoice.date)" />
                    </div>

                    <div v-if="!loadingData">
                        <DisplayData :input="$t('form.due_date')" :value="formatDate(invoice.due_date)" />
                    </div>

                    <div v-if="!loadingData">
                        <DisplayData :input="$t('form.status')" custom-value>
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
                    </div>

                    <div v-if="!loadingData">
                        <DisplayData :input="$t('form.currency')" :value="formatText(invoice.currency)" />
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <div v-if="!loadingData">
                        <DisplayData :input="$t('form.sales_person')" custom-value>
                            <span v-if="invoice.sales_person_id">{{
                                invoice.sales_person?.first_name + ' ' + invoice.sales_person?.last_name
                            }}</span>
                            <span v-else>{{ $t('invoice.no_sales_person') }}</span>
                        </DisplayData>
                    </div>

                    <div v-if="!loadingData">
                        <DisplayData :input="$t('form.payment_method')" custom-value>
                            <span v-if="invoice.payment_method" class="flex items-center">
                                <i :class="invoice.payment_method.icon"></i>
                                <span class="ml-1">{{ invoice.payment_method.name }}</span>
                            </span>
                            <span v-else>{{ $t('invoice.no_payment_method') }}</span>
                        </DisplayData>
                    </div>
                </div>

                <div v-if="!loadingData" id="invoice_items">
                    <DataTable :value="invoice.items" class="overflow-x-auto w-full">
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
                                <span>{{ data.price + ' ' + $settings.default_currency }}</span>
                            </template>
                        </Column>
                        <Column field="tax" :header="$t('form.tax')">
                            <template #body="{ data }">
                                <span>{{ data.tax !== null ? data.tax + ' %' : '-' }}</span>
                            </template>
                        </Column>
                        <Column field="discount" :header="$t('form.discount')">
                            <template #body="{ data }">
                                <span v-if="data.discount_type === 'percent'">{{ data.discount + ' %' }}</span>
                                <span v-if="data.discount_type === 'fixed'">{{ data.discount + ' ' + $settings.default_currency }}</span>
                            </template>
                        </Column>
                        <Column field="total" :header="$t('form.total')">
                            <template #body="{ data }">
                                <span>{{ data.total + ' ' + $settings.default_currency }}</span>
                            </template>
                        </Column>
                    </DataTable>
                </div>

                <div id="invoice_calculations" class="grid grid-cols-1 lg:grid-cols-2">
                    <div id="invoice_notes">
                        <DisplayData v-if="invoice.footer && !loadingData" :input="$t('form.footer')" custom-value>
                            <span v-html="formatHtml(invoice.footer)"></span>
                        </DisplayData>
                    </div>

                    <div id="invoice_calculations_table">
                        <DisplayData :input="$t('form.discount')" custom-value displayInline>
                            <span v-if="invoice.discount_type === 'percent'">{{ invoice.discount + ' %' }}</span>
                            <span v-if="invoice.discount_type === 'fixed'">{{ invoice.discount + ' ' + $settings.default_currency }}</span>
                        </DisplayData>

                        <DisplayData
                            v-if="invoice.currency != $settings.default_currency"
                            :input="$t('form.currency_rate')"
                            custom-value
                            displayInline
                        >
                            {{ `1 ${$settings.default_currency} = ${invoice.currency_rate} ${invoice.currency}` }}
                        </DisplayData>

                        <div id="invoice_tax_info">
                            <DisplayData :input="$t('form.tax')" custom-value>
                                <div v-for="tax in invoice.tax_calculation" :key="tax.id">
                                    <DisplayData :input="tax.name" custom-value displayInline>
                                        {{ formatMoney(tax.amount, invoice.currency) }}
                                    </DisplayData>
                                </div>
                            </DisplayData>
                        </div>

                        <DisplayData :input="$t('form.total')" custom-value displayInline>
                            {{ formatMoney(invoice.total, invoice.currency) }}
                        </DisplayData>
                    </div>
                </div>
            </div>

            <div id="function_buttons" class="flex justify-end mt-4 gap-2">
                <Button
                    id="cancel_button"
                    :label="$t('basic.close')"
                    icon="fa fa-times"
                    severity="secondary"
                    @click="goTo('/client-portal/invoices')"
                />
            </div>
        </LoadingScreen>
    </DefaultLayout>
</template>

<script>
export default {
    name: 'ClientPortalViewInvoice',
    data() {
        return {
            invoice: {
                sales_person_id: null,
                sales_person: '',
                number: '',
                date: '',
                due_date: '',
                customer_id: null,
                customer_name: '',
                customer_address_id: null,
                customer_address: '',
                customer_zip_code: '',
                customer_city: '',
                customer_country: '',
                payer_id: null,
                payer_name: '',
                payer_address_id: null,
                payer_address: '',
                payer_zip_code: '',
                payer_city: '',
                payer_country: '',
                status: 'draft',
                items: [
                    {
                        product_id: '',
                        type: '',
                        item: '',
                        name: '',
                        description: '',
                        quantity: 1,
                        unit: '',
                        price: 0,
                        tax: null,
                        tax_type: 'percent', // percent, fixed
                        discount: 0,
                        discount_type: 'percent', // percent, fixed
                        total: 0,
                    },
                ],
                currency: 'EUR',
                currency_rate: 1,
                payment_method_id: null,
                payment_method: {},
                notes: '',
                discount: 0,
                discount_type: 'percent', // percent, fixed
                tax: '',
                total: 0.0,
            },
        }
    },

    methods: {
        getInvoiceById(id) {
            this.makeHttpRequest('GET', `/api/client-portal/invoices/${id}`).then((response) => {
                this.invoice = response.data.data
            })
        },

        payInvoiceWithGateway(paymentGateway) {
            this.makeHttpRequest(
                'POST',
                `/api/client-portal/online-payment/invoice/${paymentGateway}`,
                { invoiceId: this.invoice.id },
                null,
                null
            ).then((response) => {
                this.$cookies.set('payment_id', response.data.data.payment_id, '1h')
                window.open(response.data.data.redirect_url, '_blank')
            })
        },

        downloadFile(url) {
            window.open(url, '_blank', 'noopener,noreferrer')
        },
    },

    created() {
        this.getInvoiceById(this.$route.params.id)
    },
}
</script>
