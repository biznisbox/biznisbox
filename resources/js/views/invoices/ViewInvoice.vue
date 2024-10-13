<template>
    <DefaultLayout>
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="invoice.number">
                <template #actions>
                    <Button
                        v-if="invoice.status != 'paid' && invoice.status != 'overpaid' && invoice.status != 'refunded'"
                        id="edit_invoice_button"
                        :label="$t('basic.edit')"
                        icon="fa fa-pen"
                        severity="success"
                        @click="$router.push(`/invoices/${$route.params.id}/edit`)"
                    />
                    <Button
                        v-if="invoice.status != 'paid' && invoice.status != 'overpaid' && invoice.status != 'refunded'"
                        id="delete_invoice_button"
                        :label="$t('basic.delete')"
                        icon="fa fa-trash"
                        severity="danger"
                        @click="deleteInvoiceAsk($route.params.id)"
                    />
                    <Button
                        v-if="invoice.status != 'paid' && invoice.status != 'overpaid' && invoice.status != 'refunded'"
                        id="add_payment_button"
                        :label="$t('invoice.add_payment')"
                        icon="fa fa-plus"
                        @click="addTransactionDialog = true"
                    />

                    <SplitButton
                        id="more_options_button"
                        :label="$t('invoice.show_transactions')"
                        icon="fa fa-list"
                        :model="[
                            { label: $t('basic.share'), icon: 'fa fa-share', command: () => shareInvoice($route.params.id) },
                            {
                                label: $t('basic.send'),
                                icon: 'fa fa-paper-plane',
                                command: () => sendInvoiceNotification($route.params.id),
                            },
                            { label: $t('basic.download'), icon: 'fa fa-download', command: downloadInvoice },
                            { label: $t('basic.show_pdf'), icon: 'fa fa-file-pdf', command: viewInvoicePdf },
                            {
                                label: $t('basic.audit_log'),
                                icon: 'fa fa-history',
                                command: () => (showAuditLogDialog = true),
                            },
                        ]"
                        @click="showTransactionsDialog = true"
                    />
                </template>
            </PageHeader>

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
                            <span v-if="invoice.payment_method">{{ $t('payment_methods.' + invoice.payment_method) }}</span>
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
                        <DisplayData v-if="invoice.notes && !loadingData" :input="$t('form.notes')" custom-value>
                            <span v-html="invoice.notes"></span>
                        </DisplayData>

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
            <div id="function_buttons" class="flex justify-end mt-4">
                <Button id="cancel_button" :label="$t('basic.close')" icon="fa fa-times" severity="secondary" @click="goTo('/invoices')" />
            </div>
        </LoadingScreen>

        <!-- Share dialog -->
        <Dialog
            ref="shareDialog"
            v-model:visible="shareDialog"
            :header="$t('invoice.share_dialog')"
            modal
            class="w-full m-2 lg:w-1/2"
            :draggable="false"
        >
            <div id="share_dialog_content">
                <div class="text-center">{{ $t('invoice.share_dialog_text') }}</div>

                <div class="flex justify-center my-2">
                    <qrcode-vue :value="shareUrl" :size="140" level="H" />
                </div>

                <div class="flex gap-2 w-full">
                    <InputText v-model="shareUrl" class="w-full" />
                    <Button :label="$t('basic.copy')" icon="fa fa-copy" @click="copyToClipboard(shareUrl)" />
                </div>
            </div>
            <template #footer>
                <Button :label="$t('basic.cancel')" icon="fa fa-times" severity="secondary" @click="shareDialog = false" />
            </template>
        </Dialog>

        <!-- Show transactions dialog -->
        <Dialog
            v-model:visible="showTransactionsDialog"
            :header="$t('invoice.list_of_transactions')"
            modal
            class="w-full m-2 lg:w-1/2"
            :draggable="false"
        >
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
                        <span>{{ data.amount ? formatMoney(data.amount, data.currency) : '-' }}</span> <br />
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

            <div class="grid grid-cols-2 gap-2">
                <DisplayData :input="$t('form.sum_of_payments')" :value="formatMoney(invoice.sum_of_payments, invoice.currency)" />
                <DisplayData
                    v-if="invoice.status === 'overpaid'"
                    :input="$t('form.overpaid_amount')"
                    :value="formatMoney(invoice.overpaid_amount, invoice.currency)"
                />
            </div>

            <template #footer>
                <Button :label="$t('basic.close')" icon="fa fa-times" severity="secondary" @click="showTransactionsDialog = false" />
            </template>
        </Dialog>

        <!-- Add transaction dialog -->
        <Dialog
            v-model:visible="addTransactionDialog"
            :header="$t('invoice.add_payment')"
            modal
            class="w-full m-2 lg:w-1/2"
            :draggable="false"
        >
            <div>
                <form>
                    <DateInput id="date_input" v-model="transaction.date" :label="$t('form.date')" />
                    <NumberInput
                        id="amount_input"
                        v-model="transaction.amount"
                        type="currency"
                        :currency="invoice.currency"
                        :label="$t('form.amount')"
                    />
                </form>
            </div>

            <template #footer>
                <Button :label="$t('basic.cancel')" icon="fa fa-times" severity="secondary" @click="addTransactionDialog = false" />
                <Button :label="$t('basic.save')" icon="fa fa-save" severity="success" @click="saveInvoiceTransaction" />
            </template>
        </Dialog>

        <!-- Audit log dialog -->
        <Dialog
            v-model:visible="showAuditLogDialog"
            modal
            maximizable
            class="w-full m-2 lg:w-1/2"
            :header="$t('audit_log.audit_log')"
            :draggable="false"
        >
            <AuditLog :item_id="$route.params.id" item_type="Invoice" />
        </Dialog>
    </DefaultLayout>
</template>

<script>
import InvoicesMixin from '@/mixins/invoices'
import { formatDate } from '@fullcalendar/core'
import QrcodeVue from 'qrcode.vue'
export default {
    name: 'ViewInvoicePage',
    mixins: [InvoicesMixin],
    components: {
        QrcodeVue,
    },
    created() {
        this.getInvoice(this.$route.params.id)
    },
    data() {
        return {
            shareDialog: false,
            shareUrl: '',
            showTransactionsDialog: false,
            addTransactionDialog: false,
            transaction: {
                amount: '',
                date: new Date().toISOString().substr(0, 10),
                type: 'income',
                currency: this.invoice?.currency,
            },
            showAuditLogDialog: false,
        }
    },
    methods: {
        viewInvoicePdf() {
            window.open(this.invoice.preview, '_blank')
        },
        downloadInvoice() {
            window.open(this.invoice.download, '_blank')
        },

        saveInvoiceTransaction() {
            this.makeHttpRequest('POST', `/api/invoice/${this.invoice.id}/payment`, this.transaction, null, null, false).then(
                (response) => {
                    this.showToast(response.data.message, this.$t('basic.success'))
                    this.transaction = {
                        amount: '',
                        date: new Date().toISOString().substr(0, 10),
                        type: 'income',
                        currency: this.invoice?.currency,
                    }
                    this.addTransactionDialog = false
                    this.getInvoice(this.$route.params.id)
                }
            )
        },
    },
}
</script>
