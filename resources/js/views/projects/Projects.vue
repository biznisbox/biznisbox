<template>
    <DefaultLayout>
        <PageHeader :title="$t('project.project', 3)">
            <template v-slot:actions>
                <Button :label="$t('project.new_project')" icon="fa fa-plus" @click="openCreateProjectDialog" />
            </template>
        </PageHeader>

        <div id="projects_table" class="card">
            <DataTable
                :value="projects"
                paginator
                dataKey="id"
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50, 100]"
                :loading="loadingData"
                @row-dblclick="viewProjectNavigation"
                filter-display="menu"
                v-model:filters="filters"
            >
                <template #empty>
                    <div class="p-4 pl-0 text-center w-full dark:text-gray-400">
                        <i class="fa fa-info-circle empty-icon"></i>
                        <p>{{ $t('project.no_projects') }}</p>
                        <Button
                            class="mt-3"
                            :label="$t('project.create_first_project')"
                            icon="fa fa-plus"
                            @click="openCreateProjectDialog"
                        />
                    </div>
                </template>

                <Column field="number" :header="$t('form.number')">
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" placeholder="Search by number" />
                    </template>
                </Column>
                <Column field="name" :header="$t('form.name')" sortable>
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" placeholder="Search by name" />
                    </template>
                </Column>
                <Column field="date" :header="$t('project.start_end_date')" sortable>
                    <template #body="{ data }">
                        <span>{{ data.start_date ? formatDate(data.start_date) : '' }}</span> <br />
                        <span>{{ data.end_date ? formatDate(data.end_date) : '' }}</span>
                    </template>
                    <template #filter="{ filterModel }">
                        <div class="flex">
                            <InputText v-model="filterModel.value" placeholder="Search by date" />
                        </div>
                    </template>
                </Column>
                <Column filter-field="status" :header="$t('form.status')">
                    <template #body="{ data }">
                        <Tag :value="$t(`status.${data.status}`)" :severity="getStatusSeverity(data.status)" />
                    </template>
                    <template #filter="{ filterModel }">
                        <Select
                            v-model="filterModel.value"
                            :options="[
                                { label: $t('status.draft'), value: 'draft' },
                                { label: $t('status.planned'), value: 'planned' },
                                { label: $t('status.in_progress'), value: 'in_progress' },
                                { label: $t('status.completed'), value: 'completed' },
                                { label: $t('status.on_hold'), value: 'on_hold' },
                                { label: $t('status.cancelled'), value: 'cancelled' },
                            ]"
                            option-label="label"
                            option-value="value"
                            placeholder="Select a status"
                        />
                    </template>
                </Column>
                <template #paginatorstart>
                    <Button id="refresh_button" icon="fa fa-sync" @click="getProjects" />
                </template>
            </DataTable>
        </div>

        <Dialog
            id="project_create_dialog"
            v-model:visible="showNewProjectDialog"
            :header="$t('project.new_project')"
            modal
            class="w-full m-2 lg:w-1/2"
            :draggable="false"
        >
            <LoadingScreen :blocked="loadingData">
                <form>
                    <TextInput v-model="project.name" :label="$t('form.name')" />
                    <TextInput v-model="project.project_key" :label="$t('form.project_key')" />
                    <TinyMceEditor v-model="project.description" :label="$t('form.description')" />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <DateInput v-model="project.start_date" :label="$t('form.start_date')" />
                        <DateInput v-model="project.end_date" :label="$t('form.end_date')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <SelectInput
                            v-model="project.status"
                            :options="projectStatuses"
                            :label="$t('form.status')"
                            placeholder="Select a status"
                        />

                        <SelectInput
                            v-model="project.priority"
                            :options="projectPriorities"
                            :label="$t('form.priority')"
                            placeholder="Select a priority"
                        />
                    </div>
                    <NumberInput v-model="project.budget" :label="$t('form.budget')" type="currency" />
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div class="flex flex-col gap-2 mb-2">
                            <label for="project_is_billable" class="dark:text-surface-200">{{ $t('form.is_billable') }}</label>
                            <ToggleSwitch id="project_is_billable" v-model="project.is_billable" />
                        </div>
                        <div class="flex flex-col gap-2 mb-2">
                            <label for="project_is_active" class="dark:text-surface-200">{{ $t('form.active') }}</label>
                            <ToggleSwitch v-model="project.active" :label="$t('form.active')" />
                        </div>
                    </div>
                    <SelectInput
                        v-model="project.partner_id"
                        :options="partners"
                        option-label="name"
                        option-value="id"
                        filter
                        placeholder="Select a partner"
                        :label="$t('form.partner')"
                    />
                </form>
            </LoadingScreen>

            <template #footer>
                <div id="function_buttons" class="flex gap-2 flex-wrap">
                    <div class="flex-grow"></div>
                    <div class="flex justify-content-end gap-2 flex-wrap">
                        <Button :label="$t('basic.cancel')" icon="fa fa-times" severity="secondary" @click="showNewProjectDialog = false" />
                        <Button :label="$t('basic.save')" icon="fa fa-save" @click="createProject" severity="success" />
                    </div>
                </div>
            </template>
        </Dialog>
    </DefaultLayout>
</template>

<script>
import ProjectMixin from '@/mixins/projects'
import { FilterMatchMode, FilterOperator } from '@primevue/core/api'
export default {
    name: 'ProjectsPage',
    mixins: [ProjectMixin],

    created() {
        this.getProjects()
        this.initFilters()
        this.getPartners()
        this.getProjectCategories()
    },

    methods: {
        initFilters() {
            this.filters = {
                number: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                date: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                status: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
            }
        },

        openCreateProjectDialog() {
            this.resetProjectForm()
            this.showNewProjectDialog = true
        },

        getStatusSeverity(status) {
            switch (status) {
                case 'draft':
                    return 'warn'
                case 'planned':
                    return 'info'
                case 'in_progress':
                    return 'primary'
                case 'completed':
                    return 'success'
                case 'on_hold':
                    return 'warn'
                case 'cancelled':
                    return 'danger'
                default:
                    return null
            }
        },
    },
    data() {
        return {
            filters: null,
            showNewProjectDialog: false,
        }
    },
}
</script>
