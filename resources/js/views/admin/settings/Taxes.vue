<template>
    <div>
        <admin-layout>
            <div id="admin_settings_tax_page">
                <user-header :title="$t('admin.taxes.title')">
                    <template #actions>
                        <Button :label="$t('admin.taxes.new_tax')" icon="fa fa-plus" @click="newTaxDialog" />
                    </template>
                </user-header>

                <div id="tax_table" class="card">
                    <DataTable :value="taxes" :loading="loadingData" column-resize-mode="expand" @row-dblclick="editTaxDialog">
                        <template #empty>
                            <div class="p-4 pl-0 text-center w-full text-gray-500">
                                <i class="fa fa-info-circle empty-icon"></i>
                                <p>{{ $t('admin.taxes.no_taxes') }}</p>
                                <Button class="mt-3" :label="$t('admin.taxes.create_first_tax')" icon="fa fa-plus" @click="newTaxDialog" />
                            </div>
                        </template>
                        <Column field="name" :header="$t('admin.taxes.name')" />
                        <Column field="description" :header="$t('admin.taxes.description')" />
                        <Column field="value" :header="$t('admin.taxes.value')" />
                    </DataTable>
                </div>
            </div>

            <!-- Edit tax modal -->
            <Dialog v-model:visible="showEditTaxDialog" :header="$t('admin.taxes.edit_tax')" modal>
                <LoadingScreen :blocked="loadingData">
                    <form id="edit_tax_form" class="formgrid">
                        <div class="grid">
                            <TextInput
                                v-model="v$.tax.name.$model"
                                :label="$t('admin.taxes.name')"
                                class="col-12"
                                :validate="v$.tax.name"
                            />
                        </div>
                        <div class="grid">
                            <TextAreaInput
                                v-model="v$.tax.description.$model"
                                :label="$t('admin.taxes.description')"
                                class="col-12"
                                :validate="v$.tax.description"
                            />
                        </div>
                        <div class="grid">
                            <NumberInput
                                v-model="v$.tax.value.$model"
                                :label="$t('admin.taxes.value')"
                                type="float"
                                :min-fraction="2"
                                :max-fraction="2"
                                class="col-12"
                                :validate="v$.tax.value"
                            />
                        </div>
                    </form>
                </LoadingScreen>

                <template #footer>
                    <div id="function_buttons" class="flex gap-2">
                        <div class="flex justify-content-end">
                            <Button :label="$t('basic.delete')" icon="fa fa-trash" class="p-button-danger" @click="deleteTax(tax.id)" />
                        </div>
                        <div class="flex-grow"></div>
                        <div class="flex gap-2 justify-content-end">
                            <Button
                                :label="$t('basic.cancel')"
                                icon="fa fa-times"
                                class="p-button-danger"
                                @click="showEditTaxDialog = false"
                            />
                            <Button :label="$t('basic.save')" icon="fa fa-floppy-disk" class="p-button-success" @click="updateTax" />
                        </div>
                    </div>
                </template>
            </Dialog>

            <!-- New tax modal -->
            <Dialog v-model:visible="showNewTaxDialog" :header="$t('admin.taxes.new_tax')" modal>
                <LoadingScreen :blocked="loadingData">
                    <form id="new_tax_form" class="formgrid mt-3">
                        <div class="grid">
                            <TextInput
                                v-model="v$.tax.name.$model"
                                :label="$t('admin.taxes.name')"
                                class="col-12"
                                :validate="v$.tax.name"
                            />
                        </div>
                        <div class="grid">
                            <TextAreaInput
                                v-model="v$.tax.description.$model"
                                :label="$t('admin.taxes.description')"
                                class="col-12"
                                :validate="v$.tax.description"
                            />
                        </div>
                        <div class="grid">
                            <NumberInput
                                v-model="v$.tax.value.$model"
                                :label="$t('admin.taxes.value')"
                                type="float"
                                :min-fraction="2"
                                :max-fraction="2"
                                class="col-12"
                                :validate="v$.tax.value"
                            />
                        </div>
                    </form>
                </LoadingScreen>

                <template #footer>
                    <div id="function_buttons" class="flex gap-2">
                        <div class="flex gap-2 justify-content-end">
                            <Button
                                id="cancel_button"
                                :label="$t('basic.cancel')"
                                icon="fa fa-times"
                                class="p-button-danger"
                                @click="showNewTaxDialog = false"
                            />
                            <Button :label="$t('basic.save')" icon="fa fa-floppy-disk" class="p-button-success" @click="createTax" />
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
    name: 'AdminSettingsTaxPage',
    setup: () => ({ v$: useVuelidate() }),
    data() {
        return {
            taxes: [],
            tax: {
                id: '',
                name: '',
                description: '',
                value: null,
            },
            showEditTaxDialog: false,
            showNewTaxDialog: false,
        }
    },

    validations() {
        return {
            tax: {
                name: { required },
                description: { required },
                value: { required },
            },
        }
    },
    created() {
        this.getTaxes()
    },

    methods: {
        getTaxes() {
            this.makeHttpRequest('GET', '/api/admin/taxes').then((response) => {
                this.taxes = response.data.data
            })
        },

        getTax(id) {
            this.makeHttpRequest('GET', `/api/admin/taxes/${id}`).then((response) => {
                this.tax = response.data.data
            })
        },

        updateTax() {
            this.v$.$touch()
            if (this.v$.$error) {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }

            this.makeHttpRequest('PUT', `/api/admin/taxes/${this.tax.id}`, this.tax).then((response) => {
                this.v$.$reset()
                this.getTaxes()
                this.showToast(response.data.message)
                this.showEditTaxDialog = false
            })
        },

        deleteTax(id) {
            this.makeHttpRequest('DELETE', `/api/admin/taxes/${id}`).then((response) => {
                this.showEditTaxDialog = false
                this.showToast(response.data.message)
                this.getTaxes()
            })
        },

        createTax() {
            this.v$.$touch()
            if (this.v$.$error) {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }

            this.makeHttpRequest('POST', '/api/admin/taxes', this.tax).then((response) => {
                this.v$.$reset()
                this.showToast(response.data.message)
                this.getTaxes()
                this.showNewTaxDialog = false
            })
        },

        newTaxDialog() {
            this.v$.$reset()
            this.tax = {
                id: '',
                name: '',
                description: '',
                value: '',
                type: '',
            }
            this.showNewTaxDialog = true
        },

        editTaxDialog(event) {
            this.v$.$reset()
            this.showEditTaxDialog = true
            this.getTax(event.data.id)
        },
    },
}
</script>

<style></style>
