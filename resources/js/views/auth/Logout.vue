<template>
    <div id="auth_logout_page">
        <div class="mx-6">
            <div class="flex justify-center items-center h-screen">
                <div class="p-4 shadow-md w-full border border-surface-300 rounded-md">
                    <h1 class="text-center text-2xl font-bold mb-4 dark:text-surface-200">
                        {{ $t('auth.logout') }}
                    </h1>
                    <p class="text-center dark:text-surface-200">
                        {{ $t('auth.logging_out') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'LogoutPage',
    created() {
        this.logout()
    },
    methods: {
        logout() {
            this.makeHttpRequest('POST', '/api/auth/logout')
                .then((response) => {
                    this.showToast(this.$t('auth.logout_success'), response.data.message, 'success')
                })
                .finally(() => {
                    this.$cookies.remove('token')
                    this.$router.push({ name: 'auth-login' })
                })
        },
    },
}
</script>
