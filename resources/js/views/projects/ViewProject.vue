<template>
    <DefaultLayout>
        <PageHeader :title="project.name || $t('project.project')">
            <template v-slot:actions>
                <Button :label="$t('project.edit_project')" icon="fa fa-edit" @click="openEditProjectDialog" severity="success" />
                <Button :label="$t('project.add_task')" icon="fa fa-plus" @click="openNewTaskDialog" />
                <Button :label="$t('project.project_members')" icon="fa fa-users" @click="showProjectMembersDialog = true" />
            </template>
        </PageHeader>

        <Tabs :value="activeTab">
            <TabList>
                <Tab value="tasks">{{ $t('project.tasks') }} ({{ project.tasks ? project.tasks.length : 0 }})</Tab>
            </TabList>

            <TabPanels>
                <TabPanel value="tasks">
                    <div id="tasks_table" class="card">
                        <DataTable
                            :value="project.tasks"
                            paginator
                            dataKey="id"
                            :rows="10"
                            :rowsPerPageOptions="[5, 10, 20, 50, 100]"
                            :loading="loadingData"
                            filter-display="menu"
                            v-model:filters="taskFilters"
                            @row-dblclick="openEditTaskDialog"
                        >
                            <template #empty>
                                <div class="p-4 pl-0 text-center w-full dark:text-gray-400">
                                    <i class="fa fa-info-circle empty-icon"></i>
                                    <p>{{ $t('project.no_tasks') }}</p>
                                    <Button class="mt-3" :label="$t('project.create_task')" icon="fa fa-plus" @click="openNewTaskDialog" />
                                </div>
                            </template>

                            <Column field="number" :header="$t('form.number')" sortable>
                                <template #body="{ data }">
                                    {{ data.number }}
                                </template>
                            </Column>

                            <Column field="title" :header="$t('form.title')" sortable>
                                <template #filter="{ filterModel }">
                                    <InputText v-model="filterModel.value" placeholder="Search by title" />
                                </template>
                            </Column>
                            <Column field="type" :header="$t('form.type')" sortable>
                                <template #body="{ data }">
                                    <Tag :value="$t(`task_type.${data.type}`)" />
                                </template>
                                <template #filter="{ filterModel }">
                                    <Select v-model="filterModel.value" :options="taskTypes" placeholder="Select a type" />
                                </template>
                            </Column>
                            <Column field="status" :header="$t('form.status')">
                                <template #body="{ data }">
                                    <Tag :value="$t(`status.${data.status}`)" :severity="getStatusSeverity(data.status)" />
                                </template>
                                <template #filter="{ filterModel }">
                                    <Select
                                        v-model="filterModel.value"
                                        option-label="label"
                                        option-value="value"
                                        :options="projectStatuses"
                                        placeholder="Select a status"
                                    />
                                </template>
                            </Column>
                            <Column field="priority" :header="$t('form.priority')">
                                <template #body="{ data }">
                                    <Tag :value="$t(`priority.${data.priority}`)" :severity="getStatusSeverity(data.priority)" />
                                </template>
                                <template #filter="{ filterModel }">
                                    <Select
                                        v-model="filterModel.value"
                                        option-label="label"
                                        option-value="value"
                                        :options="projectPriorities"
                                        placeholder="Select a priority"
                                    />
                                </template>
                            </Column>
                            <Column field="due_date" :header="$t('form.due_date')" sortable>
                                <template #body="{ data }">
                                    <span>{{ data.due_date ? formatDate(data.due_date) : '' }}</span>
                                </template>
                                <template #filter="{ filterModel }">
                                    <div class="flex">
                                        <InputText v-model="filterModel.value" placeholder="Search by due date" />
                                    </div>
                                </template>
                            </Column>
                            <Column field="progress_in_percent" :header="$t('form.progress_in_percent')" sortable>
                                <template #body="{ data }">
                                    <ProgressBar :value="data.progress_in_percent" :showValue="true" />
                                </template>
                            </Column>
                        </DataTable>
                    </div>
                </TabPanel>
            </TabPanels>
        </Tabs>

        <!-- Edit Project Dialog -->
        <Dialog
            id="project_edit_dialog"
            v-model:visible="showEditProjectDialog"
            :header="$t('project.edit_project')"
            modal
            class="w-full m-2 lg:w-1/2"
            :draggable="false"
        >
            <LoadingScreen :blocked="loadingData">
                <form>
                    <TextInput v-model="project.name" :label="$t('form.name')" />
                    <TextInput v-model="project.project_key" :label="$t('form.project_key')" disabled />
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
                        <Button :label="$t('basic.save')" icon="fa fa-save" @click="updateProject" severity="success" />
                    </div>
                </div>
            </template>
        </Dialog>

        <!-- New edit task Dialog -->
        <Dialog
            id="task_new_edit_dialog"
            v-model:visible="showNewEditTaskDialog"
            modal
            class="w-full m-2 lg:w-1/2"
            :draggable="false"
            :header="isEditTask ? $t('project.edit_task') : $t('project.add_task')"
        >
            <LoadingScreen :blocked="loadingData">
                <form>
                    <TextInput v-model="task.title" :label="$t('form.title')" />
                    <SelectInput
                        v-model="task.type"
                        :options="taskTypes"
                        :label="$t('form.type')"
                        placeholder="Select a type"
                        showClear
                        filter
                    />
                    <SelectInput
                        v-model="task.category"
                        :options="taskCategories"
                        filter
                        showClear
                        option-label="name"
                        option-value="id"
                        :label="$t('form.category')"
                        placeholder="Select a category"
                    />
                    <TinyMceEditor v-model="task.description" :label="$t('form.description')" />
                    <TextAreaInput v-model="task.notes" :label="$t('form.notes')" />
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <DateInput v-model="task.start_date" :label="$t('form.start_date')" />
                        <DateInput v-model="task.due_date" :label="$t('form.due_date')" />
                    </div>
                    <DateInput v-model="task.completed_at" :label="$t('form.completed_at')" />
                    <NumberInput v-model="task.progress_in_percent" :show-buttons="true" :label="$t('form.progress_in_percent')" />

                    <SelectInput
                        v-model="task.assigned_to"
                        :options="project.members"
                        option-label="full_name"
                        option-value="id"
                        filter
                        :label="$t('form.assigned_to')"
                        placeholder="Select an assignee"
                    />

                    <SelectInput
                        v-model="task.status"
                        :options="projectStatuses"
                        :label="$t('form.status')"
                        placeholder="Select a status"
                    />

                    <SelectInput
                        v-model="task.priority"
                        :options="projectPriorities"
                        :label="$t('form.priority')"
                        placeholder="Select a priority"
                    />

                    <div class="flex flex-col gap-2 mb-2">
                        <label for="task_is_active" class="dark:text-surface-200">{{ $t('form.active') }}</label>
                        <ToggleSwitch id="task_is_active" v-model="task.active" :label="$t('form.active')" />
                    </div>
                </form>
            </LoadingScreen>
            <template #footer>
                <div id="function_buttons" class="flex gap-2 flex-wrap">
                    <Button
                        :label="$t('basic.delete')"
                        icon="fa fa-trash"
                        severity="danger"
                        @click="deleteTaskAsk(task.id)"
                        v-if="isEditTask"
                    />
                    <div class="flex-grow"></div>
                    <div class="flex justify-content-end gap-2 flex-wrap">
                        <Button
                            :label="$t('basic.cancel')"
                            icon="fa fa-times"
                            severity="secondary"
                            @click="showNewEditTaskDialog = false"
                        />
                        <Button
                            :label="$t('basic.save')"
                            icon="fa fa-save"
                            @click="isEditTask ? updateTask(task.id) : createTask()"
                            severity="success"
                        />
                    </div>
                </div>
            </template>
        </Dialog>

        <!-- Members Dialog -->
        <Dialog
            id="project_members_dialog"
            v-model:visible="showProjectMembersDialog"
            :header="$t('project.project_members')"
            modal
            class="w-full m-2 lg:w-1/2"
            :draggable="false"
        >
            <LoadingScreen :blocked="loadingData">
                <form>
                    <DataTable
                        :value="project.members"
                        paginator
                        dataKey="id"
                        :rows="10"
                        :rowsPerPageOptions="[5, 10, 20, 50, 100]"
                        :loading="loadingData"
                    >
                        <Column field="full_name" :header="$t('form.name')" sortable>
                            <template #body="{ data }">
                                <div class="flex align-items-center justify-content-start gap-2">
                                    <Avatar v-if="data.avatar_url" :image="data.avatar_url" shape="circle" />
                                    <span>{{ data.full_name }}</span>
                                </div>
                            </template>
                        </Column>
                        <Column field="email" :header="$t('form.email')" sortable></Column>
                        <Column field="role" :header="$t('form.role')" sortable>
                            <template #body="{ data }">
                                <Tag :value="$t(`project_role.${data.pivot.project_role}`)" />
                            </template>
                        </Column>
                        <Column :header="$t('basic.actions')" class="flex gap-2">
                            <template #body="{ data }">
                                <Button icon="fa fa-trash" severity="danger" @click="removeMemberAsk(data.id)" />
                                <Button icon="fa fa-pencil" severity="success" @click="openEditProjectMemberDialog(data)" />
                            </template>
                        </Column>
                    </DataTable>
                </form>
            </LoadingScreen>
            <template #footer>
                <div id="function_buttons" class="flex gap-2 flex-wrap">
                    <div class="flex-grow"></div>
                    <div class="flex justify-content-end gap-2 flex-wrap">
                        <Button
                            :label="$t('basic.cancel')"
                            icon="fa fa-times"
                            severity="secondary"
                            @click="showProjectMembersDialog = false"
                        />
                        <Button :label="$t('project.add_member')" icon="fa fa-plus" @click="openNewProjectMemberDialog" />
                    </div>
                </div>
            </template>
        </Dialog>

        <!-- New/Edit Project Member Dialog -->
        <Dialog
            id="new_edit_project_member_dialog"
            v-model:visible="showNewEditProjectMemberDialog"
            :header="isEditProjectMember ? $t('project.edit_member') : $t('project.add_member')"
            modal
            class="w-full m-2 lg:w-1/2"
            :draggable="false"
        >
            <LoadingScreen :blocked="loadingData">
                <form @submit.prevent="isEditProjectMember ? updateProjectMember() : addProjectMember()">
                    <SelectInput
                        v-model="projectMemberForm.user_id"
                        :options="users"
                        option-label="full_name"
                        option-value="id"
                        filter
                        :label="$t('form.user')"
                        placeholder="Select a user"
                        :disabled="isEditProjectMember"
                    />
                    <SelectInput
                        v-model="projectMemberForm.role"
                        :options="projectRoles"
                        :label="$t('form.role')"
                        placeholder="Select a role"
                    />
                </form>
            </LoadingScreen>
            <template #footer>
                <div id="function_buttons" class="flex gap-2 flex-wrap">
                    <div class="flex-grow"></div>
                    <div class="flex justify-content-end gap-2 flex-wrap">
                        <Button
                            :label="$t('basic.cancel')"
                            icon="fa fa-times"
                            severity="secondary"
                            @click="showNewEditProjectMemberDialog = false"
                        />
                        <Button
                            :label="$t('basic.save')"
                            icon="fa fa-save"
                            @click="
                                isEditProjectMember
                                    ? updateProjectMember(projectMemberForm.user_id, projectMemberForm.role)
                                    : addProjectMember(projectMemberForm.user_id, projectMemberForm.role)
                            "
                            severity="success"
                        />
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
        this.getProject(this.$route.params.id)
        this.getPartners()
        this.getTaskCategories()
        this.initFilters()
        this.getUsers()
    },

    methods: {
        openEditProjectDialog() {
            this.resetProjectForm()
            this.getProject(this.$route.params.id)
            this.showEditProjectDialog = true
        },

        openEditTaskDialog(event) {
            this.resetTaskForm()
            this.getTask(event.data.id)
            this.showNewEditTaskDialog = true
            this.isEditTask = true
        },

        openNewEditTaskDialog() {
            this.resetTaskForm()
            this.showNewEditTaskDialog = true
        },

        openNewProjectMemberDialog() {
            this.isEditProjectMember = false
            this.showNewEditProjectMemberDialog = true
        },

        openEditProjectMemberDialog(member) {
            this.isEditProjectMember = true
            this.projectMemberForm.user_id = member.id
            this.projectMemberForm.role = member.pivot.project_role
            this.showNewEditProjectMemberDialog = true
        },

        openNewTaskDialog() {
            this.resetTaskForm()
            this.isEditTask = false
            this.showNewEditTaskDialog = true
        },

        initFilters() {
            this.taskFilters = {
                title: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                type: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
                status: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
                priority: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
                due_date: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
            }
        },
    },

    data() {
        return {
            showEditProjectDialog: false,
            showNewEditTaskDialog: false,
            showProjectMembersDialog: false,
            showNewEditProjectMemberDialog: false,
            isEditTask: false,
            taskFilters: null,
            activeTab: 'tasks',
            isEditProjectMember: false,
            projectMemberForm: { user_id: null, role: null },
        }
    },
}
</script>
