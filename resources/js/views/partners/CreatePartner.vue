<template>
    <DefaultLayout>
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="$t('partner.new_partner')" />
            <div class="card">
                <form>
                    <div class="grid lg:grid-cols-2 grid-cols-1 gap-2">
                        <TextInput
                            id="number_input"
                            v-model="v$.partner.number.$model"
                            disabled
                            :label="$t('form.number')"
                            :validate="v$.partner.number"
                        />
                        <TextInput id="name_input" v-model="v$.partner.name.$model" :label="$t('form.name')" :validate="v$.partner.name" />
                    </div>

                    <div class="grid lg:grid-cols-2 grid-cols-1 gap-2">
                        <SelectButtonInput
                            id="select_partner_entity_type"
                            v-model="v$.partner.entity_type.$model"
                            :label="$t('form.entity_type')"
                            :options="[
                                { label: $t('entity_types.individual'), value: 'individual' },
                                { label: $t('entity_types.company'), value: 'company' },
                            ]"
                            :validate="v$.partner.entity_type"
                        />

                        <SelectButtonInput
                            id="select_partner_type"
                            v-model="v$.partner.type.$model"
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

                    <div class="grid lg:grid-cols-2 grid-cols-1 gap-2">
                        <SelectInput
                            id="select_partner_currency"
                            v-model="v$.partner.currency.$model"
                            :options="currencies"
                            :label="$t('form.currency')"
                            option-value="code"
                            option-label="name"
                            :validate="v$.partner.currency"
                        />
                        <SelectInput
                            id="select_partner_size"
                            v-model="partner.size"
                            :options="[
                                { label: $t('basic.micro'), value: 'micro' },
                                { label: $t('basic.small'), value: 'small' },
                                { label: $t('basic.medium'), value: 'medium' },
                                { label: $t('basic.large'), value: 'large' },
                            ]"
                            :label="$t('form.size')"
                            show-clear
                        />
                    </div>
                    <div class="grid lg:grid-cols-2 grid-cols-1 gap-2">
                        <TextInput id="partner_website_input" v-model="partner.website" :label="$t('form.website')" />

                        <SelectInput
                            id="select_partner_language"
                            v-model="v$.partner.language.$model"
                            :options="locales"
                            :label="$t('form.language')"
                            option-value="code"
                            option-label="locale"
                            :validate="v$.partner.language"
                        />
                    </div>
                    <div class="grid lg:grid-cols-2 grid-cols-1 gap-2">
                        <div class="grid grid-cols-1 gap-2">
                            <div class="flex items-end gap-2 content-center">
                                <TextInput
                                    id="vat_number_input"
                                    v-model="partner.vat_number"
                                    :label="$t('form.vat_number')"
                                    class="flex-1"
                                />
                                <Button
                                    v-if="partner.entity_type == 'company'"
                                    label="Validate VAT"
                                    @click="validateVatId"
                                    class="whitespace-nowrap mb-2"
                                />
                            </div>
                            <div v-if="vatValidationError" class="text-red-500 text-sm">
                                {{ vatValidationError }}
                            </div>
                        </div>

                        <!-- Industry select -->
                        <SelectInput
                            id="select_partner_industry"
                            v-model="partner.industry"
                            :options="industries"
                            :label="$t('form.industry')"
                            option-value="value"
                            option-label="name"
                            show-clear
                        />
                    </div>
                    <div id="addresses_table_section" class="grid">
                        <div class="my-2">
                            <Button :label="$t('partner.add_address')" icon="fa fa-plus" @click="addAddress" />
                        </div>
                        <DataTable id="addresses_table" :value="partner.addresses" class="overflow-auto">
                            <template #empty>
                                <div class="p-4 pl-0 text-center">{{ $t('partner.no_addresses') }}</div>
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
                                        severity="danger"
                                        @click="removeAddress(slotProps.index)"
                                    />
                                </template>
                            </Column>
                        </DataTable>
                    </div>

                    <!-- Contact table -->
                    <div id="contacts_table_section" class="grid">
                        <div class="my-2">
                            <Button :label="$t('partner.add_contact')" icon="fa fa-plus" @click="addContact" />
                        </div>
                        <DataTable id="contacts_table" :value="partner.contacts" class="clearfix overflow-auto">
                            <template #empty>
                                <div class="p-4 pl-0 text-center">{{ $t('partner.no_contacts') }}</div>
                            </template>

                            <Column field="name" :header="$t('form.name')">
                                <template #body="slotProps">
                                    <div class="flex gap-2">
                                        <StarButton :id="`is_primary_${slotProps.index}`" v-model="slotProps.data.is_primary" />
                                        <TextInput :id="`name_${slotProps.index}`" v-model="slotProps.data.name" />
                                    </div>
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
                                        severity="danger"
                                        @click="removeContact(slotProps.index)"
                                    />
                                </template>
                            </Column>
                        </DataTable>
                    </div>

                    <div class="grid">
                        <TextAreaInput id="notes_input" v-model="partner.notes" :label="$t('form.notes')" />
                    </div>
                </form>
            </div>

            <div id="function_buttons" class="flex justify-end mt-4 gap-2">
                <Button id="close_button" :label="$t('basic.cancel')" icon="fa fa-times" @click="goTo('/partners')" severity="secondary" />
                <Button id="save_button" :label="$t('basic.save')" icon="fa fa-save" @click="validateForm" severity="success" />
            </div>
        </LoadingScreen>
    </DefaultLayout>
</template>
<script>
import { required } from '@/plugins/i18n-validators'
import { useVuelidate } from '@vuelidate/core'
import PartnerMixin from '@/mixins/partners'
export default {
    name: 'PartnersPage',
    mixins: [PartnerMixin],
    created() {
        this.getCurrencies()
        this.getLocales()
        this.getNextPartnerNumber()
        this.partner.currency = this.$settings.default_currency
        this.partner.language = this.$settings.default_lang
    },
    setup() {
        return { v$: useVuelidate() }
    },
    validations() {
        return {
            partner: {
                number: { required },
                name: { required },
                entity_type: { required },
                type: { required },
                currency: { required },
                language: { required },
            },
        }
    },

    methods: {
        validateForm() {
            this.v$.partner.$touch()
            if (this.v$.partner.$invalid) {
                this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
                return
            }

            this.createPartner()
        },

        addContact() {
            this.partner.contacts.push({
                is_primary: false,
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
    },
}
</script>
