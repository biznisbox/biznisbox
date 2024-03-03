<template>
    <user-layout>
        <div id="partners_page">
            <user-header :title="$t('partner.partner', 2)">
                <template #actions>
                    <HeaderActionButton :label="$t('partner.new_partner')" icon="fa fa-plus" to="/partners/new" />
                </template>
            </user-header>

            <div id="partners_table" class="card">
                <DataTable
                    v-model:filters="filters"
                    :value="partners"
                    :loading="loadingData"
                    column-resize-mode="expand"
                    paginator
                    data-key="id"
                    :rows="10"
                    filter-display="menu"
                    paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    :rows-per-page-options="[10, 20, 50]"
                    @row-dblclick="viewPartnerNavigation"
                >
                    <Column field="number" :header="$t('form.number')" sortable="">
                        <template #body="{ data }">
                            {{ data.number }}
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by number" />
                        </template>
                    </Column>

                    <Column field="name" :header="$t('form.name')">
                        <template #body="{ data }">
                            {{ data.name }}
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by name" />
                        </template>
                    </Column>

                    <Column field="type" :header="$t('form.type')">
                        <template #body="{ data }">
                            <Tag v-if="data.type === 'customer'">{{ $t('partner_types.customer') }}</Tag>
                            <Tag v-else-if="data.type === 'supplier'">{{ $t('partner_types.supplier') }}</Tag>
                            <Tag v-else-if="data.type === 'both'">{{ $t('partner_types.both') }}</Tag>
                            <Tag v-else>{{ $t('basic.other') }}</Tag>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by type" />
                        </template>
                    </Column>

                    <template #empty>
                        <div class="p-4 pl-0 text-center w-full text-gray-500">
                            <i class="fa fa-info-circle empty-icon"></i>
                            <p>{{ $t('partner.no_partners') }}</p>
                            <Button
                                class="mt-3"
                                :label="$t('partner.create_first_partner')"
                                icon="fa fa-plus"
                                @click="$router.push('/partners/new')"
                            />
                        </div>
                    </template>

                    <template #paginatorstart>
                        <Button
                            class="p-button-rounded p-button-text p-button-plain"
                            id="refresh_button"
                            icon="fa fa-sync"
                            @click="getPartners()"
                        />
                    </template>
                </DataTable>
            </div>
        </div>
    </user-layout>
</template>

<script>
import PartnerMixin from '@/mixins/partners'
import { FilterMatchMode, FilterOperator } from 'primevue/api'
export default {
    name: 'PartnersPage',
    mixins: [PartnerMixin],

    data() {
        return {
            filters: null,
        }
    },
    created() {
        this.getPartners()
        this.initFilters()
    },

    methods: {
        viewPartnerNavigation(rowData) {
            this.$router.push(`/partners/${rowData.data.id}`)
        },

        initFilters() {
            this.filters = {
                number: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                type: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
            }
        },
    },
}
</script>
