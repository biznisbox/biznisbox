<template>
    <DefaultLayout menu_type="admin">
        <PageHeader :title="$t('admin.taxes.title')">
            <template #actions>
                <Button :label="$t('admin.taxes.new_tax')" icon="fa fa-plus" @click="openNewTaxDialog" />
                <Button :label="$t('admin.taxes.import_tax')" icon="fa fa-upload" @click="openImportTaxDialog" />
            </template>
        </PageHeader>

        <div id="tax_table" class="card">
            <DataTable
                :value="taxes"
                :loading="loadingData"
                column-resize-mode="expand"
                @row-dblclick="openEditTaxDialog"
                :paginator="true"
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50]"
                dataKey="id"
            >
                <template #empty>
                    <div class="p-4 pl-0 text-center w-full dark:text-gray-400">
                        <i class="fa fa-info-circle empty-icon"></i>
                        <p>{{ $t('admin.taxes.no_taxes') }}</p>
                        <Button class="mt-3" :label="$t('admin.taxes.create_first_tax')" icon="fa fa-plus" @click="openNewTaxDialog" />
                    </div>
                </template>
                <Column field="name" :header="$t('admin.taxes.name')" />
                <Column field="description" :header="$t('admin.taxes.description')" />
                <Column field="type" :header="$t('form.type')">
                    <template #body="slotProps">
                        <Tag v-if="slotProps.data.type === 'percent'">{{ $t('tax_types.percent') }}</Tag>
                        <Tag v-else>{{ $t('tax_types.fixed') }}</Tag>
                    </template>
                </Column>
                <Column field="rate" :header="$t('form.rate')" />
            </DataTable>
        </div>

        <!--Import tax rates modal -->
        <Dialog v-model:visible="showImportTaxDialog" :header="$t('admin.taxes.import_tax')" modal>
            <p class="mb-4 block text-gray-600 dark:text-gray-400">
                {{ $t('admin.taxes.import_tax_description') }}
            </p>
            <LoadingScreen :blocked="loadingData">
                <SelectInput v-model="importCountryCodeValue" :label="$t('form.country')" :options="countryOptions" />
            </LoadingScreen>

            <template #footer>
                <div id="function_buttons" class="flex flex-wrap gap-2">
                    <div class="flex-grow"></div>
                    <div class="flex gap-2 flex-wrap justify-end">
                        <Button :label="$t('basic.cancel')" icon="fa fa-times" severity="secondary" @click="showImportTaxDialog = false" />
                        <Button :label="$t('basic.import')" severity="success" icon="fa fa-upload" @click="importTaxRates" />
                    </div>
                </div>
            </template>
        </Dialog>

        <!-- Edit new tax modal -->
        <Dialog
            v-model:visible="showNewEditTaxDialog"
            :header="dialogMethod === 'edit' ? $t('admin.taxes.edit_tax') : $t('admin.taxes.new_tax')"
            modal
        >
            <LoadingScreen :blocked="loadingData">
                <form>
                    <TextInput v-model="tax.name" :label="$t('form.name')" />
                    <TextAreaInput v-model="tax.description" :label="$t('form.description')" />
                    <SelectInput
                        v-model="tax.type"
                        :label="$t('form.type')"
                        :options="[
                            { label: $t('tax_types.percent'), value: 'percent' },
                            { label: $t('tax_types.fixed'), value: 'fixed' },
                        ]"
                    />
                    <NumberInput v-model="tax.rate" :label="$t('form.rate')" type="float" :min-fraction="2" :max-fraction="2" />
                </form>
            </LoadingScreen>

            <template #footer>
                <div id="function_buttons" class="flex flex-wrap gap-2">
                    <div class="flex justify-end">
                        <Button
                            :label="$t('basic.delete')"
                            icon="fa fa-trash"
                            severity="danger"
                            @click="deleteTaxAsk(tax.id)"
                            v-if="dialogMethod === 'edit' && tax.id !== ''"
                        />
                    </div>
                    <div class="flex-grow"></div>
                    <div class="flex gap-2 flex-wrap justify-end">
                        <Button :label="$t('basic.cancel')" icon="fa fa-times" severity="secondary" @click="showNewEditTaxDialog = false" />
                        <Button
                            :label="dialogMethod === 'edit' ? $t('basic.update') : $t('basic.save')"
                            severity="success"
                            icon="fa fa-save"
                            @click="dialogMethod === 'edit' ? updateTax() : createTax()"
                        />
                    </div>
                </div>
            </template>
        </Dialog>
    </DefaultLayout>
