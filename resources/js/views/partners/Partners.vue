<template>
    <DefaultLayout>
        <PageHeader :title="$t('partner.partner', 3)">
            <template v-slot:actions>
                <Button :label="$t('partner.new_partner')" icon="fa fa-plus" @click="$router.push({ name: 'partner-create' })" />
            </template>
        </PageHeader>
        <div class="card">
            <DataTable
                :value="partners"
                paginator
                dataKey="id"
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50, 100]"
                :loading="loadingData"
                @row-dblclick="viewPartnerNavigation"
                filter-display="menu"
                v-model:filters="filters"
            >
                <template #empty>
                    <div class="p-4 pl-0 text-center w-full">
                        <i class="fa fa-info-circle empty-icon"></i>
                        <p>{{ $t('partner.no_partners') }}</p>
                        <Button
                            class="mt-3"
                            :label="$t('partner.create_first_partner')"
                            icon="fa fa-plus"
                            @click="$router.push('/partners/create')"
                        />
                    </div>
                </template>
                <Column field="number" :header="$t('form.number')" sortable>
                    <template #body="{ data }">
                        {{ data.number }}
                    </template>
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" placeholder="Search by number" />
                    </template>
                </Column>
                <Column field="name" :header="$t('form.name')" sortable>
                    <template #body="{ data }">
                        {{ data.name }}
                    </template>
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" placeholder="Search by name" />
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
                        <InputText v-model="filterModel.value" type="text" placeholder="Search by type" />
                    </template>
                </Column>

                <template #paginatorstart>
                    <Button id="refresh_button" icon="fa fa-sync" @click="getPartners()" />
                </template>
            </DataTable>
        </div>
    </DefaultLayout>
</template>
<script>
import { FilterMatchMode, FilterOperator } from '@primevue/core/api'
import PartnerMixin from '@/mixins/partners'
export default {
    name: 'PartnersPage',
    mixins: [PartnerMixin],

    created() {
        this.initFilters()
        this.getPartners()
    },

    data() {
        return {
            filters: {},
        }
    },

    methods: {
        /**
         * Function that redirects to product view page
         * @param {string} id
         **/
        viewPartnerNavigation(event) {
            this.$router.push(`/partners/${event.data.id}`)
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
