<template>
    <user-layout>
        <div id="new_vendor_page">
            <user-header :title="$t('vendor.new_vendor')" />

            <div class="card">
                <form class="formgrid">
                    <div class="grid">
                        <TextInput
                            id="name_input"
                            v-model="vendor.name"
                            class="field col-12 md:col-6"
                            :label="$t('vendor.name')"
                        ></TextInput>
                        <SelectButtonInput
                            id="select_vendor_type"
                            v-model="vendor.type"
                            class="field col-12 md:col-6"
                            :label="$t('vendor.type')"
                            :options="[
                                { label: $t('vendor.individual'), value: 'individual' },
                                { label: $t('vendor.company'), value: 'company' },
                            ]"
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
                        <TextInput id="email_input" v-model="vendor.email" :label="$t('vendor.email')" class="col-12 md:col-6"></TextInput>
                        <TextInput id="phone_input" v-model="vendor.phone" :label="$t('vendor.phone')" class="col-12 md:col-6"></TextInput>
                    </div>

                    <div class="grid">
                        <TextInput
                            id="website_input"
                            v-model="vendor.website"
                            :label="$t('vendor.website')"
                            class="col-12 md:col-6"
                        ></TextInput>
                        <TextInput
                            id="vat_number_input"
                            v-model="vendor.vat_number"
                            :label="$t('vendor.vat_number')"
                            class="col-12 md:col-6"
                        ></TextInput>
                    </div>
                </form>

                <div id="function_buttons" class="flex gap-2 justify-content-end">
                    <Button :label="$t('basic.cancel')" icon="fa fa-times" class="p-button-danger" @click="goTo('/vendors')" />
                    <Button
                        :label="$t('basic.save')"
                        :disabled="loadingData"
                        icon="fa fa-floppy-disk"
                        class="p-button-success"
                        @click="createVendor"
                    />
                </div>
            </div>
        </div>
    </user-layout>
</template>

<script>
import VendorMixin from '@/mixins/vendors'
export default {
    name: 'NewVendorPage',
    mixins: [VendorMixin],
}
</script>

<style></style>
