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
                    v-model:filters="filters"
                    :value="users"
                    :loading="loadingData"
                    paginator
                    data-key="id"
                    filter-display="menu"
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

                    <Column field="name" :header="$t('form.name')">
                        <template #body="{ data }">
                            {{ data.first_name + ' ' + data.last_name }}
                        </template>

                        <template #filter="{ filterModel }">
                            <div class="flex">
                                <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by name" />
                            </div>
                        </template>
                    </Column>
                    <Column field="email" :header="$t('form.email')">
                        <template #body="{ data }">
                            {{ data.email }}
                        </template>
                        <template #filter="{ filterModel }">
                            <div class="flex">
                                <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by email" />
                            </div>
                        </template>
                    </Column>
                    <Column field="role" :header="$t('form.role')">
                        <template #body="{ data }">
                            <Tag v-if="data.roles[0]" :value="data.roles[0]?.display_name" />
                            <Tag v-else severity="danger" :value="$t('admin.user.no_roles')" />
                        </template>
                    </Column>

                    <Column field="active" :header="$t('form.active')">
                        <template #body="slotProps">
                            <Tag v-if="slotProps.data.active" :value="$t('status.active')" severity="success" />
                            <Tag v-if="!slotProps.data.active" :value="$t('status.inactive')" severity="danger" />
                        </template>

                        <template #filter="{ filterModel }">
                            <div class="flex">
                                <Dropdown
                                    v-model="filterModel.value"
                                    :options="[
                                        { label: $t('status.active'), value: true },
                                        { label: $t('status.inactive'), value: false },
                                    ]"
                                    option-label="label"
                                    option-value="value"
                                    class="p-column-filter"
                                    placeholder="Search by status"
                                />
                            </div>
                        </template>
                    </Column>
                    <template #paginatorstart>
                        <Button class="p-button-rounded p-button-text p-button-plain" icon="fa fa-sync" @click="getUsers" />
                    </template>
                </DataTable>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import { FilterMatchMode, FilterOperator } from 'primevue/api'
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
            this.$router.push('/admin/users/' + event.data.id)
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

<style></style>
