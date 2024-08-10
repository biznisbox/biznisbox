<template>
    <DefaultLayout>
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="$t('transaction.transaction') + ' ' + transaction.number">
                <template #actions>
                    <Button
                        :label="$t('basic.edit')"
                        icon="fa fa-edit"
                        @click="$router.push({ name: 'transaction-edit', params: { id: $route.params.id } })"
                        severity="success"
                    />
                    <Button
                        :label="$t('basic.delete')"
                        icon="fa fa-trash"
                        severity="danger"
                        @click="deleteTransactionAsk($route.params.id)"
                    />
                    <Button :label="$t('audit_log.audit_log')" icon="fa fa-history" severity="info" @click="showAuditLogDialog = true" />
                </template>
            </PageHeader>

            <div class="card">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <DisplayData :input="$t('form.number')" :value="transaction.number" />
                    <DisplayData :input="$t('transaction.name')" :value="transaction.name" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <DisplayData :input="$t('form.amount')" :value="formatMoney(transaction.amount, transaction.currency)" />
                    <div v-if="transaction.exchange_rate && transaction.exchange_rate != 1">
                        <DisplayData
                            :input="$t('form.exchange_rate')"
                            :value="formatMoney(transaction.exchange_rate, transaction.currency)"
                        />
                    </div>
                </div>
                <DisplayData :input="$t('form.description')" :value="transaction.description" />
                <DisplayData :input="$t('form.date')" :value="formatDate(transaction.date)" />
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <DisplayData :input="$t('form.type')" custom-value>
                        <Tag v-if="transaction.type === 'income'" :value="$t('transaction_type.income')" severity="success" />
                        <Tag v-if="transaction.type === 'expense'" :value="$t('transaction_type.expense')" severity="danger" />
                        <Tag v-if="transaction.type === 'transfer'" :value="$t('transaction_type.transfer')" severity="info" />
                    </DisplayData>
                    <DisplayData v-if="transaction.status" :input="$t('form.status')" custom-value>
                        <Tag v-if="transaction.status === 'pending'" :value="$t('status.pending')" severity="warning" />
                        <Tag v-if="transaction.status === 'completed'" :value="$t('status.completed')" severity="success" />
                        <Tag v-if="transaction.status === 'cancelled'" :value="$t('status.cancelled')" severity="danger" />
                    </DisplayData>
                </div>
                <DisplayData v-if="transaction.category" :input="$t('form.category')" :value="transaction.category?.label" />
                <DisplayData v-if="transaction.account_id != null" :input="$t('form.account')" :value="transaction.account?.name" />
                <DisplayData v-if="transaction.reference" :input="$t('form.reference')" :value="transaction.reference" />
            </div>
            <div id="function_buttons" class="flex justify-end mt-4 gap-2">
                <Button
                    id="cancel_button"
                    :label="$t('basic.close')"
                    icon="fa fa-times"
                    severity="secondary"
                    @click="goTo('/transactions')"
                />
            </div>
        </LoadingScreen>

        <!-- Audit Log Dialog -->
        <Dialog
            v-model:visible="showAuditLogDialog"
            modal
            maximizable
            class="w-full m-2 lg:w-1/2"
            :header="$t('audit_log.audit_log')"
            :draggable="false"
        >
            <AuditLog :item_id="$route.params.id" item_type="Transaction" />
        </Dialog>
    </DefaultLayout>
</template>

<script>
import TransactionsMixin from '@/mixins/transactions'
export default {
    name: 'ViewTransactionPage',
    mixins: [TransactionsMixin],

    created() {
        this.getTransaction(this.$route.params.id)
    },

    data() {
        return {
            showAuditLogDialog: false,
        }
    },

    methods: {
        editTransactionNavigation() {
            this.$router.push({ name: 'edit-transaction', params: { id: this.$route.params.id } })
        },
    },
}
</script>

<style></style>
