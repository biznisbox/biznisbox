<template>
    <user-layout>
        <div id="view_transaction_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('transaction.transaction') + ' ' + transaction.number">
                    <template #actions>
                        <Button :label="$t('basic.edit')" icon="fa fa-edit" class="p-button-success" @click="editTransactionNavigation" />
                        <Button
                            :label="$t('basic.delete')"
                            icon="fa fa-trash"
                            class="p-button-danger"
                            @click="deleteTransactionAsk($route.params.id)"
                        />
                    </template>
                </user-header>

                <div class="card">
                    <div class="grid">
                        <div class="col-12 md:col-6">
                            <DisplayData :input="$t('form.number')" :value="transaction.number" />
                        </div>
                        <div class="col-12 md:col-6">
                            <DisplayData :input="$t('transaction.name')" :value="transaction.name" />
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-12 md:col-6">
                            <DisplayData :input="$t('form.amount')" :value="formatMoney(transaction.amount, transaction.currency)" />
                        </div>
                        <div class="col-12 md:col-6" v-if="transaction.exchange_rate && transaction.exchange_rate != 1">
                            <DisplayData
                                :input="$t('form.exchange_rate')"
                                :value="formatMoney(transaction.exchange_rate, transaction.currency)"
                            />
                        </div>
                    </div>
                    <DisplayData :input="$t('form.description')" :value="transaction.description" />
                    <DisplayData :input="$t('form.date')" :value="formatDate(transaction.date)" />
                    <div class="grid">
                        <div class="col-12 md:col-6">
                            <DisplayData :input="$t('form.type')" custom-value>
                                <Tag v-if="transaction.type === 'income'" :value="$t('transaction_type.income')" class="p-tag-success" />
                                <Tag v-if="transaction.type === 'expense'" :value="$t('transaction_type.expense')" class="p-tag-danger" />
                                <Tag v-if="transaction.type === 'transfer'" :value="$t('transaction_type.transfer')" class="p-tag-info" />
                            </DisplayData>
                        </div>
                        <div class="col-12 md:col-6">
                            <DisplayData :input="$t('form.status')" custom-value v-if="transaction.status">
                                <Tag v-if="transaction.status === 'pending'" :value="$t('status.pending')" class="p-tag-warning" />
                                <Tag v-if="transaction.status === 'completed'" :value="$t('status.completed')" class="p-tag-success" />
                                <Tag v-if="transaction.status === 'cancelled'" :value="$t('status.cancelled')" class="p-tag-danger" />
                            </DisplayData>
                        </div>
                    </div>
                    <DisplayData :input="$t('form.category')" :value="transaction.category?.label" v-if="transaction.category" />
                    <DisplayData :input="$t('form.account')" :value="transaction.account?.name" />
                    <DisplayData :input="$t('form.reference')" :value="transaction.reference" v-if="transaction.reference" />

                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button :label="$t('basic.close')" icon="fa fa-times" class="p-button-danger" @click="goTo('/transactions')" />
                    </div>
                </div>
            </LoadingScreen>
        </div>
    </user-layout>
</template>

<script>
import TransactionsMixin from '@/mixins/transactions'
export default {
    name: 'ViewTransactionPage',
    mixins: [TransactionsMixin],

    created() {
        this.getTransaction(this.$route.params.id)
    },

    methods: {
        editTransactionNavigation() {
            this.$router.push({ name: 'edit-transaction', params: { id: this.$route.params.id } })
        },
    },
}
</script>

<style></style>
