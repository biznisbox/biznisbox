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
                        <DisplayData v-if="partner.website" :input="$t('form.website')" :value="partner.website" is-link />
                        <DisplayData v-if="partner.language" :input="$t('form.language')" :value="$t('language.' + partner.language)" />
                        <DisplayData v-if="partner.currency" :input="$t('form.currency')" :value="partner.currency" />
                        <DisplayData v-if="partner.size" :input="$t('form.size')" :value="$t('basic.' + partner.size)" />
                        <DisplayData :input="$t('form.notes')" :value="partner.notes" />
                        <DisplayData v-if="partner.industry" :input="$t('form.industry')" :value="$t(`industries.${partner.industry}`)" />
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:col-span-8">
                    <div class="card">
                        <Tabs value="partner_activities">
                            <TabList>
                                <Tab value="partner_activities">{{ $t('partner.partner_activities') }}</Tab>
                                <Tab value="contact_information">{{ $t('partner.contact_information') }}</Tab>
                                <Tab value="addresses">{{ $t('partner.addresses') }}</Tab>
                                <Tab v-if="hasPermission('invoices')" value="invoices">{{ $t('invoice.invoice', 2) }}</Tab>
                                <Tab v-if="hasPermission('quotes')" value="quotes">{{ $t('quote.quote', 2) }}</Tab>
                                <Tab v-if="hasPermission('bills')" value="bills">{{ $t('bill.bill', 2) }}</Tab>
                                <Tab v-if="hasPermission('transactions')" value="transactions">{{ $t('transaction.transaction', 2) }}</Tab>
                                <Tab v-if="hasPermission('support')" value="support">{{ $t('support.support') }}</Tab>
                                <Tab v-if="hasPermission('archive')" value="archive_documents">{{ $t('archive.archive') }}</Tab>
                            </TabList>

                            <TabPanels>
                                <!-- Partner activities tab -->
                                <TabPanel value="partner_activities">
                                    <div>
                                        <div class="flex justify-between items-center">
                                            <h3 class="font-bold mb-4 dark:text-surface-200">{{ $t('partner.activities') }}</h3>
                                            <Button
                                                :label="$t('partner.add_activity')"
                                                icon="fa fa-plus"
                                                @click="newActivity()"
                                                severity="secondary"
                                                outlined
                                                v-if="partner.activities.length > 0"
                                            />
                                        </div>
                                        <div id="activities_timeline" v-if="partner.activities.length > 0">
                                            <Timeline :value="partner.activities">
                                                <template #marker="slotProps">
                                                    <span
                                                        class="flex w-8 h-8 items-center justify-center text-primary rounded-full border border-primary z-10 shadow-sm"
                                                    >
                                                        <span v-if="slotProps.item.type === 'call'" class="fa fa-phone"></span>
                                                        <span v-if="slotProps.item.type === 'task'" class="fa fa-tasks"></span>
                                                        <span v-if="slotProps.item.type === 'video_call'" class="fa fa-video"></span>
                                                        <span v-if="slotProps.item.type === 'meeting'" class="fa fa-users"></span>
                                                        <span v-if="slotProps.item.type === 'email'" class="fa fa-envelope"></span>
                                                        <span v-if="slotProps.item.type === 'visit'" class="fa fa-map-marker"></span>
                                                        <span v-if="slotProps.item.type === 'note'" class="fa fa-sticky-note"></span>
                                                        <span v-if="slotProps.item.type === 'other'" class="fa fa-ellipsis-h"></span>
                                                    </span>
                                                </template>

                                                <template #content="slotProps">
                                                    <div class="flex flex-col mt-2">
                                                        <div class="grid grid-cols-3 gap-2">
                                                            <span class="text-left font-bold dark:text-surface-200">{{
                                                                slotProps.item.subject
                                                            }}</span>
                                                            <span
                                                                class="ml-2 text-sm dark:text-surface-200"
                                                                v-if="slotProps.item.start_date"
                                                                >{{
                                                                    formatDateTime(slotProps.item.start_date) +
                                                                    ' - ' +
                                                                    formatDateTime(slotProps.item.end_date)
                                                                }}</span
                                                            >
                                                        </div>

                                                        <div class="flex">
                                                            <div>
                                                                <Tag
                                                                    v-if="slotProps.item.status === 'not_started'"
                                                                    severity="info"
                                                                    :value="$t('status.not_started')"
                                                                />
                                                                <Tag
                                                                    v-if="slotProps.item.status === 'planned'"
                                                                    severity="warn"
                                                                    :value="$t('status.planned')"
                                                                />
                                                                <Tag
                                                                    v-if="slotProps.item.status === 'in_progress'"
                                                                    severity="warn"
                                                                    :value="$t('status.in_progress')"
                                                                />
                                                                <Tag
                                                                    v-if="slotProps.item.status === 'completed'"
                                                                    severity="success"
                                                                    :value="$t('status.completed')"
                                                                />
                                                                <Tag
                                                                    v-if="slotProps.item.status === 'cancelled'"
                                                                    severity="secondary"
                                                                    :value="$t('status.cancelled')"
                                                                />
                                                                <Tag
                                                                    v-if="slotProps.item.status === 'other'"
                                                                    severity="secondary"
                                                                    :value="$t('basic.other')"
                                                                />
                                                            </div>
                                                            <div class="ml-2">
                                                                <Tag
                                                                    v-if="slotProps.item.priority === 'low'"
                                                                    severity="info"
                                                                    :value="$t('priority.low')"
                                                                />
                                                                <Tag
                                                                    v-if="slotProps.item.priority === 'medium'"
                                                                    severity="warn"
                                                                    :value="$t('priority.medium')"
                                                                />
                                                                <Tag
                                                                    v-if="slotProps.item.priority === 'high'"
                                                                    severity="danger"
                                                                    :value="$t('priority.high')"
                                                                />
                                                                <Tag
                                                                    v-if="slotProps.item.priority === 'other'"
                                                                    severity="secondary"
                                                                    :value="$t('basic.other')"
                                                                />
                                                            </div>
                                                        </div>
                                                        <div class="grid">
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                                                <div>
                                                                    <div class="block text-sm dark:text-surface-200">
                                                                        {{ slotProps.item.location }}
                                                                    </div>
                                                                    <div class="block text-sm dark:text-surface-200">
                                                                        {{ slotProps.item.notes }}
                                                                    </div>
                                                                    <div class="block text-sm dark:text-surface-200">
                                                                        {{ slotProps.item.outcome }}
                                                                    </div>
                                                                    <div
                                                                        v-if="slotProps.item.type === 'note'"
                                                                        class="block text-sm dark:text-surface-200"
                                                                    >
                                                                        <span v-html="formatHtml(slotProps.item.content)"></span>
                                                                    </div>
                                                                </div>

                                                                <div class="flex gap-2 mt-2">
                                                                    <Button
                                                                        icon="fa fa-edit"
                                                                        @click="editActivity(slotProps.item)"
                                                                        severity="success"
                                                                        outlined
                                                                        class="md:ml-auto"
                                                                    />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </Timeline>
                                        </div>

                                        <div v-else>
                                            <div class="p-4 pl-0 text-center w-full">
                                                <i class="fa fa-info-circle empty-icon"></i>
                                            </div>
                                            <p class="text-center">{{ $t('partner.no_activities') }}</p>
                                            <div class="flex justify-center mt-4">
                                                <Button
                                                    :label="$t('partner.add_activity')"
                                                    icon="fa fa-plus"
                                                    @click="newActivity()"
                                                    severity="secondary"
                                                    outlined
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </TabPanel>

                                <!-- Contacts table -->
                                <TabPanel value="contact_information">
                                    <DataTable id="contacts_table" :value="partner.contacts">
                                        <template #empty>
                                            <div class="p-4 pl-0 text-center w-full dark:text-gray-400">
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
                                        <Column field="email" :header="$t('form.email')">
                                            <template #body="{ data }">
                                                <span v-if="data.email" @click="openSendEmailDialog(data)">{{ data.email }}</span>
                                            </template>
                                        </Column>
                                        <Column field="phone_number" :header="$t('form.phone_number')">
                                            <template #body="{ data }">
                                                <a :href="'tel:' + data.phone_number">{{ data.phone_number }}</a>
                                            </template>
                                        </Column>
                                        <Column field="mobile_number" :header="$t('form.mobile_number')">
                                            <template #body="{ data }">
                                                <a :href="'tel:' + data.mobile_number">{{ data.mobile_number }}</a>
                                            </template>
                                        </Column>
                                        <Column field="notes" :header="$t('form.notes')" />
                                    </DataTable>
                                </TabPanel>

                                <!-- Addresses table -->
                                <TabPanel value="addresses">
                                    <DataTable id="addresses_table" class="col-12" :value="partner.addresses">
                                        <template #empty>
                                            <div class="p-4 pl-0 text-center w-full dark:text-gray-400">
                                                <i class="fa fa-info-circle empty-icon"></i>
                                                <p>{{ $t('partner.no_addresses') }}</p>
                                            </div>
                                        </template>

                                        <Column field="type" :header="$t('form.type')">
                                            <template #body="{ data }">
                                                <div class="flex gap-2">
                                                    <i v-if="data.is_primary" class="fa fa-star text-yellow-500 mr-2"></i>
                                                    <Tag v-if="data.type === 'billing'" :value="$t('address_types.billing')" />
                                                    <Tag v-if="data.type === 'shipping'" :value="$t('address_types.shipping')" />
                                                    <Tag v-if="data.type === 'office'" :value="$t('address_types.office')" />
                                                    <Tag v-if="data.type === 'other'" :value="$t('basic.other')" />
                                                </div>
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
                                            <div class="p-4 pl-0 text-center w-full dark:text-gray-400">
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
                                                <Tag v-if="data.status === 'paid'" severity="success" :value="$t('status.paid')" />
                                                <Tag v-if="data.status === 'unpaid'" severity="danger" :value="$t('status.unpaid')" />
                                                <Tag v-if="data.status === 'overdue'" severity="danger" :value="$t('status.overdue')" />
                                                <Tag v-if="data.status === 'draft'" severity="warn" :value="$t('status.draft')" />
                                                <Tag v-if="data.status === 'sent'" severity="warn" :value="$t('status.sent')" />
                                                <Tag
                                                    v-if="data.status === 'refunded'"
                                                    severity="secondary"
                                                    :value="$t('status.refunded')"
                                                />
                                                <Tag
                                                    v-if="data.status === 'cancelled'"
                                                    severity="secondary"
                                                    :value="$t('status.cancelled')"
                                                />
                                            </template>
                                        </Column>
                                    </DataTable>
                                </TabPanel>

                                <!-- Quotes table -->
                                <TabPanel value="quotes" v-if="hasPermission('quotes')">
                                    <div id="quote_table">
                                        <DataTable :value="partner.quotes" @row-dblclick="viewQuoteNavigation">
                                            <template #empty>
                                                <div class="p-4 pl-0 text-center w-full dark:text-gray-400">
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
                                                    <Tag
                                                        v-if="data.status === 'accepted'"
                                                        severity="success"
                                                        :value="$t('status.accepted')"
                                                    />
                                                    <Tag
                                                        v-if="data.status === 'rejected'"
                                                        severity="danger"
                                                        :value="$t('status.rejected')"
                                                    />
                                                    <Tag v-if="data.status === 'draft'" severity="warn" :value="$t('status.draft')" />
                                                    <Tag v-if="data.status === 'sent'" severity="warn" :value="$t('status.sent')" />
                                                    <Tag v-if="data.status === 'viewed'" severity="warn" :value="$t('status.viewed')" />
                                                    <Tag v-if="data.status === 'expired'" severity="danger" :value="$t('status.expired')" />
                                                    <Tag
                                                        v-if="data.status === 'cancelled'"
                                                        severity="secondary"
                                                        :value="$t('status.cancelled')"
                                                    />
                                                    <Tag
                                                        v-if="data.status === 'converted'"
                                                        severity="success"
                                                        :value="$t('status.converted')"
                                                    />
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
                                                <div class="p-4 pl-0 text-center w-full dark:text-gray-400">
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
                                                <template #body="{ data }">
                                                    <div class="status">
                                                        <Tag v-if="data.status === 'paid'" severity="success" :value="$t('status.paid')" />
                                                        <Tag
                                                            v-if="data.status === 'unpaid'"
                                                            severity="danger"
                                                            :value="$t('status.unpaid')"
                                                        />
                                                        <Tag
                                                            v-if="data.status === 'overdue'"
                                                            severity="danger"
                                                            :value="$t('status.overdue')"
                                                        />
                                                        <Tag v-if="data.status === 'draft'" severity="warn" :value="$t('status.draft')" />
                                                        <Tag
                                                            v-if="data.status === 'cancelled'"
                                                            severity="secondary"
                                                            :value="$t('status.cancelled')"
                                                        />
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
                                                <div class="p-4 pl-0 text-center w-full dark:text-gray-400">
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
                                            <div class="p-4 pl-0 text-center w-full dark:text-gray-400">
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
                                                <div class="p-4 pl-0 text-center w-full dark:text-gray-400">
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
            <div id="function_buttons" class="flex justify-end mt-4 gap-2">
                <Button :label="$t('basic.close')" icon="fa fa-times" @click="goTo('/partners')" severity="secondary" />
            </div>
        </LoadingScreen>

        <!-- Send email to partner contact dialog -->
        <Dialog
            v-model:visible="showSendEmailDialog"
            modal
            maximizable
            class="w-full m-2 lg:w-1/2"
            :header="$t('partner.send_email')"
            :draggable="false"
        >
            <div id="send_email_form">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <SelectInput
                        v-model="partner_email_message.partner_contact_id"
                        :label="$t('form.contact')"
                        :options="partner.contacts"
                        option-value="id"
                        option-label="name"
                        show-clear
                    />
                    <TextInput v-model="partner_email_message.subject" :label="$t('form.subject')" />
                </div>

                <TinyMceEditor v-model="partner_email_message.content" :label="$t('form.content')" />
            </div>

            <template #footer>
                <div id="function_buttons" class="flex justify-end gap-2">
                    <Button
                        id="email_cancel_button"
                        :label="$t('basic.cancel')"
                        icon="fa fa-times"
                        severity="secondary"
                        @click="closeSendEmailDialog"
                    />
                    <Button id="email_send_button" :label="$t('basic.send')" icon="fa fa-envelope" @click="sendEmail" severity="success" />
                </div>
            </template>
        </Dialog>

        <!-- Edit add activity dialog -->
        <Dialog
            v-model:visible="showAddEditActivityDialog"
            modal
            maximizable
            class="w-full m-2 lg:w-1/2"
            :header="activityDialogMode === 'add' ? $t('partner.add_activity') : $t('partner.edit_activity')"
            :draggable="false"
        >
            <div id="add_edit_activity_form">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <SelectInput
                        v-model="activity.partner_contact_id"
                        :label="$t('form.contact')"
                        :options="partner.contacts"
                        option-value="id"
                        option-label="name"
                        show-clear
                    />
                    <SelectInput
                        v-model="v$.activity.type.$model"
                        :label="$t('form.activity_type')"
                        :options="[
                            { value: 'call', name: $t('partner_activity_types.call') },
                            { value: 'task', name: $t('partner_activity_types.task') },
                            { value: 'video_call', name: $t('partner_activity_types.video_call') },
                            { value: 'meeting', name: $t('partner_activity_types.meeting') },
                            { value: 'email', name: $t('partner_activity_types.email') },
                            { value: 'visit', name: $t('partner_activity_types.visit') },
                            { value: 'note', name: $t('partner_activity_types.note') },
                            { value: 'other', name: $t('partner_activity_types.other') },
                        ]"
                        option-value="value"
                        option-label="name"
                        :validate="v$.activity.type"
                    />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <SelectInput
                        v-model="v$.activity.status.$model"
                        :label="$t('form.status')"
                        :options="[
                            { value: 'not_started', name: $t('status.not_started') },
                            { value: 'planned', name: $t('status.planned') },
                            { value: 'in_progress', name: $t('status.in_progress') },
                            { value: 'completed', name: $t('status.completed') },
                            { value: 'cancelled', name: $t('status.cancelled') },
                            { value: 'other', name: $t('basic.other') },
                        ]"
                        option-value="value"
                        option-label="name"
                        :validate="v$.activity.status"
                    />

                    <SelectInput
                        v-model="v$.activity.priority.$model"
                        :label="$t('form.priority')"
                        :options="[
                            { value: 'low', name: $t('priority.low') },
                            { value: 'normal', name: $t('priority.normal') },
                            { value: 'medium', name: $t('priority.medium') },
                            { value: 'high', name: $t('priority.high') },
                        ]"
                        option-value="value"
                        option-label="name"
                        :validate="v$.activity.priority"
                    />
                </div>

                <TextInput v-model="v$.activity.subject.$model" :label="$t('form.subject')" :validate="v$.activity.subject" />
                <TinyMceEditor v-model="v$.activity.content.$model" :label="$t('form.content')" :validate="v$.activity.content" />
                <TextAreaInput v-model="activity.location" :label="$t('form.location')" />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <DateInput v-model="activity.start_date" :label="$t('form.start_date')" showTime />
                    <DateInput v-model="activity.end_date" :label="$t('form.end_date')" showTime />
                </div>

                <TextAreaInput v-model="activity.notes" :label="$t('form.notes')" />
                <TextAreaInput v-model="activity.outcome" :label="$t('form.outcome')" v-if="activity.status === 'completed'" />
            </div>

            <template #footer>
                <div id="function_buttons" class="flex justify-end gap-2">
                    <Button
                        id="activity_delete_button"
                        :label="$t('basic.delete')"
                        icon="fa fa-trash"
                        severity="danger"
                        @click="deletePartnerActivity(activity.id)"
                        v-if="activityDialogMode === 'edit'"
                    />

                    <Button
                        id="activity_cancel_button"
                        :label="$t('basic.cancel')"
                        icon="fa fa-times"
                        severity="secondary"
                        @click="showAddEditActivityDialog = false"
                    />
                    <Button
                        id="activity_save_button"
                        :label="activityDialogMode == 'add' ? $t('basic.save') : $t('basic.update')"
                        icon="fa fa-save"
                        @click="addUpdateActivityValidation"
                        severity="success"
                    />
                </div>
            </template>
        </Dialog>

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
    </DefaultLayout>
