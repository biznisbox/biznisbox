<template>
    <DefaultLayout menu_type="client">
        <PageHeader :title="$t('contract.contract', 3)" />

        <div id="contracts_table" class="card">
            <DataTable
                :value="contracts"
                :loading="loadingData"
                paginator
                dataKey="id"
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50, 100]"
                filter-display="menu"
                @row-dblclick="viewContractNavigation"
            >
                <template #empty>
                    <div class="p-4 pl-0 text-center w-full dark:text-gray-400">
                        <i class="fa fa-info-circle empty-icon"></i>
                        <p>{{ $t('contract.no_contracts') }}</p>
                    </div>
                </template>

                <Column field="number" :header="$t('form.number')" sortable />
                <Column field="title" :header="$t('form.title')" />
                <Column field="status" :header="$t('form.status')">
                    <template #body="{ data }">
                        <Tag v-if="data.status === 'draft'" severity="info" :value="$t('status.draft')" />
                        <Tag v-else-if="data.status === 'waiting_signers'" severity="warn" :value="$t('status.waiting_signers')" />
                        <Tag v-else-if="data.status === 'signed'" severity="success" :value="$t('status.signed')" />
                        <Tag v-else-if="data.status === 'rejected'" severity="danger" :value="$t('status.rejected')" />
                        <Tag v-else-if="data.status === 'cancelled'" severity="secondary" :value="$t('status.cancelled')" />
                        <Tag v-else-if="data.status === 'expired'" severity="danger" :value="$t('status.expired')" />
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
export default {
    name: 'ClientPortalPartnerDetails',
    data() {
        return {
            contracts: [],
        }
    },

    methods: {
        getContracts() {
            this.makeHttpRequest('GET', '/api/client-portal/contracts').then((response) => {
                this.contracts = response.data.data
            })
        },

        viewContractNavigation(rowData) {
            this.$router.push({
                name: 'client-portal-contract-view',
                params: { id: rowData.data.id },
            })
        },
    },

    created() {
        this.getContracts()
    },
}
</script>
