<template>
    <user-layout>
        <div id="open_banking_view_feed_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="account?.internal_data.name">
                    <template #actions>
                        <Button
                            :disabled="!account"
                            :label="$t('open_banking.edit_account')"
                            icon="fa fa-pen"
                            @click="openEditAccountModal"
                        />
                    </template>
                </user-header>
                <div class="card">
                    <div id="balance" class="my-5">
                        <div class="text-gray-500 text-sm">{{ $t('open_banking.balance') }}</div>
                        <div class="flex flex-col items-center">
                            <div class="text-2xl font-bold">{{ account?.balance[0]?.balanceAmount.amount }}</div>
                            <div class="text-sm text-gray-500">{{ account?.balance[0]?.balanceAmount.currency }}</div>
                        </div>
                    </div>

                    <div id="feed_table">
                        <DataTable :value="account?.transactions.booked" paginator :rows="25">
                            <template #empty>
                                <div class="p-4 pl-0 text-center text-gray-500">
                                    {{ $t('open_banking.no_transactions') }}
                                </div>
                            </template>
                            <Column field="remittanceInformationUnstructured" :header="$t('open_banking.description')" sortable />
                            <Column field="transactionAmount.amount" :header="$t('open_banking.amount')" sortable>
                                <template #body="slotProps">
                                    <span
                                        :class="{
                                            'text-green-500': slotProps.data.transactionAmount.amount > 0,
                                            'text-red-500': slotProps.data.transactionAmount.amount < 0,
                                        }"
                                    >
                                        {{ slotProps.data.transactionAmount.amount }} {{ slotProps.data.transactionAmount.currency }}
                                    </span>
                                </template>
                            </Column>
                            <Column field="bookingDate" :header="$t('open_banking.date')" sortable>
                                <template #body="{ data }">
                                    {{ formatDate(data.bookingDate) }}
                                </template>
                            </Column>
                        </DataTable>
                    </div>
                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button :label="$t('basic.cancel')" icon="fa fa-times" class="p-button-danger" @click="goTo('/open_banking')" />
                    </div>
                </div>
            </LoadingScreen>

            <Dialog v-model:visible="showEditAccountDialog" header="Edit account" modal>
                <form class="formgrid">
                    <div class="grid">
                        <TextInput id="account_name_input" v-model="account.internal_data.name" class="field col-12" label="Account name" />
                    </div>

                    <div class="grid">
                        <SelectInput
                            id="account_connection_input"
                            v-model="account.internal_data.connected_account_id"
                            :options="app_accounts"
                            class="field col-12"
                            label="Connected app account"
                            option-value="id"
                            option-label="name"
                            show-clear
                        />
                    </div>
                </form>

                <template #footer>
                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button
                            :label="$t('basic.cancel')"
                            icon="fa fa-times"
                            class="p-button-danger"
                            @click="showEditAccountDialog = false"
                        />
                        <Button
                            :label="$t('basic.save')"
                            :disabled="loadingData"
                            icon="fa fa-floppy-disk"
                            class="p-button-success"
                            @click="updateAccount($route.params.id)"
                        />
                    </div>
                </template>
            </Dialog>
        </div>
    </user-layout>
</template>

<script>
import OpenBankingMixin from '@/mixins/open_banking'
export default {
    name: 'OpenBankingViewFeed',
    mixins: [OpenBankingMixin],
    data() {
        return {
            showEditAccountDialog: false,
        }
    },
    created() {
        this.getAppAccounts()
        this.getAccount(this.$route.params.id)
    },

    methods: {
        openEditAccountModal() {
            this.showEditAccountDialog = true
        },
    },
}
</script>

<style></style>
