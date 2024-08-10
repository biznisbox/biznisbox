<template>
    <div class="container w-full md:w-1/2 mx-auto p-6">
        <div class="card">
            <h1 class="text-2xl font-bold text-center">{{ $t('install.company_welcome') }}</h1>

            <p class="text-center">{{ $t('install.company_welcome_description') }}</p>

            <TextInput
                v-model="v$.company.company_name.$model"
                :label="$t('admin.company.company_name')"
                :validate="v$.company.company_name"
            />
            <TextInput
                v-model="v$.company.company_address.$model"
                :label="$t('admin.company.company_address')"
                :validate="v$.company.company_address"
            />
            <TextInput
                v-model="v$.company.company_zip.$model"
                :label="$t('admin.company.company_zip')"
                :validate="v$.company.company_zip"
            />
            <TextInput
                v-model="v$.company.company_city.$model"
                :label="$t('admin.company.company_city')"
                :validate="v$.company.company_city"
            />
            <CountrySelect
                v-model="v$.company.company_country.$model"
                :label="$t('admin.company.company_country')"
                :validate="v$.company.company_country"
            />
            <TextInput
                v-model="v$.company.company_phone.$model"
                :label="$t('admin.company.company_phone')"
                :validate="v$.company.company_phone"
            />
            <TextInput
                v-model="v$.company.company_email.$model"
                :label="$t('admin.company.company_email')"
                :validate="v$.company.company_email"
            />

            <div class="flex justify-end mt-6">
                <Button @click="nextStep" :label="$t('basic.next')" icon="fas fa-arrow-right" />
            </div>
        </div>
    </div>
</template>

<script>
import { required } from '@/plugins/i18n-validators'
import { useVuelidate } from '@vuelidate/core'
export default {
    name: 'InstallCompanyPage',
    data() {
        return {
            company: {
                company_name: '',
                company_address: '',
                company_zip: '',
                company_city: '',
                company_country: '',
                company_phone: '',
                company_email: '',
            },
        }
    },

    setup() {
        return { v$: useVuelidate() }
    },

    created() {
        document.title = this.$t('install.installation')
        this.checkIfInstalled()
    },

    validations() {
        return {
            company: {
                company_name: { required },
                company_address: { required },
                company_zip: { required },
                company_city: { required },
                company_country: { required },
                company_phone: { required },
                company_email: { required },
            },
        }
    },

    methods: {
        nextStep() {
            this.validateForm()
        },

        saveCompany() {
            this.makeHttpRequest('POST', `/api/install/set-settings`, this.company)
                .then((response) => {
                    if (response.data.data.status === true) {
                        this.$router.push({ name: 'install-user' })
                    } else {
                        this.error = response.data.message
                    }
                })
                .catch((error) => {
                    console.log(error)
                })
        },

        validateForm() {
            this.v$.company.$touch()
            if (this.v$.company.$error) {
                return this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
            }
            return this.saveCompany()
        },
    },
}
</script>
