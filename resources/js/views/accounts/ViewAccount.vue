<template>
    <user-layout>
        <div id="view_account_page">
            <user-header :title="account.name">
                <template #actions>
                    <Button :label="$t('basic.edit')" icon="fa fa-edit" class="p-button-success" @click="editAccountNavigation" />
                    <Button
                        :label="$t('basic.delete')"
                        icon="fa fa-trash"
                        class="p-button-danger"
                        @click="deleteAccountAsk($route.params.id)"
                    />
                </template>
            </user-header>
            <LoadingScreen :blocked="loadingData">
                <div class="grid">
                    <div class="col-12 md:col-4">
                        <div class="card">
                            <div class="card-header">
                                <h3>{{ $t('account.account_details') }}</h3>
                            </div>
                            <div class="grid">
                                <div class="col-12 sm:col-6">
                                    <DisplayData :input="$t('account.name')" :value="account.name" />
                                </div>
                                <div class="col-12 sm:col-6">
                                    <Tag v-if="account.type === 'bank_account'" :value="$t('account.bank_account')"></Tag>
                                    <Tag v-if="account.type === 'cash'" :value="$t('account.cash')"></Tag>
                                    <Tag v-if="account.type === 'online_account'" :value="$t('account.online_account')"></Tag>
                                </div>
                            </div>

                            <div class="grid">
                                <div class="col-12 sm:col-6">
                                    <DisplayData
                                        :input="$t('account.opening_balance')"
                                        :value="account.opening_balance + ' ' + account.currency"
                                    />
                                </div>
                                <div class="col-12 sm:col-6">
                                    <DisplayData
                                        :input="$t('account.account_balance')"
                                        :value="account.current_balance + ' ' + account.currency"
                                    />
                                </div>
                            </div>

                            <DisplayData :input="$t('account.description')" :value="account.description" />
                        </div>
                    </div>
                    <div class="col-12 md:col-8">
                        <div class="card">
                            <TabView id="account_tabs">
                                <TabPanel :header="$t('transaction.transaction', 2)">
                                    <DataTable
                                        :value="account.transactions"
                                        paginator
                                        :rows="10"
                                        paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                                        :rows-per-page-options="[10, 20, 50]"
                                        @row-dblclick="viewTransactionNavigation"
                                    >
                                        <template #empty>
                                            <div class="p-3 pl-0 text-center w-full text-gray-500">
                                                <i class="fa fa-info-circle empty-icon"></i>
                                                <p>{{ $t('transaction.no_transactions') }}</p>
                                            </div>
                                        </template>

                                        <Column field="name" :header="$t('transaction.name')">
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
                                                <span>{{ data.amount ? data.amount : '-' }}</span> <br />
                                                <div>
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
                                                </div>
                                            </template>
                                        </Column>

                                        <Column field="category" :header="$t('transaction.category')">
                                            <template #body="{ data }">
                                                <span>{{ data.category ? data.category : '-' }}</span>
                                            </template>
                                        </Column>

                                        <template #paginatorstart>
                                            <div class="p-d-flex p-ai-center p-mr-2">
                                                <Button
                                                    class="p-button-rounded p-button-text p-button-plain"
                                                    icon="fa fa-sync"
                                                    @click="getAccount($route.params.id)"
                                                />
                                            </div>
                                        </template>
                                    </DataTable>
                                </TabPanel>

                                <TabPanel :header="$t('account.bank_details')">
                                    <div class="p-2">
                                        <DisplayData :input="$t('account.bank_name')" :value="account.bank_name" />
                                        <DisplayData :input="$t('account.iban')" :value="account.iban" />
                                        <DisplayData :input="$t('account.bic')" :value="account.bic" />
                                        <DisplayData :input="$t('account.bank_address')" :value="account.bank_address" />
                                        <DisplayData :input="$t('account.bank_contact')" :value="account.bank_contact" />
                                    </div>
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
import AccountsMixin from '@/mixins/accounts'
export default {
    name: 'ViewAccountPage',
    mixins: [AccountsMixin],

    created() {
        this.getAccount(this.$route.params.id)
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
