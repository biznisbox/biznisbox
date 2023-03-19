<template>
    <div>
        <admin-layout>
            <div id="admin_settings_currency_page">
                <user-header :title="$t('admin.currency.title')">
                    <template #actions>
                        <Button :label="$t('admin.currency.new_currency')" icon="fa fa-plus" @click="showNewCurrencyDialog = true" />
                        <Button
                            v-if="$settings.default_currency === 'EUR'"
                            :label="$t('admin.currency.update_rates')"
                            icon="fa fa-sync"
                            @click="updateRates"
                        />
                    </template>
                </user-header>

                <div id="currency_table" class="card">
                    <DataTable :value="currencies" :loading="loadingData" column-resize-mode="expand" @row-dblclick="editCurrencyDialog">
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

            <Dialog v-model:visible="showEditCurrencyDialog" :header="$t('admin.currency.edit_currency')" modal>
                <LoadingScreen :blocked="loadingData">
                    <form id="edit_currency_form" class="formgrid">
                        <div class="grid">
                            <TextInput v-model="currency.name" :label="$t('admin.currency.name')" class="col-12" />
                        </div>
                        <div class="grid">
                            <TextInput v-model="currency.code" :label="$t('admin.currency.code')" class="col-12" />
                        </div>
                        <div class="grid">
                            <TextInput v-model="currency.symbol" :label="$t('admin.currency.symbol')" class="col-12" />
                        </div>
                        <div class="grid">
                            <TextInput v-model="currency.rate" :label="$t('admin.currency.rate')" class="col-12" />
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
                            <Button :label="$t('basic.save')" icon="fa fa-floppy-disk" class="p-button-success" @click="updateCurrency" />
                        </div>
                    </div>
                </template>
            </Dialog>

            <Dialog v-model:visible="showNewCurrencyDialog" :header="$t('admin.currency.new_currency')" modal>
                <LoadingScreen :blocked="loadingData">
                    <form id="new_currency_form" class="formgrid">
                        <div class="grid">
                            <TextInput v-model="currency.name" :label="$t('admin.currency.name')" class="col-12" />
                        </div>
                        <div class="grid">
                            <TextInput v-model="currency.code" :label="$t('admin.currency.code')" class="col-12" />
                        </div>
                        <div class="grid">
                            <TextInput v-model="currency.symbol" :label="$t('admin.currency.symbol')" class="col-12" />
                        </div>
                        <div class="grid">
                            <TextInput v-model="currency.rate" :label="$t('admin.currency.rate')" class="col-12" />
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
                            <Button :label="$t('basic.save')" icon="fa fa-floppy-disk" class="p-button-success" @click="createCurrency" />
                        </div>
                    </div>
                </template>
            </Dialog>
        </admin-layout>
    </div>
</template>

<script>
export default {
    name: 'AdminSettingsCurrencyPage',
    data() {
        return {
            currencies: [],
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
    created() {
        this.getCurrencies()
    },

    methods: {
        getCurrencies() {
            this.makeHttpRequest('GET', '/api/admin/currencies').then((response) => {
                this.currencies = response.data.data
            })
        },

        getCurrency(id) {
            this.makeHttpRequest('GET', `/api/admin/currencies/${id}`).then((response) => {
                this.currency = response.data.data
            })
        },

        updateCurrency() {
            this.makeHttpRequest('PUT', `/api/admin/currencies/${this.currency.id}`, this.currency).then((response) => {
                this.getCurrencies()
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
            this.makeHttpRequest('POST', '/api/admin/currencies', this.currency).then((response) => {
                this.getCurrencies()
                this.showNewCurrencyDialog = false
            })
        },

        updateRates() {
            this.makeHttpRequest('GET', '/api/admin/currency/rates').then((response) => {
                this.showToast(response.data.message)
                this.getCurrencies()
            })
        },

        newCurrencyDialog() {
            this.showNewCurrencyDialog = true
        },

        editCurrencyDialog(event) {
            this.showEditCurrencyDialog = true
            this.getCurrency(event.data.id)
        },
    },
}
</script>

<style></style>
