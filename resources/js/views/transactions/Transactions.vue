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
                    v-model:filters="filters"
                    :loading="loadingData"
                    paginator
                    data-key="id"
                    filter-display="menu"
                    :rows="10"
                    paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    :rows-per-page-options="[10, 20, 50]"
                    :globalFilterFields="['name', 'number', 'amount', 'category', 'account']"
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

                    <Column field="name" :header="$t('transaction.name')">
                        <template #body="{ data }">
                            <span>{{ data.name ? data.name : '-' }}</span>
                        </template>

                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by name" />
                        </template>
                    </Column>

                    <Column field="date" :header="$t('transaction.date_and_number')">
                        <template #body="{ data }">
                            <span>{{ data.date ? formatDate(data.date) : '-' }}</span
                            ><br />
                            <span>{{ data.number }}</span>
                        </template>

                        <template #filter="{ filterModel }">
                            <div class="flex">
                                <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by date" />
                            </div>
                        </template>
                    </Column>

                    <Column field="amount" :header="$t('transaction.amount')">
                        <template #body="{ data }">
                            <span>{{ data.amount ? data.amount + ' ' + data.currency : '-' }}</span> <br />
                        </template>

                        <template #filter="{ filterModel }">
                            <div class="flex">
                                <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by amount" />
                            </div>
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

                        <template #filter="{ filterModel }">
                            <div class="flex">
                                <Dropdown
                                    v-model="filterModel.value"
                                    :options="[
                                        { label: $t('transaction.income'), value: 'income' },
                                        { label: $t('transaction.expense'), value: 'expense' },
                                        { label: $t('transaction.transfer'), value: 'transfer' },
                                    ]"
                                    optionLabel="label"
                                    optionValue="value"
                                    class="p-column-filter"
                                    placeholder="Search by type"
                                />
                            </div>
                        </template>
                    </Column>

                    <Column field="account" :header="$t('transaction.account')">
                        <template #body="{ data }">
                            {{ data.account ? data.account?.name : '-' }}
                        </template>

                        <template #filter="{ filterModel }">
                            <div class="flex">
                                <InputText
                                    v-model="filterModel.value"
                                    type="text"
                                    class="p-column-filter"
                                    placeholder="Search by account"
                                />
                            </div>
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
import { FilterMatchMode, FilterOperator } from 'primevue/api'
export default {
    name: 'TransactionsPage',
    mixins: [TransactionsMixin],

    created() {
        this.getTransactions()
        this.initFilters()
    },

    data() {
        return {
            filters: null,
        }
    },

    methods: {
        viewTransactionNavigation(rowData) {
            this.$router.push(`/transactions/${rowData.data.id}`)
        },

        initFilters() {
            this.filters = {
                name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                date: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                amount: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                account: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                type: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
            }
        },
    },
}
</script>

<style></style>
