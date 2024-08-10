<template>
    <DefaultLayout menu_type="admin">
        <PageHeader :title="$t('admin.user.user', 2)">
            <template #actions>
                <Button :label="$t('admin.user.new_user')" icon="fa fa-plus" @click="$router.push({ name: 'admin-user-create' })" />
            </template>
        </PageHeader>

        <div id="users_table" class="card">
            <DataTable
                :value="users"
                paginator
                dataKey="id"
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50, 100]"
                :loading="loadingData"
                @row-dblclick="viewUserNavigation"
                filter-display="menu"
                v-model:filters="filters"
            >
                <template #empty>
                    <div class="p-4 pl-0 text-center w-full">
                        <i class="fa fa-info-circle empty-icon"></i>
                        <p>{{ $t('admin.user.no_users') }}</p>
                        <Button
                            class="mt-3"
                            :label="$t('admin.user.create_first_user')"
                            icon="fa fa-plus"
                            @click="$router.push({ name: 'admin-user-create' })"
                        />
                    </div>
                </template>

                <Column field="name" :header="$t('form.name')">
                    <template #body="{ data }">
                        <div class="flex items-center">
                            <Avatar v-if="data.avatar_url" :image="data.avatar_url" class="avatar" />
                            <span>{{ data.first_name + ' ' + data.last_name }}</span>
                        </div>
                    </template>

                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" placeholder="Search by name" />
                    </template>
                </Column>
                <Column field="email" :header="$t('form.email')">
                    <template #body="{ data }">
                        {{ data.email }}
                    </template>
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" placeholder="Search by email" />
                    </template>
                </Column>
                <Column field="role" :header="$t('form.role')">
                    <template #body="{ data }">
                        <Tag :value="data.roles?.[0]?.display_name" v-if="data.roles?.[0]" />
                    </template>
                </Column>

                <Column field="active" :header="$t('form.active')">
                    <template #body="{ data }">
                        <Tag v-if="data.active" :value="$t('status.active')" severity="success" />
                        <Tag v-if="!data.active" :value="$t('status.inactive')" severity="danger" />
                    </template>

                    <template #filter="{ filterModel }">
                        <Dropdown
                            v-model="filterModel.value"
                            :options="[
                                { label: $t('status.active'), value: true },
                                { label: $t('status.inactive'), value: false },
                            ]"
                            option-label="label"
                            option-value="value"
                            placeholder="Search by status"
                        />
                    </template>
                </Column>
                <template #paginatorstart>
                    <Button icon="fa fa-sync" @click="getUsers" />
                </template>
            </DataTable>
        </div>
    </DefaultLayout>
</template>

<script>
import { FilterMatchMode, FilterOperator } from '@primevue/core/api'
import AdminUserMixin from '@/mixins/admin/users'
export default {
    name: 'AdminUsersPage',
    mixins: [AdminUserMixin],

    data() {
        return {
            filters: null,
        }
    },

    created() {
        this.getUsers()
        this.initFilters()
    },

    methods: {
        viewUserNavigation(event) {
            this.$router.push({ name: 'admin-user-view', params: { id: event.data.id } })
        },

        initFilters() {
            this.filters = {
                name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                email: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                active: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
            }
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
