<template>
    <div id="client_view_invoice_page" class="p-3">
        <LoadingScreen :blocked="loadingData">
            <div>
                <div id="company_data" class="mb-2 d-block p-3">
                    <span class="font-bold">{{ formatText($settings.company_name) }}</span
                    ><br />
                    <span>{{ formatText($settings.company_address) }}</span> <br />
                    <span>{{ formatText($settings.company_zip) + ' ' + formatText($settings.company_city) }}</span> <br />
                    <span>{{ formatCountry($settings.company_country) }}</span> <br />
                    <span v-if="$settings.company_vat">{{ $t('client.invoice.tax_id') + ': ' + $settings.company_vat }}</span>
                </div>

                <div v-if="!no_found" class="card">
                    <user-header :title="$t('invoice.invoice') + ' ' + invoice.number">
                        <template #actions>
                            <Button
                                v-tooltip:top="$t('invoice.click_for_download')"
                                class="mr-2 no-print"
                                :disabled="!invoice"
                                icon="fa fa-download"
                                @click="downloadInvoice"
                            />
                            <Button
                                v-if="$settings.stripe_available && invoice.status != 'paid'"
                                class="mr-2 no-print"
                                icon="fa fa-credit-card"
                                @click="payWithCard"
                            />
                            <Button
                                v-if="$settings.paypal_available && invoice.status != 'paid'"
                                class="mr-2 no-print"
                                icon="fab fa-paypal"
                                @click="payWithPaypal"
                            />
                        </template>
                    </user-header>

                    <div class="alert">
                        <Message v-if="$route.query.status == 'success' && invoice.status == 'paid'" severity="success" closable>
                            {{ $t('invoice.payment_success') }}
                        </Message>

                        <Message v-if="$route.query.status == 'error' && invoice.status != 'paid'" severity="error" closable>
                            {{ $t('invoice.payment_error') }}
                        </Message>
                    </div>

                    <div id="payer_customer_data" class="grid">
                        <div v-if="!loadingData" id="customer_data" class="col-12 md:col-6">
                            <DisplayData :input="$t('invoice.customer')" custom-value>
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

                        <div v-if="!loadingData" id="payer_data" class="col-12 md:col-6">
                            <DisplayData :input="$t('invoice.payer')" custom-value>
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

                    <div id="invoice_data" class="grid">
                        <div v-if="!loadingData" class="col-6 md:col-3">
                            <DisplayData :input="$t('invoice.date')" :value="formatDate(formatText(invoice.date))" />
                        </div>

                        <div v-if="!loadingData" class="col-6 md:col-3">
                            <DisplayData :input="$t('invoice.due_date')" :value="formatDate(formatText(invoice.due_date))" />
                        </div>

                        <div v-if="!loadingData" class="col-6 md:col-3">
                            <DisplayData :input="$t('invoice.status')" custom-value>
                                <Tag v-if="invoice.status === 'paid'" severity="success">{{ $t('status.paid') }}</Tag>
                                <Tag v-if="invoice.status === 'unpaid'" severity="danger">{{ $t('status.unpaid') }}</Tag>
                                <Tag v-if="invoice.status === 'overdue'" severity="danger">{{ $t('status.overdue') }}</Tag>
                                <Tag v-if="invoice.status === 'draft'" severity="warning">{{ $t('status.draft') }}</Tag>
                                <Tag v-if="invoice.status === 'sent'" severity="warning">{{ $t('status.sent') }}</Tag>
                                <Tag v-if="invoice.status === 'refunded'" severity="">{{ $t('status.refunded') }}</Tag>
                                <Tag v-if="invoice.status === 'cancelled'" severity="">{{ $t('status.cancelled') }}</Tag>
                            </DisplayData>
                        </div>

                        <div v-if="!loadingData" class="col-6 md:col-3">
                            <DisplayData :input="$t('invoice.currency')" :value="formatText(invoice.currency)" />
                        </div>
                    </div>

                    <div v-if="!loadingData" id="invoice_items">
                        <DataTable :value="invoice.items">
                            <template #empty>
                                <div class="p-3 text-center w-full text-gray-500">
                                    <i class="fa fa-info-circle empty-icon"></i>
                                    <p>
                                        {{ $t('invoice.no_items') }}
                                    </p>
                                </div>
                            </template>
                            <Column field="name" :header="$t('invoice.name')" />
                            <Column field="description" :header="$t('invoice.description')" />
                            <Column field="quantity" :header="$t('invoice.quantity')">
                                <template #body="slotProps">
                                    <span>{{ slotProps.data.quantity + ' ' + slotProps.data.unit }}</span>
                                </template>
                            </Column>
                            <Column field="price" :header="$t('invoice.price')">
                                <template #body="slotProps">
                                    <span>{{ slotProps.data.price + ' ' + invoice.currency }}</span>
                                </template>
                            </Column>
                            <Column field="tax" :header="$t('invoice.tax')">
                                <template #body="slotProps">
                                    <span>{{ slotProps.data.tax + ' %' }}</span>
                                </template>
                            </Column>
                            <Column field="discount" :header="$t('invoice.discount')">
                                <template #body="slotProps">
                                    <span>{{ slotProps.data.discount + ' %' }}</span>
                                </template>
                            </Column>
                            <Column field="total" :header="$t('invoice.total')">
                                <template #body="slotProps">
                                    <span>{{ slotProps.data.total + ' ' + invoice.currency }}</span>
                                </template>
                            </Column>
                        </DataTable>
                    </div>

                    <div id="invoice_calculations" class="grid mt-5">
                        <div id="invoice_notes" class="col-12 md:col-6">
                            <DisplayData :input="$t('invoice.notes')" custom-value>
                                <span v-if="invoice.notes && !loadingData" v-html="invoice.notes"></span>
                            </DisplayData>
                        </div>

                        <div class="col-12 md:col-6">
                            <table class="w-full">
                                <tr>
                                    <td class="w-6 font-bold mb-1">{{ $t('invoice.discount') }}</td>
                                    <td class="text-gray-700 text-right">{{ invoice.discount }} %</td>
                                </tr>

                                <tr>
                                    <td class="w-6 font-bold mb-1">{{ $t('invoice.total') }}</td>
                                    <td class="text-gray-700 text-right">{{ invoice.total }} {{ invoice.currency }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </LoadingScreen>
    </div>
</template>

<script>
export default {
    name: 'ClientViewInvoice',
    data() {
        return {
            no_found: false,
            invoice: {
                number: '',
                date: '',
                due_date: '',
                customer_id: '',
                payer_id: '',
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
            },
        }
    },
    mounted() {
        this.getInvoice()
    },
    methods: {
        getInvoice() {
            this.makeHttpRequest('GET', '/api/client/invoices', null, { key: this.$route.query.key }, { 'X-CLIENT-ROUTE': true })
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
            this.makeHttpRequest(
                'POST',
                '/api/online_payment/stripe',
                { key: this.$route.query.key, type: 'web' },
                null,
                {
                    'X-CLIENT-ROUTE': true,
                },
                false
            ).then((response) => {
                window.open(response.data.url, '_blank')
            })
        },

        payWithPaypal() {
            this.makeHttpRequest(
                'POST',
                '/api/online_payment/paypal',
                { key: this.$route.query.key, type: 'web' },
                null,
                {
                    'X-CLIENT-ROUTE': true,
                },
                false
            ).then((response) => {
                window.open(response.data.url, '_blank')
            })
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