</template>
<script>
import PartnerMixin from '@/mixins/partners'
import { required } from '@/plugins/i18n-validators'
import { useVuelidate } from '@vuelidate/core'
export default {
    name: 'ViewPartnerPage',
    mixins: [PartnerMixin],

    created() {
        this.getPartner(this.$route.params.id)
    },

    setup() {
        return { v$: useVuelidate() }
    },

    validations() {
        return {
            activity: {
                type: { required },
                status: { required },
                subject: { required },
                content: { required },
                priority: { required },
            },
        }
    },

    data() {
        return {
            showAuditLogDialog: false,
            showAddEditActivityDialog: false,
            activityDialogMode: 'add',
            showSendEmailDialog: false,
        }
    },

    methods: {
        editPartnerNavigation() {
            this.$router.push({ name: 'partner-edit', params: { id: this.$route.params.id } })
        },

        downloadFile(rowData) {
            window.open(rowData.data.download_link, '_blank')
        },

        editActivity(activity) {
            this.resetActivityDialog()
            this.activity = { ...activity }
            this.showAddEditActivityDialog = true
            this.activityDialogMode = 'edit'
        },

        newActivity() {
            this.resetActivityDialog()
            this.showAddEditActivityDialog = true
            this.activityDialogMode = 'add'
        },

        resetActivityDialog() {
            this.v$.activity.$reset()
            this.activity = {
                partner_contact_id: null,
                type: 'email',
                status: 'planned',
                priority: 'normal',
                subject: '',
                content: '',
                location: '',
                start_date: null,
                end_date: null,
                notes: '',
                outcome: '',
            }
        },

        resetPartnerEmailMessage() {
            this.partner_email_message = {
                partner_contact_id: null,
                subject: '',
                content: '',
            }
        },

        sendEmail() {
            if (this.partner_email_message.partner_contact_id === null) {
                this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
                return
            }
            this.sendEmailToPartner()
        },

        openSendEmailDialog(partner) {
            this.resetPartnerEmailMessage()
            this.partner_email_message.partner_contact_id = partner.id
            this.showSendEmailDialog = true
        },

        closeSendEmailDialog() {
            this.showSendEmailDialog = false
        },

        addUpdateActivityValidation() {
            this.v$.activity.$touch()
            if (this.v$.activity.$invalid) {
                this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
                return
            }

            this.activity.partner_id = this.partner.id

            if (this.activityDialogMode === 'add') {
                this.addPartnerActivity()
            } else {
                this.updatePartnerActivity()
            }
        },
    },
}
</script>
<style>
/* Hide the opposite event section */
div[data-pc-section='eventopposite'] {
    display: none;
}
</style>
