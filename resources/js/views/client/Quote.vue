<template>
    <LoadingScreen :blocked="loadingData">
        <div>
            <div id="company_data" class="mb-2 d-block p-3">
                <span class="font-bold">{{ formatText($settings.company_name) }}</span
                ><br />
                <span>{{ formatText($settings.company_address) }}</span> <br />
                <span>{{ formatText($settings.company_zip) + ' ' + formatText($settings.company_city) }}</span> <br />
                <span>{{ formatCountry($settings.company_country) }}</span> <br />
                <span v-if="$settings.company_vat">{{ $t('form.tax_id') + ': ' + $settings.company_vat }}</span>
            </div>

            <div v-if="!not_found" class="card m-2">
                <PageHeader :title="$t('quote.quote') + ' ' + quote.number">
                    <template #actions>
                        <Button class="mr-2 no-print" :disabled="!quote" icon="fa fa-download" @click="downloadQuote" />
                        <div
                            v-if="
                                quote.valid_until > new Date().toISOString() &&
                                quote.status !== 'accepted' &&
                                quote.status !== 'rejected' &&
                                quote.status !== 'converted'
                            "
                        >
                            <Button
                                class="mr-2 no-print"
                                severity="success"
                                :disabled="!quote"
                                icon="fa fa-check"
                                :label="$t('basic.accept')"
                                @click="acceptRejectQuote($route.params.id, 'accepted')"
                            />
                            <Button
                                class="mr-2 no-print"
                                :disabled="!quote"
                                severity="danger"
                                icon="fa fa-times"
                                :label="$t('basic.reject')"
                                @click="acceptRejectQuote($route.params.id, 'rejected')"
                            />
                        </div>
                    </template>
                </PageHeader>

                <div id="alter">
                    <Message v-if="quote.valid_until < new Date().toISOString()" severity="error">
                        {{ $t('quote.expired') }}
                    </Message>

                    <Message v-if="acceptedRejected && quote.status === 'accepted'" severity="success">
                        {{ $t('quote.accepted') }}
                    </Message>

                    <Message v-if="acceptedRejected && quote.status === 'rejected'" severity="error">
                        {{ $t('quote.rejected') }}
                    </Message>
                </div>

                <div id="payer_customer_data" class="grid grid-cols-1 md:grid-cols-2">
                    <div v-if="!loadingData" id="customer_data">
                        <DisplayData :input="$t('form.customer')" custom-value>
                            <div v-if="quote.customer_id != null">
                                <span>{{ formatText(quote.customer_name) }}</span> <br />
                                <span>{{ formatText(quote.customer_address) }}</span>
                                <br />
                                <span>{{ formatText(quote.customer_zip_code) + ' ' + formatText(quote.customer_city) }}</span>
                                <br />
                                <span>{{ formatCountry(quote.customer_country) }}</span>
                                <br />
                            </div>
                            <div v-else>
                                <span>{{ $t('quote.no_customer') }}</span>
                            </div>
                        </DisplayData>
                    </div>

                    <div v-if="!loadingData" id="payer_data">
                        <DisplayData :input="$t('form.payer')" custom-value>
                            <div v-if="quote.payer_id">
                                <span>{{ formatText(quote.payer_name) }}</span> <br />
                                <span>{{ formatText(quote.payer_address) }}</span>
                                <br />
                                <span>{{ formatText(quote.payer_zip_code) + ' ' + formatText(quote.payer_city) }}</span>
                                <br />
                                <span>{{ formatCountry(quote.payer_country) }}</span>
                                <br />
                            </div>
                            <div v-else>
                                <span>{{ $t('quote.no_payer') }}</span>
                            </div>
                        </DisplayData>
                    </div>
                </div>

                <div id="quote_data" class="grid grid-cols-2 md:grid-cols-4">
                    <div v-if="!loadingData">
                        <DisplayData :input="$t('form.date')" :value="formatDate(formatText(quote.date))" />
                    </div>

                    <div v-if="!loadingData">
                        <DisplayData :input="$t('form.valid_until')" :value="formatDate(formatText(quote.due_date))" />
                    </div>

                    <div v-if="!loadingData">
                        <DisplayData :input="$t('form.status')" custom-value>
                            <Tag v-if="quote.status === 'draft'" severity="warn">{{ $t('status.draft') }}</Tag>
                            <Tag v-if="quote.status === 'sent'" severity="warn">{{ $t('status.sent') }}</Tag>
                            <Tag v-if="quote.status === 'viewed'" severity="warn">{{ $t('status.viewed') }}</Tag>
                            <Tag v-if="quote.status === 'accepted'" severity="success">{{ $t('status.accepted') }}</Tag>
                            <Tag v-if="quote.status === 'cancelled'" severity="secondary">{{ $t('status.cancelled') }}</Tag>
                            <Tag v-if="quote.status === 'rejected'" severity="danger">{{ $t('status.rejected') }}</Tag>
                            <Tag v-if="quote.status === 'converted'" severity="success">{{ $t('status.converted') }}</Tag>
                            <Tag v-if="quote.status === 'expired'" severity="danger">{{ $t('status.expired') }}</Tag>
                        </DisplayData>
                    </div>

                    <div v-if="!loadingData">
                        <DisplayData :input="$t('form.currency')" :value="formatText(quote.currency)" />
                    </div>
                </div>

                <div v-if="!loadingData" id="quote_items">
                    <DataTable :value="quote.items">
                        <template #empty>
                            <div class="p-3 text-center w-full">
                                <i class="fa fa-info-circle empty-icon"></i>
                                <p>
                                    {{ $t('quote.no_items') }}
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

                <div id="quote_calculations" class="grid mt-5">
                    <div id="quote_notes" class="col-12 md:col-6">
                        <DisplayData :input="$t('form.footer')" custom-value>
                            <span v-if="quote.footer && !loadingData" v-html="quote.footer"></span>
                        </DisplayData>
                    </div>

                    <div class="col-12 md:col-6">
                        <table class="w-full">
                            <tr>
                                <td class="w-6 font-bold mb-1">{{ $t('form.discount') }}</td>
                                <td class="text-right">
                                    <span v-if="quote.discount_type === 'percent'">{{ quote.discount + ' %' }}</span>
                                    <span v-if="quote.discount_type === 'fixed'">{{
                                        quote.discount + ' ' + $settings.default_currency
                                    }}</span>
                                </td>
                            </tr>
                            <tr v-if="quote.currency != $settings.default_currency">
                                <td class="w-6 font-bold mb-1">{{ $t('form.currency_rate') }}</td>
                                <td class="text-right">
                                    {{ `1 ${$settings.default_currency} = ${quote.currency_rate} ${quote.currency}` }}
                                </td>
                            </tr>
                            <tr>
                                <td class="w-6 font-bold mb-1">{{ $t('form.total') }}</td>
                                <td class="text-right">{{ formatMoney(quote.total, quote.currency) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </LoadingScreen>
</template>

<script>
export default {
    name: 'ClientViewQuotePage',
    data() {
        return {
            not_found: false,
            quote: {
                number: '',
                date: '',
                valid_until: '',
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
                items: [],
                currency: 'EUR',
                currency_rate: 1,
                payment_method: '',
                notes: '',
                discount: 0,
                discount_type: 'percent',
                tax: '',
                total: 0.0,
                footer: '',
            },
            acceptedRejected: false,
        }
    },

    mounted() {
        this.getQuote()
    },

    methods: {
        getQuote() {
            this.makeHttpRequest('GET', '/api/client/quote', null, { key: this.$route.query.key })
                .then((response) => {
                    this.quote = response.data.data
                })
                .catch((error) => {
                    if (error.response.status == 404) {
                        this.not_found = true
                        this.showToast(error.response.data.message, '', 'error')
                    }
                })
        },

        downloadQuote() {
            window.open(this.quote.download, '_blank')
        },

        acceptRejectQuote(id, status) {
            this.makeHttpRequest(
                'POST',
                '/api/client/quote/accept-reject',
                { status: status },
                { key: this.$route.query.key },
                null,
                false
            ).then((response) => {
                if (response.data.data.error === true) {
                    this.showToast(response.data.data.message, '', 'error')
                    return
                }
                this.showToast(response.data.message)
                this.getQuote()
                this.acceptedRejected = true
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
