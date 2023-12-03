<template>
    <user-layout>
        <div id="products_page">
            <user-header :title="$t('product.product', 2)">
                <template #actions>
                    <HeaderActionButton :label="$t('product.new_product')" icon="fa fa-plus" to="/products/new" />
                </template>
            </user-header>
            <div id="products_table" class="card">
                <DataTable
                    v-model:filters="filters"
                    :value="products"
                    :loading="loadingData"
                    column-resize-mode="expand"
                    paginator
                    filter-display="menu"
                    data-key="id"
                    :rows="10"
                    paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    :rows-per-page-options="[10, 20, 50]"
                    :global-filter-fields="['name', 'stock_status', 'sell_price', 'buy_price']"
                    @row-dblclick="viewProductNavigation"
                >
                    <template #empty>
                        <div class="p-4 pl-0 text-center w-full text-gray-500">
                            <i class="fa fa-info-circle empty-icon"></i>
                            <p>{{ $t('product.no_products') }}</p>
                            <Button
                                class="mt-3"
                                :label="$t('product.create_first_product')"
                                icon="fa fa-plus"
                                @click="$router.push('/products/new')"
                            />
                        </div>
                    </template>

                    <Column field="number" :header="$t('form.number')" sortable>
                        <template #body="{ data }">
                            <span>{{ data.number }}</span>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by number" />
                        </template>
                    </Column>

                    <Column field="name" :header="$t('form.name')" sortable>
                        <template #body="{ data }">
                            {{ data.name }}
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by name" />
                        </template>
                    </Column>
                    <Column field="sell_price" :header="$t('form.sell_price')" sortable>
                        <template #body="{ data }">
                            {{ formatMoney(data.sell_price) }}
                        </template>

                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by sell price" />
                        </template>
                    </Column>
                    <Column field="buy_price" :header="$t('form.buy_price')" sortable>
                        <template #body="{ data }"> {{ formatMoney(data.buy_price) }} </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by buy price" />
                        </template>
                    </Column>
                    <Column field="stock_status" :header="$t('form.stock_status')" sortable>
                        <template #body="{ data }">
                            <Tag v-if="data.stock_status === 'out_of_stock'" severity="danger"> {{ $t('stock_status.out_of_stock') }}</Tag>
                            <Tag v-if="data.stock_status === 'in_stock'" severity="success"> {{ $t('stock_status.in_stock') }}</Tag>
                            <Tag v-if="data.stock_status === 'low_stock'" severity="warning"> {{ $t('stock_status.low_stock') }}</Tag>
                            <Tag v-if="data.stock_status === 'over_stock'" severity="warning"> {{ $t('stock_status.over_stock') }}</Tag>
                            <Tag v-if="data.stock_status === 'unknown'"> {{ $t('stock_status.unknown') }}</Tag>
                        </template>

                        <template #filter="{ filterModel }">
                            <Dropdown
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
                                class="p-column-filter"
                                placeholder="Search by stock status"
                            />
                        </template>
                    </Column>

                    <template #paginatorstart>
                        <div class="p-d-flex p-ai-center p-mr-2">
                            <Button class="p-button-rounded p-button-text p-button-plain" icon="fa fa-sync" @click="getProducts()" />
                        </div>
                    </template>
                </DataTable>
            </div>
        </div>
    </user-layout>
</template>

<script>
import { FilterMatchMode, FilterOperator } from 'primevue/api'
import ProductMixin from '@/mixins/products'
export default {
    name: 'ProductsPage',
    mixins: [ProductMixin],

    data() {
        return {
            filters: {},
        }
    },
    created() {
        this.getProducts()
        this.initFilters()
    },

    methods: {
        /**
         * Function that redirects to product view page
         * @param {string} id
         */
        viewProductNavigation(event) {
            this.$router.push(`/products/${event.data.id}`)
        },

        initFilters() {
            this.filters = {
                number: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                sell_price: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                buy_price: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
                stock_status: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
            }
        },
    },
}
</script>

<style></style>
