<template>
    <user-layout>
        <div id="edit_partner_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="$t('partner.edit_partner')" />

                <div class="card">
                    <form id="edit_partner_form" class="formgrid">
                        <div class="grid">
                            <TextInput
                                id="number_input"
                                v-model="v$.partner.number.$model"
                                disabled
                                class="col-12 md:col-3"
                                :label="$t('form.number')"
                                :validate="v$.partner.number"
                            />
                            <TextInput
                                id="name_input"
                                v-model="v$.partner.name.$model"
                                class="col-12 md:col-9"
                                :label="$t('form.name')"
                                :validate="v$.partner.name"
                            />
                            <SelectButtonInput
                                id="select_partner_type"
                                v-model="v$.partner.type.$model"
                                class="col-12 md:col-5"
                                :label="$t('form.partner_type')"
                                :options="[
                                    { label: $t('partner_types.customer'), value: 'customer' },
                                    { label: $t('partner_types.supplier'), value: 'supplier' },
                                    { label: $t('partner_types.both'), value: 'both' },
                                    { label: $t('basic.other'), value: 'other' },
                                ]"
                                :validate="v$.partner.type"
                            />
                        </div>

                        <div class="grid">
                            <SelectButtonInput
                                id="select_partner_entity_type"
                                v-model="v$.partner.entity_type.$model"
                                class="col-12 md:col-6"
                                :label="$t('form.entity_type')"
                                :options="[
                                    { label: $t('entity_types.individual'), value: 'individual' },
                                    { label: $t('entity_types.company'), value: 'company' },
                                ]"
                                :validate="v$.partner.entity_type"
                            />

                            <TextInput
                                id="vat_number_input"
                                v-model="partner.vat_number"
                                class="col-12 md:col-6"
                                :label="$t('form.vat_number')"
                            />
                        </div>

                        <div class="grid">
                            <SelectInput
                                id="select_partner_currency"
                                v-model="partner.currency"
                                class="col-12 md:col-6"
                                :options="currencies"
                                :label="$t('form.currency')"
                                option-value="name"
                                option-label="name"
                            />

                            <SelectInput
                                id="select_partner_size"
                                v-model="partner.size"
                                class="col-12 md:col-6"
                                :options="[
                                    { label: $t('basic.micro'), value: 'micro' },
                                    { label: $t('basic.small'), value: 'small' },
                                    { label: $t('basic.medium'), value: 'medium' },
                                    { label: $t('basic.large'), value: 'large' },
                                ]"
                                :label="$t('form.size')"
                            />
                        </div>

                        <div class="grid">
                            <TextInput
                                id="partner_website_input"
                                v-model="partner.website"
                                class="col-12 md:col-6"
                                :label="$t('form.website')"
                            />

                            <SelectInput
                                id="select_partner_language"
                                v-model="partner.language"
                                class="col-12 md:col-6"
                                :options="languages"
                                :label="$t('form.language')"
                                option-value="name"
                                option-label="name"
                            />
                        </div>

                        <div id="addresses_table_section" class="grid">
                            <div class="col-12">
                                <Button :label="$t('partner.add_address')" icon="fa fa-plus" @click="addAddress" />
                            </div>
                            <DataTable class="col-12" id="addresses_table" :value="partner.addresses">
                                <template #empty>
                                    <div class="p-4 pl-0 text-center text-gray-500">{{ $t('partner.no_addresses') }}</div>
                                </template>

                                <Column field="type" :header="$t('form.type')">
                                    <template #body="slotProps">
                                        <SelectInput
                                            :id="`type_${slotProps.index}`"
                                            v-model="slotProps.data.type"
                                            :options="[
                                                { label: $t('address_types.billing'), value: 'billing' },
                                                { label: $t('address_types.shipping'), value: 'shipping' },
                                                { label: $t('address_types.office'), value: 'office' },
                                                { label: $t('basic.other'), value: 'other' },
                                            ]"
                                        />
                                    </template>
                                </Column>
                                <Column field="address" :header="$t('form.address')">
                                    <template #body="slotProps">
                                        <TextInput :id="`address_${slotProps.index}`" v-model="slotProps.data.address" />
                                    </template>
                                </Column>

                                <Column field="zip_code" :header="$t('form.zip_code')">
                                    <template #body="slotProps">
                                        <TextInput :id="`zip_${slotProps.index}`" v-model="slotProps.data.zip_code" />
                                    </template>
                                </Column>

                                <Column field="city" :header="$t('form.city')">
                                    <template #body="slotProps">
                                        <TextInput :id="`city_${slotProps.index}`" v-model="slotProps.data.city" />
                                    </template>
                                </Column>

                                <Column field="country" :header="$t('form.country')">
                                    <template #body="slotProps">
                                        <CountrySelect :id="`country_${slotProps.index}`" v-model="slotProps.data.country" :label="null" />
                                    </template>
                                </Column>

                                <Column field="notes" :header="$t('form.notes')">
                                    <template #body="slotProps">
                                        <TextInput :id="`notes_${slotProps.index}`" v-model="slotProps.data.notes" />
                                    </template>
                                </Column>

                                <Column :header="$t('basic.actions')">
                                    <template #body="slotProps">
                                        <Button
                                            :id="`remove_address_${slotProps.index}`"
                                            icon="fa fa-trash"
                                            class="p-button-danger"
                                            @click="removeAddress(slotProps.index)"
                                        />
                                    </template>
                                </Column>
                            </DataTable>
                        </div>

                        <div id="contacts_table_section" class="grid">
                            <div class="col-12">
                                <Button :label="$t('partner.add_contact')" icon="fa fa-plus" @click="addContact" />
                            </div>
                            <DataTable class="col-12" id="contacts_table" :value="partner.contacts">
                                <template #empty>
                                    <div class="p-4 pl-0 text-center text-gray-500">{{ $t('partner.no_contacts') }}</div>
                                </template>

                                <Column field="name" :header="$t('form.name')">
                                    <template #body="slotProps">
                                        <TextInput :id="`name_${slotProps.index}`" v-model="slotProps.data.name" />
                                    </template>
                                </Column>

                                <Column field="function" :header="$t('form.function')">
                                    <template #body="slotProps">
                                        <TextInput :id="`function_${slotProps.index}`" v-model="slotProps.data.function" />
                                    </template>
                                </Column>

                                <Column field="email" :header="$t('form.email')">
                                    <template #body="slotProps">
                                        <TextInput :id="`email_${slotProps.index}`" v-model="slotProps.data.email" />
                                    </template>
                                </Column>

                                <Column field="phone_number" :header="$t('form.phone_number')">
                                    <template #body="slotProps">
                                        <TextInput :id="`phone_number_${slotProps.index}`" v-model="slotProps.data.phone_number" />
                                    </template>
                                </Column>

                                <Column field="mobile_number" :header="$t('form.mobile_number')">
                                    <template #body="slotProps">
                                        <TextInput :id="`mobile_number_${slotProps.index}`" v-model="slotProps.data.mobile_number" />
                                    </template>
                                </Column>

                                <Column field="fax_number" :header="$t('form.fax_number')">
                                    <template #body="slotProps">
                                        <TextInput :id="`fax_number_${slotProps.index}`" v-model="slotProps.data.fax_number" />
                                    </template>
                                </Column>

                                <Column field="notes" :header="$t('form.notes')">
                                    <template #body="slotProps">
                                        <TextInput :id="`notes_${slotProps.index}`" v-model="slotProps.data.notes" />
                                    </template>
                                </Column>

                                <Column :header="$t('basic.actions')">
                                    <template #body="slotProps">
                                        <Button
                                            :id="`remove_contact_${slotProps.index}`"
                                            icon="fa fa-trash"
                                            class="p-button-danger"
                                            @click="removeContact(slotProps.index)"
                                        />
                                    </template>
                                </Column>
                            </DataTable>
                        </div>

                        <div class="grid">
                            <div class="col-12">
                                <TextAreaInput id="notes_input" v-model="partner.notes" :label="$t('form.notes')" />
                            </div>
                        </div>

                        <div id="function_buttons" class="flex gap-2 justify-content-end">
                            <Button
                                id="close_button"
                                :label="$t('basic.cancel')"
                                icon="fa fa-times"
                                class="p-button-danger"
                                @click="goTo('/partners')"
                            />
                            <Button
                                id="save_button"
                                :label="$t('basic.save')"
                                icon="fa fa-save"
                                class="p-button-success"
                                @click="validateForm"
                            />
                        </div>
                    </form>
                </div>
            </LoadingScreen>
        </div>
    </user-layout>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { required, url } from '@vuelidate/validators'
import PartnerMixin from '@/mixins/partners'
export default {
    name: 'EditPartnerPage',
    mixins: [PartnerMixin],
    setup: () => ({ v$: useVuelidate() }),

    created() {
        this.getPartner(this.$route.params.id)
        this.getCurrencies()
    },

    validations: {
        partner: {
            number: { required },
            name: { required },
            type: { required },
            entity_type: { required },
            website: { url },
        },
    },

    methods: {
        addContact() {
            this.partner.contacts.push({
                name: '',
                function: '',
                email: '',
                phone_number: '',
                mobile_number: '',
                fax_number: '',
                notes: '',
            })
        },

        addAddress() {
            this.partner.addresses.push({
                type: '',
                address: '',
                zip: '',
                city: '',
                country: '',
            })
        },

        removeAddress(index) {
            this.partner.addresses.splice(index, 1)
        },

        removeContact(index) {
            this.partner.contacts.splice(index, 1)
        },

        validateForm() {
            this.v$.partner.$touch()
            if (this.v$.partner.$error) {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }
            return this.updatePartner(this.$route.params.id)
        },
    },
}
</script>
