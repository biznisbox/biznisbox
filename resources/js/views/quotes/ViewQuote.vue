<template>
    <user-layout>
        <div id="view_quote_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="quote.number">
                    <template #actions>
                        <Button
                            v-if="quote.status != 'accepted' && quote.status != 'converted'"
                            id="edit_quote_button"
                            :label="$t('basic.edit')"
                            icon="fa fa-pen"
                            severity="success"
                            @click="editQuoteRoute"
                        />
                        <Button
                            v-if="quote.status != 'accepted' && quote.status != 'converted'"
                            id="delete_quote_button"
                            :label="$t('basic.delete')"
                            icon="fa fa-trash"
                            severity="danger"
                            @click="deleteQuoteAsk(quote.id)"
                        />
                        <Button
                            v-if="quote.status != 'converted' && quote.status != 'paid'"
                            id="convert_quote_to_invoice_button"
                            :label="$t('quote.convert_to_invoice')"
                            icon="fa fa-file-invoice-dollar"
                            severity="success"
                            @click="convertQuoteToInvoice(quote.id)"
                        />
                        <Button
                            v-if="quote.status != 'accepted' && quote.status != 'converted'"
                            id="send_quote_button"
                            :label="$t('basic.send')"
                            icon="fa fa-paper-plane"
                            @click="sendQuoteNotification(quote.id)"
                        />
                        <Button
                            id="share_quote_button"
                            :label="$t('basic.share')"
                            icon="fa fa-share"
                            @click="shareQuote($route.params.id)"
                        />
                        <Button id="download_quote_button" :label="$t('basic.download')" icon="fa fa-download" @click="downloadQuote" />
                    </template>
                </user-header>

                <div class="card">
                    <div id="payer_customer_data" class="grid">
                        <div v-if="!loadingData" id="customer_data" class="col-12 md:col-6">
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

                        <div v-if="!loadingData" id="payer_data" class="col-12 md:col-6">
                            <DisplayData :input="$t('form.payer')" custom-value>
                                <div v-if="quote.payer_id">
                                    <span>{{ formatText(quote.payer_name) }}</span> <br />
                                    <span>{{ formatText(quote.payer_address) }}</span>
                                    <br />
                                    <span>{{ formatText(quote.payer_zip_code) + ' ' + formatText(quote.payer_city) }}</span>
                                    <br />
                                    <span>{{ formatText(quote.payer_country) }}</span>
                                    <br />
                                </div>
                                <div v-else>
                                    <span>{{ $t('quote.no_payer') }}</span>
                                </div>
                            </DisplayData>
                        </div>
                    </div>

                    <div id="quote_data" class="grid">
                        <div class="col-6 md:col-3">
                            <DisplayData :input="$t('form.date')" :value="formatDate(formatText(quote.date))" />
                        </div>

                        <div class="col-6 md:col-3">
                            <DisplayData :input="$t('form.valid_until')" :value="formatDate(formatText(quote.valid_until))" />
                        </div>

                        <div class="col-6 md:col-3">
                            <DisplayData :input="$t('form.status')" custom-value>
                                <Tag v-if="quote.status === 'accepted'" severity="success">{{ $t('status.accepted') }}</Tag>
                                <Tag v-if="quote.status === 'rejected'" severity="danger">{{ $t('status.rejected') }}</Tag>
                                <Tag v-if="quote.status === 'draft'" severity="warning">{{ $t('status.draft') }}</Tag>
                                <Tag v-if="quote.status === 'sent'" severity="warning">{{ $t('status.sent') }}</Tag>
                                <Tag v-if="quote.status === 'viewed'" severity="warning">{{ $t('status.viewed') }}</Tag>
                                <Tag v-if="quote.status === 'expired'" severity="danger">{{ $t('status.expired') }}</Tag>
                                <Tag v-if="quote.status === 'cancelled'" severity="">{{ $t('status.cancelled') }}</Tag>
                                <Tag v-if="quote.status === 'converted'" severity="success">{{ $t('status.converted') }}</Tag>
                            </DisplayData>
                        </div>

                        <div class="col-6 md:col-3">
                            <DisplayData :input="$t('form.currency')" :value="formatText(quote.currency)" />
                        </div>
                    </div>

                    <div id="quote_items">
                        <DataTable :value="quote.items">
                            <template #empty>
                                <div class="p-3 text-center w-full text-gray-500">
                                    <i class="fa fa-info-circle empty-icon"></i>
                                    <p>
                                        {{ $t('quote.no_items') }}
                                    </p>
                                </div>
                            </template>

                            <Column field="name" :header="$t('form.name')" />
                            <Column field="description" :header="$t('form.description')" />
                            <Column field="quantity" :header="$t('form.quantity')">
                                <template #body="slotProps">
                                    <span>{{ slotProps.data.quantity + ' ' + slotProps.data.unit }}</span>
                                </template>
                            </Column>
                            <Column field="price" :header="$t('form.price')">
                                <template #body="slotProps">
                                    <span>{{ formatMoney(slotProps.data.price, quote.currency) }}</span>
                                </template>
                            </Column>
                            <Column field="tax" :header="$t('form.tax')">
                                <template #body="slotProps">
                                    <span>{{ slotProps.data.tax + ' %' }}</span>
                                </template>
                            </Column>
                            <Column field="discount" :header="$t('form.discount')">
                                <template #body="slotProps">
                                    <span>{{ slotProps.data.discount + ' %' }}</span>
                                </template>
                            </Column>
                            <Column field="total" :header="$t('form.total')">
                                <template #body="slotProps">
                                    <span>{{ formatMoney(slotProps.data.total, quote.currency) }}</span>
                                </template>
                            </Column>
                        </DataTable>
                    </div>

                    <div id="quote_calculations" class="grid mt-5">
                        <div id="quote_notes" class="col-12 md:col-6">
                            <DisplayData :input="$t('form.notes')" custom-value>
                                <span v-if="quote.notes && !loadingData" v-html="quote.notes"></span>
                            </DisplayData>

                            <DisplayData :input="$t('form.footer')" custom-value>
                                <span v-if="quote.footer && !loadingData" v-html="quote.footer"></span>
                            </DisplayData>
                        </div>

                        <div class="col-12 md:col-6">
                            <table class="w-full">
                                <tr>
                                    <td class="w-6 font-bold">{{ $t('form.discount') }}</td>
                                    <td class="text-right">{{ quote.discount }} %</td>
                                </tr>

                                <tr v-if="quote.currency != $settings.default_currency">
                                    <td class="w-6 font-bold">{{ $t('form.currency_rate') }}</td>
                                    <td class="text-right">
                                        {{ `1 ${$settings.default_currency} = ${quote.currency_rate} ${quote.currency}` }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="w-6 font-bold">{{ $t('form.total') }}</td>
                                    <td class="text-right">{{ formatMoney(quote.total, quote.currency) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="function_buttons" class="flex gap-2 justify-content-end">
                    <Button
                        id="cancel_button"
                        :label="$t('basic.close')"
                        icon="fa fa-times"
                        class="p-button-danger"
                        @click="goTo('/quotes')"
                    />
                </div>
            </LoadingScreen>

            <Dialog ref="shareDialog" v-model:visible="shareDialog" :header="$t('quote.share_dialog')" modal>
                <div id="share_dialog_content">
                    <div class="text-center">{{ $t('quote.share_dialog_text') }}</div>

                    <div class="text-center py-2">
                        <qrcode-vue :value="shareUrl" :size="140" level="H" />
                    </div>

                    <div class="flex gap-2 w-full">
                        <InputText v-model="shareUrl" class="w-full" />
                        <Button :label="$t('basic.copy')" icon="fa fa-copy" @click="copyToClipboard(shareUrl)" />
                    </div>
                </div>
                <template #footer>
                    <Button :label="$t('basic.cancel')" icon="fa fa-times" class="p-button-danger" @click="shareDialog = false" />
                </template>
            </Dialog>
        </div>
    </user-layout>
</template>

<script>
import QuoteMixin from '@/mixins/quotes'
import QrcodeVue from 'qrcode.vue'
export default {
    name: 'ViewQuotePage',
    components: {
        QrcodeVue,
    },
    mixins: [QuoteMixin],
    data() {
        return {
            shareDialog: false,
        }
    },
    created() {
        this.getQuote(this.$route.params.id)
    },

    methods: {
        editQuoteRoute() {
            this.$router.push({ name: 'edit-quote', params: { id: this.quote.id } })
        },

        downloadQuote() {
            window.open(this.quote.download, '_blank')
        },
    },
}
</script>

<style></style>
