<template>
    <DefaultLayout>
        <PageHeader :title="$t('quote.quote', 3)">
            <template v-slot:actions>
                <Button :label="$t('quote.new_quote')" icon="fa fa-plus" @click="$router.push('/quotes/create')" />
            </template>
        </PageHeader>

        <div id="quote_table" class="card">
            <DataTable
                :value="quotes"
                paginator
                dataKey="id"
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50, 100]"
                :loading="loadingData"
                @row-dblclick="viewQuoteNavigation"
                filter-display="menu"
                v-model:filters="filters"
            >
                <template #empty>
                    <div class="p-4 pl-0 text-center w-full">
                        <i class="fa fa-info-circle empty-icon"></i>
                        <p>{{ $t('quote.no_quotes') }}</p>
                        <Button
                            class="mt-3"
                            :label="$t('quote.create_first_quote')"
                            icon="fa fa-plus"
                            @click="$router.push('/quotes/create')"
                        />
                    </div>
                </template>

                <Column field="number" :header="$t('form.number')">
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" placeholder="Search by number" />
                    </template>
                </Column>
                <Column field="date" :header="$t('quote.date_and_due_date')">
                    <template #body="{ data }">
                        <span>{{ data.date ? formatDate(data.date) : '' }}</span> <br />
                        <span>{{ data.valid_until ? formatDate(data.valid_until) : '' }}</span>
                    </template>
                    <template #filter="{ filterModel }">
                        <div class="flex">
                            <InputText v-model="filterModel.value" placeholder="Search by date" />
                        </div>
                    </template>
                </Column>
                <Column field="customer" :header="$t('quote.customer_and_payer')">
                    <template #body="{ data }">
                        {{ formatText(data.customer_name) }} <br />
                        {{ formatText(data.payer_name) }}
                    </template>
                </Column>
                <Column field="total" :header="$t('form.total')">
                    <template #body="{ data }">
                        {{ formatMoney(data.total, data.currency) }}
                    </template>

                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" placeholder="Search by total" />
                    </template>
                </Column>
                <Column filter-field="status" :header="$t('form.status')">
                    <template #body="{ data }">
                        <Tag v-if="data.status === 'accepted'" severity="success">{{ $t('status.accepted') }}</Tag>
                        <Tag v-if="data.status === 'rejected'" severity="danger">{{ $t('status.rejected') }}</Tag>
                        <Tag v-if="data.status === 'draft'" severity="warn">{{ $t('status.draft') }}</Tag>
                        <Tag v-if="data.status === 'sent'" severity="warn">{{ $t('status.sent') }}</Tag>
                        <Tag v-if="data.status === 'viewed'" severity="warn">{{ $t('status.viewed') }}</Tag>
                        <Tag v-if="data.status === 'expired'" severity="danger">{{ $t('status.expired') }}</Tag>
                        <Tag v-if="data.status === 'cancelled'" severity="">{{ $t('status.cancelled') }}</Tag>
                        <Tag v-if="data.status === 'converted'" severity="success">{{ $t('status.converted') }}</Tag>
                    </template>
                    <template #filter="{ filterModel }">
                        <Select
                            v-model="filterModel.value"
                            :options="[
                                { label: $t('status.accepted'), value: 'accepted' },
                                { label: $t('status.rejected'), value: 'rejected' },
                                { label: $t('status.draft'), value: 'draft' },
                                { label: $t('status.sent'), value: 'sent' },
                                { label: $t('status.viewed'), value: 'viewed' },
                                { label: $t('status.expired'), value: 'expired' },
                                { label: $t('status.cancelled'), value: 'cancelled' },
                                { label: $t('status.converted'), value: 'converted' },
                            ]"
                            option-label="label"
                            option-value="value"
                            placeholder="Select a status"
                        />
                    </template>
                </Column>
                <template #paginatorstart>
                    <Button id="refresh_button" icon="fa fa-sync" @click="getQuotes" />
                </template>
            </DataTable>
        </div>
    </DefaultLayout>
</template>

<script>
import QuotesMixin from '@/mixins/quotes'
import { FilterMatchMode, FilterOperator } from '@primevue/core/api'
export default {
    name: 'QuotesPage',
    mixins: [QuotesMixin],

    created() {
        this.getQuotes()
        this.initFilters()
    },

    methods: {
        initFilters() {
            this.filters = {
                number: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                date: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                total: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
                status: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
            }
        },
    },
    data() {
        return {
            filters: null,
        }
    },
}
</script>
<style></style>
