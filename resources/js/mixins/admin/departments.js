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
                longitude: '',
                latitude: '',
                location: '',
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
         * @return {void} show toast and redirect to view department
         */
        updateDepartment() {
            this.makeHttpRequest('PUT', '/api/admin/departments/' + this.department.id, this.department).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'admin-department-view', params: { id: this.department.id } })
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
            this.confirmDeleteDialog(this.$t('admin.department.delete_confirm_department'), this.$t('basic.confirmation'), () => {
                this.deleteDepartment(id)
            })
        },

        /*
         * Get current location
         * @return {void} set latitude and longitude
         */

        getCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    this.department.latitude = position.coords.latitude
                    this.department.longitude = position.coords.longitude
                })
            }
        },
    },
}
