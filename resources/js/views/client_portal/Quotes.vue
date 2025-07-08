<template>
    <DefaultLayout menu_type="client">
        <PageHeader :title="$t('quote.quote', 3)" />

        <div id="quote_table" class="card">
            <DataTable
                :value="quotes"
                :loading="loadingData"
                paginator
                dataKey="id"
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50, 100]"
                @row-dblclick="viewQuoteNavigationClientPortal"
            >
                <template #empty>
                    <div class="p-4 pl-0 text-center w-full dark:text-gray-400">
                        <i class="fa fa-info-circle empty-icon"></i>
                        <p>{{ $t('quote.no_quotes') }}</p>
                    </div>
                </template>

                <Column field="number" :header="$t('form.number')"> </Column>
                <Column field="date" :header="$t('quote.date_and_due_date')">
                    <template #body="{ data }">
                        <span>{{ data.date ? formatDate(data.date) : '' }}</span> <br />
                        <span>{{ data.valid_until ? formatDate(data.valid_until) : '' }}</span>
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
                </Column>
                <Column filter-field="status" :header="$t('form.status')">
                    <template #body="{ data }">
                        <Tag v-if="data.status === 'accepted'" severity="success">{{ $t('status.accepted') }}</Tag>
                        <Tag v-if="data.status === 'rejected'" severity="danger">{{ $t('status.rejected') }}</Tag>
                        <Tag v-if="data.status === 'draft'" severity="warn">{{ $t('status.draft') }}</Tag>
                        <Tag v-if="data.status === 'sent'" severity="warn">{{ $t('status.sent') }}</Tag>
                        <Tag v-if="data.status === 'viewed'" severity="warn">{{ $t('status.viewed') }}</Tag>
                        <Tag v-if="data.status === 'expired'" severity="danger">{{ $t('status.expired') }}</Tag>
                        <Tag v-if="data.status === 'cancelled'" severity="secondary">{{ $t('status.cancelled') }}</Tag>
                        <Tag v-if="data.status === 'converted'" severity="success">{{ $t('status.converted') }}</Tag>
                    </template>
                </Column>
                <template #paginatorstart>
                    <Button icon="fa fa-sync" @click="getQuotes" id="refresh_button" />
                </template>
            </DataTable>
        </div>
    </DefaultLayout>
</template>

<script>
import quotes from '@/mixins/quotes'

export default {
    name: 'ClientPortalQuotesPage',
    data() {
        return {
            quotes: null,
        }
    },

    methods: {
        getQuotes() {
            this.makeHttpRequest('GET', '/api/client-portal/quotes').then((response) => {
                this.quotes = response.data.data
            })
        },

        viewQuoteNavigationClientPortal(rowData) {
            this.$router.push({
                name: 'client-portal-quote-view',
                params: { id: rowData.data.id },
            })
        },
    },

    created() {
        this.getQuotes()
    },
}
</script>
