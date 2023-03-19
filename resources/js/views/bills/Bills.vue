<template>
    <user-layout>
        <div id="bills_page">
            <user-header :title="$t('bill.bill', 2)">
                <template #actions>
                    <HeaderActionButton :label="$t('bill.new_bill')" icon="fa fa-plus" to="/bills/new" />
                </template>
            </user-header>
            <div id="bills_table" class="card">
                <DataTable
                    :value="bills"
                    :loading="loadingData"
                    paginator
                    :rows="10"
                    paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    :rows-per-page-options="[10, 20, 50]"
                    column-resize-mode="expand"
                    @row-dblclick="viewBillNavigation"
                >
                    <template #empty>
                        <div class="p-4 pl-0 text-center w-full text-gray-500">
                            <i class="fa fa-info-circle empty-icon"></i>
                            <p>{{ $t('bill.no_bills') }}</p>
                            <Button
                                class="mt-3"
                                :label="$t('bill.create_first_bill')"
                                icon="fa fa-plus"
                                @click="$router.push('/bills/new')"
                            />
                        </div>
                    </template>

                    <Column field="number" :header="$t('bill.bill_number')" sortable></Column>
                    <Column :header="$t('bill.date_and_due_date')">
                        <template #body="slotProps">
                            <div class="date_due_date">
                                <div class="date">{{ slotProps.data.date ? formatDate(slotProps.data.date) : '-' }}</div>
                                <div class="due_date">{{ slotProps.data.due_date ? formatDate(slotProps.data.due_date) : '-' }}</div>
                            </div>
                        </template>
                    </Column>
                    <Column :header="$t('bill.status')">
                        <template #body="slotProps">
                            <div class="status">
                                <Tag v-if="slotProps.data.status === 'paid'" severity="success">{{ $t('status.paid') }}</Tag>
                                <Tag v-if="slotProps.data.status === 'unpaid'" severity="danger">{{ $t('status.unpaid') }}</Tag>
                                <Tag v-if="slotProps.data.status === 'overdue'" severity="danger">{{ $t('status.overdue') }}</Tag>
                                <Tag v-if="slotProps.data.status === 'draft'" severity="warning">{{ $t('status.draft') }}</Tag>
                                <Tag v-if="slotProps.data.status === 'cancelled'" severity="">{{ $t('status.cancelled') }}</Tag>
                            </div>
                        </template>
                    </Column>

                    <Column field="total" :header="$t('bill.total')">
                        <template #body="slotProps">
                            <div class="total">
                                {{ slotProps.data.total + ' ' + $settings.default_currency }}
                            </div>
                        </template>
                    </Column>
                    <template #paginatorstart>
                        <div class="p-d-flex p-ai-center p-mr-2">
                            <Button class="p-button-rounded p-button-text p-button-plain" icon="fa fa-sync" @click="getBills()" />
                        </div>
                    </template>
                </DataTable>
            </div>
        </div>
    </user-layout>
</template>

<script>
import BillsMixin from '@/mixins/bills'
export default {
    name: 'BillsPage',
    mixins: [BillsMixin],

    created() {
        this.getBills()
    },

    methods: {
        viewBillNavigation(rowData) {
            this.$router.push(`/bills/${rowData.data.id}`)
        },
    },
}
</script>

<style></style>
