<template>
    <user-layout>
        <div id="transactions_page">
            <user-header :title="$t('transaction.transaction', 2)">
                <template #actions>
                    <HeaderActionButton :label="$t('transaction.new_transaction')" icon="fa fa-plus" to="/transactions/new" />
                </template>
            </user-header>

            <div id="transactions_table" class="card">
                <DataTable
                    :value="transactions"
                    :loading="loadingData"
                    paginator
                    :rows="10"
                    paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    :rows-per-page-options="[10, 20, 50]"
                    @row-dblclick="viewTransactionNavigation"
                >
                    <template #empty>
                        <div class="p-4 pl-0 text-center w-full text-gray-500">
                            <i class="fa fa-info-circle empty-icon"></i>
                            <p>{{ $t('transaction.no_transactions') }}</p>
                            <Button
                                class="mt-3"
                                :label="$t('transaction.create_first_transaction')"
                                icon="fa fa-plus"
                                @click="$router.push('/transactions/new')"
                            />
                        </div>
                    </template>

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

                    <Column field="account" :header="$t('transaction.account')">
                        <template #body="{ data }">
                            <span>{{ data.account ? data.account?.name : '-' }}</span>
                        </template>
                    </Column>

                    <template #paginatorstart>
                        <div class="p-d-flex p-ai-center p-mr-2">
                            <Button class="p-button-rounded p-button-text p-button-plain" icon="fa fa-sync" @click="getTransactions()" />
                        </div>
                    </template>
                </DataTable>
            </div>
        </div>
    </user-layout>
</template>

<script>
import TransactionsMixin from '@/mixins/transactions'
export default {
    name: 'TransactionsPage',
    mixins: [TransactionsMixin],

    created() {
        this.getTransactions()
    },

    methods: {
        viewTransactionNavigation(rowData) {
            this.$router.push(`/transactions/${rowData.data.id}`)
        },
    },
}
</script>

<style></style>
