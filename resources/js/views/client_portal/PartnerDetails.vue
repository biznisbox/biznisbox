<template>
    <DefaultLayout menu_type="client">
        <LoadingScreen :blocked="loadingData">
            <PageHeader :title="partner ? partner.name : $t('client_portal.partner_details')" />

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-3">
                <div class="grid grid-cols-1 lg:col-span-4">
                    <div class="card">
                        <div class="font-bold mb-4">
                            <h3>{{ $t('partner.partner_details') }}</h3>
                        </div>
                        <DisplayData :input="$t('form.number')" :value="partner.number" />
                        <DisplayData :input="$t('form.name')" :value="partner.name" />
                        <div class="grid md:grid-cols-2 gap-2">
                            <div>
                                <Tag v-if="partner.type === 'customer'" :value="$t('partner_types.customer')" />
                                <Tag v-if="partner.type === 'supplier'" :value="$t('partner_types.supplier')" />
                                <Tag v-if="partner.type === 'both'" :value="$t('partner_types.both')" />
                                <Tag v-if="partner.type === 'other'" :value="$t('basic.other')" />
                            </div>
                            <div>
                                <Tag v-if="partner.entity_type == 'company'" :value="$t('entity_types.company')" />
                                <Tag v-if="partner.entity_type == 'individual'" :value="$t('entity_types.individual')" />
                            </div>
                        </div>
                        <DisplayData :input="$t('form.vat_number')" :value="partner.vat_number" />
                        <DisplayData v-if="partner.website" :input="$t('form.website')" :value="partner.website" is-link />
                        <DisplayData v-if="partner.language" :input="$t('form.language')" :value="$t('language.' + partner.language)" />
                        <DisplayData v-if="partner.currency" :input="$t('form.currency')" :value="partner.currency" />
                        <DisplayData v-if="partner.size" :input="$t('form.size')" :value="$t('basic.' + partner.size)" />
                        <DisplayData v-if="partner.industry" :input="$t('form.industry')" :value="$t(`industries.${partner.industry}`)" />
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:col-span-8">
                    <div class="card">
                        <Tabs value="contact_information" scrollable>
                            <TabList>
                                <Tab value="contact_information">{{ $t('partner.contact_information') }}</Tab>
                                <Tab value="addresses">{{ $t('partner.addresses') }}</Tab>
                            </TabList>

                            <TabPanels>
                                <!-- Contacts table -->
                                <TabPanel value="contact_information">
                                    <DataTable id="contacts_table" :value="partner.contacts">
                                        <template #empty>
                                            <div class="p-4 pl-0 text-center w-full dark:text-gray-400">
                                                <i class="fa fa-info-circle empty-icon"></i>
                                                <p>{{ $t('partner.no_contacts') }}</p>
                                            </div>
                                        </template>
                                        <Column field="name" :header="$t('form.name')">
                                            <template #body="{ data }">
                                                <div class="flex gap-2">
                                                    <i v-if="data.is_primary" class="fa fa-star text-yellow-500 mr-2"></i>
                                                    <span>{{ data.name }}</span>
                                                </div>
                                            </template>
                                        </Column>
                                        <Column field="function" :header="$t('form.function')" />
                                        <Column field="email" :header="$t('form.email')">
                                            <template #body="{ data }">
                                                <span v-if="data.email">{{ data.email }}</span>
                                            </template>
                                        </Column>
                                        <Column field="phone_number" :header="$t('form.phone_number')">
                                            <template #body="{ data }">
                                                <a :href="'tel:' + data.phone_number">{{ data.phone_number }}</a>
                                            </template>
                                        </Column>
                                        <Column field="mobile_number" :header="$t('form.mobile_number')">
                                            <template #body="{ data }">
                                                <a :href="'tel:' + data.mobile_number">{{ data.mobile_number }}</a>
                                            </template>
                                        </Column>
                                        <Column field="client_portal" :header="$t('form.client_portal')">
                                            <template #body="{ data }">
                                                <Tag v-if="data.client_portal" :value="$t('basic.yes')" severity="success" />
                                                <Tag v-else :value="$t('basic.no')" severity="danger" />
                                            </template>
                                        </Column>
                                    </DataTable>
                                </TabPanel>

                                <!-- Addresses table -->
                                <TabPanel value="addresses">
                                    <DataTable id="addresses_table" class="col-12" :value="partner.addresses">
                                        <template #empty>
                                            <div class="p-4 pl-0 text-center w-full dark:text-gray-400">
                                                <i class="fa fa-info-circle empty-icon"></i>
                                                <p>{{ $t('partner.no_addresses') }}</p>
                                            </div>
                                        </template>

                                        <Column field="type" :header="$t('form.type')">
                                            <template #body="{ data }">
                                                <div class="flex gap-2">
                                                    <i v-if="data.is_primary" class="fa fa-star text-yellow-500 mr-2"></i>
                                                    <Tag v-if="data.type === 'billing'" :value="$t('address_types.billing')" />
                                                    <Tag v-if="data.type === 'shipping'" :value="$t('address_types.shipping')" />
                                                    <Tag v-if="data.type === 'office'" :value="$t('address_types.office')" />
                                                    <Tag v-if="data.type === 'other'" :value="$t('basic.other')" />
                                                </div>
                                            </template>
                                        </Column>
                                        <Column field="address" :header="$t('form.address')" />
                                        <Column field="zip_code" :header="$t('form.zip_code')" />
                                        <Column field="city" :header="$t('form.city')" />
                                        <Column field="country" :header="$t('form.country')">
                                            <template #body="slotProps">
                                                {{ formatCountry(slotProps.data.country) }}
                                            </template>
                                        </Column>
                                    </DataTable>
                                </TabPanel>
                            </TabPanels>
                        </Tabs>
                    </div>
                </div>
            </div>
        </LoadingScreen>
    </DefaultLayout>
</template>
<script>
export default {
    name: 'ClientPortalPartnerDetails',
    data() {
        return {
            partner: null,
        }
    },

    methods: {
        getPartnerData() {
            this.makeHttpRequest('GET', '/api/client-portal/partner-details').then((response) => {
                this.partner = response.data.data
            })
        },
    },

    created() {
        this.getPartnerData()
    },
}
</script>
