<template>
    <div>
        <admin-layout>
            <div id="admin_settings_currency_page">
                <user-header :title="$t('admin.currency.title')">
                    <template #actions>
                        <Button :label="$t('admin.currency.new_currency')" icon="fa fa-plus" @click="openNewCurrencyDialog" />
                        <Button
                            v-if="$settings.default_currency === 'EUR'"
                            :label="$t('admin.currency.update_rates')"
                            icon="fa fa-sync"
                            @click="updateRates"
                        />
                    </template>
                </user-header>

                <div id="currency_table" class="card">
                    <DataTable
                        :value="currencies"
                        :loading="loadingData"
                        column-resize-mode="expand"
                        @row-dblclick="openEditCurrencyDialog"
                    >
                        <Column field="name" :header="$t('admin.currency.name')">
                            <template #body="slotProps">
                                <span>{{ slotProps.data.name }}</span>
                                <i v-if="slotProps.data.code === $settings.default_currency" class="ml-2 fa fa-lock"></i>
                            </template>
                        </Column>
                        <Column field="code" :header="$t('admin.currency.code')" />
                        <Column field="symbol" :header="$t('admin.currency.symbol')" />
                        <Column field="rate" :header="$t('admin.currency.rate')" />
                    </DataTable>
                </div>
            </div>

            <!-- Edit currency modal -->
            <Dialog v-model:visible="showEditCurrencyDialog" :header="$t('admin.currency.edit_currency')" modal>
                <LoadingScreen :blocked="loadingData">
                    <form id="edit_currency_form" class="formgrid mt-3">
                        <div class="grid">
                            <SelectInput
                                v-model="v$.currency.name.$model"
                                :label="$t('admin.currency.name')"
                                class="col-12"
                                :validate="v$.currency.name"
                                :options="availableCurrencies"
                                option-label="name"
                                option-value="name"
                                filter
                                disabled
                            />
                        </div>
                        <div class="grid">
                            <TextInput
                                v-model="v$.currency.code.$model"
                                :label="$t('admin.currency.code')"
                                class="col-12"
                                :validate="v$.currency.code"
                                disabled
                            />
                        </div>
                        <div class="grid">
                            <TextInput
                                v-model="v$.currency.symbol.$model"
                                :label="$t('admin.currency.symbol')"
                                class="col-12"
                                :validate="v$.currency.symbol"
                                disabled
                            />
                        </div>
                        <div class="grid">
                            <TextInput
                                v-model="v$.currency.rate.$model"
                                :label="$t('admin.currency.rate')"
                                class="col-12"
                                :validate="v$.currency.rate"
                            />
                        </div>
                    </form>
                </LoadingScreen>

                <template #footer>
                    <div id="function_buttons" class="flex gap-2">
                        <div class="flex justify-content-end">
                            <Button
                                :label="$t('basic.delete')"
                                icon="fa fa-trash"
                                class="p-button-danger"
                                @click="deleteCurrency(currency.id)"
                            />
                        </div>
                        <div class="flex-grow"></div>
                        <div class="flex justify-content-end">
                            <Button
                                :label="$t('basic.cancel')"
                                icon="fa fa-times"
                                class="p-button-danger"
                                @click="showEditCurrencyDialog = false"
                            />
                            <Button
                                :label="$t('basic.save')"
                                icon="fa fa-floppy-disk"
                                class="p-button-success ml-2"
                                @click="updateCurrency"
                            />
                        </div>
                    </div>
                </template>
            </Dialog>

            <!-- New currency modal -->
            <Dialog v-model:visible="showNewCurrencyDialog" :header="$t('admin.currency.new_currency')" modal>
                <LoadingScreen :blocked="loadingData">
                    <form id="new_currency_form" class="formgrid mt-3">
                        <div class="grid">
                            <SelectInput
                                v-model="v$.currency.name.$model"
                                :label="$t('admin.currency.name')"
                                class="col-12"
                                :validate="v$.currency.name"
                                :options="availableCurrencies"
                                option-label="name"
                                option-value="name"
                                filter
                            />
                        </div>
                        <div class="grid">
                            <TextInput
                                v-model="v$.currency.code.$model"
                                :label="$t('admin.currency.code')"
                                class="col-12"
                                :validate="v$.currency.code"
                            />
                        </div>
                        <div class="grid">
                            <TextInput
                                v-model="v$.currency.symbol.$model"
                                :label="$t('admin.currency.symbol')"
                                class="col-12"
                                :validate="v$.currency.symbol"
                            />
                        </div>
                        <div class="grid">
                            <TextInput
                                v-model="v$.currency.rate.$model"
                                :label="$t('admin.currency.rate')"
                                class="col-12"
                                :validate="v$.currency.rate"
                            />
                        </div>
                    </form>
                </LoadingScreen>

                <template #footer>
                    <div id="function_buttons" class="flex gap-2">
                        <div class="flex justify-content-end">
                            <Button
                                :label="$t('basic.cancel')"
                                icon="fa fa-times"
                                class="p-button-danger"
                                @click="showNewCurrencyDialog = false"
                            />
                            <Button
                                :label="$t('basic.save')"
                                icon="fa fa-floppy-disk"
                                class="p-button-success ml-2"
                                @click="createCurrency"
                            />
                        </div>
                    </div>
                </template>
            </Dialog>
        </admin-layout>
    </div>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { required } from '@vuelidate/validators'
