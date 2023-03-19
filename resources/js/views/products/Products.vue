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
                    :value="products"
                    :loading="loadingData"
                    column-resize-mode="expand"
                    paginator
                    :rows="10"
                    paginator-template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                    :rows-per-page-options="[10, 20, 50]"
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

                    <Column field="name" :header="$t('product.name')" sortable></Column>
                    <Column field="sell_price" :header="$t('product.sell_price')" sortable>
                        <template #body="{ data }">
                            {{ data.sell_price }} {{ data.sell_price ? $settings.default_currency : '' }}
                        </template>
                    </Column>
                    <Column field="buy_price" :header="$t('product.buy_price')" sortable>
                        <template #body="{ data }"> {{ data.buy_price }} {{ data.buy_price ? $settings.default_currency : '' }} </template>
                    </Column>
                    <Column field="stock_status" :header="$t('product.stock_status')" sortable>
                        <template #body="{ data }">
                            <Tag v-if="data.stock_status === 'out_of_stock'" severity="danger"> {{ $t('stock_status.out_of_stock') }}</Tag>
                            <Tag v-if="data.stock_status === 'in_stock'" severity="success"> {{ $t('stock_status.in_stock') }}</Tag>
                            <Tag v-if="data.stock_status === 'low_stock'" severity="warning"> {{ $t('stock_status.low_stock') }}</Tag>
                            <Tag v-if="data.stock_status === 'over_stock'" severity="warning"> {{ $t('stock_status.over_stock') }}</Tag>
                            <Tag v-if="data.stock_status === 'unknown'"> {{ $t('stock_status.unknown') }}</Tag>
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
import ProductMixin from '@/mixins/products'
export default {
    name: 'ProductsPage',
    mixins: [ProductMixin],
    created() {
        this.getProducts()
    },
    methods: {
        /**
         * Function that redirects to product view page
         * @param {string} id
         */
        viewProductNavigation(event) {
            this.$router.push(`/products/${event.data.id}`)
        },
    },
}
</script>

<style></style>
