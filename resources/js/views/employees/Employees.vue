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

                <Column field="number" :header="$t('form.number')" sortable>
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" placeholder="Search by number" />
                    </template>
                </Column>
                <Column :header="$t('form.name')" field="full_name">
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" placeholder="Search by name" />
                    </template>
                </Column>
                <Column field="email" :header="$t('form.email')">
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" placeholder="Search by email" />
                    </template>
                </Column>

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
        this.initFilters()
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
                full_name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                email: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
            }
        },
    },
}
</script>
<style></style>