export default {
    name: 'AdminSettingsCurrencyPage',
    setup: () => ({ v$: useVuelidate() }),
    data() {
        return {
            currencies: [],
            availableCurrencies: [],
            currency: {
                id: '',
                name: '',
                code: '',
                symbol: '',
                rate: '',
            },
            showEditCurrencyDialog: false,
            showNewCurrencyDialog: false,
        }
    },

    validations() {
        return {
            currency: {
                name: { required },
                code: { required },
                symbol: { required },
                rate: { required },
            },
        }
    },

    watch: {
        'currency.name': function (val) {
            // Find the currency in the available currencies
            const currency = this.availableCurrencies.find((currency) => currency.name === val)
            if (!currency) return
            // Update the currency object
            if (!this.showEditCurrencyDialog) {
                this.currency.code = currency.code
                this.currency.symbol = currency.symbol_native
                this.currency.rate = 1
            }
        },
    },

    created() {
        this.getCurrencies()
        this.getAvailableCurrencies()
    },

    methods: {
        getCurrencies() {
            this.makeHttpRequest('GET', '/api/admin/currencies').then((response) => {
                this.currencies = response.data.data
            })
        },

        getAvailableCurrencies() {
            this.makeHttpRequest('GET', '/api/currencies?fields=symbol,decimal_mark,thousands_separator,precision,code,symbol_native').then(
                (response) => {
                    this.availableCurrencies = response.data.data
                }
            )
        },

        getCurrency(id) {
            this.makeHttpRequest('GET', `/api/admin/currencies/${id}`).then((response) => {
                this.currency = response.data.data
            })
        },

        updateCurrency() {
            this.v$.$touch()
            if (this.v$.$error) {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }

            this.makeHttpRequest('PUT', `/api/admin/currencies/${this.currency.id}`, this.currency).then((response) => {
                this.v$.$reset()
                this.getCurrencies()
                this.showToast(response.data.message)
                this.showEditCurrencyDialog = false
            })
        },

        deleteCurrency(id) {
            this.makeHttpRequest('DELETE', `/api/admin/currencies/${id}`).then((response) => {
                this.showEditCurrencyDialog = false
                this.showToast(response.data.message)
                this.getCurrencies()
            })
        },

        createCurrency() {
            this.v$.$touch()
            if (this.v$.$error) {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }

            this.makeHttpRequest('POST', '/api/admin/currencies', this.currency).then((response) => {
                this.getCurrencies()
                this.showToast(response.data.message)
                this.v$.$reset()
                this.showNewCurrencyDialog = false
            })
        },

        updateRates() {
            this.makeHttpRequest('GET', '/api/admin/currency/rates').then((response) => {
                this.showToast(response.data.message)
                this.getCurrencies()
            })
        },

        openNewCurrencyDialog() {
            this.v$.$reset()
            this.currency = {
                id: '',
                name: '',
                code: '',
                symbol: '',
                rate: '',
            }
            this.showNewCurrencyDialog = true
        },

        openEditCurrencyDialog(event) {
            this.showEditCurrencyDialog = true
            this.getCurrency(event.data.id)
        },
    },
}
</script>

<style></style>
