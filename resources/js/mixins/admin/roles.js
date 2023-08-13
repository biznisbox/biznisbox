export default {
    data() {
        return {
            roles: [],
            role: {
                name: '',
                description: '',
                display_name: '',
                permissions: [],
            },
            permissions: [],
        }
    },

    methods: {
        /**
         * Get all roles
         * @return {void} return roles
         **/
        getRoles() {
            this.makeHttpRequest('GET', '/api/admin/roles').then((response) => {
                this.roles = response.data.data
            })
        },

        /**
         * Get role
         * @param {string} id UUID of role
         * @return {void} return role
         */
        getRole(id) {
            this.makeHttpRequest('GET', '/api/admin/roles/' + id).then((response) => {
                this.role = response.data.data
                this.role.name = this.role.display_name
            })
        },

        /**
         * Get permissions
         * @return {void} return permissions
         **/
        getPermissions() {
            this.makeHttpRequest('GET', '/api/admin/permissions').then((response) => {
                this.permissions = response.data.data
            })
        },

        /**
         * Create role
         * @return {void} show toast and redirect to roles
         */
        createRole() {
            if (this.role.name == 'Super Admin') {
                return this.showToast('Error', 'Super Admin is a default role and cannot be created', 'error')
            }

            this.makeHttpRequest('POST', '/api/admin/roles', this.role).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'admin-roles' })
            })
        },

        /**
         * Delete role
         * @param {string} id UUID of role
         * @return {void} show toast and redirect to roles
         */
        deleteRole(id) {
            if (this.role.name == 'Super Admin') {
                return this.showToast('Error', 'Super Admin is a default role and cannot be deleted', 'error')
            }
            this.makeHttpRequest('DELETE', '/api/admin/roles/' + id).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'admin-roles' })
            })
        },

        deleteRoleAsk(id) {
            this.$confirm.require({
                message: this.$t('admin.role.delete_confirm_role'),
                header: this.$t('basic.confirmation'),
                icon: 'fa fa-circle-exclamation',
                accept: () => {
                    this.deleteRole(id)
                },
            })
        },

        /**
         * Update role
         * @param {string} id UUID of role
         * @return {void} show toast and redirect to roles
         */
        updateRole(id) {
            if (this.role.name == 'Super Admin') {
                return this.showToast('Error', 'Super Admin is a default role and cannot be updated', 'error')
            }
            this.makeHttpRequest('PUT', '/api/admin/roles/' + id, this.role).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'admin-roles' })
            })
        },
    },
}
