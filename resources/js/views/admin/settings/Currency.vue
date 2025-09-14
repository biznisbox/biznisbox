<template>
    <DefaultLayout menu_type="admin">
        <PageHeader :title="$t('admin.currency.title')">
            <template #actions>
                <Button :label="$t('admin.currency.new_currency')" icon="fa fa-plus" @click="openNewCurrencyDialog" />
                <Button
                    v-if="$settings.default_currency === 'EUR'"
                    :label="$t('admin.currency.update_rates')"
                    icon="fa fa-sync"
                    @click="updateRates"
                    severity="secondary"
                    outlined
                />
            </template>
        </PageHeader>

        <div id="currency_table" class="card">
            <DataTable
                :value="currencies"
                :loading="loadingData"
                column-resize-mode="expand"
                @row-dblclick="openEditCurrencyDialog"
                paginator
                dataKey="id"
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50]"
            >
                <template #empty>
                    <div class="p-4 pl-0 text-center w-full dark:text-gray-400">
                        <i class="fa fa-info-circle empty-icon"></i>
                        <p>{{ $t('admin.currency.no_currencies') }}</p>
                    </div>
                </template>

                <Column field="name" :header="$t('admin.currency.name')">
                    <template #body="{ data }">
                        <i v-if="data.code === $settings.default_currency" class="mr-2 fa fa-lock"></i>
                        <span>{{ data.name }}</span>
                    </template>
                </Column>
                <Column field="code" :header="$t('admin.currency.code')" />
                <Column field="symbol" :header="$t('admin.currency.symbol')" />
                <Column field="exchange_rate" :header="$t('admin.currency.rate')" />
            </DataTable>
        </div>

        <!-- New edit currency modal -->
        <Dialog
            v-model:visible="showNewEditCurrencyDialog"
            :header="modalMode === 'edit' ? $t('admin.currency.edit_currency') : $t('admin.currency.new_currency')"
            modal
            class="w-full m-2 lg:w-1/2"
            :draggable="false"
        >
            <LoadingScreen :blocked="loadingData">
                <form>
                    <SelectInput
                        v-model="currency.name"
                        :label="$t('admin.currency.name')"
                        :options="availableCurrencies"
                        option-label="name"
                        option-value="name"
                        filter
                        :disabled="modalMode === 'edit'"
                    />
                    <TextInput v-model="currency.code" :label="$t('admin.currency.code')" disabled />
                    <TextInput v-model="currency.symbol" :label="$t('admin.currency.symbol')" disabled />
                    <TextInput v-model="currency.number_of_decimal" :label="$t('admin.currency.decimals')" />
                    <TextInput v-model="currency.decimal_separator" :label="$t('admin.currency.decimal_separator')" />
                    <TextInput v-model="currency.thousand_separator" :label="$t('admin.currency.thousands_separator')" />
                    <SelectInput
                        v-model="currency.placement"
                        :label="$t('admin.currency.placement')"
                        :options="[
                            { label: $t('admin.currency.before'), value: 'before' },
                            { label: $t('admin.currency.after'), value: 'after' },
                        ]"
                        option-label="label"
                        option-value="value"
                    />
                    <TextInput v-model="currency.exchange_rate" :label="$t('admin.currency.rate')" />
                </form>
            </LoadingScreen>

            <template #footer>
                <div id="function_buttons" class="flex gap-2 flex-wrap">
                    <div class="flex justify-content-end">
                        <Button
                            v-if="modalMode === 'edit' && currency.code !== $settings.default_currency"
                            :label="$t('basic.delete')"
                            icon="fa fa-trash"
                            severity="danger"
                            @click="deleteCurrencyAsk(currency.id)"
                        />
                    </div>
                    <div class="flex-grow"></div>
                    <div class="flex justify-content-end gap-2 flex-wrap">
                        <Button
                            :label="$t('basic.cancel')"
                            icon="fa fa-times"
                            severity="secondary"
                            @click="showNewEditCurrencyDialog = false"
                        />
                        <Button
                            v-if="modalMode === 'edit'"
                            :label="$t('basic.update')"
                            icon="fa fa-floppy-disk"
                            @click="updateCurrency"
                            severity="success"
                        />
                        <Button v-else :label="$t('basic.save')" icon="fa fa-floppy-disk" @click="createCurrency" severity="success" />
                    </div>
                </div>
            </template>
        </Dialog>
    </DefaultLayout>
</template>

<script>
export default {
    name: 'AdminSettingsCurrencyPage',
    data() {
        return {
            currencies: [],
            availableCurrencies: [],
            currency: {
                id: '',
                name: '',
                code: '',
                symbol: '',
                exchange_rate: '',
                decimal_separator: '',
                thousand_separator: '',
                number_of_decimal: '',
                placement: 'after',
            },
            showNewEditCurrencyDialog: false,
            modalMode: 'new',
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
                this.currency.decimal_separator = currency.decimal_mark
                this.currency.thousand_separator = currency.thousands_separator
                this.currency.number_of_decimal = currency.precision
                this.currency.exchange_rate = 1
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
                    // Remove duplicates
                    const unique = [...new Map(response.data.data.map((item) => [item['code'], item])).values()]
                    this.availableCurrencies = unique
                }
            )
        },

        getCurrency(id) {
            this.makeHttpRequest('GET', `/api/admin/currencies/${id}`).then((response) => {
                this.currency = response.data.data
            })
        },

        updateCurrency() {
            this.makeHttpRequest('PUT', `/api/admin/currencies/${this.currency.id}`, this.currency).then((response) => {
                this.getCurrencies()
                this.showToast(response.data.message)
                this.showNewEditCurrencyDialog = false
            })
        },

        deleteCurrency(id) {
            this.makeHttpRequest('DELETE', `/api/admin/currencies/${id}`).then((response) => {
                this.showToast(response.data.message)
                this.getCurrencies()
                this.showNewEditCurrencyDialog = false
            })
        },

        deleteCurrencyAsk(id) {
            this.confirmDeleteDialog(this.$t('admin.currency.delete_confirm_currency'), this.$t('basic.confirmation'), () => {
                this.deleteCurrency(id)
            })
        },

        createCurrency() {
            this.makeHttpRequest('POST', '/api/admin/currencies', this.currency).then((response) => {
                this.getCurrencies()
                this.showToast(response.data.message)
                this.showNewEditCurrencyDialog = false
            })
        },

        updateRates() {
            this.makeHttpRequest('GET', '/api/admin/currency/live-update').then((response) => {
                this.showToast(response.data.message)
                this.getCurrencies()
            })
        },

        openEditCurrencyDialog(rowData) {
            this.getCurrency(rowData.data.id)
            this.modalMode = 'edit'
            this.showNewEditCurrencyDialog = true
        },

        openNewCurrencyDialog() {
            this.currency = {
                id: '',
                name: '',
                code: '',
                symbol: '',
                exchange_rate: '',
                decimal_separator: '',
                thousands_separator: '',
                number_of_decimals: '',
                placement: 'after',
            }
            this.modalMode = 'new'
            this.showNewEditCurrencyDialog = true
        },
    },
}
</script>
