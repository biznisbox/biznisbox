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
                        <SelectButtonInput
                            id="select_product_type"
                            v-model="product.type"
                            class="field col-12 md:col-4"
                            :label="$t('product.product_type')"
                            :options="[
                                { label: $t('product.product'), value: 'product' },
                                { label: $t('product.service'), value: 'service' },
                            ]"
                            disabled
                        />
                    </div>

                    <!-- Product price -->
                    <div class="grid">
                        <NumberInput
                            id="sell_price_input"
                            v-model="product.sell_price"
                            class="field col-12 md:col-4"
                            :label="$t('product.sell_price')"
                            type="currency"
                            disabled
                        ></NumberInput>

                        <NumberInput
                            id="buy_price_input"
                            v-model="product.buy_price"
                            class="field col-12 md:col-4"
                            :label="$t('product.buy_price')"
                            type="currency"
                            disabled
                        ></NumberInput>

                        <SelectInput
                            id="select_unit"
                            v-model="product.unit"
                            class="field col-12 md:col-4"
                            :options="units"
                            :label="$t('product.unit')"
                            option-value="name"
                            option-label="name"
                            disabled
                        />
                    </div>
                    <!-- Product taxes -->
                    <SelectInput
                        id="select_product_tax"
                        v-model="product.tax"
                        class="field"
                        :label="$t('product.tax')"
                        :options="taxes"
                        option-label="name"
                        option-value="value"
                        disabled
                    />

                    <!-- Stock -->
                    <div v-if="product.type == 'product'" class="grid">
                        <NumberInput
                            id="stock_input"
                            v-model="product.stock"
                            class="field col-12 md:col-4"
                            :label="$t('product.stock')"
                            type="items"
                            disabled
                        ></NumberInput>

                        <NumberInput
                            id="min_stock_input"
                            v-model="product.stock_min"
                            class="field col-12 md:col-4"
                            :label="$t('product.min_stock')"
                            type="items"
                            disabled
                        ></NumberInput>

                        <NumberInput
                            id="max_stock_input"
                            v-model="product.stock_max"
                            class="field col-12 md:col-4"
                            :label="$t('product.max_stock')"
                            type="items"
                            disabled
                        ></NumberInput>
                    </div>

                    <!-- Barcode input -->
                    <TextInput id="barcode_input" v-model="product.barcode" :label="$t('product.barcode')" disabled></TextInput>

                    <!-- Product description -->
                    <EditorInput
                        id="description_editor"
                        v-model="product.description"
                        readonly
                        :label="$t('product.description')"
                        class="product-text-editor"
                    />
                    <div id="function_buttons" class="flex gap-2 justify-content-end">
                        <Button :label="$t('basic.cancel')" icon="fa fa-times" class="p-button-danger" @click="goTo('/products')" />
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
