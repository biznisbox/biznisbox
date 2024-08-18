<template>
    <DefaultLayout>
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="quote.number">
                <template #actions>
                    <Button
                        v-if="quote.status != 'accepted' && quote.status != 'converted'"
                        id="edit_quote_button"
                        :label="$t('basic.edit')"
                        icon="fa fa-pen"
                        severity="success"
                        @click="$router.push(`/quotes/${quote.id}/edit`)"
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
                    <SplitButton
                        id="quote_actions"
                        :label="$t('basic.share')"
                        icon="fa fa-share"
                        @click="shareQuote($route.params.id)"
                        :model="[
                            { label: $t('basic.send'), icon: 'fa fa-paper-plane', command: () => sendQuoteNotification(quote.id) },
                            { label: $t('basic.download'), icon: 'fa fa-download', command: () => downloadQuote() },
                            { label: $t('basic.show_pdf'), icon: 'fa fa-file-pdf', command: () => viewQuotePdf() },
                            { label: $t('audit_log.audit_log'), icon: 'fa fa-history', command: () => (showAuditLogDialog = true) },
                        ]"
                    />
                </template>
            </PageHeader>

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
                                    {{ (data.price, quote.currency) }}
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
                            <span v-html="quote.notes"></span>
                        </DisplayData>

                        <DisplayData :input="$t('form.footer')" custom-value v-if="quote.footer && !loadingData">
                            <span v-html="quote.footer"></span>
                        </DisplayData>
                    </div>

                    <div class="grid">
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
            <div id="function_buttons" class="flex justify-end mt-5">
                <Button id="cancel_button" :label="$t('basic.close')" icon="fa fa-times" severity="secondary" @click="goTo('/quotes')" />
            </div>
        </LoadingScreen>

        <!--Audit log dialog -->
        <Dialog
            v-model:visible="showAuditLogDialog"
            modal
            maximizable
            class="w-full m-2 lg:w-1/2"
            :header="$t('audit_log.audit_log')"
            :draggable="false"
        >
            <AuditLog :item_id="$route.params.id" item_type="Quote" />
        </Dialog>

        <!--Quote share dialog -->
        <Dialog
            ref="shareDialog"
            v-model:visible="shareDialog"
            :header="$t('quote.share_dialog')"
            modal
            class="w-full m-2 lg:w-1/2"
            :draggable="false"
        >
            <div id="share_dialog_content">
                <div class="text-center">{{ $t('quote.share_dialog_text') }}</div>

                <div class="flex justify-center my-2">
                    <qrcode-vue :value="shareUrl" :size="140" level="H" />
                </div>

                <div class="flex gap-2 w-full">
                    <InputText v-model="shareUrl" class="w-full" />
                    <Button :label="$t('basic.copy')" icon="fa fa-copy" @click="copyToClipboard(shareUrl)" />
                </div>
            </div>
            <template #footer>
                <Button :label="$t('basic.cancel')" icon="fa fa-times" @click="shareDialog = false" severity="secondary" />
            </template>
        </Dialog>
    </DefaultLayout>
</template>

<script>
import QuotesMixin from '@/mixins/quotes'
import QrcodeVue from 'qrcode.vue'
export default {
    name: 'ViewQuotePage',
    mixins: [QuotesMixin],
    components: {
        QrcodeVue,
    },
    created() {
        this.getQuote(this.$route.params.id)
    },
    data() {
        return {
            shareDialog: false,
            shareUrl: '',
            showAuditLogDialog: false,
        }
    },

    methods: {
        viewQuotePdf() {
            window.open(this.quote.preview, '_blank')
        },
        downloadQuote() {
            window.open(this.quote.download, '_blank')
        },
    },
}
</script>
<style></style>
