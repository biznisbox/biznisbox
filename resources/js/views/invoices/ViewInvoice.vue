<template>
    <user-layout>
        <div id="view_invoice_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="invoice.number">
                    <template #actions>
                        <Button
                            v-if="invoice.status != 'paid' && invoice.status != 'overpaid' && invoice.status != 'refunded'"
                            id="edit_invoice_button"
                            :label="$t('basic.edit')"
                            icon="fa fa-pen"
                            class="p-button-success"
                            @click="editInvoiceNavigate"
                        />
                        <Button
                            v-if="invoice.status != 'paid' && invoice.status != 'overpaid' && invoice.status != 'refunded'"
                            id="delete_invoice_button"
                            :label="$t('basic.delete')"
                            icon="fa fa-trash"
                            class="p-button-danger"
                            @click="deleteInvoiceAsk($route.params.id)"
                        />
                        <Button
                            v-if="invoice.status != 'paid' && invoice.status != 'overpaid' && invoice.status != 'refunded'"
                            id="add_payment_button"
                            :label="$t('invoice.add_payment')"
                            icon="fa fa-plus"
                            @click="addTransactionDialog = true"
                        />
                        <Button
                            id="show_transactions_button"
                            :label="$t('invoice.show_transactions')"
                            icon="fa fa-list"
                            @click="showTransactionsDialog = true"
                        />
                        <Button
                            id="share_invoice_button"
                            :label="$t('basic.share')"
                            icon="fa fa-share"
                            @click="shareInvoice($route.params.id)"
                        />
                        <Button id="download_invoice_button" :label="$t('basic.download')" icon="fa fa-download" @click="downloadInvoice" />
                    </template>
                </user-header>

                <div class="card">
                    <div id="payer_customer_data" class="grid">
                        <div v-if="!loadingData" id="customer_data" class="col-12 md:col-6">
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

                        <div v-if="!loadingData" id="payer_data" class="col-12 md:col-6">
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

                    <div id="invoice_data" class="grid">
                        <div v-if="!loadingData" class="col-6 md:col-3">
                            <DisplayData :input="$t('form.date')" :value="formatDate(invoice.date)" />
                        </div>

                        <div v-if="!loadingData" class="col-6 md:col-3">
                            <DisplayData :input="$t('form.due_date')" :value="formatDate(invoice.due_date)" />
                        </div>

                        <div v-if="!loadingData" class="col-6 md:col-3">
                            <DisplayData :input="$t('form.status')" custom-value>
                                <Tag v-if="invoice.status === 'paid'" severity="success">{{ $t('status.paid') }}</Tag>
                                <Tag v-if="invoice.status === 'unpaid'" severity="danger">{{ $t('status.unpaid') }}</Tag>
                                <Tag v-if="invoice.status === 'overdue'" severity="danger">{{ $t('status.overdue') }}</Tag>
                                <Tag v-if="invoice.status === 'draft'" severity="warning">{{ $t('status.draft') }}</Tag>
                                <Tag v-if="invoice.status === 'sent'" severity="warning">{{ $t('status.sent') }}</Tag>
                                <Tag v-if="invoice.status === 'refunded'" severity="">{{ $t('status.refunded') }}</Tag>
                                <Tag v-if="invoice.status === 'partial'" severity="warning">{{ $t('status.partial') }}</Tag>
                                <Tag v-if="invoice.status === 'overpaid'" severity="danger">{{ $t('status.overpaid') }}</Tag>
                                <Tag v-if="invoice.status === 'cancelled'" severity="">{{ $t('status.cancelled') }}</Tag>
                            </DisplayData>
                        </div>

                        <div v-if="!loadingData" class="col-6 md:col-3">
                            <DisplayData :input="$t('form.currency')" :value="formatText(invoice.currency)" />
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
                                    <span>{{ data.tax + ' %' }}</span>
                                </template>
                            </Column>
                            <Column field="discount" :header="$t('form.discount')">
                                <template #body="{ data }">
                                    <span>{{ data.discount + ' %' }}</span>
                                </template>
                            </Column>
                            <Column field="total" :header="$t('form.total')">
                                <template #body="{ data }">
                                    <span>{{ data.total + ' ' + $settings.default_currency }}</span>
                                </template>
                            </Column>
                        </DataTable>
                    </div>

                    <div id="invoice_calculations" class="grid mt-5">
                        <div id="invoice_notes" class="col-12 md:col-6">
                            <DisplayData :input="$t('form.notes')" custom-value>
                                <span v-if="invoice.notes && !loadingData" v-html="invoice.notes"></span>
                            </DisplayData>

                            <DisplayData :input="$t('form.footer')" custom-value>
                                <span v-if="invoice.footer && !loadingData" v-html="invoice.footer"></span>
                            </DisplayData>
                        </div>

                        <div class="col-12 md:col-6">
                            <table class="w-full">
                                <tr>
                                    <td class="w-6 font-bold mb-1">{{ $t('form.discount') }}</td>
                                    <td class="text-right">{{ invoice.discount }} %</td>
                                </tr>
                                <tr v-if="invoice.currency_rate != 1">
                                    <td class="w-6 font-bold mb-1">{{ $t('form.currency_rate') }}</td>
                                    <td class="text-right">{{ invoice.currency_rate }}</td>
                                </tr>
                                <tr>
                                    <td class="w-6 font-bold mb-1">{{ $t('form.total') }}</td>
                                    <td class="text-right">{{ invoice.total }} {{ invoice.currency }}</td>
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

            <!-- Add transaction dialog -->
            <Dialog ref="add_transaction_dialog" v-model:visible="addTransactionDialog" :header="$t('invoice.add_payment')" modal>
                <div id="add_transaction_dialog_content">
                    <form>
                        <NumberInput
                            id="amount_input"
                            v-model="transaction.amount"
                            type="currency"
                            :currency="invoice.currency"
                            :label="$t('transaction.amount')"
                            class="col-12"
                        />
                    </form>
                </div>
                <template #footer>
                    <Button :label="$t('basic.cancel')" icon="fa fa-times" class="p-button-danger" @click="closeSaveTransactionDialog" />
                    <Button :label="$t('basic.save')" icon="fa fa-save" class="p-button-success" @click="saveTransaction" />
                </template>
            </Dialog>

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

                        <Column field="amount" :header="$t('transaction.amount')">
                            <template #body="{ data }">
                                <span>{{ data.amount ? data.amount + ' ' + data.currency : '-' }}</span> <br />
                            </template>
                        </Column>
                        <Column field="type" :header="$t('transaction.type')">
                            <template #body="{ data }">
                                <span v-if="data.type === 'income'">
                                    <i class="fa fa-arrow-up text-green-500 mr-2"></i>
                                    <span>{{ $t('transaction.income') }}</span>
                                </span>
                                <span v-if="data.type === 'expense'">
                                    <i class="fa fa-arrow-down text-red-500 mr-2"></i>
                                    <span>{{ $t('transaction.expense') }}</span>
                                </span>
                                <span v-if="data.type === 'transfer'">
                                    <i class="fa fa-exchange-alt text-blue-500 mr-2"></i>
                                    <span>{{ $t('transaction.transfer') }}</span>
                                </span>
                            </template>
                        </Column>
                    </DataTable>
                </div>
                <template #footer>
                    <Button
                        :label="$t('basic.cancel')"
                        icon="fa fa-times"
                        class="p-button-danger"
                        @click="showTransactionsDialog = false"
                    />
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
            addTransactionDialog: false,
            showTransactionsDialog: false,
            transaction: {
                amount: 0,
            },
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

        closeSaveTransactionDialog() {
            this.transaction = {
                amount: 0,
            }
            this.addTransactionDialog = false
        },

        saveTransaction() {
            this.makeHttpRequest('POST', '/api/invoice/transaction/' + this.invoice.id, this.transaction).then((response) => {
                this.showToast(response.data.message)
                this.closeSaveTransactionDialog()
                this.getInvoice(this.$route.params.id)
            })
        },
    },
}
</script>

<style></style>
