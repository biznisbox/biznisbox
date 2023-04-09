<template>
    <user-layout>
        <div id="accounts_page">
            <user-header :title="$t('account.account', 2)">
                <template #actions>
                    <HeaderActionButton :label="$t('account.new_account')" icon="fa fa-plus" to="/accounts/new" />
                </template>
            </user-header>

            <div id="accounts_table" class="card">
                <DataTable
                    :value="accounts"
                    v-model:filters="filters"
                    :loading="loadingData"
                    paginator
                    :rows="10"
                    data-key="id"
                    filterDisplay="menu"
                    paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    :rows-per-page-options="[10, 20, 50]"
                    column-resize-mode="expand"
                    :globalFilterFields="['name', 'account_number']"
                    @row-dblclick="viewAccountNavigation"
                >
                    <template #empty>
                        <div class="p-4 pl-0 text-center w-full text-gray-500">
                            <i class="fa fa-info-circle empty-icon"></i>
                            <p>{{ $t('account.no_accounts') }}</p>
                            <Button
                                class="mt-3"
                                :label="$t('account.create_first_account')"
                                icon="fa fa-plus"
                                @click="$router.push('/accounts/new')"
                            />
                        </div>
                    </template>

                    <Column field="name" :header="$t('account.name_and_number')">
                        <template #body="{ data }">
                            {{ formatText(data.name) }} <br />
                            {{ formatText(data.account_number) }}
                        </template>

                        <template #filter="{ filterModel }">
                            <div class="flex">
                                <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by name" />
                            </div>
                        </template>
                    </Column>
                    <Column field="type" :header="$t('account.account_type')">
                        <template #body="{ data }">
                            <Tag v-if="data.type === 'bank_account'" :value="$t('account.bank_account')"></Tag>
                            <Tag v-if="data.type === 'cash'" :value="$t('account.cash')"></Tag>
                            <Tag v-if="data.type === 'credit_card'" :value="$t('account.credit_card')"></Tag>
                            <Tag v-if="data.type === 'online_account'" :value="$t('account.online_account')"></Tag>
                        </template>

                        <template #filter="{ filterModel }">
                            <div class="flex">
                                <Dropdown
                                    v-model="filterModel.value"
                                    :options="[
                                        { label: $t('account.bank_account'), value: 'bank_account' },
                                        { label: $t('account.cash'), value: 'cash' },
                                        { label: $t('account.credit_card'), value: 'credit_card' },
                                        { label: $t('account.online_account'), value: 'online_account' },
                                    ]"
                                    optionLabel="label"
                                    optionValue="value"
                                    class="p-column-filter"
                                    placeholder="Select type"
                                />
                            </div>
                        </template>
                    </Column>
                    <Column field="current_balance" :header="$t('account.balance')">
                        <template #body="{ data }">
                            <span>{{ formatMoney(data.current_balance, data.currency) }}</span>
                        </template>

                        <template #filter="{ filterModel }">
                            <div class="flex">
                                <InputText
                                    v-model="filterModel.value"
                                    type="text"
                                    class="p-column-filter"
                                    placeholder="Search by balance"
                                />
                            </div>
                        </template>
                    </Column>
                    <Column field="bank_name" :header="$t('account.bank_name')">
                        <template #body="{ data }">
                            <span>{{ formatText(data.bank_name) }}</span>
                        </template>

                        <template #filter="{ filterModel }">
                            <div class="flex">
                                <InputText
                                    v-model="filterModel.value"
                                    type="text"
                                    class="p-column-filter"
                                    placeholder="Search by bank name"
                                />
                            </div>
                        </template>
                    </Column>
                    <template #paginatorstart>
                        <div class="p-d-flex p-ai-center p-mr-2">
                            <Button class="p-button-rounded p-button-text p-button-plain" icon="fa fa-sync" @click="getAccounts()" />
                        </div>
                    </template>
                </DataTable>
            </div>
        </div>
    </user-layout>
</template>

<script>
import { FilterMatchMode, FilterOperator } from 'primevue/api'
import AccountsMixin from '@/mixins/accounts'
export default {
    name: 'AccountsPage',
    mixins: [AccountsMixin],

    created() {
        this.getAccounts()
        this.initFilters()
    },

    data() {
        return {
            filters: null,
        }
    },

    methods: {
        /**
         * Function that redirects to account view page
         * @param {string} id
         */
        viewAccountNavigation(event) {
            this.$router.push(`/accounts/${event.data.id}`)
        },

        initFilters() {
            this.filters = {
                name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                account_number: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                type: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
                current_balance: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                bank_name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
            }
        },
    },
}
</script>

<style></style>
