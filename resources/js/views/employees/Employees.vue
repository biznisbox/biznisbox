<template>
    <user-layout>
        <div id="employees">
            <user-header :title="$t('employee.employee', 2)">
                <template #actions>
                    <HeaderActionButton :label="$t('employee.new_employee')" icon="fa fa-plus" to="/employees/new" />
                </template>
            </user-header>
            <div id="employee_table" class="card">
                <DataTable
                    :value="employees"
                    :loading="loadingData"
                    paginator
                    data-key="id"
                    :rows="10"
                    paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    :rows-per-page-options="[10, 20, 50]"
                    @row-dblclick="viewEmployeeNavigation"
                >
                    <template #empty>
                        <div class="p-4 pl-0 text-center w-full text-gray-500">
                            <i class="fa fa-info-circle empty-icon"></i>
                            <p>{{ $t('employee.no_employees') }}</p>
                            <Button
                                class="mt-3"
                                :label="$t('employee.create_first_employee')"
                                icon="fa fa-plus"
                                @click="$router.push('/employees/new')"
                            />
                        </div>
                    </template>

                    <Column field="number" :header="$t('form.number')" />
                    <Column :header="$t('form.name')">
                        <template #body="{ data }">
                            <span>{{ data.first_name }} {{ data.last_name }}</span>
                        </template>
                    </Column>
                    <Column field="email" :header="$t('form.email')" />
                    <template #paginatorstart>
                        <div>
                            <Button class="p-button-rounded p-button-text p-button-plain" icon="fa fa-sync" @click="getEmployees" />
                        </div>
                    </template>
                </DataTable>
            </div>
        </div>
    </user-layout>
</template>

<script>
import EmployeeMixin from '@/mixins/employee'
export default {
    name: 'EmployeesPage',
    mixins: [EmployeeMixin],
    created() {
        this.getEmployees()
    },

    methods: {
        viewEmployeeNavigation(rowData) {
            this.$router.push(`/employees/${rowData.data.id}`)
        },
    },
}
</script>

<style></style>
