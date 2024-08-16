<template>
    <DefaultLayout>
        <PageHeader :title="$t('bill.bill', 2)">
            <template #actions>
                <Button :label="$t('bill.new_bill')" icon="fa fa-plus" @click="$router.push({ name: 'bill-create' })" />
            </template>
        </PageHeader>

        <div id="bills_table" class="card">
            <DataTable
                :value="bills"
                paginator
                dataKey="id"
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50, 100]"
                :loading="loadingData"
                @row-dblclick="viewBillNavigation"
                filter-display="menu"
                v-model:filters="filters"
            >
                <template #empty>
                    <div class="p-4 pl-0 text-center w-full">
                        <i class="fa fa-info-circle empty-icon"></i>
                        <p>{{ $t('bill.no_bills') }}</p>
                        <Button
                            class="mt-3"
                            :label="$t('bill.create_first_bill')"
                            icon="fa fa-plus"
                            @click="$router.push({ name: 'bill-create' })"
                        />
                    </div>
                </template>

                <Column field="number" :header="$t('form.number')">
                    <template #body="{ data }">
                        {{ data.number }}
                    </template>
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" type="text" placeholder="Search by number" />
                    </template>
                </Column>
                <Column field="supplier_name" :header="$t('form.supplier')">
                    <template #body="{ data }">
                        {{ data.supplier_name }}
                    </template>
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" type="text" placeholder="Search by supplier" />
                    </template>
                </Column>
                <Column field="date" :header="$t('bill.date_and_due_date')">
                    <template #body="{ data }">
                        <span class="date">{{ data.date ? formatDate(data.date) : '-' }}</span> <br />
                        <span class="due_date">{{ data.due_date ? formatDate(data.due_date) : '-' }}</span>
                    </template>

                    <template #filter="{ filterModel }">
                        <div class="flex">
                            <InputText v-model="filterModel.value" type="text" placeholder="Search by date" />
                        </div>
                    </template>
                </Column>
                <Column field="status" :header="$t('form.status')">
                    <template #body="{ data }">
                        <div class="status">
                            <Tag v-if="data.status === 'paid'" severity="success">{{ $t('status.paid') }}</Tag>
                            <Tag v-if="data.status === 'unpaid'" severity="danger">{{ $t('status.unpaid') }}</Tag>
                            <Tag v-if="data.status === 'overdue'" severity="danger">{{ $t('status.overdue') }}</Tag>
                            <Tag v-if="data.status === 'draft'" severity="warning">{{ $t('status.draft') }}</Tag>
                            <Tag v-if="data.status === 'cancelled'">{{ $t('status.cancelled') }}</Tag>
                        </div>
                    </template>

                    <template #filter="{ filterModel }">
                        <Select
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
                            placeholder="Search by status"
                        />
                    </template>
                </Column>

                <Column field="total" :header="$t('form.total')">
                    <template #body="{ data }">
                        <div class="total">
                            {{ formatMoney(data.total, data.currency) }}
                        </div>
                    </template>

                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" type="text" placeholder="Search by total" />
                    </template>
                </Column>
                <template #paginatorstart>
                    <Button icon="fa fa-sync" @click="getBills" />
                </template>
            </DataTable>
        </div>
    </DefaultLayout>
</template>

<script>
import { FilterMatchMode, FilterOperator } from '@primevue/core/api'
import BillMixin from '@/mixins/bills'
export default {
    name: 'BillsPage',
    mixins: [BillMixin],
    created() {
        this.getBills()
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
