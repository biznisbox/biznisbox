<template>
    <div id="auth_login_page">
        <div class="flex justify-center items-center h-screen">
            <div class="p-2 shadow-md border border-surface-300 rounded-md w-full md:w-96 mx-4">
                <LoadingScreen :blocked="loadingData" class="p-1">
                    <img
                        v-if="$settings['company_logo'] != undefined && $settings['company_logo'] != null"
                        :src="`/storage/${$settings['company_logo']}`"
                        class="w-32 h-32 mx-auto"
                        alt="logo"
                    />

                    <h1 class="text-center text-2xl font-bold mb-4 dark:text-surface-200">
                        {{ $t('auth.login') }}
                    </h1>
                    <form @submit.prevent="login">
                        <TextInput v-model="form.email" :label="$t('auth.email')" autocomplete="username" />
                        <PasswordInput v-model="form.password" :label="$t('auth.password')" />

                        <OtpInput v-model="form.otp" :label="$t('auth.otp')" v-if="otp_required" />
                        <Button
                            @click="login"
                            :label="$t('auth.login')"
                            class="mt-4"
                            type="submit"
                            :disabled="!form.email || !form.password || loadingData"
                        />
                    </form>
                </LoadingScreen>
            </div>
        </div>
    </div>
</template>
<script>
import { jwtDecode } from 'jwt-decode'
export default {
    name: 'AuthLoginPage',
    data() {
        return {
            form: {
                email: '',
                password: '',
                otp: '',
            },
            otp_required: false,
        }
    },

    methods: {
        login() {
            this.makeHttpRequest('POST', '/api/auth/login', this.form).then((response) => {
                if (response.data.data.active == false) {
                    this.showToast(this.$t('auth.account_disabled'), this.$t('auth.login_failed'), 'error')
                    return
                }

                if (response.data.data.two_factor_auth == true) {
                    this.otp_required = true
                    return
                }

                if (response.data.data.otp == false) {
                    this.showToast(this.$t('auth.invalid_otp'), this.$t('auth.login_failed'), 'error')
                    return
                }

                if (response.data.data.access_token) {
                    this.$cookies.set('theme', jwtDecode(response.data.data.access_token).data?.theme, '1y')
                    this.showToast(this.$t('auth.login_success'), this.$t('auth.welcome_back'), 'success')
                    this.$cookies.set('token', response.data.data.access_token, '2h')
                    this.$cookies.set('lang', jwtDecode(response.data.data.access_token).data?.language, '1y')
                    if (this.$route.query.redirect) {
                        this.$router.push(this.$route.query.redirect)
                    } else {
                        this.$router.push({ name: 'dashboard' })
                    }
                }
            })
        },
    },
}
</script>
