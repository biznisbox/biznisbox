<template>
    <admin-layout>
        <div id="admin-roles">
            <loadingScreen :blocked="loadingData">
                <user-header :title="$t('admin.role.title')">
                    <template #actions>
                        <header-action-button icon="fa fa-plus" to="/admin/roles/new" :label="$t('admin.role.new_role')" />
                    </template>
                </user-header>

                <div id="roles_table" class="card">
                    <DataTable :value="roles" @row-dblclick="editRoleNavigation">
                        <template #empty>
                            <div class="p-4 pl-0 text-center w-full text-gray-500">
                                <i class="fa fa-info-circle empty-icon"></i>
                                <p>{{ $t('admin.role.no_roles') }}</p>
                                <Button
                                    class="mt-3"
                                    :label="$t('admin.role.create_first_role')"
                                    icon="fa fa-plus"
                                    @click="$router.push('/admin/roles/new')"
                                />
                            </div>
                        </template>
                        <Column field="display_name" :header="$t('form.name')" sortable />
                        <Column field="description" :header="$t('form.description')" sortable />
                    </DataTable>
                </div>
            </loadingScreen>
        </div>
    </admin-layout>
</template>

<script>
import RoleMixin from '@/mixins/admin/roles'
export default {
    name: 'AdminRoles',
    mixins: [RoleMixin],

    created() {
        this.getRoles()
    },

    methods: {
        editRoleNavigation(rowData) {
            this.$router.push(`/admin/roles/${rowData.data.id}`)
        },
    },
}
</script>

<style></style>
