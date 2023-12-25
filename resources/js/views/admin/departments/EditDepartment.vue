<template>
    <admin-layout>
        <div id="admin-edit-department">
            <loadingScreen :blocked="loadingData">
                <user-header :title="$t('admin.department.edit_department')">
                    <template v-slot:actions>
                        <Button
                            id="delete_button"
                            :label="$t('basic.delete')"
                            icon="fa fa-trash"
                            class="p-button-danger"
                            @click="deleteDepartmentAsk($route.params.id)"
                        />
                    </template>
                </user-header>

                <div class="card">
                    <form class="formgrid">
                        <TextInput
                            id="input_name"
                            v-model="v$.department.name.$model"
                            :label="$t('form.name')"
                            :placeholder="$t('form.name')"
                            :validate="v$.department.name"
                        />
                        <TextAreaInput
                            id="input_description"
                            v-model="department.description"
                            class="w-full"
                            :label="$t('form.description')"
                            :placeholder="$t('form.description')"
                        />
                        <TextInput
                            id="input_address"
                            v-model="department.address"
                            :label="$t('form.address')"
                            :placeholder="$t('form.address')"
                        />
                        <div class="grid">
                            <div class="col-12 md:col-6">
                                <TextInput
                                    id="input_zip_code"
                                    v-model="department.zip_code"
                                    :label="$t('form.zip_code')"
                                    :placeholder="$t('form.zip_code')"
                                />
                            </div>
                            <div class="col-12 md:col-6">
                                <TextInput
                                    id="input_city"
                                    v-model="department.city"
                                    :label="$t('form.city')"
                                    :placeholder="$t('form.city')"
                                />
                            </div>
                        </div>
                        <CountrySelect
                            id="input_country"
                            v-model="department.country"
                            :label="$t('form.country')"
                            :placeholder="$t('form.country')"
                        />
                        <div class="grid">
                            <div class="col-12 md:col-6">
                                <TextInput
                                    id="input_phone"
                                    v-model="department.phone_number"
                                    :label="$t('form.phone_number')"
                                    :placeholder="$t('form.phone_number')"
                                />
                            </div>
                            <div class="col-12 md:col-6">
                                <TextInput
                                    id="input_email"
                                    v-model="department.email"
                                    :label="$t('form.email')"
                                    :placeholder="$t('form.email')"
                                />
                            </div>
                        </div>
                    </form>
                </div>
            </loadingScreen>
            <div id="function_buttons" class="flex gap-2 justify-content-end">
                <Button
                    id="cancel_button"
                    :label="$t('basic.cancel')"
                    icon="fa fa-times"
                    class="p-button-danger"
                    @click="goTo('/admin/departments')"
                />
                <Button
                    id="update_button"
                    :label="$t('basic.update')"
                    icon="fa fa-floppy-disk"
                    class="p-button-success"
                    @click="validateForm"
                />
            </div>
        </div>
    </admin-layout>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import DepartmentsMixin from '@/mixins/admin/departments'
export default {
    name: 'AdminNewDepartment',
    mixins: [DepartmentsMixin],
    setup: () => ({ v$: useVuelidate() }),
    created() {
        this.getDepartment(this.$route.params.id)
    },
    validations() {
        return {
            department: {
                name: { required },
            },
        }
    },
    methods: {
        validateForm() {
            this.v$.$touch()
            if (this.v$.$error) {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }
            this.updateDepartment()
        },
    },
}
</script>

<style></style>
