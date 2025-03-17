<template>
    <DefaultLayout>
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="account.name">
                <template #actions>
                    <Button :label="$t('basic.edit')" icon="fa fa-edit" severity="success" @click="editAccountNavigation" />
                    <Button :label="$t('basic.delete')" icon="fa fa-trash" severity="danger" @click="deleteAccountAsk($route.params.id)" />
                    <Button :label="$t('audit_log.audit_log')" icon="fa fa-history" severity="info" @click="showAuditLogDialog = true" />
                </template>
            </PageHeader>
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="col-span-12 md:col-span-4">
                    <div class="card">
                        <div class="mb-2 font-bold">
                            <h3>{{ $t('account.account_details') }}</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2">
                            <DisplayData :input="$t('form.name')" :value="account.name" />
                            <div>
                                <Tag v-if="account.type === 'bank_account'" :value="$t('account_types.bank_account')" />
                                <Tag v-if="account.type === 'cash'" :value="$t('account_types.cash')" />
                                <Tag v-if="account.type === 'online_account'" :value="$t('account_types.online_account')" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2">
                            <DisplayData
                                :input="$t('form.opening_balance')"
                                :value="formatMoney(account.opening_balance, account.currency)"
                            />
                            <DisplayData :input="$t('form.balance')" :value="formatMoney(account.current_balance, account.currency)" />
                        </div>
                        <DisplayData :input="$t('form.opening_balance_date')" :value="formatDate(account.date_opened)" />
                        <DisplayData :input="$t('form.currency')" :value="account.currency" />
                        <DisplayData :input="$t('form.active_account')" custom-value>
                            <Tag v-if="account.is_active" :value="$t('basic.yes')" severity="success" />
                            <Tag v-else :value="$t('basic.no')" severity="danger" />
                        </DisplayData>
                        <DisplayData :input="$t('form.description')" :value="account.description" />
                    </div>
                </div>
                <div class="col-span-12 md:col-span-8">
                    <div class="card">
                        <Tabs value="transactions">
                            <TabList>
                                <Tab value="transactions">{{ $t('transaction.transaction', 2) }}</Tab>
                                <Tab v-if="account.type === 'bank_account'" value="bank_details">{{ $t('account.bank_details') }}</Tab>
                            </TabList>

                            <TabPanels>
                                <TabPanel value="transactions">
                                    <DataTable
                                        :value="account.transactions"
                                        paginator
                                        :rows="10"
                                        :rows-per-page-options="[10, 20, 50]"
                                        @row-dblclick="viewTransactionNavigation"
                                    >
                                        <template #empty>
                                            <div class="p-3 pl-0 text-center w-full">
                                                <i class="fa fa-info-circle empty-icon"></i>
                                                <p>{{ $t('transaction.no_transactions') }}</p>
                                            </div>
                                        </template>
                                        <Column field="name" :header="$t('form.name')">
                                            <template #body="{ data }">
                                                <span>{{ data.name }}</span>
                                            </template>
                                        </Column>
                                        <Column field="date" :header="$t('transaction.date_and_number')">
                                            <template #body="{ data }">
                                                <span>{{ data.date ? formatDate(data.date) : '-' }}</span
                                                ><br />
                                                <span>{{ data.number }}</span>
                                            </template>
                                        </Column>
                                        <Column field="amount" :header="$t('transaction.amount_and_type')">
                                            <template #body="{ data }">
                                                <span>{{ data.amount ? formatMoney(data.amount, data.currency) : '-' }}</span> <br />
                                                <div>
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
                                                </div>
                                            </template>
                                        </Column>
                                        <template #paginatorstart>
                                            <Button icon="fa fa-sync" @click="getAccount($route.params.id)" />
                                        </template>
                                    </DataTable>
                                </TabPanel>

                                <TabPanel value="bank_details" v-if="account.type === 'bank_account'" class="p-2">
                                    <DisplayData :input="$t('form.bank_name')" :value="account.bank_name" />
                                    <DisplayData :input="$t('form.iban')" :value="account.iban" />
                                    <DisplayData :input="$t('form.bic')" :value="account.bic" />
                                    <DisplayData :input="$t('form.address')" :value="account.bank_address" />
                                    <DisplayData :input="$t('form.contact')" :value="account.bank_contact" />
                                </TabPanel>
                            </TabPanels>
                        </Tabs>
                    </div>
                    <div id="function_buttons" class="flex justify-end mt-4 gap-2">
                        <Button
                            id="close_button"
                            :label="$t('basic.close')"
                            icon="fa fa-times"
                            severity="secondary"
                            @click="goTo('/accounts')"
                        />
                    </div>
                </div>
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
            <AuditLog :item_id="$route.params.id" item_type="Account" />
        </Dialog>
    </DefaultLayout>
</template>

<script>
import AccountsMixin from '@/mixins/accounts'
export default {
    name: 'ViewAccountPage',
    mixins: [AccountsMixin],

    created() {
        this.getAccount(this.$route.params.id)
    },

    data() {
        return {
            showAuditLogDialog: false,
        }
    },

    methods: {
        viewTransactionNavigation(rowData) {
            this.$router.push(`/transactions/${rowData.data.id}`)
        },

        editAccountNavigation() {
            this.$router.push(`/accounts/${this.account.id}/edit`)
        },
    },
}
</script>

<style>
#account_tabs .p-tabview-panels {
    padding: 0 !important;
}
</style>
