<template>
    <DefaultLayout>
        <PageHeader :title="$t('employee.employee', 3)">
            <template v-slot:actions>
                <Button :label="$t('employee.new_employee')" icon="fa fa-plus" @click="$router.push({ name: 'employee-create' })" />
            </template>
        </PageHeader>

        <div id="employee_table" class="card">
            <DataTable
                :value="employees"
                paginator
                dataKey="id"
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50, 100]"
                :loading="loadingData"
                @row-dblclick="viewEmployeeNavigation"
                filter-display="menu"
                v-model:filters="filters"
            >
                <template #empty>
                    <div class="p-4 pl-0 text-center w-full">
                        <i class="fa fa-info-circle empty-icon"></i>
                        <p>{{ $t('employee.no_employees') }}</p>
                        <Button
                            class="mt-3"
                            :label="$t('employee.create_first_employee')"
                            icon="fa fa-plus"
                            @click="$router.push('/employees/create')"
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
                        <Button icon="fa fa-sync" @click="getEmployees" id="refresh_button" />
                    </div>
                </template>
            </DataTable>
        </div>
    </DefaultLayout>
</template>

<script>
import { FilterMatchMode, FilterOperator } from '@primevue/core/api'
import EmployeesMixin from '@/mixins/employees'
export default {
    name: 'EmployeesPage',
    mixins: [EmployeesMixin],
    created() {
        this.getEmployees()
    },
    data() {
        return {
            filters: null,
        }
    },

    methods: {
        initFilters() {
            this.filters = {
                number: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                email: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
            }
        },
    },
}
</script>
<style></style>
