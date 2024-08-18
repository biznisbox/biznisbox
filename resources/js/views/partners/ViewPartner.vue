<template>
    <DefaultLayout>
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="partner.name">
                <template #actions>
                    <Button :label="$t('basic.edit')" icon="fa fa-pen" @click="editPartnerNavigation" severity="success" />
                    <Button :label="$t('basic.delete')" icon="fa fa-trash" severity="danger" @click="deletePartnerAsk($route.params.id)" />
                    <Button :label="$t('audit_log.audit_log')" icon="fa fa-history" @click="showAuditLogDialog = true" />
                </template>
            </PageHeader>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-3">
                <div class="grid grid-cols-1 lg:col-span-4">
                    <div class="card">
                        <div class="font-bold mb-4">
                            <h3>{{ $t('partner.partner_details') }}</h3>
                        </div>
                        <DisplayData :input="$t('form.number')" :value="partner.number" />
                        <DisplayData :input="$t('form.name')" :value="partner.name" />
                        <div class="grid md:grid-cols-2 gap-2">
                            <div>
                                <Tag v-if="partner.type === 'customer'" :value="$t('partner_types.customer')" />
                                <Tag v-if="partner.type === 'supplier'" :value="$t('partner_types.supplier')" />
                                <Tag v-if="partner.type === 'both'" :value="$t('partner_types.both')" />
                                <Tag v-if="partner.type === 'other'" :value="$t('basic.other')" />
                            </div>
                            <div>
                                <Tag v-if="partner.entity_type == 'company'" :value="$t('entity_types.company')" />
                                <Tag v-if="partner.entity_type == 'individual'" :value="$t('entity_types.individual')" />
                            </div>
                        </div>
                        <DisplayData :input="$t('form.vat_number')" :value="partner.vat_number" />
                        <DisplayData :input="$t('form.website')" :value="partner.website" is-link />
                        <DisplayData :input="$t('form.language')" v-if="partner.language" :value="$t('language.' + partner.language)" />
                        <DisplayData :input="$t('form.currency')" :value="partner.currency" />
                        <DisplayData :input="$t('form.size')" :value="partner.size" custom-value>
                            <span v-if="partner.size === 'micro'">{{ $t('basic.micro') }}</span>
                            <span v-if="partner.size === 'small'">{{ $t('basic.small') }}</span>
                            <span v-if="partner.size === 'medium'">{{ $t('basic.medium') }}</span>
                            <span v-if="partner.size === 'large'">{{ $t('basic.large') }}</span>
                        </DisplayData>
                        <DisplayData :input="$t('form.notes')" :value="partner.notes" />
                        <DisplayData v-if="partner.industry" :input="$t('form.industry')" :value="$t(`industries.${partner.industry}`)" />
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:col-span-8">
                    <div class="card">
                        <Tabs value="contact_informations">
                            <TabList>
                                <Tab value="contact_informations">{{ $t('partner.contact_informations') }}</Tab>
                                <Tab value="addresses">{{ $t('partner.addresses') }}</Tab>
                                <Tab v-if="hasPermission('invoices')" value="invoices">{{ $t('invoice.invoice', 2) }}</Tab>
                                <Tab v-if="hasPermission('quotes')" value="quotes">{{ $t('quote.quote', 2) }}</Tab>
                                <Tab v-if="hasPermission('bills')" value="bills">{{ $t('bill.bill', 2) }}</Tab>
                                <Tab v-if="hasPermission('transactions')" value="transactions">{{ $t('transaction.transaction', 2) }}</Tab>
                                <Tab v-if="hasPermission('support')" value="support">{{ $t('support.support') }}</Tab>
                                <Tab v-if="hasPermission('archive')" value="archive_documents">{{ $t('archive.archive') }}</Tab>
                            </TabList>

                            <TabPanels>
                                <!-- Contacts table -->
                                <TabPanel value="contact_informations">
                                    <DataTable id="contacts_table" :value="partner.contacts">
                                        <template #empty>
                                            <div class="p-4 pl-0 text-center w-full">
                                                <i class="fa fa-info-circle empty-icon"></i>
                                                <p>{{ $t('partner.no_contacts') }}</p>
                                            </div>
                                        </template>
                                        <Column field="name" :header="$t('form.name')">
                                            <template #body="{ data }">
                                                <div class="flex gap-2">
                                                    <i v-if="data.is_primary" class="fa fa-star text-yellow-500 mr-2"></i>
                                                    <span>{{ data.name }}</span>
                                                </div>
                                            </template>
                                        </Column>
                                        <Column field="function" :header="$t('form.function')" />
                                        <Column field="email" :header="$t('form.email')" />
                                        <Column field="phone_number" :header="$t('form.phone_number')" />
                                        <Column field="mobile_number" :header="$t('form.mobile_number')" />
                                        <Column field="fax_number" :header="$t('form.fax_number')" />
                                        <Column field="notes" :header="$t('form.notes')" />
                                    </DataTable>
                                </TabPanel>

                                <!-- Addresses table -->
                                <TabPanel value="addresses">
                                    <DataTable id="addresses_table" class="col-12" :value="partner.addresses">
                                        <template #empty>
                                            <div class="p-4 pl-0 text-center w-full">
                                                <i class="fa fa-info-circle empty-icon"></i>
                                                <p>{{ $t('partner.no_addresses') }}</p>
                                            </div>
                                        </template>

                                        <Column field="type" :header="$t('form.type')">
                                            <template #body="{ data }">
                                                <Tag v-if="data.type === 'billing'" :value="$t('address_types.billing')" />
                                                <Tag v-if="data.type === 'shipping'" :value="$t('address_types.shipping')" />
                                                <Tag v-if="data.type === 'office'" :value="$t('address_types.office')" />
                                                <Tag v-if="data.type === 'other'" :value="$t('basic.other')" />
                                            </template>
                                        </Column>
                                        <Column field="address" :header="$t('form.address')" />
                                        <Column field="zip_code" :header="$t('form.zip_code')" />
                                        <Column field="city" :header="$t('form.city')" />
                                        <Column field="country" :header="$t('form.country')">
                                            <template #body="slotProps">
                                                {{ formatCountry(slotProps.data.country) }}
                                            </template>
                                        </Column>
                                        <Column field="notes" :header="$t('form.notes')" />
                                    </DataTable>
                                </TabPanel>

                                <!-- Invoices table -->
                                <TabPanel value="invoices" v-if="hasPermission('invoices')">
                                    <DataTable :value="partner.invoices" @row-dblclick="viewInvoiceNavigation">
                                        <template #empty>
                                            <div class="p-4 pl-0 text-center w-full">
                                                <i class="fa fa-info-circle empty-icon"></i>
                                                <p>{{ $t('invoice.no_invoices') }}</p>
                                            </div>
                                        </template>
                                        <Column field="number" :header="$t('form.number')" />
                                        <Column field="date" :header="$t('invoice.date_and_due_date')">
                                            <template #body="{ data }">
                                                <div>{{ data.date ? formatDate(data.date) : '' }}</div>
                                                <div>{{ data.due_date ? formatDate(data.due_date) : '' }}</div>
                                            </template>
                                        </Column>
                                        <Column field="total" :header="$t('form.total')">
                                            <template #body="{ data }">
                                                {{ formatMoney(data.total, data.currency) }}
                                            </template>
                                        </Column>
                                        <Column filter-field="status" :header="$t('form.status')">
                                            <template #body="{ data }">
                                                <Tag v-if="data.status === 'paid'" severity="success">{{ $t('status.paid') }}</Tag>
                                                <Tag v-if="data.status === 'unpaid'" severity="danger">{{ $t('status.unpaid') }}</Tag>
                                                <Tag v-if="data.status === 'overdue'" severity="danger">{{ $t('status.overdue') }}</Tag>
                                                <Tag v-if="data.status === 'draft'" severity="warn">{{ $t('status.draft') }}</Tag>
                                                <Tag v-if="data.status === 'sent'" severity="warn">{{ $t('status.sent') }}</Tag>
                                                <Tag v-if="data.status === 'refunded'" severity="secondary">{{
                                                    $t('status.refunded')
                                                }}</Tag>
                                                <Tag v-if="data.status === 'cancelled'" severity="secondary">{{
                                                    $t('status.cancelled')
                                                }}</Tag>
                                            </template>
                                        </Column>
                                    </DataTable>
                                </TabPanel>

                                <!-- Quotes table -->
                                <TabPanel value="quotes" v-if="hasPermission('quotes')">
                                    <div id="quote_table">
                                        <DataTable :value="partner.quotes" @row-dblclick="viewQuoteNavigation">
                                            <template #empty>
                                                <div class="p-4 pl-0 text-center w-full">
                                                    <i class="fa fa-info-circle empty-icon"></i>
                                                    <p>{{ $t('quote.no_quotes') }}</p>
                                                </div>
                                            </template>
                                            <Column field="number" :header="$t('form.number')">
                                                <template #body="{ data }">
                                                    {{ data.number }}
                                                </template>
                                            </Column>
                                            <Column field="date" :header="$t('quote.date_and_due_date')">
                                                <template #body="{ data }">
                                                    <span>{{ data.date ? formatDate(data.date) : '' }}</span> <br />
                                                    <span>{{ data.valid_until ? formatDate(data.valid_until) : '' }}</span>
                                                </template>
                                            </Column>
                                            <Column field="customer" :header="$t('quote.customer_and_payer')">
                                                <template #body="{ data }">
                                                    {{ formatText(data.customer_name) }} <br />
                                                    {{ formatText(data.payer_name) }}
                                                </template>
                                            </Column>
                                            <Column field="total" :header="$t('form.total')">
                                                <template #body="{ data }">
                                                    {{ formatMoney(data.total, data.currency) }}
                                                </template>
                                            </Column>
                                            <Column filter-field="status" :header="$t('form.status')">
                                                <template #body="{ data }">
                                                    <Tag v-if="data.status === 'accepted'" severity="success">{{
                                                        $t('status.accepted')
                                                    }}</Tag>
                                                    <Tag v-if="data.status === 'rejected'" severity="danger">{{
                                                        $t('status.rejected')
                                                    }}</Tag>
                                                    <Tag v-if="data.status === 'draft'" severity="warn">{{ $t('status.draft') }}</Tag>
                                                    <Tag v-if="data.status === 'sent'" severity="warn">{{ $t('status.sent') }}</Tag>
                                                    <Tag v-if="data.status === 'viewed'" severity="warn">{{ $t('status.viewed') }}</Tag>
                                                    <Tag v-if="data.status === 'expired'" severity="danger">{{ $t('status.expired') }}</Tag>
                                                    <Tag v-if="data.status === 'cancelled'" severity="secondary">{{
                                                        $t('status.cancelled')
                                                    }}</Tag>
                                                    <Tag v-if="data.status === 'converted'" severity="success">{{
                                                        $t('status.converted')
                                                    }}</Tag>
                                                </template>
                                            </Column>
                                        </DataTable>
                                    </div>
                                </TabPanel>

                                <!-- Bills tab -->
                                <TabPanel value="bills" v-if="hasPermission('bills')">
                                    <div id="bills_table">
                                        <DataTable :value="partner.bills" @row-dblclick="viewBillNavigation">
                                            <template #empty>
                                                <div class="p-4 pl-0 text-center w-full">
                                                    <i class="fa fa-info-circle empty-icon"></i>
                                                    <p>{{ $t('bill.no_bills') }}</p>
                                                </div>
                                            </template>

                                            <Column field="number" :header="$t('form.number')" />
                                            <Column field="supplier_name" :header="$t('form.supplier')">
                                                <template #body="{ data }">
                                                    {{ data.supplier_name }}
                                                </template>
                                            </Column>
                                            <Column field="date" :header="$t('bill.date_and_due_date')">
                                                <template #body="{ data }">
                                                    <span class="date">{{ data.date ? formatDate(data.date) : '-' }}</span> <br />
                                                    <span class="due_date">{{ data.due_date ? formatDate(data.due_date) : '-' }}</span>
                                                </template>
                                            </Column>
                                            <Column field="status" :header="$t('form.status')">
                                                <template #body="slotProps">
                                                    <div class="status">
                                                        <Tag v-if="slotProps.data.status === 'paid'" severity="success">{{
                                                            $t('status.paid')
                                                        }}</Tag>
                                                        <Tag v-if="slotProps.data.status === 'unpaid'" severity="danger">{{
                                                            $t('status.unpaid')
                                                        }}</Tag>
                                                        <Tag v-if="slotProps.data.status === 'overdue'" severity="danger">{{
                                                            $t('status.overdue')
                                                        }}</Tag>
                                                        <Tag v-if="slotProps.data.status === 'draft'" severity="warn">{{
                                                            $t('status.draft')
                                                        }}</Tag>
                                                        <Tag v-if="slotProps.data.status === 'cancelled'" severity="secondary">{{
                                                            $t('status.cancelled')
                                                        }}</Tag>
                                                    </div>
                                                </template>
                                            </Column>

                                            <Column field="total" :header="$t('form.total')">
                                                <template #body="{ data }">
                                                    {{ data.total + ' ' + data.currency }}
                                                </template>
                                            </Column>
                                        </DataTable>
                                    </div>
                                </TabPanel>

                                <!-- Transactions tab -->
                                <TabPanel value="transactions" v-if="hasPermission('transactions')">
                                    <div id="transactions_table">
                                        <DataTable :value="partner.transactions" @row-dblclick="viewTransactionNavigation">
                                            <template #empty>
                                                <div class="p-4 pl-0 text-center w-full">
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

                                            <Column field="account" :header="$t('form.account')">
                                                <template #body="{ data }">
                                                    {{ data.account ? data.account?.name : '-' }}
                                                </template>
                                            </Column>
                                        </DataTable>
                                    </div>
                                </TabPanel>

                                <!-- Support tab -->
                                <TabPanel value="support" v-if="hasPermission('support')">
                                    <DataTable :value="partner.support_tickets" @row-dblclick="viewSupportTicketNavigation">
                                        <template #empty>
                                            <div class="p-4 pl-0 text-center w-full">
                                                <i class="fa fa-info-circle empty-icon"></i>
                                                <p>{{ $t('support.no_support_tickets') }}</p>
                                            </div>
                                        </template>
                                        <Column field="number" :header="$t('form.number')" />
                                        <Column field="subject" :header="$t('form.subject')" />
                                        <Column field="status" :header="$t('form.status')">
                                            <template #body="{ data }">
                                                <Tag v-if="data.status === 'open'" :value="$t('status.open')" severity="success" />
                                                <Tag
                                                    v-else-if="data.status === 'closed'"
                                                    :value="$t('status.closed')"
                                                    severity="secondary"
                                                />
                                                <Tag
                                                    v-else-if="data.status === 'in_progress'"
                                                    :value="$t('status.in_progress')"
                                                    severity="warning"
                                                />
                                                <Tag
                                                    v-else-if="data.status === 'resolved'"
                                                    :value="$t('status.resolved')"
                                                    severity="success"
                                                />
                                                <Tag
                                                    v-else-if="data.status === 'reopened'"
                                                    :value="$t('status.reopened')"
                                                    severity="secondary"
                                                />
                                            </template>
                                        </Column>
                                    </DataTable>
                                </TabPanel>

                                <!-- Archive documents tab -->
                                <TabPanel value="archive_documents" v-if="hasPermission('archive')">
                                    <div id="archive_documents_table">
                                        <DataTable :value="partner.archive_documents" @row-dblclick="downloadFile">
                                            <template #empty>
                                                <div class="p-4 pl-0 text-center w-full">
                                                    <i class="fa fa-info-circle empty-icon"></i>
                                                    <p>{{ $t('archive.no_documents') }}</p>
                                                </div>
                                            </template>
                                            <Column field="name" :header="$t('form.name')" sortable>
                                                <template #body="{ data }">
                                                    <div class="flex items-center">
                                                        <span :class="`fiv-viv fiv-icon-${data.file_extension} icon-file`"></span>
                                                        <span class="ml-2">{{ data.name }}</span>
                                                    </div>
                                                </template>
                                            </Column>
                                            <Column field="created_at" :header="$t('form.created_at')">
                                                <template #body="{ data }">
                                                    <span>{{ formatDateTime(data.created_at) }}</span>
                                                </template>
                                            </Column>
                                            <Column field="file_size" :header="$t('form.size')">
                                                <template #body="{ data }">
                                                    <span>{{ formatFileSize(data.file_size) }}</span>
                                                </template>
                                            </Column>
                                        </DataTable>
                                    </div>
                                </TabPanel>
                            </TabPanels>
                        </Tabs>
                    </div>
                </div>
            </div>
            <div id="function_buttons" class="flex justify-end mt-4">
                <Button :label="$t('basic.close')" icon="fa fa-times" @click="goTo('/partners')" severity="secondary" />
            </div>

            <!--Audit log dialog -->
            <Dialog
                v-model:visible="showAuditLogDialog"
                modal
                maximizable
                class="w-full m-2 lg:w-1/2"
                :header="$t('audit_log.audit_log')"
                :draggable="false"
            >
                <AuditLog :item_id="$route.params.id" item_type="Partner" />
            </Dialog>
        </LoadingScreen>
    </DefaultLayout>
</template>
<script>
import PartnerMixin from '@/mixins/partners'
export default {
    name: 'ViewPartnerPage',
    mixins: [PartnerMixin],

    created() {
        this.getPartner(this.$route.params.id)
    },

    data() {
        return {
            showAuditLogDialog: false,
        }
    },

    methods: {
        editPartnerNavigation() {
            this.$router.push({ name: 'partner-edit', params: { id: this.$route.params.id } })
        },

        downloadFile(rowData) {
            window.open(rowData.data.download_link, '_blank')
        },
    },
}
</script>
<style></style>
