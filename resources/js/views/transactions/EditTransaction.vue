<template>
    <DefaultLayout>
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="$t('transaction.edit_transaction')" />

            <div class="card">
                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <TextInput
                            id="number_input"
                            v-model="v$.transaction.number.$model"
                            :label="$t('form.number')"
                            disabled
                            :validate="v$.transaction.number"
                        />
                        <SelectButtonInput
                            id="type_input"
                            v-model="v$.transaction.type.$model"
                            :label="$t('form.type')"
                            :options="[
                                { label: $t('transaction_type.income'), value: 'income' },
                                { label: $t('transaction_type.expense'), value: 'expense' },
                                { label: $t('transaction_type.transfer'), value: 'transfer' },
                            ]"
                            :validate="v$.transaction.type"
                        />
                    </div>
                    <TextInput
                        id="name_input"
                        v-model="v$.transaction.name.$model"
                        :label="$t('form.name')"
                        :validate="v$.transaction.name"
                    />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <NumberInput
                            id="amount_input"
                            v-model="v$.transaction.amount.$model"
                            type="currency"
                            :currency="transaction.currency"
                            :label="$t('form.amount')"
                            :validate="v$.transaction.amount"
                        />

                        <DateInput
                            id="date_input"
                            v-model="v$.transaction.date.$model"
                            :label="$t('form.date')"
                            :validate="v$.transaction.date"
                        />
                    </div>

                    <div v-if="transaction.type != 'transfer'">
                        <SelectInput
                            id="account_input"
                            v-model="v$.transaction.account_id.$model"
                            :label="$t('form.account')"
                            :options="accounts"
                            option-label="name"
                            option-value="id"
                            filter
                            :validate="v$.transaction.account_id"
                        />
                    </div>

                    <div v-if="transaction.type == 'transfer'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <SelectInput
                            id="from_account_input"
                            v-model="v$.transaction.from_account.$model"
                            :label="$t('transaction.from_account')"
                            :options="accounts"
                            option-label="name"
                            option-value="id"
                            filter
                            :validate="v$.transaction.from_account"
                        />
                        <SelectInput
                            id="to_account_input"
                            v-model="v$.transaction.to_account.$model"
                            :label="$t('transaction.to_account')"
                            :options="accounts"
                            option-label="name"
                            option-value="id"
                            filter
                            :validate="v$.transaction.to_account"
                        />
                    </div>

                    <TextAreaInput id="description_input" v-model="transaction.description" :label="$t('form.description')" />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <SelectInput
                            id="category_input"
                            v-model="transaction.category_id"
                            :label="$t('form.category')"
                            :options="transactionCategories"
                            option-label="label"
                            option-value="id"
                            filter
                        />

                        <SelectInput
                            v-if="transaction.type == 'income'"
                            id="customer_input"
                            v-model="transaction.customer_id"
                            :label="$t('form.customer')"
                            :options="customers"
                            option-label="name"
                            option-value="id"
                            filter
                        />
                        <SelectInput
                            v-if="transaction.type == 'expense'"
                            id="supplier_input"
                            v-model="transaction.supplier_id"
                            :label="$t('form.supplier')"
                            :options="suppliers"
                            option-label="name"
                            option-value="id"
                            filter
                        />
                    </div>
                    <TextInput id="reference_input" v-model="transaction.reference" :label="$t('form.reference')" />
                </form>
            </div>
            <div id="function_buttons" class="flex justify-end mt-4 gap-2">
                <Button
                    id="cancel_button"
                    :label="$t('basic.cancel')"
                    icon="fa fa-times"
                    severity="secondary"
                    @click="goTo('/transactions/' + $route.params.id)"
                />
                <Button
                    id="update_button"
                    :label="$t('basic.update')"
                    :disabled="loadingData"
                    icon="fa fa-floppy-disk"
                    severity="success"
                    @click="validateForm"
                />
            </div>
        </LoadingScreen>
    </DefaultLayout>
</template>

<script>
import { required, requiredIf } from '@/plugins/i18n-validators'
import { useVuelidate } from '@vuelidate/core'
import TransactionsMixin from '@/mixins/transactions'
export default {
    name: 'EditTransactionPage',
    mixins: [TransactionsMixin],

    created() {
        this.transaction.currency = this.$settings.default_currency
        this.getAccounts()
        this.getCustomers()
        this.getSuppliers()
        this.getTransaction(this.$route.params.id)
        this.getTransactionCategories()
    },

    setup() {
        return { v$: useVuelidate() }
    },

    validations() {
        return {
            transaction: {
                number: { required },
                type: { required },
                name: { required },
                amount: { required },
                date: { required },
                account_id: { requiredIfNotTransfer: requiredIf(this.transaction.type != 'transfer') },
                from_account: { requiredIfTransfer: requiredIf(this.transaction.type == 'transfer') },
                to_account: { requiredIfTransfer: requiredIf(this.transaction.type == 'transfer') },
            },
        }
    },

    methods: {
        validateForm() {
            this.v$.transaction.$touch()
            if (this.v$.transaction.$invalid) {
                this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
                return
            }

            return this.updateTransaction()
        },
    },
}
</script>
