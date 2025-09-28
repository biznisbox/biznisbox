export default {
    data() {
        return {
            projects: [],
            project: {
                id: null,
                number: '',
                project_key: '',
                name: '',
                partner_id: null,
                description: '',
                start_date: null,
                end_date: null,
                status: 'not_started',
                progress: 0,
                hourly_rate: 0,
                priority: 'medium',
                active: true,
                members: [],
                tasks: [],
            },
            partners: [],
            projectCategories: [],
            taskCategories: [],
            projectStatuses: [
                { label: this.$t('status.not_started'), value: 'not_started' },
                { label: this.$t('status.in_progress'), value: 'in_progress' },
                { label: this.$t('status.on_hold'), value: 'on_hold' },
                { label: this.$t('status.completed'), value: 'completed' },
                { label: this.$t('status.cancelled'), value: 'cancelled' },
            ],
            projectPriorities: [
                { label: this.$t('priority.low'), value: 'low' },
                { label: this.$t('priority.medium'), value: 'medium' },
                { label: this.$t('priority.normal'), value: 'normal' },
                { label: this.$t('priority.high'), value: 'high' },
                { label: this.$t('priority.urgent'), value: 'urgent' },
            ],
            task: {
                project_id: this.project?.id,
                number: '',
                title: '',
                type: 'task',
                category: null,
                notes: '',
                tags: [],
                description: '',
                start_date: null,
                due_date: null,
                status: 'to_do',
                priority: 'normal',
                assigned_to: null,
                progress_in_percent: 0,
                description: '',
                start_date: null,
                due_date: null,
                completed_at: null,
                active: true,
            },
        }
    },

    methods: {
        /**
         * Fetch projects from API
         */
        getProjects() {
            this.makeHttpRequest('GET', '/api/projects').then((response) => {
                this.projects = response.data.data
            })
        },

        /**
         * Get partners
         * @returns {void}
         */
        getPartners() {
            this.makeHttpRequest('GET', '/api/partner/limited?type=customer,both,supplier').then((response) => {
                this.partners = response.data.data
            })
        },

        /**
         * Create a new project
         * @returns {void} return response
         */
        createProject() {
            this.makeHttpRequest('POST', '/api/projects', this.project).then((response) => {
                this.showToast(response.data.message)
                this.showNewProjectDialog = false
                this.getProjects()
            })
        },

        /**
         * Update an existing project
         * @returns {void}
         */
        updateProject() {
            this.makeHttpRequest('PUT', `/api/projects/${this.project.id}`, this.project).then((response) => {
                this.showToast(response.data.message)
                this.showEditProjectDialog = false
                this.getProjects()
            })
        },

        /**
         * Fetch a single project from API
         * @returns {void}
         */
        getProject(id) {
            this.makeHttpRequest('GET', `/api/projects/${id}`).then((response) => {
                this.project = response.data.data
            })
        },

        /**
         * Create a new task
         * @returns {void} return response
         */
        createTask() {
            this.task.project_id = this.project.id
            this.makeHttpRequest('POST', '/api/projects/tasks', this.task).then((response) => {
                this.showToast(response.data.message)
                this.showNewEditTaskDialog = false
                this.getProject(this.project.id)
            })
        },

        /**
         * Update an existing task
         * @returns {void}
         */
        updateTask(id) {
            this.makeHttpRequest('PUT', `/api/projects/tasks/${id}`, this.task).then((response) => {
                this.showToast(response.data.message)
                this.showNewEditTaskDialog = false
                this.getProject(this.project.id)
            })
        },

        deleteTask(id) {
            this.makeHttpRequest('DELETE', `/api/projects/tasks/${id}`).then((response) => {
                this.showToast(response.data.message)
                this.getProject(this.project.id)
            })
        },

        /**
         * Fetch task categories from API
         * @returns {void}
         */
        getTaskCategories() {
            this.getCategories('task_category').then((response) => {
                this.taskCategories = response
            })
        },

        /**
         * Fetch task priorities from API
         * @returns {void}
         */
        getProjectCategories() {
            this.getCategories('project_category').then((response) => {
                this.projectCategories = response
            })
        },

        /**
         * Reset project form
         * @returns {void}
         */
        resetProjectForm() {
            this.project = {
                id: null,
                number: '',
                project_key: '',
                name: '',
                partner_id: null,
                description: '',
                start_date: null,
                end_date: null,
                status: 'not_started',
                progress: 0,
                hourly_rate: 0,
                priority: 'medium',
                active: true,
                members: [],
                tasks: [],
            }
        },

        /**
         * Reset task form
         * @returns {void}
         */
        resetTaskForm() {
            this.task = {
                project_id: this.project.id,
                title: '',
                type: 'task',
                category: null,
                notes: '',
                tags: [],
                description: '',
                start_date: null,
                due_date: null,
                status: 'to_do',
                priority: 'normal',
                assigned_to: null,
                progress_in_percent: 0,
                description: '',
                start_date: null,
                due_date: null,
                completed_at: null,
                active: true,
            }
        },
    },
}
