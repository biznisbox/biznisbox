<template>
    <user-layout>
        <div id="estimates_page">
            <user-header :title="$t('estimate.estimate', 2)">
                <template #actions>
                    <HeaderActionButton :label="$t('estimate.new_estimate')" icon="fa fa-plus" to="/estimates/new" />
                </template>
            </user-header>
            <div id="estimate_table" class="card">
                <DataTable
                    :value="estimates"
                    :loading="loadingData"
                    column-resize-mode="expand"
                    paginator
                    :rows="10"
                    paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    :rows-per-page-options="[10, 20, 50]"
                    @row-dblclick="viewEstimateNavigation"
                >
                    <template #empty>
                        <div class="p-4 pl-0 text-center w-full text-gray-500">
                            <i class="fa fa-info-circle empty-icon"></i>
                            <p>{{ $t('estimate.no_estimates') }}</p>
                            <Button
                                class="mt-3"
                                :label="$t('estimate.create_first_estimate')"
                                icon="fa fa-plus"
                                @click="$router.push('/estimates/new')"
                            />
                        </div>
                    </template>

                    <Column field="number" :header="$t('estimate.estimate_number')">
                        <template #body="{ data }">
                            {{ data.number }}
                        </template>
                    </Column>

                    <Column :header="$t('estimate.date_and_due_date')">
                        <template #body="{ data }">
                            <span>{{ data.date ? formatDate(data.date) : '' }}</span> <br />
                            <span>{{ data.due_date ? formatDate(data.date) : '' }}</span>
                        </template>
                    </Column>

                    <Column :header="$t('estimate.customer_and_payer')">
                        <template #body="{ data }">
                            {{ formatText(data.customer_name) }} <br />
                            {{ formatText(data.payer_name) }}
                        </template>
                    </Column>

                    <Column field="total" :header="$t('invoice.total')">
                        <template #body="{ data }">
                            {{ data.total + ' ' + data.currency }}
                        </template>
                    </Column>

                    <Column filter-field="status" :header="$t('invoice.status')">
                        <template #body="{ data }">
                            <Tag v-if="data.status === 'accepted'" severity="success">{{ $t('status.accepted') }}</Tag>
                            <Tag v-if="data.status === 'rejected'" severity="danger">{{ $t('status.rejected') }}</Tag>
                            <Tag v-if="data.status === 'draft'" severity="warning">{{ $t('status.draft') }}</Tag>
                            <Tag v-if="data.status === 'sent'" severity="warning">{{ $t('status.sent') }}</Tag>
                            <Tag v-if="data.status === 'viewed'" severity="warning">{{ $t('status.viewed') }}</Tag>
                            <Tag v-if="data.status === 'expired'" severity="danger">{{ $t('status.expired') }}</Tag>
                            <Tag v-if="data.status === 'cancelled'" severity="">{{ $t('status.cancelled') }}</Tag>
                            <Tag v-if="data.status === 'converted'" severity="success">{{ $t('status.converted') }}</Tag>
                        </template>
                    </Column>
                    <template #paginatorstart>
                        <div class="p-d-flex p-ai-center p-mr-2">
                            <Button class="p-button-rounded p-button-text p-button-plain" icon="fa fa-sync" @click="getEstimates()" />
                        </div>
                    </template>
                </DataTable>
            </div>
        </div>
    </user-layout>
</template>

<script>
import EstimateMixin from '@/mixins/estimates'
export default {
    name: 'EstimatesPage',
    mixins: [EstimateMixin],
    created() {
        this.getEstimates()
    },

    methods: {
        viewEstimateNavigation(rowData) {
            this.$router.push(`/estimates/${rowData.data.id}`)
        },
    },
}
</script>

<style></style>
