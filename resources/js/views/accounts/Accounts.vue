<template>
    <DefaultLayout>
        <PageHeader :title="$t('account.account', 3)">
            <template #actions>
                <Button :label="$t('account.new_account')" icon="fa fa-plus" @click="$router.push('/accounts/create')" />
                <Button
                    v-if="$settings.open_banking_available"
                    :label="$t('account.connect_bank')"
                    icon="fa fa-university"
                    @click="connectBankDialog = true"
                />
            </template>
        </PageHeader>

        <div id="accounts_table" class="card">
            <DataTable
                :value="accounts"
                paginator
                dataKey="id"
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50, 100]"
                :loading="loadingData"
                @row-dblclick="viewAccountNavigation"
                filter-display="menu"
                v-model:filters="filters"
            >
                <template #empty>
                    <div class="p-4 pl-0 text-center w-full">
                        <i class="fa fa-info-circle empty-icon"></i>
                        <p>{{ $t('account.no_accounts') }}</p>
                        <Button
                            class="mt-3"
                            :label="$t('account.create_first_account')"
                            icon="fa fa-plus"
                            @click="$router.push('/accounts/create')"
                        />
                    </div>
                </template>
                <Column field="name" :header="$t('account.name_and_number')">
                    <template #body="{ data }">
                        {{ formatText(data.name) }} <br />
                        {{ formatText(data.account_number) }}
                    </template>

                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" type="text" placeholder="Search by name" />
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
                        <Select
                            v-model="filterModel.value"
                            :options="[
                                { label: $t('account_types.bank_account'), value: 'bank_account' },
                                { label: $t('account_types.cash'), value: 'cash' },
                                { label: $t('account_types.online_account'), value: 'online_account' },
                            ]"
                            option-label="label"
                            option-value="value"
                            placeholder="Select type"
                        />
                    </template>
                </Column>
                <Column field="current_balance" :header="$t('form.balance')">
                    <template #body="{ data }">
                        <span :class="data.current_balance < 0 ? 'text-red-500' : 'text-green-500'">
                            {{ formatMoney(data.current_balance, data.currency) }}
                        </span>
                    </template>
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" type="text" placeholder="Search by balance" />
                    </template>
                </Column>
                <Column field="bank_name" :header="$t('form.bank_name')">
                    <template #body="{ data }">
                        <span>{{ formatText(data.bank_name) }}</span>
                    </template>
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" type="text" placeholder="Search by bank name" />
                    </template>
                </Column>
                <template #paginatorstart>
                    <Button icon="fa fa-sync" @click="getAccounts" />
                </template>
            </DataTable>
        </div>

        <!-- Dialog connect bank account -->
        <Dialog v-model:visible="connectBankDialog" :header="$t('account.connect_bank')" :visible="connectBankDialog" modal>
            <div>
                <LoadingScreen :blocked="loadingData">
                    <SelectInput
                        v-model="selected_country"
                        :options="available_countries"
                        option-label="name"
                        option-value="code"
                        placeholder="Select country"
                        label="Country"
                    />

                    <div v-if="selected_country">
                        <div class="flex flex-col gap-2 mb-2">
                            <label class="dark:text-surface-200">{{ $t('form.bank') }}</label>
                            <Select
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
                            </Select>
                        </div>
                    </div>
                </LoadingScreen>
            </div>
            <template #footer>
                <div class="flex justify-end gap-2">
                    <Button :label="$t('basic.cancel')" severity="secondary" icon="fa fa-times" @click="connectBankDialog = false" />
                    <Button :label="$t('account.connect_bank')" icon="fa fa-university" @click="initSession" :disabled="!selected_bank" />
                </div>
            </template>
        </Dialog>
    </DefaultLayout>
</template>
<script>
import { FilterMatchMode, FilterOperator } from '@primevue/core/api'
import AccountsMixin from '@/mixins/accounts'
export default {
    name: 'AccountsPage',
    mixins: [AccountsMixin],
    data() {
        return {
            filters: null,
            connectBankDialog: false,
            selected_country: null,
            selected_bank: null,
            available_banks: [],
            available_countries: [],
        }
    },
    created() {
        if (this.$route.query.ref) {
            this.getRequisitions(this.$route.query.ref)
        }
        this.getAccounts()
        this.initFilters()
        this.getAvailableCountries()
    },

    watch: {
        selected_country() {
            this.getBanks()
        },
    },

    methods: {
        /**
         * Function that redirects to account view page
         * @param {string} id
         */
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
            this.makeHttpRequest('GET', '/api/open-banking/banks', null, { country: this.selected_country }).then((response) => {
                this.available_banks = response.data.data
            })
        },

        /**
         * Function that gets available countries for open banking
         */
        getAvailableCountries() {
            this.makeHttpRequest('GET', '/api/open-banking/countries').then((response) => {
                this.available_countries = response.data.data
            })
        },

        /**
         * Function that get redirect url for bank
         */
        initSession() {
            this.makeHttpRequest('POST', '/api/open-banking/session', { institution_id: this.selected_bank }).then((response) => {
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
            this.makeHttpRequest('POST', '/api/open-banking/account', { requisition_id: id }).then((response) => {
                this.showToast(response.data.message)
            })
            this.$router.push('/accounts')
        },
    },
}
</script>

<style></style>
