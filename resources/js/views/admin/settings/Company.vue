<template>
    <DefaultLayout menu_type="admin">
        <div id="company_page"></div>
        <loadingScreen :blocked="loadingData">
            <PageHeader :title="$t('admin.company.title')" />

            <div id="company_data" class="card">
                <form class="formgrid">
                    <div id="company_logo" class="flex items-center">
                        <Avatar
                            :image="`/storage/${settings.company_logo}`"
                            size="xlarge"
                            v-if="settings.company_logo"
                            @contextmenu.prevent="removeLogo"
                            class="bg-transparent transition duration-300 ease-in-out transform hover:scale-110"
                        />
                        <FileUpload
                            name="company_logo"
                            url="/api/admin/settings/company/logo"
                            auto
                            accept="image/*"
                            @before-send="beforeUploadLogo"
                            @upload="getCompanySettings"
                            mode="basic"
                            :class="settings.company_logo ? 'ml-4' : 'ml-0'"
                            class="flex items-center justify-center"
                            :disabled="loadingData"
                        />
                    </div>

                    <TextInput
                        id="company_name_input"
                        v-model="v$.settings.company_name.$model"
                        :label="$t('admin.company.company_name')"
                        :validate="v$.settings.company_name"
                    />
                    <TextInput
                        id="company_address_input"
                        v-model="v$.settings.company_address.$model"
                        :label="$t('admin.company.company_address')"
                        :validate="v$.settings.company_address"
                    />
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-2">
                        <TextInput
                            id="company_zip_input"
                            v-model="v$.settings.company_zip.$model"
                            class="col-span-1 md:col-span-4"
                            :label="$t('admin.company.company_zip')"
                            :validate="v$.settings.company_zip"
                        />
                        <TextInput
                            id="company_city_input"
                            v-model="v$.settings.company_city.$model"
                            class="col-span-1 md:col-span-8"
                            :label="$t('admin.company.company_city')"
                            :validate="v$.settings.company_city"
                        />
                    </div>

                    <CountrySelect
                        v-model="v$.settings.company_country.$model"
                        :label="$t('admin.company.company_country')"
                        :validate="v$.settings.company_country"
                    />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <TextInput id="company_phone_input" v-model="settings.company_phone" :label="$t('admin.company.company_phone')" />
                        <TextInput id="company_email_input" v-model="settings.company_email" :label="$t('admin.company.company_email')" />
                    </div>

                    <TextInput
                        id="company_vat_input"
                        v-model="settings.company_vat"
                        class="col-12"
                        :label="$t('admin.company.company_vat')"
                    />
                </form>
            </div>
            <div id="function_buttons" class="flex gap-2 justify-end">
                <Button id="update_button" :label="$t('basic.update')" icon="fa fa-floppy-disk" severity="success" @click="validateForm" />
            </div>
        </loadingScreen>
    </DefaultLayout>
</template>

<script>
import { required } from '@/plugins/i18n-validators'
import { useVuelidate } from '@vuelidate/core'
import SettingsMixin from '@/mixins/admin/settings'
export default {
    name: 'AdminCompanyPage',
    mixins: [SettingsMixin],
    setup() {
        return { v$: useVuelidate() }
    },

    validations() {
        return {
            settings: {
                company_name: { required: required },
                company_address: { required: required },
                company_zip: { required: required },
                company_city: { required: required },
                company_country: { required: required },
            },
        }
    },

    created() {
        this.getCompanySettings()
    },
    methods: {
        removeLogo() {
            this.makeHttpRequest('DELETE', '/api/admin/settings/company/logo').then((response) => {
                this.getCompanySettings()
                this.showToast(response.data.message)
            })
        },

        beforeUploadLogo(event) {
            event.xhr.setRequestHeader('Authorization', `Bearer ${this.token}`)
        },

        validateForm() {
            this.v$.settings.$touch()
            if (this.v$.settings.$error) {
                return this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
            }
            this.updateCompanySettings()
        },
    },
}
</script>

<style></style>
