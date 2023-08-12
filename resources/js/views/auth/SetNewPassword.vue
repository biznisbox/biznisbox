<template>
    <div id="auth_set_new_password_page">
        <div class="flex justify-content-center mt-5 mx-5">
            <div class="surface-card p-4 shadow-2 border-round w-full lg:w-6">
                <div class="text-center">
                    <h1 class="text-900 font-medium text-5xl mb-4">{{ $t('auth.password') }}</h1>
                    <p class="text-900 font-medium text-xl mb-4">{{ $t('auth.reset_password.set_your_password') }}</p>
                    <div class="flex justify-content-center">
                        <div class="w-full lg:w-10">
                            <div class="mb-4">
                                <TextInput
                                    id="password"
                                    v-model="v$.form.password.$model"
                                    :label="$t('auth.password')"
                                    type="password"
                                    :validate="v$.form.password"
                                />

                                <TextInput
                                    id="password_confirmation"
                                    v-model="v$.form.password_confirmation.$model"
                                    :label="$t('auth.password_confirmation')"
                                    type="password"
                                    :validate="v$.form.password_confirmation"
                                />
                            </div>
                            <Button
                                :label="$t('auth.reset_password.set_new_password')"
                                :disabled="loadingData"
                                class="w-full"
                                @click="setNewPassword"
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
import { required, minLength, sameAs } from '@vuelidate/validators'
import TextInput from '@/components/form/TextInput.vue'
export default {
    name: 'SetNewPassword',
    components: {
        TextInput,
    },
    setup: () => ({ v$: useVuelidate() }),
    data() {
        return {
            form: {
                password: '',
                password_confirmation: '',
                token: this.$route.query.token,
                email: this.$route.params.email,
            },
        }
    },

    validations() {
        return {
            form: {
                password: {
                    required,
                    minLength: minLength(6),
                },
                password_confirmation: {
                    required,
                    sameAs: sameAs(this.form.password),
                },
            },
        }
    },

    methods: {
        setNewPassword() {
            this.v$.$touch()
            if (this.v$.$error) {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }

            this.makeHttpRequest('POST', '/api/auth/set_new_password', this.form).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'AuthLogin' })
            })
        },
    },
}
</script>

<style></style>
