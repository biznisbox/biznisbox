<template>
    <user-layout>
        <div id="new_employee_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('employee.new_employee')" />

                <div class="card">
                    <form class="formgrid">
                        <div class="grid">
                            <div class="col-12 md:col-6">
                                <TextInput
                                    id="number_input"
                                    v-model="v$.employee.number.$model"
                                    :label="$t('form.number')"
                                    disabled
                                    :validate="v$.employee.number"
                                />
                            </div>
                            <div class="col-12 md:col-6">
                                <SelectInput
                                    id="department_select"
                                    v-model="employee.department_id"
                                    :options="departments"
                                    option-value="id"
                                    option-label="name"
                                    :label="$t('form.department')"
                                />
                            </div>
                        </div>
                        <div class="grid">
                            <div class="col-12 md:col-6">
                                <TextInput
                                    id="first_name_input"
                                    v-model="v$.employee.first_name.$model"
                                    :label="$t('form.first_name')"
                                    :validate="v$.employee.first_name"
                                />
                            </div>
                            <div class="col-12 md:col-6">
                                <TextInput
                                    id="last_name_input"
                                    v-model="v$.employee.last_name.$model"
                                    :label="$t('form.last_name')"
                                    :validate="v$.employee.last_name"
                                />
                            </div>
                        </div>
                        <div class="grid">
                            <div class="col-12 md:col-6">
                                <TextInput
                                    id="email_input"
                                    v-model="v$.employee.email.$model"
                                    :label="$t('form.email')"
                                    :validate="v$.employee.email"
                                />
                            </div>
                            <div class="col-12 md:col-6">
                                <TextInput id="phone_input" v-model="employee.phone_number" :label="$t('form.phone_number')" />
                            </div>
                        </div>
                        <TextInput id="address_input" v-model="employee.address" :label="$t('form.address')" />
                        <div class="grid">
                            <div class="col-12 md:col-6">
                                <TextInput id="zip_code_input" v-model="employee.zip_code" :label="$t('form.zip_code')" />
                            </div>
                            <div class="col-12 md:col-6">
                                <TextInput id="city_input" v-model="employee.city" :label="$t('form.city')" />
                            </div>
                        </div>
                        <CountrySelect id="country_select" v-model="employee.country" :label="$t('form.country')" />
                        <div class="grid">
                            <div class="col-12 md:col-6">
                                <TextInput id="position_input" v-model="employee.position" :label="$t('form.position')" />
                            </div>
                            <div class="col-12 md:col-6">
                                <SelectInput
                                    id="type_select"
                                    v-model="employee.type"
                                    :label="$t('form.type')"
                                    :options="[
                                        { label: $t('employee_type.full_time'), value: 'full_time' },
                                        { label: $t('employee_type.part_time'), value: 'part_time' },
                                        { label: $t('employee_type.contractor'), value: 'contractor' },
                                        { label: $t('employee_type.intern'), value: 'intern' },
                                        { label: $t('employee_type.temporary'), value: 'temporary' },
                                        { label: $t('employee_type.apprentice'), value: 'apprentice' },
                                        { label: $t('employee_type.founder'), value: 'founder' },
                                        { label: $t('employee_type.co_founder'), value: 'co_founder' },
                                        { label: $t('employee_type.owner'), value: 'owner' },
                                        { label: $t('basic.other'), value: 'other' },
                                    ]"
                                />
                            </div>
                        </div>
                        <div class="grid">
                            <div class="col-12 md:col-6">
                                <TextInput id="salary_input" v-model="employee.salary" :label="$t('form.salary')" />
                            </div>
                            <div class="col-12 md:col-6">
                                <TextInput id="hourly_rate_input" v-model="employee.hourly_rate" :label="$t('form.hourly_rate')" />
                            </div>
                        </div>
                        <div class="grid">
                            <div class="col-12 md:col-6">
                                <SelectInput
                                    id="level_select"
                                    v-model="employee.level"
                                    :label="$t('form.level')"
                                    :options="[
                                        { label: $t('employee_level.junior'), value: 'junior' },
                                        { label: $t('employee_level.mid_level'), value: 'mid_level' },
                                        { label: $t('employee_level.senior'), value: 'senior' },
                                        { label: $t('employee_level.executive'), value: 'executive' },
                                        { label: $t('employee_level.director'), value: 'director' },
                                        { label: $t('employee_level.vice_president'), value: 'vice_president' },
                                        { label: $t('employee_level.c_level'), value: 'c_level' },
                                        { label: $t('employee_level.owner'), value: 'owner' },
                                        { label: $t('basic.other'), value: 'other' },
                                    ]"
                                />
                            </div>
                            <div class="col-12 md:col-6">
                                <SelectInput
                                    id="contract_type_input"
                                    v-model="employee.contract_type"
                                    :label="$t('form.contract_type')"
                                    :options="[
                                        { label: $t('contract_type.permanent'), value: 'permanent' },
                                        { label: $t('contract_type.fixed_term'), value: 'fixed_term' },
                                        { label: $t('contract_type.temporary'), value: 'temporary' },
                                        { label: $t('contract_type.zero_hours'), value: 'zero_hours' },
                                        { label: $t('contract_type.freelance'), value: 'freelance' },
                                        { label: $t('contract_type.contractor'), value: 'contractor' },
                                        { label: $t('contract_type.apprentice'), value: 'apprentice' },
                                        { label: $t('contract_type.intern'), value: 'intern' },
                                        { label: $t('contract_type.volunteer'), value: 'volunteer' },
                                        { label: $t('basic.other'), value: 'other' },
                                    ]"
                                />
                            </div>
                        </div>
                        <div class="grid">
                            <div class="col-12 md:col-6">
                                <DateInput id="start_date_input" v-model="employee.contract_start_date" :label="$t('form.start_date')" />
                            </div>
                            <div class="col-12 md:col-6">
                                <DateInput id="end_date_input" v-model="employee.contract_end_date" :label="$t('form.end_date')" />
                            </div>
                        </div>

                        <SelectInput
                            id="username_select"
                            v-model="employee.user_id"
                            :options="users"
                            option-value="id"
                            option-label="label"
                            :label="$t('form.internal_user')"
                            filter
                        />
                    </form>
                </div>
                <div id="function_buttons" class="flex gap-2 justify-content-end">
                    <Button
                        id="cancel_button"
                        :label="$t('basic.cancel')"
                        icon="fa fa-times"
                        class="p-button-danger"
                        @click="goTo('/employees')"
                    />
                    <Button
                        id="save_button"
                        :label="$t('basic.save')"
                        :disabled="loadingData"
                        icon="fa fa-floppy-disk"
                        class="p-button-success"
                        @click="validateForm"
                    />
                </div>
            </LoadingScreen>
        </div>
    </user-layout>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
import EmployeeMixin from '@/mixins/employee'
export default {
    name: 'NewEmployeePage',
    mixins: [EmployeeMixin],
    setup: () => ({ v$: useVuelidate() }),
    created() {
        this.getDepartments()
        this.getPublicUsers()
        this.getEmployeeNumber()
    },
    validations() {
        return {
            employee: {
                number: { required },
                first_name: { required },
                last_name: { required },
                email: { required, email },
            },
        }
    },

    methods: {
        validateForm() {
            this.v$.$validate()
            if (this.v$.$error) {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }
            return this.saveEmployee()
        },
    },
}
</script>

<style></style>
