export default {
    data() {
        return {
            roles: [],
            role: {
                name: '',
                description: '',
                display_name: '',
                system: false,
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
            this.makeHttpRequest('DELETE', '/api/admin/roles/' + id).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'admin-roles' })
            })
        },

        deleteRoleAsk(id) {
            this.confirmDeleteDialog(this.$t('admin.role.delete_confirm_role'), this.$t('basic.confirmation'), () => {
                this.deleteRole(id)
            })
        },

        /**
         * Update role
         * @param {string} id UUID of role
         * @return {void} show toast and redirect to roles
         */
        updateRole(id) {
            this.makeHttpRequest('PUT', '/api/admin/roles/' + id, this.role).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'admin-role-view', params: { id: id } })
            })
        },
    },
}
