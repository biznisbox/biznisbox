<template>
    <user-layout>
        <div id="view_product_page">
            <LoadingScreen :blocked="loadingData">
                <user-header :title="product.name">
                    <template #actions>
                        <Button
                            :label="$t('basic.edit')"
                            icon="fa fa-pen"
                            class="p-button-success"
                            @click="editProductRoute($route.params.id)"
                        />
                        <Button
                            :label="$t('basic.delete')"
                            icon="fa fa-trash"
                            class="p-button-danger"
                            @click="deleteProductAsk($route.params.id)"
                        />
                    </template>
                </user-header>

                <div id="product_data" class="card">
                    <div class="grid">
                        <DisplayData class="col-12 md:col-6" :input="$t('form.number')" :value="product.number" />

                        <DisplayData class="col-12 md:col-6" :input="$t('form.type')" custom-value>
                            <Tag :value="$t('product_type.' + product.type)" />
                        </DisplayData>
                    </div>

                    <!-- Product price -->
                    <div class="grid">
                        <DisplayData
                            class="col-12 md:col-4"
                            :input="$t('form.sell_price')"
                            :value="product.sell_price + ' ' + $settings.default_currency"
                        />
                        <DisplayData
                            class="col-12 md:col-4"
                            :input="$t('form.buy_price')"
                            :value="product.buy_price + ' ' + $settings.default_currency"
                        />
                        <DisplayData class="col-12 md:col-4" :input="$t('form.unit')" :value="product.unit" />
                    </div>
                    <!-- Product taxes -->
                    <div class="grid">
                        <DisplayData class="col-12" :input="$t('form.tax')" :value="product.tax + '%'" />
                    </div>
                    <!-- Stock -->
                    <div v-if="product.type == 'product'" class="grid">
                        <DisplayData class="col-12 md:col-4" :input="$t('form.stock')" :value="product.stock" />
                        <DisplayData class="col-12 md:col-4" :input="$t('form.min_stock')" :value="product.stock_min" />
                        <DisplayData class="col-12 md:col-4" :input="$t('form.max_stock')" :value="product.stock_max" />
                    </div>

                    <!-- Barcode input -->
                    <div class="grid">
                        <DisplayData class="col-12" :input="$t('form.barcode')" :value="product.barcode" />
                    </div>

                    <!-- Product description -->
                    <div class="grid">
                        <DisplayData class="col-12" :input="$t('form.description')" custom-value>
                            <span v-html="product.description"></span>
                        </DisplayData>
                    </div>

                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button
                            id="cancel_button"
                            :label="$t('basic.cancel')"
                            icon="fa fa-times"
                            class="p-button-danger"
                            @click="goTo('/products')"
                        />
                    </div>
                </div>
            </LoadingScreen>
        </div>
    </user-layout>
</template>

<script>
import ProductMixin from '@/mixins/products'
export default {
    name: 'ViewProductPage',
    mixins: [ProductMixin],

    created() {
        this.getProduct(this.$route.params.id)
    },

    methods: {
        editProductRoute(id) {
            this.$router.push({ name: 'edit-product', params: { id: id } })
        },
    },
}
</script>

<style></style>
