<template>
    <DefaultLayout menu_type="admin">
        <PageHeader :title="$t('admin.units.title')">
            <template v-slot:actions>
                <Button @click="openNewUnitDialog" icon="fa fa-plus" :label="$t('admin.units.new_unit')" />
            </template>
        </PageHeader>

        <div id="tax_table" class="card">
            <DataTable
                :value="units"
                :loading="loadingData"
                column-resize-mode="expand"
                @row-dblclick="openEditUnitDialog"
                paginator
                dataKey="id"
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50, 100]"
            >
                <template #empty>
                    <div class="p-4 pl-0 text-center w-full">
                        <i class="fa fa-info-circle empty-icon"></i>
                        <p>{{ $t('admin.units.no_units') }}</p>
                        <Button class="mt-3" :label="$t('admin.units.create_first_unit')" icon="fa fa-plus" @click="openNewUnitDialog" />
                    </div>
                </template>
                <Column field="name" :header="$t('form.name')" />
                <Column field="description" :header="$t('form.description')" />
                <Column field="symbol" :header="$t('form.symbol')" />
            </DataTable>
        </div>

        <!-- Edit new unit modal -->
        <Dialog
            v-model:visible="showNewEditUnitDialog"
            :header="dialogMethod === 'edit' ? $t('admin.units.edit_unit') : $t('admin.units.new_unit')"
            modal
        >
            <LoadingScreen :blocked="loadingData">
                <form>
                    <TextInput v-model="v$.unit.name.$model" :label="$t('form.name')" :validate="v$.unit.name" />
                    <TextAreaInput v-model="v$.unit.description.$model" :label="$t('form.description')" :validate="v$.unit.description" />
                    <TextInput v-model="v$.unit.symbol.$model" :label="$t('form.symbol')" :validate="v$.unit.symbol" />
                </form>
            </LoadingScreen>

            <template #footer>
                <div id="function_buttons" class="flex flex-wrap gap-2">
                    <div class="flex justify-end">
                        <Button
                            :label="$t('basic.delete')"
                            icon="fa fa-trash"
                            severity="danger"
                            @click="deleteUnit(unit.id)"
                            v-if="dialogMethod === 'edit' && unit.id !== ''"
                        />
                    </div>
                    <div class="flex-grow"></div>
                    <div class="flex gap-2 flex-wrap justify-end">
                        <Button
                            :label="$t('basic.cancel')"
                            icon="fa fa-times"
                            severity="secondary"
                            @click="showNewEditUnitDialog = false"
                        />
                        <Button
                            :label="dialogMethod === 'edit' ? $t('basic.update') : $t('basic.save')"
                            icon="fa fa-save"
                            severity="success"
                            @click="validateForm"
                        />
                    </div>
                </div>
            </template>
        </Dialog>
    </DefaultLayout>
</template>
<script>
import { required } from '@/plugins/i18n-validators'
import { useVuelidate } from '@vuelidate/core'
export default {
    name: 'AdminUnitsSettingsPage',
    setup() {
        return { v$: useVuelidate() }
    },
    data() {
        return {
            units: [],
            unit: {
                id: '',
                name: '',
                description: '',
                symbol: '',
                active: true,
            },
            showNewEditUnitDialog: false,
            dialogMethod: 'create',
        }
    },

    validations() {
        return {
            unit: {
                name: { required },
                description: { required },
                symbol: { required },
            },
        }
    },

    created() {
        this.getUnits()
    },

    methods: {
        openEditUnitDialog(event) {
            this.dialogMethod = 'edit'
            this.resetUnitForm()
            this.getUnit(event.data.id)
            this.showNewEditUnitDialog = true
        },

        openNewUnitDialog() {
            this.dialogMethod = 'create'
            this.resetUnitForm()
            this.showNewEditUnitDialog = true
        },

        getUnits() {
            this.makeHttpRequest('GET', '/api/admin/units').then((response) => {
                this.units = response.data.data
            })
        },

        getUnit(id) {
            this.makeHttpRequest('GET', `/api/admin/units/${id}`).then((response) => {
                this.unit = response.data.data
            })
        },

        updateUnit() {
            this.makeHttpRequest('PUT', `/api/admin/units/${this.unit.id}`, this.unit).then((response) => {
                this.getUnits()
                this.showToast(response.data.message)
                this.showNewEditUnitDialog = false
            })
        },

        createUnit() {
            this.makeHttpRequest('POST', '/api/admin/units', this.unit).then((response) => {
                this.getUnits()
                this.showToast(response.data.message)
                this.showNewEditUnitDialog = false
            })
        },

        deleteUnit(id) {
            this.makeHttpRequest('DELETE', `/api/admin/units/${id}`).then((response) => {
                this.showNewEditUnitDialog = false
                this.showToast(response.data.message)
                this.getUnits()
            })
        },

        resetUnitForm() {
            this.v$.unit.$reset()
            this.unit = {
                id: '',
                name: '',
                description: '',
                active: true,
            }
        },

        validateForm() {
            this.v$.unit.$touch()
            if (this.v$.unit.$error) {
                return this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
            }

            if (this.dialogMethod === 'edit') {
                this.updateUnit()
            } else {
                this.createUnit()
            }
        },
    },
}
</script>
