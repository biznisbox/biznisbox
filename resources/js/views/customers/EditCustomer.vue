<template>
    <user-layout>
        <div id="edit_customer_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('customer.edit_customer')" />

                <div class="card">
                    <form class="formgrid">
                        <div class="grid">
                            <TextInput id="name_input" v-model="customer.name" class="field col-12 md:col-6" label="Name"></TextInput>
                            <SelectButtonInput
                                id="select_customer_type"
                                v-model="customer.type"
                                class="field col-12 md:col-6"
                                :label="$t('customer.type')"
                                :options="[
                                    { label: $t('customer.individual'), value: 'individual' },
                                    { label: $t('customer.company'), value: 'company' },
                                ]"
                            />
                        </div>

                        <div class="grid">
                            <TextInput
                                id="vat_number_input"
                                v-model="customer.vat_number"
                                class="col-12"
                                :label="$t('customer.vat_number')"
                            ></TextInput>
                        </div>

                        <div class="grid">
                            <div class="col-12 md:col-6">
                                <span class="font-bold text-lg mt-2">{{ $t('customer.billing_address') }}</span>
                                <TextInput
                                    id="billing_address_input"
                                    v-model="customer.addresses[0].address"
                                    :label="$t('address.address')"
                                ></TextInput>
                                <div class="gap-2">
                                    <TextInput
                                        id="billing_city_input"
                                        v-model="customer.addresses[0].city"
                                        :label="$t('address.city')"
                                    ></TextInput>
                                    <TextInput
                                        id="billing_zip_input"
                                        v-model="customer.addresses[0].zip_code"
                                        :label="$t('address.zip')"
                                    ></TextInput>
                                </div>
                                <CountrySelect
                                    id="billing_country_input"
                                    v-model="customer.addresses[0].country"
                                    :label="$t('address.country')"
                                />
                            </div>
                            <div class="col-12 md:col-6">
                                <span class="font-bold text-lg mt-2">{{ $t('customer.shipping_address') }}</span>
                                <TextInput
                                    id="shipping_address_input"
                                    v-model="customer.addresses[1].address"
                                    :label="$t('address.address')"
                                ></TextInput>
                                <div class="gap-2">
                                    <TextInput
                                        id="shipping_city_input"
                                        v-model="customer.addresses[1].city"
                                        :label="$t('address.city')"
                                    ></TextInput>
                                    <TextInput
                                        id="shipping_zip_input"
                                        v-model="customer.addresses[1].zip_code"
                                        :label="$t('address.zip')"
                                    ></TextInput>
                                </div>
                                <CountrySelect
                                    id="shipping_country_input"
                                    v-model="customer.addresses[1].country"
                                    :label="$t('address.country')"
                                />
                            </div>
                        </div>

                        <span class="font-bold text-lg mt-2">{{ $t('customer.contact_infos') }}</span>
                        <div class="grid">
                            <TextInput
                                id="email_input"
                                v-model="customer.email"
                                class="col-12 md:col-4"
                                :label="$t('customer.email')"
                            ></TextInput>
                            <TextInput
                                id="phone_input"
                                v-model="customer.phone"
                                class="col-12 md:col-4"
                                :label="$t('customer.phone')"
                            ></TextInput>

                            <TextInput
                                id="website_input"
                                v-model="customer.website"
                                class="col-12 md:col-4"
                                :label="$t('customer.website')"
                            ></TextInput>
                        </div>

                        <div id="notes" class="grid">
                            <div class="col-12">
                                <TextAreaInput id="notes_input" v-model="customer.notes" :label="$t('customer.notes')"></TextAreaInput>
                            </div>
                        </div>
                    </form>

                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button
                            :label="$t('basic.cancel')"
                            icon="fa fa-times"
                            class="p-button-danger"
                            @click="goTo('/customers/' + customer.id)"
                        />
                        <Button
                            :label="$t('basic.update')"
                            icon="fa fa-floppy-disk"
                            class="p-button-success"
                            :disabled="loadingData"
                            @click="updateCustomer($route.params.id)"
                        />
                    </div>
                </div>
            </LoadingScreen>
        </div>
    </user-layout>
</template>

<script>
import CustomerMixin from '@/mixins/customers'
export default {
    name: 'EditCustomerPage',
    mixins: [CustomerMixin],
    created() {
        this.getCustomer(this.$route.params.id)
    },
}
</script>

<style></style>
