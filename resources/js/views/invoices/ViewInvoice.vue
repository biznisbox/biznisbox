<template>
    <user-layout>
        <div id="view_invoice_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('invoice.invoice') + ' ' + invoice.number">
                    <template #actions>
                        <Button
                            v-if="invoice.status != 'paid'"
                            :label="$t('basic.edit')"
                            icon="fa fa-pen"
                            class="p-button-success"
                            @click="editInvoiceNavigate"
                        />
                        <Button
                            v-if="invoice.status != 'paid'"
                            :label="$t('basic.delete')"
                            icon="fa fa-trash"
                            class="p-button-danger"
                            @click="deleteInvoiceAsk($route.params.id)"
                        />
                        <Button
                            :label="$t('basic.share')"
                            icon="fa fa-share"
                            class="p-button-info"
                            @click="shareInvoice($route.params.id)"
                        />
                        <Button
                            v-if="invoice.status == 'draft'"
                            :label="$t('basic.send')"
                            icon="fa fa-paper-plane"
                            class="p-button-info"
                            @click="sendInvoice($route.params.id)"
                        />
                        <Button :label="$t('basic.download')" icon="fa fa-download" class="p-button-info" @click="downloadInvoice" />
                    </template>
                </user-header>

                <div class="card">
                    <div id="payer_customer_data" class="grid">
                        <div v-if="!loadingData" id="customer_data" class="col-12 md:col-6">
                            <DisplayData :input="$t('invoice.customer')" custom-value>
                                <div v-if="invoice.customer_id != null">
                                    <span class="text-gray-700">{{ formatText(invoice.customer_name) }}</span>
                                    <br />
                                    <span class="text-gray-700">{{ formatText(invoice.customer_address) }}</span>
                                    <br />
                                    <span class="text-gray-700">{{
                                        formatText(invoice.customer_zip_code) + ' ' + formatText(invoice.customer_city)
                                    }}</span>
                                    <br />
                                    <span class="text-gray-700">{{ formatCountry(invoice.customer_country) }}</span>
                                    <br />
                                </div>
                                <div v-else>
                                    <span class="text-gray-700"> {{ $t('invoice.no_customer') }}</span>
                                </div>
                            </DisplayData>
                        </div>

                        <div v-if="!loadingData" id="payer_data" class="col-12 md:col-6">
                            <DisplayData :input="$t('invoice.payer')" custom-value>
                                <div v-if="invoice.payer_id != null">
                                    <span class="text-gray-700">{{ formatText(invoice.payer_name) }}</span> <br />
                                    <span class="text-gray-700">{{ formatText(invoice.payer_address) }}</span>
                                    <br />
                                    <span class="text-gray-700">{{
                                        formatText(invoice.payer_zip_code) + ' ' + formatText(invoice.payer_city)
                                    }}</span>
                                    <br />
                                    <span class="text-gray-700">{{ formatCountry(invoice.payer_country) }}</span>
                                    <br />
                                </div>
                                <div v-else>
                                    <span class="text-gray-700">{{ $t('invoice.no_payer') }}</span>
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
                                <span v-if="invoice.notes && !loadingData" class="text-gray-700" v-html="invoice.notes"></span>
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

                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button :label="$t('basic.close')" icon="fa fa-times" class="p-button-danger" @click="goTo('/invoices')" />
                    </div>
                </div>
            </LoadingScreen>

            <Dialog ref="shareDialog" v-model:visible="shareDialog" :header="$t('invoice.share_dialog')" modal>
                <div id="share_dialog_content">
                    <div class="text-center">{{ $t('invoice.share_dialog_text') }}</div>

                    <div class="text-center my-2">
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
import InvoiceMixin from '@/mixins/invoices'
import QrcodeVue from 'qrcode.vue'
export default {
    name: 'ViewInvoicePage',
    components: {
        QrcodeVue,
    },
    mixins: [InvoiceMixin],

    data() {
        return {
            shareDialog: false,
        }
    },
    created() {
        this.getInvoice(this.$route.params.id)
    },

    methods: {
        editInvoiceNavigate() {
            this.$router.push({ name: 'edit-invoice', params: { id: this.invoice.id } })
        },

        downloadInvoice() {
            window.open(this.invoice.download, '_blank')
        },
    },
}
</script>

<style></style>
