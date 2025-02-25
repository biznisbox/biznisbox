export default {
    data() {
        return {
            formShowErrors: false,
            users: [],
            roles: [],
            user: {
                id: '',
                first_name: '',
                last_name: '',
                email: '',
                language: 'en',
                auto_generated_password: false,
                password: '',
                role: '',
                send_details_to: [],
                sessions: [],
                roles: [],
                last_login_at: '',
                active: true,
                two_factor_auth: false,
            },
        }
    },

    methods: {
        generatePassword() {
            if (this.user.auto_generated_password) {
                const array = new Uint32Array(1);
                window.crypto.getRandomValues(array);
                this.user.password = array[0].toString(36).slice(-8);
            } else {
                this.user.password = ''
            }
        },

        getUsers() {
            this.makeHttpRequest('GET', '/api/admin/users').then((response) => {
                this.users = response.data.data
            })
        },

        getUser(id) {
            this.makeHttpRequest('GET', '/api/admin/users/' + id).then((response) => {
                this.user = response.data.data
            })
        },

        createUser() {
            this.makeHttpRequest('POST', '/api/admin/users', this.user).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'admin-users' })
            })
        },

        updateUser(id) {
            this.makeHttpRequest('PUT', '/api/admin/users/' + id, this.user).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'admin-user-view', params: { id: id } })
            })
        },

        deleteUser(id) {
            this.makeHttpRequest('DELETE', '/api/admin/users/' + id).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'admin-users' })
            })
        },

        deleteUserAsk(id) {
            this.confirmDeleteDialog(this.$t('admin.user.delete_confirm_user'), this.$t('basic.confirmation'), () => {
                this.deleteUser(id)
            })
        },

        resetPassword(id, data) {
            this.makeHttpRequest('PUT', '/api/admin/users/' + id + '/reset-password', data, '', '', false).then((response) => {
                this.showToast(response.data.message)
            })
        },

        getRoles() {
            this.makeHttpRequest('GET', '/api/admin/roles').then((response) => {
                this.roles = response.data.data
            })
        },

        disable2fa(id) {
            this.makeHttpRequest('POST', `/api/admin/users/${id}/disable-2fa`).then((response) => {
                this.showToast(response.data.message)
                this.getUser(id)
            })
        },
    },
}
