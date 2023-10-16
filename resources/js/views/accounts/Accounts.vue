<template>
    <user-layout>
        <div id="accounts_page">
            <user-header :title="$t('account.account', 2)">
                <template #actions>
                    <HeaderActionButton :label="$t('account.new_account')" icon="fa fa-plus" to="/accounts/new" />
                    <Button
                        v-if="$settings.open_banking_available"
                        :label="$t('account.connect_bank')"
                        icon="fa fa-university"
                        @click="connectBankDialog = true"
                    />
                </template>
            </user-header>

            <div id="accounts_table" class="card">
                <DataTable
                    v-model:filters="filters"
                    :value="accounts"
                    :loading="loadingData"
                    paginator
                    :rows="10"
                    data-key="id"
                    filter-display="menu"
                    paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    :rows-per-page-options="[10, 20, 50]"
                    column-resize-mode="expand"
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

                    <Column field="is_active" :header="$t('form.active')">
                        <template #body="{ data }">
                            <Tag v-if="data.is_active" :value="$t('basic.yes')" severity="success" />
                            <Tag v-else :value="$t('basic.no')" severity="danger" />
                        </template>
                    </Column>

                    <Column field="type" :header="$t('form.account_type')">
                        <template #body="{ data }">
                            <Tag v-if="data.type === 'bank_account'" :value="$t('account_types.bank_account')"></Tag>
                            <Tag v-if="data.type === 'cash'" :value="$t('account_types.cash')"></Tag>
                            <Tag v-if="data.type === 'online_account'" :value="$t('account_types.online_account')"></Tag>
                        </template>

                        <template #filter="{ filterModel }">
                            <div class="flex">
                                <Dropdown
                                    v-model="filterModel.value"
                                    :options="[
                                        { label: $t('account_types.bank_account'), value: 'bank_account' },
                                        { label: $t('account_types.cash'), value: 'cash' },
                                        { label: $t('account_types.online_account'), value: 'online_account' },
                                    ]"
                                    option-label="label"
                                    option-value="value"
                                    class="p-column-filter"
                                    placeholder="Select type"
                                />
                            </div>
                        </template>
                    </Column>
                    <Column field="current_balance" :header="$t('form.balance')">
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
                    <Column field="bank_name" :header="$t('form.bank_name')">
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
            <!-- Dialog connect bank account -->
            <Dialog v-model="connectBankDialog" :header="$t('account.connect_bank')" :visible="connectBankDialog" width="500px">
                <div class="p-fluid">
                    <LoadingScreen :blocked="loadingData">
                        <div class="p-field">
                            <label for="country">{{ $t('form.country') }}</label>
                            <Dropdown
                                v-model="selected_country"
                                :options="available_countries"
                                option-label="name"
                                option-value="code"
                                placeholder="Select country"
                                @change="getBanks()"
                            />
                            <div v-if="selected_country" class="p-field">
                                <label for="bank">{{ $t('form.bank') }}</label>
                                <Dropdown
                                    v-model="selected_bank"
                                    :options="available_banks"
                                    option-label="name"
                                    option-value="id"
                                    placeholder="Select bank"
                                >
                                    <template #option="slotProps">
                                        <div class="flex align-content-center flex-wrap">
                                            <Avatar :image="slotProps.option.logo" size="large" />
                                            <span class="flex ml-2">{{ slotProps.option.name }}</span>
                                        </div>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>
                    </LoadingScreen>
                </div>
                <template #footer>
                    <div class="">
                        <Button :label="$t('basic.cancel')" severity="error" icon="fa fa-times" @click="connectBankDialog = false" />
                        <Button :label="$t('account.connect_bank')" icon="fa fa-university" @click="initSession()" />
                    </div>
                </template>
            </Dialog>
        </div>
    </user-layout>
</template>
<script>
import { FilterMatchMode, FilterOperator } from 'primevue/api'
import AccountsMixin from '@/mixins/accounts'
import open_banking_countries from '@/data/open_banking_countries.json'
export default {
    name: 'AccountsPage',
    mixins: [AccountsMixin],
    data() {
        return {
            filters: null,
            connectBankDialog: false,
            available_countries: open_banking_countries,
            selected_country: null,
            selected_bank: null,
            available_banks: [],
        }
    },
    created() {
        if (this.$route.query.ref) {
            this.getRequisitions(this.$route.query.ref)
        }

        this.getAccounts()
        this.initFilters()
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

        /**
         * Function that gets banks from selected country
         */
        getBanks() {
            this.makeHttpRequest('GET', '/api/open_banking/banks', null, { country: this.selected_country }).then((response) => {
                this.available_banks = response.data.data
            })
        },

        /**
         * Function that get redirect url for bank
         */
        initSession() {
            this.makeHttpRequest('POST', '/api/open_banking/init_session', { institution_id: this.selected_bank }).then((response) => {
                window.location.href = response.data.data.link
            })
        },

        /**
         * Function that gets requisitions
         */
        getRequisitions(id) {
            if (this.$route.query.error) {
                this.showToast(this.$route.query.error, this.$route.query.details, 'error')
                return this.$router.push('/accounts')
            }
            this.makeHttpRequest('POST', '/api/open_banking/get_requisition', { requisition_id: id })
                .then((response) => {
                    this.showToast(response.data.message)
                })
                .catch((error) => {
                    this.showToast(error.response.data.message, 'error')
                })
            this.$router.push('/accounts')
        },
    },
}
</script>

<style></style>
