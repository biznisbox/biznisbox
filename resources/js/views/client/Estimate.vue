<template>
    <div id="client_view_estimate_page" class="p-2">
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

                <div v-if="!not_found" class="card">
                    <user-header :title="$t('estimate.estimate') + ' ' + estimate.number">
                        <template #actions>
                            <Button class="mr-2 no-print" :disabled="!estimate" icon="fa fa-download" @click="downloadEstimate" />
                            <Button
                                v-if="estimate.status !== 'accepted' && estimate.status !== 'rejected' && estimate.status !== 'converted'"
                                class="mr-2 p-button-success no-print"
                                :disabled="!estimate"
                                icon="fa fa-check"
                                :label="$t('basic.accept')"
                                @click="acceptRejectEstimate($route.params.id, 'accepted')"
                            />
                            <Button
                                v-if="estimate.status !== 'accepted' && estimate.status !== 'rejected' && estimate.status !== 'converted'"
                                class="mr-2 p-button-danger no-print"
                                :disabled="!estimate"
                                icon="fa fa-times"
                                :label="$t('basic.reject')"
                                @click="acceptRejectEstimate($route.params.id, 'rejected')"
                            />
                        </template>
                    </user-header>
                    <div id="payer_customer_data" class="grid">
                        <div v-if="!loadingData" id="customer_data" class="col-12 md:col-6">
                            <DisplayData :input="$t('estimate.customer')" custom-value>
                                <div v-if="estimate.customer_id != null">
                                    <span>{{ formatText(estimate.customer_name) }}</span> <br />
                                    <span>{{ formatText(estimate.customer_address) }}</span>
                                    <br />
                                    <span>{{ formatText(estimate.customer_zip_code) + ' ' + formatText(estimate.customer_city) }}</span>
                                    <br />
                                    <span>{{ formatCountry(estimate.customer_country) }}</span>
                                    <br />
                                </div>
                                <div v-else>
                                    <span>{{ $t('estimate.no_customer') }}</span>
                                </div>
                            </DisplayData>
                        </div>

                        <div v-if="!loadingData" id="payer_data" class="col-12 md:col-6">
                            <DisplayData :input="$t('estimate.payer')" custom-value>
                                <div v-if="estimate.payer">
                                    <span>{{ formatText(estimate.payer_name) }}</span> <br />
                                    <span>{{ formatText(estimate.payer_address) }}</span>
                                    <br />
                                    <span>{{ formatText(estimate.payer_zip_code) + ' ' + formatText(estimate.payer_city) }}</span>
                                    <br />
                                    <span>{{ formatCountry(estimate.payer_country) }}</span>
                                    <br />
                                </div>
                                <div v-else>
                                    <span>{{ $t('estimate.no_payer') }}</span>
                                </div>
                            </DisplayData>
                        </div>
                    </div>

                    <div id="estimate_data" class="grid">
                        <div v-if="!loadingData" class="col-6 md:col-3">
                            <DisplayData :input="$t('estimate.date')" :value="formatDate(formatText(estimate.date))" />
                        </div>

                        <div v-if="!loadingData" class="col-6 md:col-3">
                            <DisplayData :input="$t('estimate.valid_until')" :value="formatDate(formatText(estimate.due_date))" />
                        </div>

                        <div v-if="!loadingData" class="col-6 md:col-3">
                            <DisplayData :input="$t('estimate.status')" custom-value>
                                <Tag v-if="estimate.status === 'accepted'" severity="success">{{ $t('status.accepted') }}</Tag>
                                <Tag v-if="estimate.status === 'rejected'" severity="danger">{{ $t('status.rejected') }}</Tag>
                                <Tag v-if="estimate.status === 'draft'" severity="warning">{{ $t('status.draft') }}</Tag>
                                <Tag v-if="estimate.status === 'sent'" severity="warning">{{ $t('status.sent') }}</Tag>
                                <Tag v-if="estimate.status === 'viewed'" severity="warning">{{ $t('status.viewed') }}</Tag>
                                <Tag v-if="estimate.status === 'expired'" severity="danger">{{ $t('status.expired') }}</Tag>
                                <Tag v-if="estimate.status === 'cancelled'" severity="">{{ $t('status.cancelled') }}</Tag>
                                <Tag v-if="estimate.status === 'converted'" severity="success">{{ $t('status.converted') }}</Tag>
                            </DisplayData>
                        </div>

                        <div v-if="!loadingData" class="col-6 md:col-3">
                            <DisplayData :input="$t('estimate.currency')" :value="formatText(estimate.currency)" />
                        </div>
                    </div>

                    <div v-if="!loadingData" id="estimate_items">
                        <DataTable :value="estimate.items">
                            <template #empty>
                                <div class="p-3 text-center w-full text-gray-500">
                                    <i class="fa fa-info-circle empty-icon"></i>
                                    <p>
                                        {{ $t('estimate.no_items') }}
                                    </p>
                                </div>
                            </template>
                            <Column field="name" :header="$t('estimate.name')" />
                            <Column field="description" :header="$t('estimate.description')" />
                            <Column field="quantity" :header="$t('estimate.quantity')">
                                <template #body="slotProps">
                                    <span>{{ slotProps.data.quantity + ' ' + slotProps.data.unit }}</span>
                                </template>
                            </Column>
                            <Column field="price" :header="$t('estimate.price')">
                                <template #body="slotProps">
                                    <span>{{ slotProps.data.price + ' ' + estimate.currency }}</span>
                                </template>
                            </Column>
                            <Column field="tax" :header="$t('estimate.tax')">
                                <template #body="slotProps">
                                    <span>{{ slotProps.data.tax + ' %' }}</span>
                                </template>
                            </Column>
                            <Column field="discount" :header="$t('estimate.discount')">
                                <template #body="slotProps">
                                    <span>{{ slotProps.data.discount + ' %' }}</span>
                                </template>
                            </Column>
                            <Column field="total" :header="$t('estimate.total')">
                                <template #body="slotProps">
                                    <span>{{ slotProps.data.total + ' ' + estimate.currency }}</span>
                                </template>
                            </Column>
                        </DataTable>
                    </div>

                    <div id="estimate_calculations" class="grid mt-5">
                        <div id="estimate_notes" class="col-12 md:col-6">
                            <DisplayData :input="$t('estimate.notes')" custom-value>
                                <span v-if="estimate.footer && !loadingData" v-html="estimate.footer"></span>
                            </DisplayData>
                        </div>

                        <div class="col-12 md:col-6">
                            <table class="w-full">
                                <tr>
                                    <td class="w-6 font-bold mb-1">{{ $t('estimate.discount') }}</td>
                                    <td class="text-gray-700 text-right">{{ estimate.discount }} %</td>
                                </tr>

                                <tr>
                                    <td class="w-6 font-bold mb-1">{{ $t('estimate.total') }}</td>
                                    <td class="text-gray-700 text-right">{{ estimate.total }} {{ estimate.currency }}</td>
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
    name: 'ClientViewEstimate',
    data() {
        return {
            not_found: false,
            estimate: {
                number: '',
                date: '',
                valid_until: '',
                customer_id: '',
                payer_id: '',
                status: 'draft',
                items: [],
                currency: 'EUR',
                payment_method: '',
                terms: '',
                footer: '',
                discount: 0,
                discount_type: '',
                tax: '',
                total: 0.0,
            },
        }
    },

    mounted() {
        this.getEstimate()
    },

    methods: {
        getEstimate() {
            this.makeHttpRequest('GET', '/api/client/estimates', null, { key: this.$route.query.key }, { 'X-CLIENT-ROUTE': true })
                .then((response) => {
                    this.estimate = response.data.data
                })
                .catch((error) => {
                    if (error.response.status == 404) {
                        this.not_found = true
                        this.showToast(error.response.data.message, '', 'error')
                    }
                })
        },

        downloadEstimate() {
            window.open(this.estimate.download, '_blank')
        },

        acceptRejectEstimate(id, status) {
            this.makeHttpRequest(
                'POST',
                '/api/client/estimates/accept-reject',
                { status: status },
                { key: this.$route.query.key },
                { 'X-CLIENT-ROUTE': true }
            ).then((response) => {
                this.showToast(response.data.message)
                this.getEstimate()
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
