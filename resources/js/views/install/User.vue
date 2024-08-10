<template>
    <div class="container w-full md:w-1/2 mx-auto p-6">
        <div class="card">
            <h1 class="text-2xl font-bold text-center">{{ $t('install.create_user') }}</h1>

            <p class="text-center">{{ $t('install.create_user_description') }}</p>

            <div class="mt-6">
                <TextInput v-model="v$.user.first_name.$model" :label="$t('form.first_name')" :validate="v$.user.first_name" />
                <TextInput v-model="v$.user.last_name.$model" :label="$t('form.last_name')" :validate="v$.user.last_name" />
                <TextInput v-model="v$.user.email.$model" :label="$t('form.email')" :validate="v$.user.email" />
                <PasswordInput v-model="v$.user.password.$model" :label="$t('form.password')" :validate="v$.user.password" />

                <div class="flex justify-end mt-6">
                    <Button @click="nextStep" :label="$t('basic.next')" icon="fas fa-arrow-right" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { required } from '@/plugins/i18n-validators'
import { useVuelidate } from '@vuelidate/core'
export default {
    name: 'InstallUserPage',
    setup() {
        return { v$: useVuelidate() }
    },
    data() {
        return {
            user: {
                first_name: '',
                last_name: '',
                email: '',
                password: '',
            },
        }
    },

    validations() {
        return {
            user: {
                first_name: { required },
                last_name: { required },
                email: { required },
                password: { required },
            },
        }
    },

    created() {
        document.title = this.$t('install.installation')
        this.checkIfInstalled()
    },

    methods: {
        nextStep() {
            this.validateForm()
        },

        saveUser() {
            this.makeHttpRequest('POST', `/api/install/create-user`, this.user).then((response) => {
                if (response.data.data.status === true) {
                    this.$router.push({ name: 'install-finished' })
                } else {
                    this.error = response.data.message
                }
            })
        },

        validateForm() {
            this.v$.user.$touch()
            if (this.v$.user.$error) {
                return this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
            }
            return this.saveUser()
        },
    },
}
</script>
