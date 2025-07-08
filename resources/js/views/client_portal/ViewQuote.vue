<template>
    <DefaultLayout menu_type="client">
        <PageHeader :title="quote.number" />
        <LoadingScreen :blocked="loadingData">
            <div class="card">
                <div id="payer_customer_data" class="grid mt-5 lg:grid-cols-2 grid-cols-1">
                    <div v-if="!loadingData" id="customer_data">
                        <DisplayData :input="$t('form.customer')" custom-value>
                            <div v-if="quote.customer_id">
                                <span>{{ formatText(quote.customer_name) }}</span>
                                <br />
                                <span>{{ formatText(quote.customer_address) }}</span>
                                <br />
                                <span>{{ formatText(quote.customer_zip_code) + ' ' + formatText(quote.customer_city) }}</span>
                                <br />
                                <span>{{ formatCountry(quote.customer_country) }}</span>
                                <br />
                            </div>
                            <div v-else>
                                <span> {{ $t('quote.no_customer') }}</span>
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

                <div id="quote_data" class="grid lg:grid-cols-4 grid-cols-2">
                    <DisplayData :input="$t('form.date')" :value="formatDate(formatText(quote.date))" />
                    <DisplayData :input="$t('form.valid_until')" :value="formatDate(formatText(quote.valid_until))" />
                    <DisplayData :input="$t('form.status')" custom-value>
                        <Tag v-if="quote.status === 'accepted'" severity="success">{{ $t('status.accepted') }}</Tag>
                        <Tag v-if="quote.status === 'rejected'" severity="danger">{{ $t('status.rejected') }}</Tag>
                        <Tag v-if="quote.status === 'draft'" severity="warn">{{ $t('status.draft') }}</Tag>
                        <Tag v-if="quote.status === 'sent'" severity="warn">{{ $t('status.sent') }}</Tag>
                        <Tag v-if="quote.status === 'viewed'" severity="warn">{{ $t('status.viewed') }}</Tag>
                        <Tag v-if="quote.status === 'expired'" severity="danger">{{ $t('status.expired') }}</Tag>
                        <Tag v-if="quote.status === 'cancelled'" severity="secondary">{{ $t('status.cancelled') }}</Tag>
                        <Tag v-if="quote.status === 'converted'" severity="success">{{ $t('status.converted') }}</Tag>
                    </DisplayData>
                    <DisplayData :input="$t('form.currency')" :value="formatText(quote.currency)" />
                </div>

                <div>
                    <div v-if="!loadingData">
                        <DisplayData :input="$t('form.payment_method')" custom-value>
                            <span v-if="quote.payment_method" class="flex items-center">
                                <i :class="quote.payment_method.icon"></i>
                                <span class="ml-1">{{ quote.payment_method.name }}</span>
                            </span>
                            <span v-else>{{ $t('quote.no_payment_method') }}</span>
                        </DisplayData>
                    </div>
                </div>

                <div id="quote_items">
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
                                <span>
                                    {{ data.quantity + ' ' + data.unit }}
                                </span>
                            </template>
                        </Column>
                        <Column field="price" :header="$t('form.price')">
                            <template #body="{ data }">
                                <span>
                                    {{ formatMoney(data.price, quote.currency) }}
                                </span>
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
                                <span> {{ (data.total, quote.currency) }}</span>
                            </template>
                        </Column>
                    </DataTable>
                </div>

                <div id="quote_calculations" class="grid grid-cols-2">
                    <div id="quote_notes">
                        <DisplayData :input="$t('form.notes')" custom-value v-if="quote.notes && !loadingData">
                            <span v-html="formatHtml(quote.notes)"></span>
                        </DisplayData>

                        <DisplayData :input="$t('form.footer')" custom-value v-if="quote.footer && !loadingData">
                            <span v-html="formatHtml(quote.footer)"></span>
                        </DisplayData>
                    </div>

                    <div id="quote_calculations_table">
                        <DisplayData :input="$t('form.discount')" custom-value displayInline>
                            <span v-if="quote.discount_type === 'percent'">{{ quote.discount + ' %' }}</span>
                            <span v-if="quote.discount_type === 'fixed'">{{ quote.discount + ' ' + $settings.default_currency }}</span>
                        </DisplayData>

                        <DisplayData
                            v-if="quote.currency != $settings.default_currency"
                            :input="$t('form.currency_rate')"
                            custom-value
                            displayInline
                        >
                            {{ `1 ${$settings.default_currency} = ${quote.currency_rate} ${quote.currency}` }}
                        </DisplayData>

                        <DisplayData :input="$t('form.total')" custom-value displayInline>
                            {{ formatMoney(quote.total, quote.currency) }}
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
                    @click="goTo('/client-portal/quotes')"
                />
            </div>
        </LoadingScreen>
    </DefaultLayout>
</template>
<script>
export default {
    name: 'ClientPortalViewQuotePage',
    data() {
        return {
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
                        discount: 0,
                        total: 0,
                    },
                ],
                currency: 'EUR',
                currency_rate: 1,
                notes: '',
                sales_person_id: '',
                payment_method: '',
                discount: 0,
                discount_type: 'percent', // percent or fixed
                tax: '',
                total: 0.0,
                footer: '',
            },
        }
    },

    methods: {
        getQuoteById(id) {
            this.makeHttpRequest('GET', '/api/client-portal/quotes/' + id).then((response) => {
                this.quote = response.data.data
            })
        },
    },

    created() {
        this.getQuoteById(this.$route.params.id)
    },
}
</script>
