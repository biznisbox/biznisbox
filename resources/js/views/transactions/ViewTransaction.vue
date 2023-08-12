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
                    <DisplayData :input="$t('transaction.amount')" :value="transaction.amount + ' ' + transaction.currency" />
                    <DisplayData :input="$t('transaction.date')" :value="formatDate(transaction.date)" />
                    <DisplayData :input="$t('transaction.type')" custom-value>
                        <Tag v-if="transaction.type === 'income'" :value="$t('transaction.income')" class="p-tag-success" />
                        <Tag v-if="transaction.type === 'expense'" :value="$t('transaction.expense')" class="p-tag-danger" />
                        <Tag v-if="transaction.type === 'transfer'" :value="$t('transaction.transfer')" class="p-tag-info" />
                    </DisplayData>
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
