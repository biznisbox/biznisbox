<template>
    <admin-layout>
        <div id="admin-roles">
            <user-header :title="$t('admin.role.title')">
                <template #actions>
                    <header-action-button icon="fa fa-plus" to="/admin/roles/new" :label="$t('admin.role.new_role')" />
                </template>
            </user-header>

            <div id="roles_table" class="card">
                <DataTable
                    :value="roles"
                    :loading="loadingData"
                    paginator
                    data-key="id"
                    :rows="10"
                    paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    :rows-per-page-options="[10, 20, 50]"
                    @row-dblclick="editRoleNavigation"
                >
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
                    <Column field="display_name" :header="$t('form.name')" />
                    <Column field="description" :header="$t('form.description')" />
                </DataTable>
            </div>
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
