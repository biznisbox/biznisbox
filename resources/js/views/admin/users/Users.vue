<template>
    <admin-layout>
        <div id="admin_users_page">
            <user-header :title="$t('admin.user.user', 2)">
                <template #actions>
                    <header-action-button icon="fa fa-plus" to="/admin/users/new" :label="$t('admin.user.new_user')" />
                </template>
            </user-header>

            <div id="users_table" class="card">
                <DataTable
                    :value="users"
                    :loading="loadingData"
                    paginator
                    :rows="10"
                    paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    :rows-per-page-options="[10, 20, 50]"
                    @row-dblclick="viewUserNavigation"
                >
                    <template #empty>
                        <div class="p-4 pl-0 text-center w-full text-gray-500">
                            <i class="fa fa-info-circle empty-icon"></i>
                            <p>{{ $t('admin.user.no_users') }}</p>
                            <Button
                                class="mt-3"
                                :label="$t('admin.user.create_first_user')"
                                icon="fa fa-plus"
                                @click="$router.push('/admin/users/new')"
                            />
                        </div>
                    </template>

                    <Column :header="$t('admin.user.name')" sortable>
                        <template #body="slotProps">
                            <span> {{ slotProps.data.first_name + ' ' + slotProps.data.last_name }}</span>
                        </template>
                    </Column>
                    <Column field="email" :header="$t('admin.user.email')" sortable></Column>
                    <Column field="role" :header="$t('admin.user.role')" sortable>
                        <template #body="slotProps">
                            <Tag v-if="slotProps.data.roles[0]" :value="slotProps.data.roles[0]?.display_name" />
                            <Tag v-else severity="danger" :value="$t('admin.user.no_roles')" />
                        </template>
                    </Column>

                    <Column field="active" :header="$t('admin.user.active')" sortable>
                        <template #body="slotProps">
                            <Tag v-if="slotProps.data.active" :value="$t('status.active')" severity="success" />
                            <Tag v-if="!slotProps.data.active" :value="$t('status.inactive')" severity="danger" />
                        </template>
                    </Column>
                    <template #paginatorstart>
                        <div class="p-d-flex p-ai-center p-mr-2">
                            <Button class="p-button-rounded p-button-text p-button-plain" icon="fa fa-sync" @click="getUsers" />
                        </div>
                    </template>
                </DataTable>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import AdminUserMixin from '@/mixins/admin/users'
export default {
    name: 'AdminUsersPage',
    mixins: [AdminUserMixin],

    created() {
        this.getUsers()
    },

    methods: {
        viewUserNavigation(event) {
            this.$router.push('/admin/users/' + event.data.id)
        },
    },
}
</script>

<style></style>
