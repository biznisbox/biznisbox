<template>
    <div>
        <LoadingScreen blocked>
            <h1>{{ $t('auth.logout') }}</h1>
        </LoadingScreen>
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
                .finally(() => {
                    sessionStorage.removeItem('token')
                    this.$router.push({ name: 'AuthLogin' })
                })
        },
    },
}
</script>
