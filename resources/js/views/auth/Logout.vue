<template>
    <div>
        <h1>{{ $t('auth.logout') }}</h1>
    </div>
</template>

<script>
export default {
    name: 'Logout',
    created() {
        this.logout()
    },
    methods: {
        logout() {
            this.makeHttpRequest('GET', '/api/auth/logout')
                .then((res) => {
                    this.showToast(res.data.message)
                })
                .catch((err) => {
                    console.log(err)
                    this.showToast(err.response.data.message, '', 'error')
                })
                .finally(() => {
                    sessionStorage.removeItem('token')
                    this.$router.push({ name: 'AuthLogin' })
                })
        },
    },
}
</script>

<style></style>
