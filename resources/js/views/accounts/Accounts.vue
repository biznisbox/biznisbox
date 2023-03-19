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
                    :loading="loadingData"
                    paginator
                    :rows="10"
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
                        <template #body="slotProps">
                            <span class="account_name">{{ slotProps.data.name }}</span
                            ><i v-if="slotProps.data.is_default" class="ml-2 fa fa-lock"></i><br />
                            <span class="account_number">{{ slotProps.data.account_number }}</span>
                        </template>
                    </Column>
                    <Column field="type" :header="$t('account.account_type')">
                        <template #body="{ data }">
                            <Tag v-if="data.type === 'bank_account'" :value="$t('account.bank_account')"></Tag>
                            <Tag v-if="data.type === 'cash'" :value="$t('account.cash')"></Tag>
                            <Tag v-if="data.type === 'credit_card'" :value="$t('account.credit_card')"></Tag>
                            <Tag v-if="data.type === 'online_account'" :value="$t('account.online_account')"></Tag>
                        </template>
                    </Column>
                    <Column field="current_balance" :header="$t('account.balance')"></Column>
                    <Column field="bank_name" :header="$t('account.bank_name')">
                        <template #body="slotProps">
                            <span v-if="slotProps.data.bank_name">{{ slotProps.data.bank_name }}</span>
                            <span v-else>-</span>
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
import AccountsMixin from '@/mixins/accounts'
export default {
    name: 'AccountsPage',
    mixins: [AccountsMixin],

    created() {
        this.getAccounts()
    },

    methods: {
        /**
         * Function that redirects to account view page
         * @param {string} id
         */
        viewAccountNavigation(event) {
            this.$router.push(`/accounts/${event.data.id}`)
        },
    },
}
</script>

<style></style>