</template>

<script>
export default {
    name: 'AdminSettingsTaxPage',
    data() {
        return {
            taxes: [],
            tax: {
                id: '',
                name: '',
                description: '',
                rate: null,
                type: 'percent',
            },
            showNewEditTaxDialog: false,
            dialogMethod: 'create',
            importCountryCodeValue: null,
            showImportTaxDialog: false,
            countryOptions: [
                { label: 'Slovenia (SI)', value: 'SI' },
                { label: 'Spain (ES)', value: 'ES' },
                { label: 'France (FR)', value: 'FR' },
                { label: 'Germany (DE)', value: 'DE' },
                { label: 'Italy (IT)', value: 'IT' },
                { label: 'Austria (AT)', value: 'AT' },
                { label: 'Belgium (BE)', value: 'BE' },
                { label: 'Bulgaria (BG)', value: 'BG' },
                { label: 'Croatia (HR)', value: 'HR' },
                { label: 'Cyprus (CY)', value: 'CY' },
                { label: 'Czechia (CZ)', value: 'CZ' },
                { label: 'Denmark (DK)', value: 'DK' },
                { label: 'Estonia (EE)', value: 'EE' },
                { label: 'Finland (FI)', value: 'FI' },
                { label: 'Greece (GR)', value: 'GR' },
                { label: 'Hungary (HU)', value: 'HU' },
                { label: 'Ireland (IE)', value: 'IE' },
                { label: 'Latvia (LV)', value: 'LV' },
                { label: 'Lithuania (LT)', value: 'LT' },
                { label: 'Luxembourg (LU)', value: 'LU' },
                { label: 'Malta (MT)', value: 'MT' },
                { label: 'Netherlands (NL)', value: 'NL' },
                { label: 'Poland (PL)', value: 'PL' },
                { label: 'Portugal (PT)', value: 'PT' },
                { label: 'Romania (RO)', value: 'RO' },
                { label: 'Slovakia (SK)', value: 'SK' },
                { label: 'Sweden (SE)', value: 'SE' },
                { label: 'United Kingdom (GB)', value: 'GB' },
            ],
        }
    },

    created() {
        this.getTaxes()
    },

    methods: {
        openEditTaxDialog(event) {
            this.dialogMethod = 'edit'
            this.resetTaxForm()
            this.getTax(event.data.id)
            this.showNewEditTaxDialog = true
        },

        openNewTaxDialog() {
            this.dialogMethod = 'create'
            this.resetTaxForm()
            this.showNewEditTaxDialog = true
        },

        openImportTaxDialog() {
            this.importCountryCodeValue = null
            this.showImportTaxDialog = true
        },

        importTaxRates() {
            this.makeHttpRequest('POST', `/api/admin/taxes/import/${this.importCountryCodeValue}`).then((response) => {
                this.showImportTaxDialog = false
                this.showToast(response.data.message)
                this.getTaxes()
            })
        },

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
            this.makeHttpRequest('PUT', `/api/admin/taxes/${this.tax.id}`, this.tax).then((response) => {
                this.getTaxes()
                this.showToast(response.data.message)
                this.showNewEditTaxDialog = false
            })
        },

        deleteTax(id) {
            this.makeHttpRequest('DELETE', `/api/admin/taxes/${id}`).then((response) => {
                this.showNewEditTaxDialog = false
                this.showToast(response.data.message)
                this.getTaxes()
            })
        },

        createTax() {
            this.makeHttpRequest('POST', '/api/admin/taxes', this.tax).then((response) => {
                this.showToast(response.data.message)
                this.getTaxes()
                this.showNewEditTaxDialog = false
            })
        },

        resetTaxForm() {
            this.tax = {
                id: '',
                name: '',
                description: '',
                value: '',
                type: 'percent',
            }
        },

        deleteTaxAsk(id) {
            this.confirmDeleteDialog(this.$t('admin.taxes.delete_confirm_tax'), this.$t('basic.confirmation'), () => {
                this.deleteTax(id)
            })
        },
    },
}
</script>

<style></style>
