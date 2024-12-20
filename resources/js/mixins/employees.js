export default {
    data() {
        return {
            employees: [],
            departments: [],
            users: [],
            employee: {
                id: '',
                department_id: '',
                user_id: '',
                number: '',
                first_name: '',
                last_name: '',
                email: '',
                status: '',
                phone_number: '',
                description: '',
                address: '',
                city: '',
                zip_code: '',
                country: '',
                position: '',
                type: '',
                salary: '',
                hourly_rate: '',
                level: '',
                contract_type: '',
                contract_start_date: '',
                contract_end_date: '',
            },
        }
    },

    methods: {
        /**
         * Get all employees.
         * @returns {Promise<void>}
         */
        getEmployees() {
            this.makeHttpRequest('GET', '/api/employees').then((response) => {
                this.employees = response.data.data
            })
        },

        /**
         * Get employee by id.
         * @param id
         * @returns {Promise<void>}
         */
        getEmployee(id) {
            this.makeHttpRequest('GET', '/api/employees/' + id).then((response) => {
                this.employee = response.data.data
            })
        },

        /**
         * Get employee number.
         * @returns {Promise<void>}
         */
        getEmployeeNumber() {
            this.makeHttpRequest('GET', '/api/employee/number').then((response) => {
                this.employee.number = response.data.data
            })
        },

        /**
         * Create new employee.
         * @returns {Promise<void>}
         */
        createEmployee() {
            this.makeHttpRequest('POST', '/api/employees', this.employee).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'employees' })
            })
        },

        /**
         * Update employee.
         * @returns {Promise<void>}
         */
        updateEmployee(id) {
            this.makeHttpRequest('PUT', '/api/employees/' + id, this.employee).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'employee-view', params: { id: id } })
            })
        },

        /**
         * Delete employee.
         * @param id
         * @returns {Promise<void>}
         */
        deleteEmployee(id) {
            this.makeHttpRequest('DELETE', '/api/employees/' + id).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'employees' })
            })
        },

        /**
         * Ask for confirmation before deleting employee.
         * @param id
         */
        deleteEmployeeAsk(id) {
            this.confirmDeleteDialog(this.$t('employee.delete_employee_confirmation'), this.$t('basic.confirmation'), () => {
                this.deleteEmployee(id)
            })
        },

        /**
         * Get departments.
         * @returns {Promise<void>}
         */
        getDepartments() {
            this.makeHttpRequest('GET', '/api/data', null, { type: 'departments' }).then((response) => {
                this.departments = response.data.data
            })
        },

        /**
         * Get users.
         * @returns {Promise<void>}
         */
        getPublicUsers() {
            this.makeHttpRequest('GET', '/api/data', null, { type: 'users' }).then((response) => {
                this.users = response.data.data
            })
        },
    },
}
