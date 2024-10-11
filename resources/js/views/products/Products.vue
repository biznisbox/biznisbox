<template>
    <DefaultLayout>
        <PageHeader :title="$t('product.product', 3)">
            <template v-slot:actions>
                <Button :label="$t('product.new_product')" icon="fa fa-plus" @click="$router.push('/products/create')" />
            </template>
        </PageHeader>

        <div id="products_table" class="card">
            <DataTable
                :value="products"
                paginator
                dataKey="id"
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50, 100]"
                :loading="loadingData"
                @row-dblclick="viewProductNavigation"
                filter-display="menu"
                v-model:filters="filters"
            >
                <template #empty>
                    <div class="p-4 pl-0 text-center w-full">
                        <i class="fa fa-info-circle empty-icon"></i>
                        <p>{{ $t('product.no_products') }}</p>
                        <Button
                            class="mt-3"
                            :label="$t('product.create_first_product')"
                            icon="fa fa-plus"
                            @click="$router.push('/products/create')"
                        />
                    </div>
                </template>

                <Column field="number" :header="$t('form.number')" sortable>
                    <template #body="{ data }">
                        <span>{{ data.number }}</span>
                    </template>
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" type="text" placeholder="Search by number" />
                    </template>
                </Column>

                <Column field="name" :header="$t('form.name')" sortable>
                    <template #body="{ data }">
                        {{ data.name }}
                    </template>
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" type="text" placeholder="Search by name" />
                    </template>
                </Column>
                <Column field="sell_price" :header="$t('form.sell_price')" sortable>
                    <template #body="{ data }">
                        {{ formatMoney(data.sell_price) }}
                    </template>

                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" type="text" placeholder="Search by sell price" />
                    </template>
                </Column>
                <Column field="buy_price" :header="$t('form.buy_price')" sortable>
                    <template #body="{ data }"> {{ formatMoney(data.buy_price) }} </template>
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" type="text" placeholder="Search by buy price" />
                    </template>
                </Column>

                <Column field="type" :header="$t('form.type')" sortable>
                    <template #body="{ data }">
                        <Tag v-if="data.type === 'product'" severity="success"> {{ $t('product_type.product') }}</Tag>
                        <Tag v-if="data.type === 'service'" severity="info"> {{ $t('product_type.service') }}</Tag>
                    </template>

                    <template #filter="{ filterModel }">
                        <Select
                            v-model="filterModel.value"
                            :options="[
                                { label: $t('product_type.product'), value: 'product' },
                                { label: $t('product_type.service'), value: 'service' },
                            ]"
                            option-label="label"
                            option-value="value"
                            placeholder="Search by type"
                        />
                    </template>
                </Column>

                <Column field="stock_status" :header="$t('form.stock_status')" sortable>
                    <template #body="{ data }">
                        <Tag v-if="data.stock_status === 'out_of_stock'" severity="danger"> {{ $t('stock_status.out_of_stock') }}</Tag>
                        <Tag v-if="data.stock_status === 'in_stock'" severity="success"> {{ $t('stock_status.in_stock') }}</Tag>
                        <Tag v-if="data.stock_status === 'low_stock'" severity="warn"> {{ $t('stock_status.low_stock') }}</Tag>
                        <Tag v-if="data.stock_status === 'over_stock'" severity="warn"> {{ $t('stock_status.over_stock') }}</Tag>
                    </template>

                    <template #filter="{ filterModel }">
                        <Select
                            v-model="filterModel.value"
                            :options="[
                                { label: $t('stock_status.out_of_stock'), value: 'out_of_stock' },
                                { label: $t('stock_status.in_stock'), value: 'in_stock' },
                                { label: $t('stock_status.low_stock'), value: 'low_stock' },
                                { label: $t('stock_status.over_stock'), value: 'over_stock' },
                                { label: $t('stock_status.unknown'), value: 'unknown' },
                            ]"
                            option-label="label"
                            option-value="value"
                            placeholder="Search by stock status"
                        />
                    </template>
                </Column>

                <template #paginatorstart>
                    <Button icon="fa fa-sync" @click="getProducts()" />
                </template>
            </DataTable>
        </div>
    </DefaultLayout>
</template>

<script>
import { FilterMatchMode, FilterOperator } from '@primevue/core/api'
import ProductMixin from '@/mixins/products'
export default {
    name: 'ProductsPage',
    mixins: [ProductMixin],

    created() {
        this.initFilters()
        this.getProducts()
    },

    data() {
        return {
            filters: {},
        }
    },

    methods: {
        /**
         * Function for init filters
         * @return {void}
         */
        initFilters() {
            this.filters = {
                number: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                sell_price: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                buy_price: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                type: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
                stock_status: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
            }
        },
    },
}
</script>
