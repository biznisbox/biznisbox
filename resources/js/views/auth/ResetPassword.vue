<template>
    <div id="auth_reset_password_page">
        <div class="flex justify-content-center mt-5 mx-5">
            <div class="surface-card p-4 shadow-2 border-round w-full lg:w-6">
                <div class="text-center">
                    <h1 class="text-900 font-medium text-5xl mb-4">{{ $t('auth.forgot_password') }}</h1>
                    <p class="text-900 font-medium text-2xl mb-4">{{ $t('auth.reset_password.reset_password') }}</p>
                    <p class="text-900 font-medium text-xl mb-4">
                        {{ $t('auth.reset_password.enter_email') }}
                    </p>
                    <div class="flex justify-content-center">
                        <div class="w-full lg:w-10">
                            <div class="mb-4">
                                <TextInput
                                    id="email"
                                    v-model="v$.form.email.$model"
                                    :label="$t('auth.email')"
                                    :validate="v$.form.email"
                                    :error="v$.form.email"
                                    :show-errors="formShowErrors"
                                />
                            </div>
                            <Button
                                :label="$t('auth.reset_password.reset_password')"
                                :disabled="loadingData"
                                class="w-full"
                                @click="resetPassword"
                            ></Button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { email, required } from '@vuelidate/validators'
export default {
    name: 'AuthResetPassword',
    setup: () => ({ v$: useVuelidate() }),
    data() {
        return {
            form: {
                email: null,
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
            },
        }
    },

    methods: {
        async resetPassword() {
            this.formShowErrors = true
            const isValid = await this.v$.$validate()
            if (!isValid) {
                return
            }
            this.makeHttpRequest('POST', '/api/auth/reset_password', this.form)
                .then((response) => {
                    this.showToast(response.data.message)
                    this.$router.push({ name: 'AuthLogin' })
                })
                .catch((error) => {
                    this.showToast(error.response.data.message, '', 'error')
                })
        },
    },
}
</script>

<style></style>
