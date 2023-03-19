<template>
    <user-layout>
        <div id="vendors_page">
            <user-header :title="$t('vendor.vendor', 2)">
                <template #actions>
                    <HeaderActionButton :label="$t('vendor.new_vendor')" icon="fa fa-plus" to="/vendors/new" />
                </template>
            </user-header>

            <div id="vendors_table" class="card">
                <DataTable
                    :value="vendors"
                    :loading="loadingData"
                    column-resize-mode="expand"
                    paginator
                    :rows="10"
                    paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    :rows-per-page-options="[10, 20, 50]"
                    @row-dblclick="viewVendorNavigation"
                >
                    <template #empty>
                        <div class="p-4 pl-0 text-center w-full text-gray-500">
                            <i class="fa fa-info-circle empty-icon"></i>
                            <p>{{ $t('vendor.no_vendors') }}</p>
                            <Button
                                class="mt-3"
                                :label="$t('vendor.create_first_vendor')"
                                icon="fa fa-plus"
                                @click="$router.push('/vendors/new')"
                            />
                        </div>
                    </template>

                    <Column :header="$t('vendor.name_and_tax_number')">
                        <template #body="{ data }">
                            <span v-if="data.name"> {{ data.name }}</span>
                            <br />
                            <span v-if="data.vat_number"> {{ data.vat_number }}</span>
                        </template>
                    </Column>

                    <Column :header="$t('vendor.email_and_phone')">
                        <template #body="{ data }">
                            <span v-if="data.email"> {{ data.email }}</span>
                            <br />
                            <span v-if="data.phone"> {{ data.phone }}</span>
                        </template>
                    </Column>

                    <Column :header="$t('vendor.country')">
                        <template #body="{ data }">
                            <span v-if="data.country"> {{ formatCountry(data.country) }}</span>
                        </template>
                    </Column>
                    <template #paginatorstart>
                        <div class="p-d-flex p-ai-center p-mr-2">
                            <Button class="p-button-rounded p-button-text p-button-plain" icon="fa fa-sync" @click="getVendors()" />
                        </div>
                    </template>
                </DataTable>
            </div>
        </div>
    </user-layout>
</template>

<script>
import VendorMixin from '@/mixins/vendors'
export default {
    name: 'VendorsPage',
    mixins: [VendorMixin],

    created() {
        this.getVendors()
    },

    methods: {
        viewVendorNavigation(event) {
            this.$router.push(`/vendors/${event.data.id}`)
        },
    },
}
</script>

<style></style>
