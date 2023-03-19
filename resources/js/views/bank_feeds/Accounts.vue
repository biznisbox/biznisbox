<template>
    <user-layout>
        <div id="open_banking_accounts_page">
            <user-header :title="$t('open_banking.account', 2)">
                <template #actions>
                    <HeaderActionButton :label="$t('open_banking.connect_new_account')" icon="fa fa-plus" to="/open_banking/add" />
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
                    @row-dblclick="viewOpenBankingNavigation"
                >
                    <template #empty>
                        <div class="p-4 pl-0 text-center w-full text-gray-500">
                            <i class="fa fa-info-circle empty-icon"></i>
                            <p>{{ $t('open_banking.no_bank_accounts') }}</p>
                            <Button
                                class="mt-3"
                                :label="$t('open_banking.connect_first_account')"
                                icon="fa fa-plus"
                                @click="$router.push('/open_banking/add')"
                            />
                        </div>
                    </template>

                    <Column field="name" :header="$t('open_banking.name')">
                        <template #body="{ data }">
                            <Avatar v-if="data.bank_logo != null" :image="data.bank_logo" :name="data.name" />
                            <span class="ml-2">{{ data.name }}</span>
                        </template>
                    </Column>
                    <Column field="bank_name" :header="$t('open_banking.bank_name')" sortable />
                    <Column field="account_iban" :header="$t('open_banking.iban')" sortable />
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
import OpenBankingMixin from '@/mixins/open_banking'
export default {
    name: 'OpenBankingAccounts',
    mixins: [OpenBankingMixin],

    created() {
        this.getAccounts()
    },

    methods: {
        viewOpenBankingNavigation(event) {
            this.$router.push(`/open_banking/view/${event.data.id}`)
        },
    },
}
</script>

<style></style>
