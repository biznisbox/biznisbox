<template>
    <div id="auth_login_page">
        <div class="flex justify-content-center mt-5 mx-5">
            <div class="surface-card p-4 shadow-2 border-round w-full lg:w-6">
                <div>
                    <form @submit.prevent="login">
                        <TextInput id="email" v-model="v$.form.email.$model" :label="$t('auth.email')" :validate="v$.form.email" />

                        <PasswordInput
                            id="password"
                            v-model="v$.form.password.$model"
                            :label="$t('auth.password')"
                            :validate="v$.form.password"
                            type="password"
                        />

                        <div class="flex align-items-center justify-content-between mb-6">
                            <div class="flex align-items-center">
                                <Checkbox id="remember_me" v-model="form.remember_me" binary class="mr-2"></Checkbox>
                                <label for="remember_me"> {{ $t('auth.remember_me') }} </label>
                            </div>

                            <RouterLink
                                to="/auth/reset-password"
                                class="font-medium no-underline ml-2 text-blue-500 text-right cursor-pointer"
                                >{{ $t('auth.reset_password.reset_password') }}
                            </RouterLink>
                        </div>

                        <Button :disabled="loadingData" :label="$t('auth.login')" type="submit" class="w-full"></Button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import jwtDecode from 'jwt-decode'
import { useVuelidate } from '@vuelidate/core'
import { email, required, minLength } from '@vuelidate/validators'
export default {
    name: 'AuthLogin',
    setup: () => ({ v$: useVuelidate() }),
    data() {
        return {
            form: {
                email: '',
                password: '',
                remember_me: false,
            },
        }
    },
    validations() {
        return {
            form: {
                email: {
                    required,
                    email,
                },
                password: {
                    required,
                    minLength: minLength(8),
                },
            },
        }
    },

    methods: {
        login() {
            this.v$.$touch()
            if (this.v$.$error) {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }

            this.makeHttpRequest('POST', '/api/auth/login', this.form).then((response) => {
                this.showToast(response.data.message)
                sessionStorage.setItem('token', response.data.data)
                localStorage.setItem('lang', jwtDecode(response.data.data).data?.lang)
                this.$router.push({ name: 'Dashboard' })
            })
        },
    },
}
</script>

<style></style>
