<template>
    <user-layout>
        <div id="view_bill_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('bill.bill') + ' ' + bill.number">
                    <template #actions>
                        <Button :label="$t('basic.edit')" icon="fa fa-pen" class="p-button-success" @click="editBillNavigate" />
                        <Button
                            :label="$t('basic.delete')"
                            icon="fa fa-trash"
                            class="p-button-danger"
                            @click="deleteBillAsk($route.params.id)"
                        />
                    </template>
                </user-header>

                <div class="card">
                    <div class="grid">
                        <div v-if="!loadingData" id="vendor_data" class="col-12 md:col-6">
                            <DisplayData :input="$t('bill.vendor')" custom-value>
                                <div v-if="bill.vendor">
                                    <span class="text-gray-700">{{ bill.vendor ? formatText(bill.vendor.name) : '' }}</span> <br />
                                    <span class="text-gray-700">{{ bill.vendor ? formatText(bill.vendor.address) : '' }}</span>
                                    <br />
                                    <span class="text-gray-700">{{
                                        bill.vendor ? formatText(bill.vendor.zip_code) + ' ' + formatText(bill.vendor.city) : ''
                                    }}</span>
                                    <br />
                                    <span class="text-gray-700">{{ bill.vendor ? formatText(bill.vendor.country) : '' }}</span>
                                    <br />
                                </div>
                                <div v-else>
                                    <span class="text-gray-700"> {{ $t('bill.no_vendor') }}</span>
                                </div>
                            </DisplayData>
                        </div>
                    </div>
                    <div id="bill_data" class="grid">
                        <div class="col-6 md:col-4">
                            <DisplayData :input="$t('bill.date')" :value="bill.date ? formatDate(formatText(bill.date)) : ''" />
                        </div>

                        <div class="col-6 md:col-4">
                            <DisplayData :input="$t('bill.due_date')" :value="bill.due_date ? formatDate(formatText(bill.due_date)) : ''" />
                        </div>

                        <div class="col-6 md:col-4">
                            <DisplayData :input="$t('bill.status')" custom-value>
                                <Tag v-if="bill.status == 'paid'" severity="success" :value="$t('status.paid')" />
                                <Tag v-else-if="bill.status == 'unpaid'" severity="danger" :value="$t('status.unpaid')" />
                                <Tag v-else-if="bill.status == 'overdue'" severity="danger" :value="$t('status.overdue')" />
                                <Tag v-else-if="bill.status == 'cancelled'" severity="" :value="$t('status.cancelled')" />
                                <Tag v-else-if="bill.status == 'draft'" severity="info" :value="$t('status.draft')" />
                            </DisplayData>
                        </div>
                    </div>

                    <div v-if="!loadingData" id="bill_items">
                        <DataTable :value="bill.items">
                            <template #empty>
                                <div class="p-4 pl-0 text-center w-full text-gray-500">
                                    <i class="fa fa-info-circle empty-icon"></i>
                                    <p>{{ $t('bill.no_items') }}</p>
                                </div>
                            </template>

                            <Column field="name" :header="$t('bill.name')" />
                            <Column field="description" :header="$t('bill.description')" />
                            <Column field="quantity" :header="$t('bill.quantity')">
                                <template #body="slotProps">
                                    <span>{{ slotProps.data.quantity + ' ' + slotProps.data.unit }}</span>
                                </template>
                            </Column>
                            <Column field="price" :header="$t('bill.price')">
                                <template #body="slotProps">
                                    <span>{{ slotProps.data.price + ' ' + $settings.default_currency }}</span>
                                </template>
                            </Column>
                            <Column field="total" :header="$t('bill.total')">
                                <template #body="slotProps">
                                    <span>{{ slotProps.data.total + ' ' + $settings.default_currency }}</span>
                                </template>
                            </Column>
                        </DataTable>
                    </div>

                    <div id="invoice_calculations" class="grid mt-5">
                        <div class="col-12 md:col-6"></div>
                        <div class="col-12 md:col-6">
                            <table class="w-full">
                                <tr>
                                    <td class="w-6 font-bold">{{ $t('bill.discount') }}</td>
                                    <td class="text-gray-700 text-right">{{ bill.discount }} %</td>
                                </tr>

                                <tr>
                                    <td class="w-6 font-bold">{{ $t('bill.total') }}</td>
                                    <td class="text-gray-700 text-right">{{ bill.total }} {{ $settings.default_currency }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button :label="$t('basic.close')" icon="fa fa-times" class="p-button-danger" @click="goTo('/bills')" />
                    </div>
                </div>
            </LoadingScreen>
        </div>
    </user-layout>
</template>

<script>
import BillsMixin from '@/mixins/bills'
export default {
    name: 'ViewBillPage',
    mixins: [BillsMixin],
    created() {
        this.getBill(this.$route.params.id)
    },
    methods: {
        editBillNavigate() {
            this.$router.push({ name: 'edit-bill', params: { id: this.$route.params.id } })
        },
    },
}
</script>

<style></style>
