<template>
    <user-layout>
        <div id="edit_account_page">
            <user-header :title="$t('account.edit_account')" />
            <LoadingScreen :blocked="loadingData">
                <div class="card">
                    <form class="formgrid">
                        <div class="grid">
                            <TextInput
                                id="name_input"
                                v-model="v$.account.name.$model"
                                class="col-12 md:col-6"
                                :label="$t('account.name')"
                                :validate="v$.account.name"
                            ></TextInput>
                            <SelectButtonInput
                                id="select_account_type"
                                v-model="v$.account.type.$model"
                                class="col-12 md:col-6"
                                :label="$t('account.account_type')"
                                :options="[
                                    { label: $t('account.bank_account'), value: 'bank_account' },
                                    { label: $t('account.online_account'), value: 'online_account' },
                                    { label: $t('account.cash'), value: 'cash' },
                                ]"
                                :validate="v$.account.type"
                            />
                        </div>

                        <div id="basic_data" class="grid">
                            <SelectInput
                                id="select_currency"
                                v-model="v$.account.currency.$model"
                                class="col-12 md:col-6"
                                :label="$t('account.currency')"
                                :options="currencies"
                                option-label="name"
                                option-value="code"
                                :validate="v$.account.currency"
                            />
                            <NumberInput
                                id="opening_balance_input"
                                v-model="v$.account.opening_balance.$model"
                                type="currency"
                                :currency="account.currency"
                                class="col-12 md:col-6"
                                :label="$t('account.opening_balance')"
                                :validate="v$.account.opening_balance"
                            ></NumberInput>
                        </div>

                        <div v-if="account.type === 'bank_account'" id="bank_data">
                            <div class="grid">
                                <SelectButtonInput
                                    id="is_default_account"
                                    v-model="account.is_default"
                                    class="col-12 md:col-4"
                                    :label="$t('account.default_account')"
                                    :options="[
                                        { label: $t('basic.yes'), value: true },
                                        { label: $t('basic.no'), value: false },
                                    ]"
                                />
                                <TextInput id="iban_input" v-model="account.iban" class="col-6 md:col-4" :label="$t('account.iban')" />
                                <TextInput id="bic_input" v-model="account.bic" class="col-6 md:col-4" :label="$t('account.bic')" />
                            </div>
                        </div>

                        <div id="bank_account_details">
                            <div class="grid">
                                <TextInput
                                    id="bank_name_input"
                                    v-model="account.bank_name"
                                    class="col-12 md:col-6"
                                    :label="$t('account.bank_name')"
                                ></TextInput>
                                <TextInput
                                    id="bank_contact_input"
                                    v-model="account.bank_contact"
                                    class="col-12 md:col-6"
                                    :label="$t('account.bank_contact')"
                                ></TextInput>
                            </div>
                            <div class="grid">
                                <TextAreaInput
                                    id="bank_address_input"
                                    v-model="account.bank_address"
                                    class="col-12"
                                    :label="$t('account.bank_address')"
                                ></TextAreaInput>
                            </div>
                        </div>
                    </form>

                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button
                            :label="$t('basic.cancel')"
                            icon="fa fa-times"
                            class="p-button-danger"
                            @click="goTo('/accounts/' + $route.params.id)"
                        />
                        <Button
                            :label="$t('basic.save')"
                            :disabled="loadingData"
                            icon="fa fa-floppy-disk"
                            class="p-button-success"
                            @click="validateForm"
                        />
                    </div>
                </div>
            </LoadingScreen>
        </div>
    </user-layout>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import AccountsMixin from '@/mixins/accounts'
export default {
    name: 'EditAccountPage',
    mixins: [AccountsMixin],
    setup: () => ({ v$: useVuelidate() }),
    validations() {
        return {
            account: {
                name: { required },
                type: { required },
                currency: { required },
                opening_balance: { required },
            },
        }
    },
    created() {
        this.getCurrencies()
        this.getAccount(this.$route.params.id)
    },
    methods: {
        validateForm() {
            this.v$.$touch()
            if (this.v$.$error) {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }
            return this.updateAccount(this.$route.params.id)
        },
    },
}
</script>

<style></style>
