<template>
    <admin-layout>
        <div id="company_page"></div>
        <loadingScreen :blocked="loadingData">
            <user-header :title="$t('admin.company.title')"></user-header>

            <div id="company_data" class="card">
                <form class="formgrid">
                    <TextInput id="company_name_input" v-model="company.company_name" :label="$t('admin.company.company_name')" />

                    <TextInput id="company_address_input" v-model="company.company_address" :label="$t('admin.company.company_address')" />

                    <div class="grid">
                        <TextInput
                            id="company_zip_input"
                            v-model="company.company_zip"
                            class="col-4"
                            :label="$t('admin.company.company_zip')"
                        />
                        <TextInput
                            id="company_city_input"
                            v-model="company.company_city"
                            class="col-8"
                            :label="$t('admin.company.company_city')"
                        />
                    </div>

                    <div class="grid">
                        <CountrySelect v-model="company.company_country" class="col-12" :label="$t('admin.company.company_country')" />
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
                            v-model="company.company_email"
                            class="col-6"
                            :label="$t('admin.company.company_email')"
                        />
                    </div>

                    <div class="grid">
                        <TextInput
                            id="company_vat_input"
                            v-model="company.company_vat"
                            class="col-6"
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
export default {
    name: 'AdminCompanyPage',

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
            this.makeHttpRequest('PUT', '/api/admin/company', this.company).then((response) => {
                this.showToast(response.data.message)
            })
        },
    },
}
</script>

<style></style>
