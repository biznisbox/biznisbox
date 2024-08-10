<template>
    <DefaultLayout>
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="$t('account.new_account')" />
            <div class="card">
                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <TextInput id="name_input" v-model="v$.account.name.$model" :label="$t('form.name')" :validate="v$.account.name" />
                        <SelectButtonInput
                            id="select_account_type"
                            v-model="v$.account.type.$model"
                            :label="$t('form.type')"
                            :options="[
                                { label: $t('account_types.bank_account'), value: 'bank_account' },
                                { label: $t('account_types.online_account'), value: 'online_account' },
                                { label: $t('account_types.cash'), value: 'cash' },
                            ]"
                            :validate="v$.account.type"
                        />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <SelectInput
                            id="select_currency"
                            v-model="v$.account.currency.$model"
                            :label="$t('form.currency')"
                            :options="currencies"
                            option-label="name"
                            option-value="code"
                            :validate="v$.account.currency"
                        />
                        <SelectButtonInput
                            id="is_active_account"
                            v-model="v$.account.is_active.$model"
                            :label="$t('form.active_account')"
                            :options="[
                                { label: $t('basic.yes'), value: true },
                                { label: $t('basic.no'), value: false },
                            ]"
                            :validate="v$.account.is_active"
                        />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <NumberInput
                            id="opening_balance_input"
                            v-model="account.opening_balance"
                            type="currency"
                            :currency="account.currency"
                            :label="$t('form.opening_balance')"
                        />
                        <DateInput
                            id="opening_balance_date_input"
                            v-model="v$.account.date_opened.$model"
                            :label="$t('form.opening_balance_date')"
                            :validate="v$.account.date_opened"
                        />
                    </div>

                    <div v-if="account.type === 'bank_account'" id="bank_data">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <SelectButtonInput
                                id="is_default_account"
                                v-model="account.is_default"
                                :label="$t('form.default_account')"
                                :options="[
                                    { label: $t('basic.yes'), value: true },
                                    { label: $t('basic.no'), value: false },
                                ]"
                            />
                            <TextInput id="iban_input" v-model="account.iban" :label="$t('form.iban')" />
                            <TextInput id="bic_input" v-model="account.bic" :label="$t('form.bic')" />
                        </div>
                    </div>

                    <div id="bank_account_details">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <TextInput id="bank_name_input" v-model="account.bank_name" :label="$t('form.bank_name')"></TextInput>
                            <TextInput id="bank_contact_input" v-model="account.bank_contact" :label="$t('form.contact')"></TextInput>
                        </div>

                        <TextAreaInput
                            id="bank_address_input"
                            v-model="account.bank_address"
                            class="col-12"
                            :label="$t('form.address')"
                        ></TextAreaInput>
                    </div>

                    <TextAreaInput
                        id="description_input"
                        v-model="account.description"
                        class="col-12"
                        :label="$t('form.description')"
                    ></TextAreaInput>
                </form>
            </div>
            <div id="function_buttons" class="flex justify-end gap-2">
                <Button id="cancel_button" :label="$t('basic.cancel')" icon="fa fa-times" severity="secondary" @click="goTo('/accounts')" />
                <Button
                    id="save_button"
                    :label="$t('basic.save')"
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
import { required } from '@/plugins/i18n-validators'
import { useVuelidate } from '@vuelidate/core'
import AccountsMixin from '@/mixins/accounts'
export default {
    name: 'NewAccountPage',
    mixins: [AccountsMixin],
    created() {
        this.getCurrencies()
    },

    setup() {
        return { v$: useVuelidate() }
    },

    validations() {
        return {
            account: {
                name: { required },
                type: { required },
                currency: { required },
                opening_balance: { required },
                date_opened: { required },
                is_active: { required },
            },
        }
    },

    methods: {
        validateForm() {
            this.v$.account.$touch()
            if (this.v$.account.$invalid) {
                this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
                return
            }
            return this.saveAccount()
        },
    },
}
</script>

<style></style>
