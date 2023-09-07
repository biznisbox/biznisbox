<template>
    <user-layout>
        <div id="edit_vendor_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('vendor.edit_vendor')" />

                <div class="card">
                    <form class="formgrid">
                        <div class="grid">
                            <TextInput
                                id="number_input"
                                v-model="vendor.number"
                                class="field col-12 md:col-3"
                                :label="$t('vendor.number')"
                                disabled
                            ></TextInput>
                            <TextInput
                                id="name_input"
                                v-model="v$.vendor.name.$model"
                                class="field col-12 md:col-6"
                                :label="$t('vendor.name')"
                                :validate="v$.vendor.name"
                            ></TextInput>
                            <SelectButtonInput
                                id="select_vendor_type"
                                v-model="v$.vendor.type.$model"
                                class="field col-12 md:col-3"
                                :label="$t('vendor.type')"
                                :options="[
                                    { label: $t('vendor.individual'), value: 'individual' },
                                    { label: $t('vendor.company'), value: 'company' },
                                ]"
                                :validate="v$.vendor.type"
                            />
                        </div>

                        <div class="grid">
                            <TextAreaInput id="address_input" v-model="vendor.address" :label="$t('vendor.address')" class="col-12" />
                        </div>
                        <div class="grid">
                            <TextInput
                                id="zip_input"
                                v-model="vendor.zip_code"
                                :label="$t('vendor.zip_code')"
                                class="col-12 md:col-6"
                            ></TextInput>
                            <TextInput id="city_input" v-model="vendor.city" :label="$t('vendor.city')" class="col-12 md:col-6"></TextInput>
                        </div>
                        <div class="grid">
                            <CountrySelect id="country_input" v-model="vendor.country" :label="$t('vendor.country')" class="col-12" />
                        </div>

                        <div class="grid">
                            <TextInput
                                id="email_input"
                                v-model="v$.vendor.email.$model"
                                :label="$t('vendor.email')"
                                :validate="v$.vendor.email"
                                class="col-12 md:col-6"
                            ></TextInput>
                            <TextInput
                                id="phone_input"
                                v-model="vendor.phone"
                                :label="$t('vendor.phone')"
                                class="col-12 md:col-6"
                            ></TextInput>
                        </div>

                        <div class="grid">
                            <TextInput
                                id="website_input"
                                v-model="v$.vendor.website.$model"
                                :label="$t('vendor.website')"
                                class="col-12 md:col-6"
                                :validate="v$.vendor.website"
                            ></TextInput>
                            <TextInput
                                id="vat_number_input"
                                v-model="v$.vendor.vat_number.$model"
                                type="number"
                                :label="$t('vendor.vat_number')"
                                class="col-12 md:col-6"
                                :validate="v$.vendor.vat_number"
                            ></TextInput>
                        </div>
                    </form>

                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button :label="$t('basic.cancel')" icon="fa fa-times" class="p-button-danger" @click="goTo('/vendors')" />
                        <Button
                            :label="$t('basic.update')"
                            icon="fa fa-floppy-disk"
                            class="p-button-success"
                            :disabled="loadingData"
                            @click="updateVendor($route.params.id)"
                        />
                    </div>
                </div>
            </LoadingScreen>
        </div>
    </user-layout>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { required, email, url, integer } from '@vuelidate/validators'
import VendorMixin from '@/mixins/vendors'
export default {
    name: 'EditVendorPage',
    mixins: [VendorMixin],
    setup: () => ({ v$: useVuelidate() }),
    created() {
        this.getVendor(this.$route.params.id)
    },

    validations() {
        return {
            vendor: {
                name: { required },
                email: { email },
                website: { url },
                type: { required },
                vat_number: { integer },
            },
        }
    },

    methods: {
        validateForm() {
            this.v$.vendor.$touch()
            if (this.v$.vendor.$error) {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }
            return this.updateVendor()
        },
    },
}
</script>

<style></style>
