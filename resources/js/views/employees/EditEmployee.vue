<template>
    <DefaultLayout>
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="$t('employee.new_employee')" />

            <div class="card">
                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <TextInput
                            id="number_input"
                            v-model="v$.employee.number.$model"
                            :label="$t('form.number')"
                            disabled
                            :validate="v$.employee.number"
                        />
                        <SelectInput
                            id="department_select"
                            v-model="employee.department_id"
                            :options="departments"
                            option-value="id"
                            option-label="name"
                            :label="$t('form.department')"
                        />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <TextInput
                            id="first_name_input"
                            v-model="v$.employee.first_name.$model"
                            :label="$t('form.first_name')"
                            :validate="v$.employee.first_name"
                        />
                        <TextInput
                            id="last_name_input"
                            v-model="v$.employee.last_name.$model"
                            :label="$t('form.last_name')"
                            :validate="v$.employee.last_name"
                        />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <TextInput
                            id="email_input"
                            v-model="v$.employee.email.$model"
                            :label="$t('form.email')"
                            :validate="v$.employee.email"
                        />
                        <TextInput id="phone_input" v-model="employee.phone_number" :label="$t('form.phone_number')" />
                    </div>

                    <div id="address_inputs">
                        <TextAreaInput id="address_input" v-model="employee.address" :label="$t('form.address')" />
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <TextInput id="zip_code_input" v-model="employee.zip_code" :label="$t('form.zip_code')" />
                            <TextInput id="city_input" v-model="employee.city" :label="$t('form.city')" />
                        </div>
                        <CountrySelect id="country_select" v-model="employee.country" :label="$t('form.country')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <TextInput id="position_input" v-model="employee.position" :label="$t('form.position')" />
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <TextInput id="salary_input" v-model="employee.salary" :label="$t('form.salary')" />
                        <TextInput id="hourly_rate_input" v-model="employee.hourly_rate" :label="$t('form.hourly_rate')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <DateInput id="start_date_input" v-model="employee.contract_start_date" :label="$t('form.start_date')" />
                        <DateInput id="end_date_input" v-model="employee.contract_end_date" :label="$t('form.end_date')" />
                    </div>

                    <SelectInput
                        id="username_select"
                        v-model="employee.user_id"
                        :options="users"
                        option-value="id"
                        option-label="full_name"
                        :label="$t('form.internal_user')"
                        filter
                    />
                </form>
            </div>
            <div id="function_buttons" class="flex justify-end gap-2 mt-4">
                <Button
                    id="cancel_button"
                    :label="$t('basic.cancel')"
                    icon="fa fa-times"
                    severity="secondary"
                    @click="goTo('/employees')"
                />
                <Button
                    id="save_button"
                    :label="$t('basic.save')"
                    :disabled="loadingData"
                    icon="fa fa-floppy-disk"
                    severity="success"
                    @click="validateForm(employee.id)"
                />
            </div>
        </LoadingScreen>
    </DefaultLayout>
</template>

<script>
import { required } from '@/plugins/i18n-validators'
import { useVuelidate } from '@vuelidate/core'
import EmployeesMixin from '@/mixins/employees'
export default {
    name: 'CreateEmployeePage',
    mixins: [EmployeesMixin],
    methods: {
        validateForm(id) {
            this.v$.employee.$touch()
            if (this.v$.employee.$invalid) {
                this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
                return
            }

            this.updateEmployee(id)
        },
    },
    created() {
        this.getDepartments()
        this.getPublicUsers()
        this.getEmployee(this.$route.params.id)
    },
    setup() {
        return { v$: useVuelidate() }
    },

    validations() {
        return {
            employee: {
                number: { required },
                first_name: { required },
                last_name: { required },
                email: { required },
            },
        }
    },
}
</script>
