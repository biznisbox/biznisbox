<template>
    <DefaultLayout>
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="`${bill.number}`">
                <template v-slot:actions>
                    <Button
                        :label="$t('basic.edit')"
                        @click="$router.push({ name: 'bill-edit', params: { id: bill.id } })"
                        icon="fa fa-pencil"
                        severity="success"
                    />
                    <Button :label="$t('basic.delete')" @click="deleteBillAsk($route.params.id)" icon="fa fa-trash" severity="danger" />
                    <SplitButton
                        id="more_options_button"
                        :label="$t('basic.show_pdf')"
                        icon="fa fa-list"
                        :model="[
                            { label: $t('basic.download'), icon: 'fa fa-download', command: downloadBillPdf },
                            { label: $t('basic.audit_log'), icon: 'fa fa-history', command: () => (showAuditLogDialog = true) },
                        ]"
                        @click="showBillPdf"
                    />
                </template>
            </PageHeader>

            <div class="card">
                <div class="grid grid-cols-1">
                    <div v-if="!loadingData" id="supplier_data">
                        <DisplayData :input="$t('form.supplier')" custom-value>
                            <div v-if="bill.supplier_id">
                                <span>{{ bill.supplier_id ? formatText(bill?.supplier_name) : '' }}</span> <br />
                                <span>{{ bill.supplier_address_id ? formatText(bill?.supplier_address) : '' }}</span>
                                <br />
                                <span>{{
                                    bill.supplier_address_id
                                        ? formatText(bill?.supplier_zip_code) + ' ' + formatText(bill.supplier_city)
                                        : ''
                                }}</span>
                                <br />
                                <span>{{ bill.supplier_address_id ? formatText(bill?.supplier_country) : '' }}</span>
                                <br />
                            </div>
                            <div v-else>
                                <span> {{ $t('bill.no_supplier') }}</span>
                            </div>
                        </DisplayData>
                    </div>
                </div>
                <div v-if="!loadingData" id="bill_data" class="grid grid-cols-1 md:grid-cols-3">
                    <DisplayData :input="$t('form.date')" :value="bill.date ? formatDate(formatText(bill.date)) : ''" />
                    <DisplayData :input="$t('form.due_date')" :value="bill.due_date ? formatDate(formatText(bill.due_date)) : ''" />
                    <DisplayData :input="$t('form.status')" custom-value>
                        <Tag v-if="bill.status == 'paid'" severity="success" :value="$t('status.paid')" />
                        <Tag v-if="bill.status == 'unpaid'" severity="danger" :value="$t('status.unpaid')" />
                        <Tag v-if="bill.status == 'overdue'" severity="danger" :value="$t('status.overdue')" />
                        <Tag v-if="bill.status == 'cancelled'" severity="secondary" :value="$t('status.cancelled')" />
                        <Tag v-if="bill.status == 'draft'" severity="warn" :value="$t('status.draft')" />
                    </DisplayData>
                </div>

                <div v-if="!loadingData" id="bill_items">
                    <DataTable :value="bill.items">
                        <template #empty>
                            <div class="p-4 pl-0 text-center w-full">
                                <i class="fa fa-info-circle empty-icon"></i>
                                <p>{{ $t('bill.no_items') }}</p>
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
                        <Column field="total" :header="$t('form.total')">
                            <template #body="{ data }">
                                <span>{{ formatMoney(data.total) }}</span>
                            </template>
                        </Column>
                    </DataTable>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <div id="bill_notes">
                        <DisplayData v-if="bill.notes && !loadingData" :input="$t('form.notes')" custom-value>
                            <span v-html="bill.notes"></span>
                        </DisplayData>

                        <DisplayData v-if="bill.footer && !loadingData" :input="$t('form.footer')" custom-value>
                            <span v-html="bill.footer"></span>
                        </DisplayData>
                    </div>

                    <div id="invoice_calculations">
                        <div>
                            <table class="w-full">
                                <tr>
                                    <td class="font-bold">{{ $t('form.discount') }}</td>
                                    <td class="text-right">{{ bill.discount }} %</td>
                                </tr>

                                <tr>
                                    <td class="font-bold">{{ $t('form.total') }}</td>
                                    <td class="text-right">{{ formatMoney(bill.total, bill.currency) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="function_buttons" class="flex justify-end mt-5">
                <Button id="close_button" :label="$t('basic.close')" icon="fa fa-times" severity="secondary" @click="goTo('/bills')" />
            </div>
        </LoadingScreen>

        <!-- Audit log dialog -->
        <Dialog
            v-model:visible="showAuditLogDialog"
            modal
            maximizable
            class="w-full m-2 lg:w-1/2"
            :header="$t('audit_log.audit_log')"
            :draggable="false"
        >
            <AuditLog :item_id="$route.params.id" item_type="Bill" />
        </Dialog>
    </DefaultLayout>
</template>

<script>
import BillMixin from '@/mixins/bills'
export default {
    name: 'ViewBillPage',
    mixins: [BillMixin],
    methods: {
        showBillPdf() {
            window.open(this.bill.preview, '_blank')
        },
        downloadBillPdf() {
            window.open(this.bill.download, '_blank')
        },
    },
    created() {
        this.getBill(this.$route.params.id)
    },
    data() {
        return {
            showAuditLogDialog: false,
        }
    },
}
</script>
<style></style>
