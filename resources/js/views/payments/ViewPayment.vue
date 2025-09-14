<template>
    <DefaultLayout>
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="payment.number">
                <template #actions>
                    <Button :label="$t('audit_log.audit_log')" icon="fa fa-history" severity="info" @click="showAuditLogDialog = true" />
                </template>
            </PageHeader>

            <div class="card">
                <DisplayData :input="$t('form.number')" :value="payment.number" />
                <DisplayData :input="$t('form.payment_method')" customValue>
                    <span style="font-size: 25px">
                        <i v-if="payment.payment_method === 'cash'" class="fa fa-money-bill"></i>
                        <i v-else-if="payment.payment_method === 'bank_card'" class="fa fa-credit-card"></i>
                        <i v-else-if="payment.payment_method === 'bank_transfer'" class="fa fa-university"></i>
                        <i v-else-if="payment.payment_method === 'stripe'" class="fab fa-stripe"></i>
                        <i v-else-if="payment.payment_method === 'paypal'" class="fab fa-paypal"></i>
                        <i v-else-if="payment.payment_method === 'coinbase'" class="fab fa-bitcoin"></i>
                        <i v-else-if="payment.payment_method === 'check'" class="fa fa-check"></i>
                        <div v-else>
                            <i class="fa fa-money-bill-wave"></i>
                            {{ payment.payment_method }}
                        </div>
                    </span>
                </DisplayData>

                <DisplayData :input="$t('form.amount')" :value="formatMoney(payment.amount, payment.currency)" />

                <DisplayData :input="$t('form.status')" customValue>
                    <Tag v-if="payment.status === 'pending'" :value="$t('status.pending')" severity="info" />
                    <Tag v-else-if="payment.status === 'paid'" :value="$t('status.paid')" severity="success" />
                    <Tag v-else-if="payment.status === 'failed'" :value="$t('status.failed')" severity="danger" />
                    <Tag v-else-if="payment.status === 'canceled'" :value="$t('status.canceled')" severity="info" />
                    <Tag v-else-if="payment.status === 'refunded'" :value="$t('status.refunded')" severity="secondary" />
                    <Tag v-else :value="$t(`status.${payment.status}`)" />
                </DisplayData>
            </div>

            <div id="function_buttons" class="flex justify-end mt-4 gap-2">
                <Button id="cancel_button" :label="$t('basic.close')" icon="fa fa-times" severity="secondary" @click="goTo('/payments')" />
            </div>
        </LoadingScreen>

        <Dialog
            v-model:visible="showAuditLogDialog"
            modal
            maximizable
            class="w-full m-2 lg:w-1/2"
            :header="$t('audit_log.audit_log')"
            :draggable="false"
        >
            <AuditLog :item_id="$route.params.id" item_type="Payment" />
        </Dialog>
    </DefaultLayout>
</template>

<script>
export default {
    name: 'ViewPaymentPage',
    data() {
        return {
            payment: {
                number: '',
                payment_method: '',
                amount: '',
                currency: '',
                status: '',
            },
            showAuditLogDialog: false,
        }
    },
    methods: {
        getPayment() {
            this.makeHttpRequest('GET', `/api/payments/${this.$route.params.id}`).then((response) => {
                this.payment = response.data.data
            })
        },
    },

    created() {
        this.getPayment()
    },
}
</script>
