<template>
    <user-layout>
        <div id="new_transaction_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('transaction.new_transaction')" />

                <div class="card">
                    <form class="formgrid">
                        <div class="grid">
                            <TextInput id="name_input" v-model="transaction.name" :label="$t('transaction.name')" class="col-12" />
                        </div>
                        <div class="grid">
                            <TextInput
                                id="number_input"
                                v-model="transaction.number"
                                :label="$t('transaction.number')"
                                class="col-12 md:col-6"
                            />
                            <SelectButtonInput
                                id="type_input"
                                v-model="transaction.type"
                                class="col-12 md:col-6"
                                :label="$t('transaction.type')"
                                :options="[
                                    { label: $t('transaction.income'), value: 'income' },
                                    { label: $t('transaction.expense'), value: 'expense' },
                                    { label: $t('transaction.transfer'), value: 'transfer' },
                                ]"
                            />
                        </div>

                        <div class="grid">
                            <NumberInput
                                id="amount_input"
                                v-model="transaction.amount"
                                type="currency"
                                :currency="transaction.currency"
                                :label="$t('transaction.amount')"
                                class="col-12 md:col-6"
                            />

                            <DateInput id="date_input" v-model="transaction.date" :label="$t('transaction.date')" class="col-12 md:col-6" />
                        </div>

                        <div v-if="transaction.type != 'transfer'" class="grid">
                            <SelectInput
                                id="account_input"
                                v-model="transaction.account_id"
                                :label="$t('transaction.account')"
                                :options="accounts"
                                class="col-12"
                                option-label="name"
                                option-value="id"
                                :filter="true"
                            />
                        </div>

                        <div v-if="transaction.type == 'transfer'" class="grid">
                            <SelectInput
                                id="from_account_input"
                                v-model="transaction.from_account"
                                :label="$t('transaction.from_account')"
                                :options="accounts"
                                class="col-12 md:col-6"
                                option-label="name"
                                option-value="id"
                                :filter="true"
                            />
                            <SelectInput
                                id="to_account_input"
                                v-model="transaction.to_account"
                                :label="$t('transaction.to_account')"
                                :options="accounts"
                                class="col-12 md:col-6"
                                option-label="name"
                                option-value="id"
                                :filter="true"
                            />
                        </div>

                        <div class="grid">
                            <TextAreaInput
                                id="description_input"
                                v-model="transaction.description"
                                :label="$t('transaction.description')"
                                class="col-12"
                            />
                        </div>

                        <div v-if="transaction.type == 'income'" class="grid">
                            <SelectInput
                                id="category_input"
                                v-model="transaction.category"
                                editable
                                :label="$t('transaction.category')"
                                class="col-12 md:col-6"
                            />

                            <SelectInput
                                id="customer_input"
                                v-model="transaction.customer_id"
                                :label="$t('transaction.customer')"
                                class="col-12 md:col-6"
                                :options="customers"
                                option-label="name"
                                option-value="id"
                                :filter="true"
                            />
                        </div>

                        <div v-if="transaction.type == 'expense'" class="grid">
                            <SelectInput
                                id="category_input"
                                v-model="transaction.category"
                                editable
                                :label="$t('transaction.category')"
                                class="col-12 md:col-6"
                            />

                            <SelectInput
                                id="vendor_input"
                                v-model="transaction.vendor_id"
                                :label="$t('transaction.vendor')"
                                class="col-12 md:col-6"
                                :options="vendors"
                                option-label="name"
                                option-value="id"
                                :filter="true"
                            />
                        </div>

                        <div class="grid">
                            <TextInput
                                id="reference_input"
                                v-model="transaction.reference"
                                class="col-12"
                                :label="$t('transaction.reference')"
                            />
                        </div>
                    </form>

                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button :label="$t('basic.cancel')" icon="fa fa-times" class="p-button-danger" @click="goTo('/transactions')" />
                        <Button
                            :label="$t('basic.save')"
                            :disabled="loadingData"
                            icon="fa fa-floppy-disk"
                            class="p-button-success"
                            @click="saveTransaction"
                        />
                    </div>
                </div>
            </LoadingScreen>
        </div>
    </user-layout>
</template>

<script>
import TransactionsMixin from '@/mixins/transactions'
export default {
    name: 'NewTransactionPage',
    mixins: [TransactionsMixin],
    created() {
        this.getAccounts()
        this.getCustomers()
        this.getTransactionNumber()
        this.getVendors()
        this.transaction.currency = this.$settings.default_currency
    },
}
</script>

<style></style>
