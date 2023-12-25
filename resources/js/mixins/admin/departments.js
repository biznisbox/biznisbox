export default {
    data() {
        return {
            departments: [],
            department: {
                id: '',
                name: '',
                description: '',
                address: '',
                city: '',
                zip_code: '',
                country: '',
                phone_number: '',
                email: '',
            },
        }
    },

    methods: {
        /*
         * Get all departments
         * @return {void} return departments
         */
        getDepartments() {
            this.makeHttpRequest('GET', '/api/admin/departments').then((response) => {
                this.departments = response.data.data
            })
        },

        /*
         * Get department
         * @param {string} id UUID of department
         * @return {void} return department
         */
        getDepartment(id) {
            this.makeHttpRequest('GET', '/api/admin/departments/' + id).then((response) => {
                this.department = response.data.data
            })
        },

        /*
         * Create department
         * @return {void} show toast and redirect to departments
         */
        createDepartment() {
            this.makeHttpRequest('POST', '/api/admin/departments', this.department).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'admin-departments' })
            })
        },

        /*
         * Update department
         * @return {void} show toast and redirect to departments
         */
        updateDepartment() {
            this.makeHttpRequest('PUT', '/api/admin/departments/' + this.department.id, this.department).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'admin-departments' })
            })
        },

        /*
         * Delete department
         * @param {string} id UUID of department
         * @return {void} show toast and redirect to departments
         */
        deleteDepartment(id) {
            this.makeHttpRequest('DELETE', '/api/admin/departments/' + id).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'admin-departments' })
            })
        },

        /*
         * Ask for confirmation before deleting department
         * @param {string} id UUID of department
         * @return {void}
         */
        deleteDepartmentAsk(id) {
            this.$confirm.require({
                message: this.$t('admin.department.delete_confirm_department'),
                header: this.$t('basic.confirmation'),
                icon: 'fa fa-circle-exclamation',
                accept: () => {
                    this.deleteDepartment(id)
                },
            })
        },
    },
}
