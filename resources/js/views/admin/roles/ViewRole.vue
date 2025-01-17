<template>
    <DefaultLayout menu_type="admin">
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="role.display_name">
                <template #actions>
                    <Button
                        v-if="!role.system"
                        :label="$t('basic.delete')"
                        icon="fa fa-trash"
                        severity="danger"
                        @click="deleteRoleAsk($route.params.id)"
                    />
                    <Button
                        v-if="!role.system"
                        :label="$t('basic.edit')"
                        icon="fa fa-pencil"
                        @click="$router.push({ name: 'admin-role-edit', params: { id: $route.params.id } })"
                        severity="success"
                    />
                    <Button :label="$t('audit_log.audit_log')" icon="fa fa-history" @click="showAuditLogDialog = true" />
                </template>
            </PageHeader>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="card">
                    <DisplayData :input="$t('form.name')" :value="role.display_name" />
                    <DisplayData :input="$t('form.system')" custom-value>
                        <Tag :value="role.system ? $t('basic.yes') : $t('basic.no')" />
                    </DisplayData>
                    <DisplayData :input="$t('form.description')" :value="role.description" />
                    <DisplayData :input="$t('form.permissions')" custom-value>
                        <div class="flex flex-wrap gap-2">
                            <div v-for="permission in permissions" :key="permission.id" class="flex items-center gap-2">
                                <Checkbox v-model="role.permissions" name="permission" :value="permission.name" class="mr-1" disabled />
                                <label :for="permission.id">{{ permission.display_name }}</label>
                            </div>
                        </div>
                    </DisplayData>
                </div>

                <div id="users" class="card">
                    <span class="text-xl font-bold">{{ $t('admin.role.users_with_role') }}</span>

                    <DataTable
                        :value="role.users"
                        paginator
                        dataKey="id"
                        :rows="10"
                        :rowsPerPageOptions="[5, 10, 20, 50, 100]"
                        :loading="loadingData"
                    >
                        <template #empty>
                            <div class="p-4 pl-0 text-center w-full">
                                <i class="fa fa-info-circle empty-icon"></i>
                                <p>{{ $t('admin.role.no_users') }}</p>
                            </div>
                        </template>
                        <Column :header="$t('form.name')">
                            <template #body="{ data }">
                                <div class="flex items-center">
                                    <Avatar v-if="data.avatar_url" :image="data.avatar_url" class="avatar" />
                                    <span>{{ data.first_name + ' ' + data.last_name }}</span>
                                </div>
                            </template>
                        </Column>
                        <Column field="email" :header="$t('form.email')" />
                    </DataTable>
                </div>
            </div>
        </LoadingScreen>

        <div id="function_buttons" class="flex gap-2 justify-end">
            <Button id="cancel_button" :label="$t('basic.cancel')" icon="fa fa-times" severity="secondary" @click="goTo('/admin/roles')" />
        </div>

        <!-- Audit log dialog -->
        <Dialog
            v-model:visible="showAuditLogDialog"
            modal
            maximizable
            class="w-full m-2 lg:w-1/2"
            :header="$t('audit_log.audit_log')"
            :draggable="false"
        >
            <AuditLog :item_id="$route.params.id" item_type="Role" :hiddenFields="['guard_name']" />
        </Dialog>
    </DefaultLayout>
</template>

<script>
import RoleMixin from '@/mixins/admin/roles'
export default {
    name: 'AdminViewRolePage',
    mixins: [RoleMixin],
    created() {
        this.getPermissions()
        this.getRole(this.$route.params.id)
    },

    data() {
        return {
            showAuditLogDialog: false,
        }
    },

    methods: {
        validateForm() {
            return this.updateRole(this.$route.params.id)
        },
    },
}
</script>

<style>
.avatar {
    background-color: transparent !important;
    margin-right: 0.5rem;
}
</style>
