<template>
    <user-layout>
        <div id="view_vendor_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="vendor.name">
                    <template #actions>
                        <Button :label="$t('basic.edit')" icon="fa fa-edit" class="p-button-success" @click="editVendorNavigate" />
                        <Button
                            :label="$t('basic.delete')"
                            icon="fa fa-trash"
                            class="p-button-danger"
                            @click="deleteVendorAsk($route.params.id)"
                        />
                    </template>
                </user-header>
                <div class="grid">
                    <div class="col-12 md:col-4">
                        <div class="card">
                            <div class="card-header">
                                <h3>{{ $t('vendor.vendor_details') }}</h3>
                            </div>
                            <div class="grid">
                                <div class="col-6">
                                    <DisplayData :input="$t('vendor.name')" :value="vendor.name" />
                                </div>
                                <div class="col-6">
                                    <Tag v-if="vendor.type === 'company'" :value="$t('customer.company')" />
                                    <Tag v-if="vendor.type === 'individual'" :value="$t('customer.individual')" />
                                </div>
                            </div>

                            <DisplayData :input="$t('vendor.address')" :value="vendor.address" />
                            <DisplayData :input="$t('vendor.zip_code')" :value="vendor.zip_code" />
                            <DisplayData :input="$t('vendor.city')" :value="vendor.city" />
                            <DisplayData :input="$t('vendor.country')" :value="formatCountry(vendor.country)" />
                            <DisplayData :input="$t('vendor.email')" is-link :value="vendor.email" :link="`mailto:${vendor.email}`" />
                            <DisplayData :input="$t('vendor.phone')" :value="vendor.phone" is-link :link="`tel:${vendor.phone}`" />
                            <DisplayData :input="$t('customer.vat_number')" :value="vendor.vat_number" />
                            <DisplayData :input="$t('customer.currency')" :value="vendor.currency" />
                            <DisplayData :input="$t('customer.website')" :value="vendor.website" is-link />
                        </div>
                    </div>

                    <div class="col-12 md:col-8">
                        <div class="card">
                            <TabView id="vendor_tabs">
                                <TabPanel :header="$t('vendor.bills')">
                                    <DataTable :value="vendor.bills" @row-dblclick="viewBillNavigation">
                                        <template #empty>
                                            <div class="p-3 pl-0 text-center w-full text-gray-500">
                                                <i class="fa fa-info-circle empty-icon"></i>
                                                <p>{{ $t('bill.no_bills') }}</p>
                                            </div>
                                        </template>
                                        <Column field="number" :header="$t('bill.bill_number')" sortable></Column>
                                        <Column :header="$t('bill.date_and_due_date')">
                                            <template #body="slotProps">
                                                <div class="date_due_date">
                                                    <div class="date">
                                                        {{ slotProps.data.date ? formatDate(slotProps.data.date) : '-' }}
                                                    </div>
                                                    <div class="due_date">
                                                        {{ slotProps.data.due_date ? formatDate(slotProps.data.due_date) : '-' }}
                                                    </div>
                                                </div>
                                            </template>
                                        </Column>
                                        <Column :header="$t('bill.status')">
                                            <template #body="slotProps">
                                                <div class="status">
                                                    <Tag
                                                        v-if="slotProps.data.status === 'paid'"
                                                        severity="success"
                                                        :value="$t('status.paid')"
                                                    />
                                                    <Tag
                                                        v-if="slotProps.data.status === 'unpaid'"
                                                        severity="danger"
                                                        :value="$t('status.unpaid')"
                                                    />
                                                    <Tag
                                                        v-if="slotProps.data.status === 'overdue'"
                                                        severity="danger"
                                                        :value="$t('status.overdue')"
                                                    />
                                                    <Tag
                                                        v-if="slotProps.data.status === 'draft'"
                                                        severity="warning"
                                                        :value="$t('status.draft')"
                                                    />
                                                    <Tag
                                                        v-if="slotProps.data.status === 'cancelled'"
                                                        severity=""
                                                        :value="$t('status.cancelled')"
                                                    />
                                                </div>
                                            </template>
                                        </Column>

                                        <Column field="total" :header="$t('bill.total')">
                                            <template #body="slotProps">
                                                <div class="total">
                                                    {{ slotProps.data.total + ' ' + $settings.default_currency }}
                                                </div>
                                            </template>
                                        </Column>
                                    </DataTable>
                                </TabPanel>
                            </TabView>
                        </div>
                    </div>
                </div>
            </LoadingScreen>
        </div>
    </user-layout>
</template>

<script>
import VendorMixin from '@/mixins/vendors'
export default {
    name: 'ViewVendorPage',
    mixins: [VendorMixin],
    created() {
        this.getVendor(this.$route.params.id)
    },

    methods: {
        editVendorNavigate() {
            this.$router.push({ name: 'edit-vendor', params: { id: this.$route.params.id } })
        },

        viewBillNavigation(rowData) {
            this.$router.push(`/bills/${rowData.data.id}`)
        },
    },
}
</script>

<style>
#vendor_tabs .p-tabview-panels {
    padding: 0 !important;
}
</style>
