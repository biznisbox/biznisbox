<template>
    <DefaultLayout menu_type="admin">
        <PageHeader :title="$t('admin.taxes.title')">
            <template #actions>
                <Button :label="$t('admin.taxes.new_tax')" icon="fa fa-plus" @click="openNewTaxDialog" />
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
                    <div class="p-4 pl-0 text-center w-full">
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
            this.$confirm.require({
                message: this.$t('admin.taxes.delete_confirm_tax'),
                header: this.$t('basic.confirmation'),
                icon: 'fa fa-circle-exclamation',
                accept: () => {
                    this.deleteTax(id)
                },
            })
        },
    },
}
</script>

<style></style>
