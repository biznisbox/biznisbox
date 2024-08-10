<template>
    <DefaultLayout menu_type="admin">
        <PageHeader :title="$t('admin.department.title')">
            <template #actions>
                <Button
                    icon="fa fa-plus"
                    @click="$router.push({ name: 'admin-department-create' })"
                    :label="$t('admin.department.new_department')"
                />
            </template>
        </PageHeader>

        <div id="departments_table" class="card">
            <DataTable
                :value="departments"
                :loading="loadingData"
                paginator
                data-key="id"
                :rows="10"
                paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                :rows-per-page-options="[10, 20, 50]"
                @row-dblclick="viewDepartmentNavigation"
            >
                <template #empty>
                    <div class="p-4 pl-0 text-center w-full">
                        <i class="fa fa-info-circle empty-icon"></i>
                        <p>{{ $t('admin.department.no_departments') }}</p>
                        <Button
                            class="mt-3"
                            :label="$t('admin.department.new_department')"
                            icon="fa fa-plus"
                            @click="$router.push({ name: 'admin-department-create' })"
                        />
                    </div>
                </template>
                <Column field="name" :header="$t('form.name')" />
                <Column field="description" :header="$t('form.description')" />
                <Column :header="$t('form.address')">
                    <template #body="{ data }">
                        <span>{{ formatText(data.address) }}</span> <br />
                        <span>{{ formatText(data.zip_code) + ' ' + formatText(data.city) }}</span> <br />
                        <span>{{ formatText(data.country) }}</span>
                    </template>
                </Column>
            </DataTable>
        </div>
    </DefaultLayout>
</template>

<script>
import DepartmentsMixin from '@/mixins/admin/departments'
export default {
    name: 'AdminDepartmentsPage',
    mixins: [DepartmentsMixin],
    created() {
        this.getDepartments()
    },
    methods: {
        viewDepartmentNavigation(rowData) {
            this.$router.push({ name: 'admin-department-view', params: { id: rowData.data.id } })
        },
    },
}
</script>

<style></style>
