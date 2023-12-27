<template>
    <user-layout>
        <div id="view_employee_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="employee.first_name + ' ' + employee.last_name">
                    <template #actions>
                        <Button :label="$t('basic.edit')" icon="fa fa-pen" class="p-button-success" @click="editEmployeeNavigate" />
                        <Button
                            :label="$t('basic.delete')"
                            icon="fa fa-trash"
                            class="p-button-danger"
                            @click="deleteEmployeeAsk($route.params.id)"
                        />
                    </template>
                </user-header>
                <div class="grid">
                    <div class="col-12 md:col-4">
                        <div class="card">
                            <div class="card-header">
                                <h3>{{ $t('employee.employee_details') }}</h3>
                            </div>
                            <DisplayData :input="$t('form.first_name')" :value="employee.first_name" />
                            <DisplayData :input="$t('form.last_name')" :value="employee.last_name" />
                            <DisplayData :input="$t('form.number')" :value="employee.number" />
                            <DisplayData :input="$t('form.email')" :value="employee.email" />
                            <DisplayData :input="$t('form.phone_number')" :value="employee.phone_number" />
                        </div>
                    </div>
                    <div class="col-12 md:col-8">
                        <div class="card">
                            <TabView id="employee_tabs">
                                <TabPanel :header="$t('form.address')">
                                    <DisplayData :input="$t('form.address')" :value="employee.address" />
                                    <DisplayData :input="$t('form.zip_code')" :value="employee.zip_code" />
                                    <DisplayData :input="$t('form.city')" :value="employee.city" />
                                    <DisplayData :input="$t('form.country')" :value="employee.country" />
                                </TabPanel>
                                <TabPanel :header="$t('employee.contract', 2)">
                                    <DisplayData :input="$t('form.position')" :value="employee.position" />
                                    <DisplayData
                                        v-if="employee.department_id"
                                        :input="$t('form.department')"
                                        :value="employee?.department.name"
                                    />
                                    <DisplayData v-if="employee.type" :input="$t('form.type')" custom-value>
                                        <Badge
                                            :value="$t('employee_type.' + employee.type)"
                                            :class="employee.type == 'full_time' ? 'p-badge-success' : 'p-badge-info'"
                                        />
                                    </DisplayData>
                                    <div class="grid">
                                        <div class="col-12 md:col-6">
                                            <DisplayData :input="$t('form.salary')" :value="employee.salary" />
                                        </div>
                                        <div class="col-12 md:col-6">
                                            <DisplayData :input="$t('form.hourly_rate')" :value="employee.hourly_rate" />
                                        </div>
                                    </div>
                                    <DisplayData v-if="employee.level" :input="$t('form.level')" custom-value>
                                        <Badge :value="$t('employee_level.' + employee.level)" class="p-badge-info" />
                                    </DisplayData>
                                    <DisplayData v-if="employee.contract_type" :input="$t('form.contract_type')" custom-value>
                                        <Badge :value="$t('contract_type.' + employee.contract_type)" class="p-badge-info" />
                                    </DisplayData>
                                    <div class="grid">
                                        <div class="col-12 md:col-6">
                                            <DisplayData :input="$t('form.start_date')" :value="formatDate(employee.contract_start_date)" />
                                        </div>
                                        <div class="col-12 md:col-6">
                                            <DisplayData :input="$t('form.end_date')" :value="formatDate(employee.contract_end_date)" />
                                        </div>
                                    </div>
                                </TabPanel>
                            </TabView>
                        </div>
                    </div>
                </div>
                <div id="function_buttons" class="flex gap-2 justify-content-end">
                    <Button :label="$t('basic.close')" icon="fa fa-times" class="p-button-danger" @click="goTo('/employees')" />
                </div>
            </LoadingScreen>
        </div>
    </user-layout>
</template>

<script>
import EmployeeMixin from '@/mixins/employee'
export default {
    name: 'ViewEmployeePage',
    mixins: [EmployeeMixin],
    created() {
        this.getEmployee(this.$route.params.id)
    },
    methods: {
        editEmployeeNavigate() {
            this.$router.push({
                name: 'edit-employee',
                params: { id: this.$route.params.id },
            })
        },
    },
}
</script>

<style>
.p-tabview-panels {
    border: none;
    padding: 5px !important;
}
</style>
