<template>
    <DefaultLayout>
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="employee.first_name + ' ' + employee.last_name">
                <template #actions>
                    <Button
                        :label="$t('basic.edit')"
                        icon="fa fa-pen"
                        severity="success"
                        @click="$router.push({ name: 'employee-edit', params: { id: $route.params.id } })"
                    />
                    <Button :label="$t('basic.delete')" icon="fa fa-trash" severity="danger" @click="deleteEmployeeAsk($route.params.id)" />
                    <Button :label="$t('audit_log.audit_log')" icon="fa fa-history" severity="info" @click="showAuditLogDialog = true" />
                </template>
            </PageHeader>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <div class="card">
                        <div class="font-bold text-lg">
                            <h3>{{ $t('employee.employee_details') }}</h3>
                        </div>
                        <DisplayData :input="$t('form.number')" :value="employee.number" />
                        <DisplayData :input="$t('form.first_name')" :value="employee.first_name" />
                        <DisplayData :input="$t('form.last_name')" :value="employee.last_name" />
                        <DisplayData :input="$t('form.email')" :value="employee.email" />
                        <DisplayData :input="$t('form.phone_number')" :value="employee.phone_number" />
                    </div>
                </div>

                <div>
                    <div class="card">
                        <Tabs value="address">
                            <TabList>
                                <Tab value="address">{{ $t('form.address') }}</Tab>
                                <Tab value="contract">{{ $t('employee.contract', 2) }} </Tab>
                            </TabList>

                            <TabPanel value="address">
                                <DisplayData :input="$t('form.address')" :value="employee.address" />
                                <DisplayData :input="$t('form.zip_code')" :value="employee.zip_code" />
                                <DisplayData :input="$t('form.city')" :value="employee.city" />
                                <DisplayData :input="$t('form.country')" :value="employee.country" />
                            </TabPanel>
                            <TabPanel value="contract">
                                <DisplayData :input="$t('form.position')" :value="employee.position" />
                                <DisplayData
                                    v-if="employee.department_id"
                                    :input="$t('form.department')"
                                    :value="employee?.department?.name"
                                />
                                <DisplayData v-if="employee.type" :input="$t('form.type')" custom-value>
                                    <Tag
                                        :value="$t('employee_type.' + employee.type)"
                                        :severity="employee.type == 'full_time' ? 'success' : 'info'"
                                    />
                                </DisplayData>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <DisplayData v-if="employee.salary" :input="$t('form.salary')" :value="formatMoney(employee.salary)" />
                                    <DisplayData
                                        v-if="employee.hourly_rate"
                                        :input="$t('form.hourly_rate')"
                                        :value="formatMoney(employee.hourly_rate)"
                                    />
                                </div>
                                <DisplayData v-if="employee.level" :input="$t('form.level')" custom-value>
                                    <Tag :value="$t('employee_level.' + employee.level)" severity="info" />
                                </DisplayData>
                                <DisplayData v-if="employee.contract_type" :input="$t('form.contract_type')" custom-value>
                                    <Tag :value="$t('contract_type.' + employee.contract_type)" severity="info" />
                                </DisplayData>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <DisplayData
                                        v-if="employee.contract_start_date"
                                        :input="$t('form.start_date')"
                                        :value="formatDate(employee.contract_start_date)"
                                    />
                                    <DisplayData
                                        v-if="employee.contract_end_date"
                                        :input="$t('form.end_date')"
                                        :value="formatDate(employee.contract_end_date)"
                                    />
                                </div>
                            </TabPanel>
                        </Tabs>
                    </div>
                </div>
            </div>
            <div id="function_buttons" class="flex justify-end gap-2 mt-4">
                <Button :label="$t('basic.close')" icon="fa fa-times" severity="secondary" @click="goTo('/employees')" />
            </div>
        </LoadingScreen>

        <!-- Audit Log Dialog -->
        <Dialog
            v-model:visible="showAuditLogDialog"
            modal
            maximizable
            class="w-full m-2 lg:w-1/2"
            :header="$t('audit_log.audit_log')"
            :draggable="false"
        >
            <AuditLog :item_id="$route.params.id" item_type="Employee" />
        </Dialog>
    </DefaultLayout>
</template>

<script>
import EmployeesMixin from '@/mixins/employees'
export default {
    name: 'EmployeesPage',
    mixins: [EmployeesMixin],
    methods: {},
    created() {
        this.getEmployee(this.$route.params.id)
    },
    data() {
        return {
            showAuditLogDialog: false,
        }
    },
}
</script>
<style></style>
