<template>
    <admin-layout>
        <div id="company_page"></div>
        <loadingScreen :blocked="loadingData">
            <user-header :title="$t('admin.company.title')"></user-header>

            <div id="company_data" class="card">
                <form class="formgrid">
                    <TextInput
                        id="company_name_input"
                        v-model="v$.company.company_name.$model"
                        :label="$t('admin.company.company_name')"
                        :validate="v$.company.company_name"
                    />
                    <TextInput
                        id="company_address_input"
                        v-model="v$.company.company_address.$model"
                        :label="$t('admin.company.company_address')"
                        :validate="v$.company.company_address"
                    />
                    <div class="grid">
                        <TextInput
                            id="company_zip_input"
                            v-model="v$.company.company_zip.$model"
                            class="col-4"
                            :label="$t('admin.company.company_zip')"
                            :validate="v$.company.company_zip"
                        />
                        <TextInput
                            id="company_city_input"
                            v-model="v$.company.company_city.$model"
                            class="col-8"
                            :label="$t('admin.company.company_city')"
                            :validate="v$.company.company_city"
                        />
                    </div>

                    <div class="grid">
                        <CountrySelect
                            v-model="v$.company.company_country.$model"
                            class="col-12"
                            :label="$t('admin.company.company_country')"
                            :validate="v$.company.company_country"
                        />
                    </div>

                    <div class="grid">
                        <TextInput
                            id="company_phone_input"
                            v-model="company.company_phone"
                            class="col-6"
                            :label="$t('admin.company.company_phone')"
                        />
                        <TextInput
                            id="company_email_input"
                            v-model="v$.company.company_email.$model"
                            class="col-6"
                            :label="$t('admin.company.company_email')"
                            :validate="v$.company.company_email"
                        />
                    </div>

                    <div class="grid">
                        <TextInput
                            id="company_vat_input"
                            v-model="company.company_vat"
                            class="col-12"
                            :label="$t('admin.company.company_vat')"
                        />
                    </div>
                </form>

                <div id="function_buttons" class="flex gap-2 justify-content-end">
                    <Button :label="$t('basic.cancel')" icon="fa fa-times" class="p-button-danger" @click="goTo('/admin')" />
                    <Button :label="$t('basic.update')" icon="fa fa-floppy-disk" class="p-button-success" @click="updateCompanyData" />
                </div>
            </div>
        </loadingScreen>
    </admin-layout>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { email, required } from '@vuelidate/validators'
export default {
    name: 'AdminCompanyPage',
    setup: () => ({ v$: useVuelidate() }),
    data() {
        return {
            company: {
                company_name: '',
                company_address: '',
                company_city: '',
                company_zip: '',
                company_country: '',
                company_phone: '',
                company_email: '',
                company_vat: '',
            },
        }
    },

    validations() {
        return {
            company: {
                company_name: { required },
                company_address: { required },
                company_city: { required },
                company_zip: { required },
                company_country: { required },
                company_email: { email },
            },
        }
    },

    created() {
        this.getCompanyData()
    },

    methods: {
        getCompanyData() {
            this.makeHttpRequest('GET', '/api/admin/company').then((response) => {
                this.company = response.data.data
            })
        },

        updateCompanyData() {
            this.v$.$touch()
            if (this.v$.$error) {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }

            this.makeHttpRequest('PUT', '/api/admin/company', this.company).then((response) => {
                this.v$.$reset()
                this.showToast(response.data.message)
            })
        },
    },
}
</script>

<style></style>
