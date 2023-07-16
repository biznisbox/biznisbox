<template>
    <user-layout>
        <div id="customers_page">
            <user-header :title="$t('customer.customer', 2)">
                <template #actions>
                    <HeaderActionButton :label="$t('customer.new_customer')" icon="fa fa-plus" to="/customers/new" />
                </template>
            </user-header>

            <div id="customers_table" class="card">
                <DataTable
                    v-model:filters="filters"
                    :value="customers"
                    :loading="loadingData"
                    paginator
                    :rows="10"
                    paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    :rows-per-page-options="[10, 20, 50]"
                    column-resize-mode="expand"
                    filter-display="menu"
                    data-key="id"
                    :global-filter-fields="['name', 'vat_number']"
                    @row-dblclick="viewCustomerNavigation"
                >
                    <template #empty>
                        <div class="p-4 pl-0 text-center w-full text-gray-500">
                            <i class="fa fa-info-circle empty-icon"></i>
                            <p>{{ $t('customer.no_customers') }}</p>
                            <Button
                                class="mt-3"
                                :label="$t('customer.create_first_customer')"
                                icon="fa fa-plus"
                                @click="$router.push('/customers/new')"
                            />
                        </div>
                    </template>

                    <template #header>
                        <div class="flex justify-content-end">
                            <span class="p-input-icon-left">
                                <i class="pi pi-search" />
                                <InputText v-model="filters['global'].value" placeholder="Keyword Search" />
                            </span>
                        </div>
                    </template>
                    <Column field="name" :header="$t('customer.name')">
                        <template #body="{ data }">
                            {{ data.name }}
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by name" />
                        </template>
                    </Column>
                    <Column field="type" :header="$t('customer.type')">
                        <template #body="{ data }">
                            <Tag v-if="data.type === 'individual'" :value="$t('customer.individual')" />
                            <Tag v-if="data.type === 'company'" :value="$t('customer.company')" />
                        </template>
                        <template #filter="{ filterModel }">
                            <Dropdown
                                v-model="filterModel.value"
                                :options="[
                                    { label: $t('customer.individual'), value: 'individual' },
                                    { label: $t('customer.company'), value: 'company' },
                                ]"
                                option-label="label"
                                option-value="value"
                                class="p-column-filter"
                                placeholder="Select type"
                            />
                        </template>
                    </Column>
                    <Column field="address" :header="$t('customer.address')">
                        <template #body="{ data }">
                            <div v-if="data.addresses.length > 0">
                                <span>{{ data.addresses[1].address }}</span>
                                <br />
                                <span>{{ data.addresses[1].zip_code }} {{ data.addresses[1].city }}</span>
                                <br />
                                <span>{{ formatCountry(data.addresses[1].country) }}</span>
                            </div>
                            <span v-else>-</span>
                        </template>
                    </Column>
                    <Column field="vat_number" :header="$t('customer.vat_number')">
                        <template #body="{ data }">
                            <span v-if="data.vat_number">{{ data.vat_number }}</span>
                            <span v-else>-</span>
                        </template>

                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by VAT number" />
                        </template>
                    </Column>
                    <template #paginatorstart>
                        <div class="p-d-flex p-ai-center p-mr-2">
                            <Button class="p-button-rounded p-button-text p-button-plain" icon="fa fa-sync" @click="getCustomers()" />
                        </div>
                    </template>
                </DataTable>
            </div>
        </div>
    </user-layout>
</template>

<script>
import { FilterMatchMode, FilterOperator } from 'primevue/api'
import CustomerMixin from '@/mixins/customers'
export default {
    name: 'CustomersPage',
    mixins: [CustomerMixin],

    data() {
        return {
            filters: null,
        }
    },

    created() {
        this.getCustomers()
        this.initFilters()
    },

    methods: {
        /**
         * Function that redirects to customer view page
         * @param {object} event
         */
        viewCustomerNavigation(event) {
            this.$router.push(`/customers/${event.data.id}`)
        },

        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
                vat_number: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
                type: { operator: FilterOperator.OR, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
            }
        },
    },
}
</script>

<style></style>
