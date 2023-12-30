<template>
    <admin-layout>
        <div id="admin-departments">
            <loadingScreen :blocked="loadingData">
                <user-header :title="$t('admin.department.title')">
                    <template #actions>
                        <header-action-button
                            icon="fa fa-plus"
                            to="/admin/departments/new"
                            :label="$t('admin.department.new_department')"
                        />
                    </template>
                </user-header>

                <div id="departments_table" class="card">
                    <DataTable
                        :value="departments"
                        :loading="loadingData"
                        paginator
                        data-key="id"
                        :rows="10"
                        paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                        :rows-per-page-options="[10, 20, 50]"
                        @row-dblclick="editDepartmentNavigation"
                    >
                        <template #empty>
                            <div class="p-4 pl-0 text-center w-full text-gray-500">
                                <i class="fa fa-info-circle empty-icon"></i>
                                <p>{{ $t('admin.department.no_departments') }}</p>
                                <Button
                                    class="mt-3"
                                    :label="$t('admin.department.new_department')"
                                    icon="fa fa-plus"
                                    @click="$router.push('/admin/departments/new')"
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
            </loadingScreen>
        </div>
    </admin-layout>
</template>

<script>
import DepartmentsMixin from '@/mixins/admin/departments'
export default {
    name: 'AdminDepartments',
    mixins: [DepartmentsMixin],
    created() {
        this.getDepartments()
    },
    methods: {
        editDepartmentNavigation(rowData) {
            this.$router.push(`/admin/departments/${rowData.data.id}`)
        },
    },
}
</script>

<style></style>
