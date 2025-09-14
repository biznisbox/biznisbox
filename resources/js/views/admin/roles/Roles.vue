<template>
    <DefaultLayout menu_type="admin">
        <PageHeader :title="$t('admin.role.title')">
            <template #actions>
                <Button icon="fa fa-plus" :label="$t('admin.role.new_role')" @click="$router.push({ name: 'admin-role-create' })" />
            </template>
        </PageHeader>

        <div id="roles_table" class="card">
            <DataTable
                :value="roles"
                paginator
                dataKey="id"
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50, 100]"
                :loading="loadingData"
                @row-dblclick="viewRoleNavigation"
                filter-display="menu"
            >
                <template #empty>
                    <div class="p-4 pl-0 text-center w-full dark:text-gray-400">
                        <i class="fa fa-info-circle empty-icon"></i>
                        <p>{{ $t('admin.role.no_roles') }}</p>
                        <Button
                            class="mt-3"
                            :label="$t('admin.role.create_first_role')"
                            icon="fa fa-plus"
                            @click="$router.push({ name: 'admin-role-create' })"
                        />
                    </div>
                </template>
                <Column field="display_name" :header="$t('form.name')">
                    <template #body="{ data }">
                        <span>{{ data.display_name }}</span>
                        <Tag v-if="data.system" class="ml-2" :value="$t('basic.system')" />
                    </template>
                </Column>
                <Column field="description" :header="$t('form.description')" />

                <template #paginatorstart>
                    <Button icon="fa fa-sync" @click="getRoles" />
                </template>
            </DataTable>
        </div>
    </DefaultLayout>
</template>

<script>
import RoleMixin from '@/mixins/admin/roles'
export default {
    name: 'AdminRolesPage',
    mixins: [RoleMixin],

    created() {
        this.getRoles()
    },

    methods: {
        viewRoleNavigation(rowData) {
            this.$router.push({ name: 'admin-role-view', params: { id: rowData.data.id } })
        },
    },
}
</script>
