<template>
    <DefaultLayout>
        <PageHeader :title="$t('contract.contract', 3)">
            <template #actions>
                <Button :label="$t('contract.create_contract')" icon="fa fa-plus" @click="$router.push('/contracts/create')" />
            </template>
        </PageHeader>

        <div id="contracts_table" class="card">
            <DataTable
                :value="contracts"
                :loading="loadingData"
                paginator
                dataKey="id"
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50, 100]"
                filter-display="menu"
                v-model:filters="filters"
                @row-dblclick="viewContractNavigation"
            >
                <template #empty>
                    <div class="p-4 pl-0 text-center w-full dark:text-gray-400">
                        <i class="fa fa-info-circle empty-icon"></i>
                        <p>{{ $t('contract.no_contracts') }}</p>
                        <Button
                            class="mt-3"
                            :label="$t('contract.create_contract')"
                            icon="fa fa-plus"
                            @click="$router.push('/contracts/create')"
                        />
                    </div>
                </template>

                <Column field="number" :header="$t('form.number')" sortable>
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" type="text" placeholder="Search by number" />
                    </template>
                </Column>

                <Column field="title" :header="$t('form.title')">
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" type="text" placeholder="Search by title" />
                    </template>
                </Column>

                <Column field="status" :header="$t('form.status')">
                    <template #body="{ data }">
                        <Tag v-if="data.status === 'draft'" severity="info" :value="$t('status.draft')" />
                        <Tag v-else-if="data.status === 'waiting_signers'" severity="warn" :value="$t('status.waiting_signers')" />
                        <Tag v-else-if="data.status === 'signed'" severity="success" :value="$t('status.signed')" />
                        <Tag v-else-if="data.status === 'rejected'" severity="danger" :value="$t('status.rejected')" />
                        <Tag v-else-if="data.status === 'cancelled'" severity="secondary" :value="$t('status.cancelled')" />
                        <Tag v-else-if="data.status === 'expired'" severity="danger" :value="$t('status.expired')" />
                    </template>
                    <template #filter="{ filterModel }">
                        <Select
                            v-model="filterModel.value"
                            :options="[
                                { label: $t('status.draft'), value: 'draft' },
                                { label: $t('status.waiting_signers'), value: 'waiting_signers' },
                                { label: $t('status.signed'), value: 'signed' },
                                { label: $t('status.rejected'), value: 'rejected' },
                                { label: $t('status.cancelled'), value: 'cancelled' },
                                { label: $t('status.expired'), value: 'expired' },
                            ]"
                            option-label="label"
                            option-value="value"
                            show-clear
                        />
                    </template>
                </Column>
                <template #paginatorstart>
                    <Button icon="fa fa-sync" @click="getContracts" id="refresh_button" />
                </template>
            </DataTable>
        </div>
    </DefaultLayout>
</template>

<script>
import { FilterMatchMode, FilterOperator } from '@primevue/core/api'
import ContractMixin from '@/mixins/contracts'
export default {
    name: 'InvoicesPage',
    mixins: [ContractMixin],
    created() {
        this.getContracts()
        this.initFilters()
    },

    data() {
        return {
            filters: null,
        }
    },

    methods: {
        initFilters() {
            this.filters = {
                number: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                title: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                status: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
            }
        },

        viewContractNavigation(rowData) {
            this.$router.push(`/contracts/${rowData.data.id}`)
        },
    },
}
</script>
