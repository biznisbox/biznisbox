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
                    v-model:filters="filters"
                    :value="bills"
                    :loading="loadingData"
                    paginator
                    data-key="id"
                    :rows="10"
                    filter-display="menu"
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

                    <Column field="number" :header="$t('form.number')">
                        <template #body="{ data }">
                            {{ data.number }}
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by number" />
                        </template>
                    </Column>
                    <Column field="supplier_name" :header="$t('form.supplier')">
                        <template #body="{ data }">
                            {{ data.supplier_name }}
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by supplier" />
                        </template>
                    </Column>
                    <Column field="date" :header="$t('bill.date_and_due_date')">
                        <template #body="{ data }">
                            <span class="date">{{ data.date ? formatDate(data.date) : '-' }}</span> <br />
                            <span class="due_date">{{ data.due_date ? formatDate(data.due_date) : '-' }}</span>
                        </template>

                        <template #filter="{ filterModel }">
                            <div class="flex">
                                <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by date" />
                            </div>
                        </template>
                    </Column>
                    <Column field="status" :header="$t('form.status')">
                        <template #body="slotProps">
                            <div class="status">
                                <Tag v-if="slotProps.data.status === 'paid'" severity="success">{{ $t('status.paid') }}</Tag>
                                <Tag v-if="slotProps.data.status === 'unpaid'" severity="danger">{{ $t('status.unpaid') }}</Tag>
                                <Tag v-if="slotProps.data.status === 'overdue'" severity="danger">{{ $t('status.overdue') }}</Tag>
                                <Tag v-if="slotProps.data.status === 'draft'" severity="warning">{{ $t('status.draft') }}</Tag>
                                <Tag v-if="slotProps.data.status === 'cancelled'" severity="">{{ $t('status.cancelled') }}</Tag>
                            </div>
                        </template>

                        <template #filter="{ filterModel }">
                            <Dropdown
                                v-model="filterModel.value"
                                :options="[
                                    { label: $t('status.paid'), value: 'paid' },
                                    { label: $t('status.unpaid'), value: 'unpaid' },
                                    { label: $t('status.overdue'), value: 'overdue' },
                                    { label: $t('status.draft'), value: 'draft' },
                                    { label: $t('status.cancelled'), value: 'cancelled' },
                                ]"
                                option-label="label"
                                option-value="value"
                                class="p-column-filter"
                                placeholder="Search by status"
                            />
                        </template>
                    </Column>

                    <Column field="total" :header="$t('form.total')">
                        <template #body="{ data }">
                            <div class="total">
                                {{ data.total + ' ' + data.currency }}
                            </div>
                        </template>

                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by total" />
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
import { FilterMatchMode, FilterOperator } from 'primevue/api'
import BillsMixin from '@/mixins/bills'
export default {
    name: 'BillsPage',
    mixins: [BillsMixin],

    data() {
        return {
            filters: null,
        }
    },

    created() {
        this.getBills()
        this.initFilters()
    },

    methods: {
        viewBillNavigation(rowData) {
            this.$router.push(`/bills/${rowData.data.id}`)
        },

        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                number: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                supplier_name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                date: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                total: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
                status: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
            }
        },
    },
}
</script>

<style></style>
